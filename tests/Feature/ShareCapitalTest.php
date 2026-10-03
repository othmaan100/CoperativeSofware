<?php

namespace Tests\Feature;

use App\Livewire\Admin\SharePriceManager;
use App\Livewire\Chairman\ShareWithdrawalsAuthorization;
use App\Livewire\Shares\MyShares;
use App\Livewire\Shares\RequestShareWithdrawal;
use App\Livewire\Treasurer\ContributionBatches;
use App\Livewire\Treasurer\ContributionBatchShow;
use App\Livewire\Treasurer\SharePurchaseIntents;
use App\Livewire\Treasurer\ShareWithdrawalsReview;
use App\Models\ContributionBatch;
use App\Models\Member;
use App\Models\Setting;
use App\Models\ShareAccount;
use App\Models\SharePriceHistory;
use App\Models\SharePurchaseIntent;
use App\Models\ShareWithdrawalRequest;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SavingsSeeder;
use Database\Seeders\SettingsSeeder;
use Database\Seeders\ShareSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class ShareCapitalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
        $this->seed(SavingsSeeder::class);
        $this->seed(ShareSeeder::class);
    }

    protected function makeActiveMember(array $overrides = []): Member
    {
        $user = User::factory()->create();
        $user->assignRole('member');

        return Member::factory()->create(array_merge([
            'user_id' => $user->id,
            'status' => 'active',
        ], $overrides));
    }

    protected function makeUserWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    public function test_purchase_intent_confirmation_snapshots_the_price_at_confirmation_time(): void
    {
        $member = $this->makeActiveMember();
        $treasurer = $this->makeUserWithRole('treasurer');

        Livewire::actingAs($member->user)
            ->test(MyShares::class)
            ->call('openPurchaseModal')
            ->set('shares_requested', '10')
            ->call('submitPurchase');

        $intent = SharePurchaseIntent::firstOrFail();
        $this->assertSame('pending', $intent->status);

        // Price changes AFTER the intent was logged but BEFORE confirmation —
        // confirmation must snapshot the price in effect at confirmation time.
        SharePriceHistory::query()->where('is_active', true)->update(['is_active' => false]);
        SharePriceHistory::create([
            'unit_price' => 1500,
            'effective_from' => now()->subDay(),
            'set_by' => $treasurer->id,
            'is_active' => true,
        ]);

        Livewire::actingAs($treasurer)
            ->test(SharePurchaseIntents::class)
            ->call('confirm', $intent->id);

        $intent->refresh();
        $this->assertSame('confirmed', $intent->status);
        $this->assertNotNull($intent->transaction_id);

        $account = ShareAccount::query()->where('member_id', $member->id)->first();
        $this->assertSame(10, $account->total_shares);
        $this->assertEquals(15000, (float) $account->balance);
        $this->assertEquals(1500, (float) $intent->transaction->unit_price_applied);
    }

    public function test_price_change_does_not_retroactively_rewrite_already_recorded_transactions(): void
    {
        $member = $this->makeActiveMember();
        $account = ShareAccount::openFor($member);

        $account->recordTransaction(
            type: ShareAccount::TYPE_PURCHASE,
            shares: 5,
            unitPrice: 1000,
            description: 'Initial purchase',
            postedBy: null,
        );

        SharePriceHistory::query()->where('is_active', true)->update(['is_active' => false]);
        SharePriceHistory::create([
            'unit_price' => 2000,
            'effective_from' => now(),
            'set_by' => null,
            'is_active' => true,
        ]);

        $account->refresh();
        $transaction = $account->transactions()->first();

        $this->assertEquals(1000, (float) $transaction->unit_price_applied, 'Historical transaction must keep the price that applied when it was posted.');
        $this->assertEquals(5000, (float) $transaction->amount);
        $this->assertEquals(5000, (float) $account->balance, 'Balance at cost must not be revalued when the price changes.');
        $this->assertEquals(2000, SharePriceHistory::currentPrice(), 'New purchases should use the new price.');
    }

    public function test_share_withdrawal_two_signature_flow_respects_minimum_holding(): void
    {
        Setting::set('minimum_share_holding', 5);

        $member = $this->makeActiveMember();
        $account = ShareAccount::openFor($member);
        $account->recordTransaction(
            type: ShareAccount::TYPE_PURCHASE,
            shares: 10,
            unitPrice: 1000,
            description: 'Opening shares',
            postedBy: null,
        );

        $treasurer = $this->makeUserWithRole('treasurer');
        $chairman = $this->makeUserWithRole('chairman');

        // Requesting more than (total - minimum) must be rejected up front.
        Livewire::actingAs($member->user)
            ->test(RequestShareWithdrawal::class)
            ->set('shares_requested', '6')
            ->set('bank_name', 'Test Bank')
            ->set('account_number', '0123456789')
            ->set('account_name', $member->full_name)
            ->call('submit')
            ->assertHasErrors('shares_requested');

        $this->assertSame(0, ShareWithdrawalRequest::count());

        Livewire::actingAs($member->user)
            ->test(RequestShareWithdrawal::class)
            ->set('shares_requested', '5')
            ->set('bank_name', 'Test Bank')
            ->set('account_number', '0123456789')
            ->set('account_name', $member->full_name)
            ->call('submit');

        $request = ShareWithdrawalRequest::firstOrFail();
        $this->assertSame('pending', $request->status);

        Livewire::actingAs($treasurer)
            ->test(ShareWithdrawalsReview::class)
            ->call('openReview', $request->id)
            ->set('shares_approved', '5')
            ->call('approve');

        $request->refresh();
        $this->assertSame('treasurer_approved', $request->status);

        Livewire::actingAs($chairman)
            ->test(ShareWithdrawalsAuthorization::class)
            ->call('openAuthorize', $request->id)
            ->call('authorize_');

        $request->refresh();
        $this->assertSame('chairman_authorized', $request->status);

        Livewire::actingAs($treasurer)
            ->test(ShareWithdrawalsReview::class)
            ->call('disburse', $request->id);

        $request->refresh();
        $account->refresh();
        $this->assertSame('disbursed', $request->status);
        $this->assertSame(5, $account->total_shares);
        $this->assertEquals(5000, (float) $account->balance);
    }

    public function test_contribution_batch_csv_with_shares_column_posts_to_both_ledgers(): void
    {
        $matched = $this->makeActiveMember(['staff_id' => 'FCET-3001']);
        $noShares = $this->makeActiveMember(['staff_id' => 'FCET-3002']);

        $treasurer = $this->makeUserWithRole('treasurer');

        $csv = "staff_id,amount,shares\nFCET-3001,6000,3\nFCET-3002,4000,\n";
        $file = UploadedFile::fake()->createWithContent('contributions.csv', $csv);

        Livewire::actingAs($treasurer)
            ->test(ContributionBatches::class)
            ->set('period', '2026-09')
            ->set('file', $file)
            ->call('processUpload');

        $batch = ContributionBatch::firstOrFail();
        $this->assertSame('validated', $batch->status);

        Livewire::actingAs($treasurer)
            ->test(ContributionBatchShow::class, ['batch' => $batch])
            ->call('post');

        $batch->refresh();
        $this->assertSame('posted', $batch->status);

        $matchedShareAccount = ShareAccount::query()->where('member_id', $matched->id)->first();
        $this->assertNotNull($matchedShareAccount, 'A share account should be opened for a member buying shares via the batch.');
        $this->assertSame(3, $matchedShareAccount->total_shares);
        $this->assertEquals(3000, (float) $matchedShareAccount->balance);
        $this->assertSame('BATCH-'.$batch->id, $matchedShareAccount->transactions()->first()->reference);

        $noSharesAccount = ShareAccount::query()->where('member_id', $noShares->id)->first();
        $this->assertNull($noSharesAccount, 'No share account/transaction should be created for a row with a blank shares column.');
    }

    public function test_manage_share_price_permission_is_granted_to_both_treasurer_and_chairman(): void
    {
        $treasurer = $this->makeUserWithRole('treasurer');
        $chairman = $this->makeUserWithRole('chairman');
        $member = $this->makeActiveMember();

        Livewire::actingAs($treasurer)->test(SharePriceManager::class)->assertOk();
        Livewire::actingAs($chairman)->test(SharePriceManager::class)->assertOk();

        try {
            Livewire::actingAs($member->user)->test(SharePriceManager::class);
            $this->fail('Expected a member to be blocked from Share Price settings.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_setting_a_new_share_price_does_not_change_the_price_shown_on_history(): void
    {
        $treasurer = $this->makeUserWithRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(SharePriceManager::class)
            ->call('openPriceForm')
            ->set('unit_price', '1200')
            ->set('effective_from', now()->toDateString())
            ->call('savePrice');

        $this->assertEquals(1200, SharePriceHistory::currentPrice());
        $this->assertSame(1, SharePriceHistory::query()->where('is_active', true)->count());
        $this->assertSame(2, SharePriceHistory::query()->count());
    }
}
