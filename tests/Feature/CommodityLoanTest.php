<?php

namespace Tests\Feature;

use App\Livewire\Commodities\CatalogueManager;
use App\Livewire\Commodities\CycleShow;
use App\Livewire\Commodities\RequestCommodity;
use App\Livewire\Treasurer\LoanRepaymentBatchShow;
use App\Livewire\Treasurer\LoanRepaymentBatches;
use App\Models\CommodityCycle;
use App\Models\CommodityItem;
use App\Models\CommodityRequest;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Database\Seeders\CommodityCatalogueSeeder;
use Database\Seeders\LoanSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SavingsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Livewire\Livewire;
use Tests\TestCase;

class CommodityLoanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);
        $this->seed(SavingsSeeder::class);
        $this->seed(LoanSeeder::class);
        $this->seed(CommodityCatalogueSeeder::class);
    }

    protected function makeActiveMember(array $overrides = []): Member
    {
        $user = User::factory()->create();
        $user->assignRole('member');

        return Member::factory()->create(array_merge([
            'user_id' => $user->id,
            'status' => 'active',
            'applied_at' => now()->subYear(),
        ], $overrides));
    }

    protected function openCycle(User $secretary, int $deadlineDays = 14): CommodityCycle
    {
        return CommodityCycle::create([
            'name' => 'Test Cycle',
            'request_deadline' => now()->addDays($deadlineDays)->toDateString(),
            'status' => CommodityCycle::STATUS_OPEN,
            'opened_by' => $secretary->id,
        ]);
    }

    public function test_full_commodity_cycle_lifecycle_including_custom_item_promotion(): void
    {
        $secretary = User::factory()->create();
        $secretary->assignRole('secretary');
        $auditor = User::factory()->create();
        $auditor->assignRole('auditor');
        $storeOfficer = User::factory()->create();
        $storeOfficer->assignRole('store_officer');
        $chairman = User::factory()->create();
        $chairman->assignRole('chairman');

        $cycle = $this->openCycle($secretary);

        $sugar = CommodityItem::where('description', 'BUA Sugar')->first();
        $member = $this->makeActiveMember(['staff_id' => 'FCET-8001']);

        // Member requests a catalogue item and a custom (not-listed) item.
        Livewire::actingAs($member->user)
            ->test(RequestCommodity::class)
            ->set('lines.0.commodity_item_id', (string) $sugar->id)
            ->set('lines.0.quantity', '2')
            ->set('lines.0.unit_basis', 'bag')
            ->call('addLine')
            ->set('lines.1.custom_item_text', 'Groundnut Oil 4 Litres')
            ->set('lines.1.quantity', '1')
            ->set('lines.1.unit_basis', 'gallon')
            ->set('salary_deduction_authorized', true)
            ->call('submit');

        $request = CommodityRequest::firstOrFail();
        $this->assertSame('submitted', $request->status);
        $this->assertSame(2, $request->lines()->count());

        // Secretary closes the request window and finalizes pricing.
        Livewire::actingAs($secretary)->test(CycleShow::class, ['cycle' => $cycle])
            ->call('closeRequestsNow');
        $this->assertSame('requests_closed', $cycle->fresh()->status);

        $pricingTest = Livewire::actingAs($secretary)->test(CycleShow::class, ['cycle' => $cycle->fresh()])
            ->set('tenure_months', '3')
            ->set('moratorium_months', '1');

        // Fill in a price for every demanded item (BUA Sugar + the custom oil).
        foreach ($cycle->fresh()->demandSummary() as $row) {
            $key = $row->commodity_item_id ? "item-{$row->commodity_item_id}" : 'custom-'.strtolower($row->custom_item_text);
            $price = $row->commodity_item_id ? 60000 : 8000; // 2 bags sugar @60k, 1 gallon oil @8k
            $pricingTest->set("prices.{$key}", (string) $price);
        }

        $pricingTest->call('finalizePricing');

        $cycle->refresh();
        $this->assertSame('priced', $cycle->status);
        $this->assertEquals(3, $cycle->tenure_months);
        $this->assertEquals(1, $cycle->moratorium_months);

        // The custom item must have been promoted into the permanent catalogue.
        $promoted = CommodityItem::where('description', 'Groundnut Oil 4 Litres')->first();
        $this->assertNotNull($promoted, 'A custom item priced during finalization must be auto-promoted into the catalogue.');
        $this->assertNotNull($promoted->created_from_request_line_id);

        $request->refresh();
        // Subtotal = (2 x 60000) + (1 x 8000) = 128000. Markup 10% => 12800. Total 140800.
        $this->assertEquals(128000, (float) $request->commodity_subtotal);
        $this->assertEquals(12800, (float) $request->markup_amount);
        $this->assertEquals(140800, (float) $request->total_repayable);
        $this->assertSame('priced', $request->status);

        // Auditor -> Store Officer -> Chairman, all cycle-wide (bulk) actions.
        Livewire::actingAs($auditor)->test(CycleShow::class, ['cycle' => $cycle])->call('verify');
        $this->assertSame('auditor_verified', $cycle->fresh()->status);

        Livewire::actingAs($storeOfficer)->test(CycleShow::class, ['cycle' => $cycle->fresh()])->call('approve');
        $this->assertSame('store_approved', $cycle->fresh()->status);

        Livewire::actingAs($chairman)->test(CycleShow::class, ['cycle' => $cycle->fresh()])->call('authorize_');
        $this->assertSame('chairman_authorized', $cycle->fresh()->status);

        // Store Officer releases goods to this specific member.
        Livewire::actingAs($storeOfficer)->test(CycleShow::class, ['cycle' => $cycle->fresh()])
            ->call('releaseGoods', $request->id);

        $request->refresh();
        $this->assertSame('active', $request->status);
        $this->assertNotNull($request->loan_id);
        $this->assertSame('active', $cycle->fresh()->status, 'Cycle should flip to active once the first release happens.');

        $loan = Loan::findOrFail($request->loan_id);
        $this->assertEquals(140800, (float) $loan->outstanding_balance);
        $this->assertSame('goods', $loan->disbursement_method);
        $this->assertSame(3, $loan->schedules()->count());

        // First installment must fall due after the 1-month moratorium (i.e. 2 months from release).
        $firstDue = $loan->schedules()->orderBy('installment_no')->first()->due_date;
        $this->assertTrue($firstDue->gt(now()->addMonthNoOverflow()), 'First installment must fall after the moratorium, not immediately.');

        // Repay it in full via the standard loan repayment batch mechanism (reused, not duplicated).
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        $csv = "staff_id,loan_no,amount\nFCET-8001,{$loan->loan_no},140800\n";
        $file = UploadedFile::fake()->createWithContent('commodity-repay.csv', $csv);

        Livewire::actingAs($treasurer)->test(LoanRepaymentBatches::class)
            ->set('period', now()->format('Y-m'))->set('file', $file)->call('processUpload');

        $batch = \App\Models\LoanRepaymentBatch::firstOrFail();
        Livewire::actingAs($treasurer)->test(LoanRepaymentBatchShow::class, ['batch' => $batch])->call('post');

        $this->assertSame('closed', $loan->fresh()->status);
    }

    public function test_member_cannot_request_again_while_a_previous_commodity_loan_is_still_active(): void
    {
        $member = $this->makeActiveMember(['staff_id' => 'FCET-8101']);
        $product = \App\Models\LoanProduct::where('code', 'commodity')->first();

        Loan::create([
            'member_id' => $member->id,
            'loan_product_id' => $product->id,
            'loan_no' => Loan::generateLoanNo(),
            'principal_amount' => 50000,
            'interest_admin_pct' => 2,
            'interest_profit_pct' => 8,
            'total_interest' => 5000,
            'interest_admin_amount' => 1000,
            'interest_profit_amount' => 4000,
            'total_repayable' => 55000,
            'tenure_months' => 3,
            'monthly_installment' => 18333.33,
            'outstanding_balance' => 55000,
            'status' => 'active',
            'applied_at' => now(),
            'disbursed_at' => now(),
            'disbursement_method' => 'goods',
        ]);

        $secretary = User::factory()->create();
        $secretary->assignRole('secretary');
        $this->openCycle($secretary);

        $this->assertTrue($member->hasActiveCommodityLoan());

        Livewire::actingAs($member->user)->test(RequestCommodity::class);
        // The view itself blocks submission; verify no request row gets created via a direct submit attempt.
        try {
            Livewire::actingAs($member->user)->test(RequestCommodity::class)
                ->set('lines.0.custom_item_text', 'Rice')
                ->set('lines.0.quantity', '1')
                ->set('lines.0.unit_basis', 'bag')
                ->set('salary_deduction_authorized', true)
                ->call('submit');
            $this->fail('Expected submission to be blocked while a previous commodity loan is active.');
        } catch (\Throwable $e) {
            // Expected: abort_if() in submit() refuses the request.
        }

        $this->assertSame(0, CommodityRequest::count());
    }

    public function test_expired_cycle_deadline_auto_closes_the_request_window(): void
    {
        $secretary = User::factory()->create();
        $secretary->assignRole('secretary');

        $cycle = CommodityCycle::create([
            'name' => 'Expired Cycle',
            'request_deadline' => now()->subDay()->toDateString(),
            'status' => CommodityCycle::STATUS_OPEN,
            'opened_by' => $secretary->id,
        ]);

        Artisan::call('commodities:close-expired-cycles');

        $this->assertSame('requests_closed', $cycle->fresh()->status);
    }

    public function test_member_can_still_see_priced_totals_after_the_request_window_closes(): void
    {
        $secretary = User::factory()->create();
        $secretary->assignRole('secretary');
        $cycle = $this->openCycle($secretary);

        $sugar = CommodityItem::where('description', 'BUA Sugar')->first();
        $member = $this->makeActiveMember(['staff_id' => 'FCET-8201']);

        Livewire::actingAs($member->user)
            ->test(RequestCommodity::class)
            ->set('lines.0.commodity_item_id', (string) $sugar->id)
            ->set('lines.0.quantity', '1')
            ->set('lines.0.unit_basis', 'bag')
            ->set('salary_deduction_authorized', true)
            ->call('submit');

        $request = CommodityRequest::firstOrFail();

        // Close the request window (this used to make the member's own page
        // report "no open cycle" and hide their request entirely).
        Livewire::actingAs($secretary)->test(CycleShow::class, ['cycle' => $cycle])->call('closeRequestsNow');

        $afterClose = Livewire::actingAs($member->user)->test(RequestCommodity::class);
        $afterClose->assertSee($cycle->fresh()->name);
        $afterClose->assertSee('BUA Sugar');
        $afterClose->assertDontSee('There is no commodity cycle currently open');

        // Now finalize pricing and confirm the member sees real totals.
        $pricingTest = Livewire::actingAs($secretary)->test(CycleShow::class, ['cycle' => $cycle->fresh()])
            ->set('tenure_months', '2')
            ->set('moratorium_months', '0');

        foreach ($cycle->fresh()->demandSummary() as $row) {
            $key = $row->commodity_item_id ? "item-{$row->commodity_item_id}" : 'custom-'.strtolower($row->custom_item_text);
            $pricingTest->set("prices.{$key}", '60000');
        }
        $pricingTest->call('finalizePricing');

        $request->refresh();
        $this->assertEquals(60000, (float) $request->commodity_subtotal);
        $this->assertEquals(66000, (float) $request->total_repayable);
        $this->assertEquals(33000, (float) $request->monthly_installment);

        $memberView = Livewire::actingAs($member->user)->test(RequestCommodity::class);
        $memberView->assertSee('66,000', false);
        $memberView->assertSee('33,000', false);
        $memberView->assertDontSee('There is no commodity cycle currently open');
    }

    public function test_catalogue_search_filters_by_description_type_brand_and_pack_unit(): void
    {
        $secretary = User::factory()->create();
        $secretary->assignRole('secretary');

        CommodityItem::create(['description' => 'Rice', 'type_brand' => 'Mama Gold', 'pack_unit' => '50kg bag', 'is_active' => true]);
        CommodityItem::create(['description' => 'Vegetable Oil', 'type_brand' => 'Power Oil', 'pack_unit' => '4 litres', 'is_active' => true]);
        CommodityItem::create(['description' => 'Spaghetti', 'type_brand' => 'Golden Penny', 'pack_unit' => 'carton', 'is_active' => true]);

        // Search by description.
        Livewire::actingAs($secretary)
            ->test(CatalogueManager::class)
            ->set('search', 'rice')
            ->assertSee('Rice')
            ->assertDontSee('Vegetable Oil')
            ->assertDontSee('Spaghetti');

        // Search by type/brand.
        Livewire::actingAs($secretary)
            ->test(CatalogueManager::class)
            ->set('search', 'Golden Penny')
            ->assertSee('Spaghetti')
            ->assertDontSee('Rice');

        // Search by pack/unit.
        Livewire::actingAs($secretary)
            ->test(CatalogueManager::class)
            ->set('search', 'litres')
            ->assertSee('Vegetable Oil')
            ->assertDontSee('Rice')
            ->assertDontSee('Spaghetti');

        // No match.
        Livewire::actingAs($secretary)
            ->test(CatalogueManager::class)
            ->set('search', 'nonexistent-item-xyz')
            ->assertSee('No catalogue items match your search.');
    }

    public function test_catalogue_displays_pack_unit_for_every_item(): void
    {
        $secretary = User::factory()->create();
        $secretary->assignRole('secretary');

        CommodityItem::create(['description' => 'Rice', 'type_brand' => 'Mama Gold', 'pack_unit' => '50kg bag', 'is_active' => true]);

        Livewire::actingAs($secretary)
            ->test(CatalogueManager::class)
            ->assertSee('50kg bag');
    }

    public function test_request_form_shows_unit_placeholder_examples_after_the_quantity_field(): void
    {
        $secretary = User::factory()->create();
        $secretary->assignRole('secretary');
        $this->openCycle($secretary);

        $member = $this->makeActiveMember(['staff_id' => 'FCET-7601']);

        Livewire::actingAs($member->user)
            ->test(RequestCommodity::class)
            ->assertSee('e.g. carton, half bag, 2 litres');
    }

    public function test_secretary_can_define_unit_options_for_a_catalogue_item(): void
    {
        $secretary = User::factory()->create();
        $secretary->assignRole('secretary');

        Livewire::actingAs($secretary)
            ->test(CatalogueManager::class)
            ->call('openCreate')
            ->set('description', 'Rice')
            ->set('type_brand', 'Mama Gold')
            ->set('pack_unit', '50kg Bag')
            ->set('unit_options', 'Full bag,  Half bag ,Quarter bag')
            ->call('save');

        $item = CommodityItem::where('description', 'Rice')->firstOrFail();
        $this->assertSame(['Full bag', 'Half bag', 'Quarter bag'], $item->unit_options);

        // Re-opening for edit must show the options back as a clean comma-separated string.
        $component = Livewire::actingAs($secretary)
            ->test(CatalogueManager::class)
            ->call('openEdit', $item->id);

        $this->assertSame('Full bag, Half bag, Quarter bag', $component->get('unit_options'));
    }

    public function test_leaving_unit_options_blank_keeps_the_item_on_free_text_entry(): void
    {
        $secretary = User::factory()->create();
        $secretary->assignRole('secretary');

        Livewire::actingAs($secretary)
            ->test(CatalogueManager::class)
            ->call('openCreate')
            ->set('description', 'Assorted Item')
            ->set('pack_unit', 'Carton')
            ->set('unit_options', '')
            ->call('save');

        $item = CommodityItem::where('description', 'Assorted Item')->firstOrFail();
        $this->assertNull($item->unit_options);
        $this->assertFalse($item->hasUnitOptions());
    }

    public function test_request_form_offers_a_dropdown_of_configured_unit_options(): void
    {
        $secretary = User::factory()->create();
        $secretary->assignRole('secretary');
        $this->openCycle($secretary);

        $item = CommodityItem::create([
            'description' => 'Rice',
            'type_brand' => 'Mama Gold',
            'pack_unit' => '50kg Bag',
            'unit_options' => ['Full bag', 'Half bag', 'Quarter bag'],
            'is_active' => true,
        ]);

        $member = $this->makeActiveMember(['staff_id' => 'FCET-7602']);

        Livewire::actingAs($member->user)
            ->test(RequestCommodity::class)
            ->set('lines.0.commodity_item_id', (string) $item->id)
            ->assertSee('Full bag')
            ->assertSee('Half bag')
            ->assertSee('Quarter bag')
            ->assertDontSee('e.g. carton, half bag, 2 litres');
    }

    public function test_request_is_rejected_when_unit_is_not_one_of_the_configured_options(): void
    {
        $secretary = User::factory()->create();
        $secretary->assignRole('secretary');
        $this->openCycle($secretary);

        $item = CommodityItem::create([
            'description' => 'Rice',
            'type_brand' => 'Mama Gold',
            'pack_unit' => '50kg Bag',
            'unit_options' => ['Full bag', 'Half bag', 'Quarter bag'],
            'is_active' => true,
        ]);

        $member = $this->makeActiveMember(['staff_id' => 'FCET-7603']);

        Livewire::actingAs($member->user)
            ->test(RequestCommodity::class)
            ->set('lines.0.commodity_item_id', (string) $item->id)
            ->set('lines.0.quantity', '1')
            ->set('lines.0.unit_basis', 'Eighth bag') // not one of the configured options
            ->set('salary_deduction_authorized', true)
            ->call('submit')
            ->assertHasErrors(['lines.0.unit_basis']);

        $this->assertSame(0, CommodityRequest::count());
    }

    public function test_item_without_unit_options_still_accepts_free_text_on_submit(): void
    {
        $secretary = User::factory()->create();
        $secretary->assignRole('secretary');
        $this->openCycle($secretary);

        $item = CommodityItem::create([
            'description' => 'Assorted Item',
            'pack_unit' => 'Carton',
            'unit_options' => null,
            'is_active' => true,
        ]);

        $member = $this->makeActiveMember(['staff_id' => 'FCET-7604']);

        Livewire::actingAs($member->user)
            ->test(RequestCommodity::class)
            ->set('lines.0.commodity_item_id', (string) $item->id)
            ->set('lines.0.quantity', '3')
            ->set('lines.0.unit_basis', 'my own custom description')
            ->set('salary_deduction_authorized', true)
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertSame(1, CommodityRequest::count());
    }
}
