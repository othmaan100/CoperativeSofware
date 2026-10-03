<?php

namespace Tests\Feature;

use App\Livewire\Members\PayApplicationFee;
use App\Livewire\Members\RegisterApplication;
use App\Livewire\Treasurer\PendingApplications;
use App\Models\ApplicationFeePayment;
use App\Models\Member;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class PaystackPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SettingsSeeder::class);

        config(['services.paystack.secret_key' => 'sk_test_fake']);
        config(['services.paystack.public_key' => 'pk_test_fake']);
        config(['services.paystack.base_url' => 'https://api.paystack.co']);
    }

    protected function registerApplicant(): Member
    {
        Livewire::test(RegisterApplication::class)
            ->set('full_name', 'Amina Bello')
            ->set('date_of_birth', '1985-04-10')
            ->set('gender', 'female')
            ->set('marital_status', 'married')
            ->set('home_address', 'No 1 Coop Street, Potiskum')
            ->set('phone_1', '08010000000')
            ->set('email', 'amina.bello@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->set('department', 'Bursary')
            ->set('staff_category', 'senior_staff')
            ->set('staff_id', 'SS/9001')
            ->set('employment_status', 'permanent')
            ->set('preferred_monthly_contribution', '6000')
            ->set('nok_name', 'Musa Bello')
            ->set('nok_relationship', 'Spouse')
            ->set('nok_phone', '08020000000')
            ->set('declaration_accepted', true)
            ->set('declaration_signed_name', 'Amina Bello')
            ->call('submit')
            ->assertRedirect(route('my-application.pay-fee'));

        return Member::firstOrFail();
    }

    public function test_registration_redirects_to_the_fee_payment_page(): void
    {
        $member = $this->registerApplicant();

        $this->assertFalse($member->application_fee_paid);
    }

    public function test_pay_now_initializes_a_paystack_transaction_and_redirects_to_checkout(): void
    {
        $member = $this->registerApplicant();

        Http::fake([
            'api.paystack.co/transaction/initialize' => Http::response([
                'status' => true,
                'message' => 'Authorization URL created',
                'data' => [
                    'authorization_url' => 'https://checkout.paystack.com/abc123',
                    'access_code' => 'abc123',
                    'reference' => 'ignored-because-we-send-our-own',
                ],
            ], 200),
        ]);

        Livewire::actingAs($member->user)
            ->test(PayApplicationFee::class)
            ->call('payNow')
            ->assertRedirect('https://checkout.paystack.com/abc123');

        $payment = ApplicationFeePayment::firstOrFail();
        $this->assertSame($member->id, $payment->member_id);
        $this->assertSame('pending', $payment->status);
        $this->assertEquals(5000, (float) $payment->amount);
        $this->assertStringNotContainsString('/', $payment->reference, 'Paystack rejects "/" in transaction references — application_no (FCET/CSL/00042) must be sanitized.');

        Http::assertSent(function ($request) use ($payment) {
            return $request->url() === 'https://api.paystack.co/transaction/initialize'
                && $request['reference'] === $payment->reference
                && $request['amount'] === 500000; // kobo
        });
    }

    public function test_pay_now_shows_an_error_when_paystack_is_not_configured(): void
    {
        config(['services.paystack.secret_key' => '']);
        $member = $this->registerApplicant();

        Livewire::actingAs($member->user)
            ->test(PayApplicationFee::class)
            ->call('payNow');

        $this->assertSame(0, ApplicationFeePayment::count(), 'No payment attempt should be recorded if Paystack is not configured.');
    }

    public function test_successful_callback_marks_the_fee_paid_and_unblocks_approval(): void
    {
        $member = $this->registerApplicant();

        $payment = ApplicationFeePayment::create([
            'member_id' => $member->id,
            'reference' => 'FEE-TEST-001',
            'amount' => 5000,
            'status' => 'pending',
            'initiated_at' => now(),
        ]);

        Http::fake([
            'api.paystack.co/transaction/verify/*' => Http::response([
                'status' => true,
                'message' => 'Verification successful',
                'data' => [
                    'status' => 'success',
                    'reference' => 'FEE-TEST-001',
                    'amount' => 500000,
                    'currency' => 'NGN',
                    'channel' => 'card',
                ],
            ], 200),
        ]);

        $response = $this->actingAs($member->user)->get(route('payments.paystack.callback', ['reference' => 'FEE-TEST-001']));

        $response->assertRedirect(route('my-application'));

        $member->refresh();
        $this->assertTrue($member->application_fee_paid);
        $this->assertSame('paystack', $member->application_fee_source);
        $this->assertNull($member->application_fee_marked_by);
        $this->assertSame('success', $payment->fresh()->status);
        $this->assertSame('card', $payment->fresh()->channel);
        $this->assertSame('paystack', $payment->fresh()->source);
        $this->assertEquals(20, (float) $payment->fresh()->admin_pct);
        $this->assertEquals(80, (float) $payment->fresh()->profit_pct);
        $this->assertEquals(1000, (float) $payment->fresh()->admin_amount);
        $this->assertEquals(4000, (float) $payment->fresh()->profit_amount);

        // Now the Treasurer can approve without needing the manual override.
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(PendingApplications::class)
            ->call('openApprove', $member->id)
            ->set('approved_monthly_contribution', (string) $member->preferred_monthly_contribution)
            ->call('approve');

        $this->assertSame('active', $member->fresh()->status);
    }

    public function test_failed_verification_leaves_the_member_unpaid_and_blocks_approval(): void
    {
        $member = $this->registerApplicant();

        ApplicationFeePayment::create([
            'member_id' => $member->id,
            'reference' => 'FEE-TEST-002',
            'amount' => 5000,
            'status' => 'pending',
            'initiated_at' => now(),
        ]);

        Http::fake([
            'api.paystack.co/transaction/verify/*' => Http::response([
                'status' => true,
                'data' => [
                    'status' => 'failed',
                    'reference' => 'FEE-TEST-002',
                    'amount' => 500000,
                    'currency' => 'NGN',
                ],
            ], 200),
        ]);

        $response = $this->actingAs($member->user)->get(route('payments.paystack.callback', ['reference' => 'FEE-TEST-002']));
        $response->assertRedirect(route('my-application.pay-fee'));

        $this->assertFalse($member->fresh()->application_fee_paid);

        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(PendingApplications::class)
            ->call('openApprove', $member->id)
            ->set('approved_monthly_contribution', (string) $member->preferred_monthly_contribution)
            ->call('approve')
            ->assertHasErrors('application_fee_paid');

        $this->assertSame('pending', $member->fresh()->status, 'Approval must be blocked while the fee is unpaid.');
    }

    public function test_treasurer_can_manually_override_an_unpaid_fee_with_a_note(): void
    {
        $member = $this->registerApplicant();
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        // Ticking the override box without a note is rejected.
        Livewire::actingAs($treasurer)
            ->test(PendingApplications::class)
            ->call('openApprove', $member->id)
            ->set('approved_monthly_contribution', (string) $member->preferred_monthly_contribution)
            ->set('application_fee_paid', true)
            ->call('approve')
            ->assertHasErrors('fee_override_note');

        $this->assertSame('pending', $member->fresh()->status);

        Livewire::actingAs($treasurer)
            ->test(PendingApplications::class)
            ->call('openApprove', $member->id)
            ->set('approved_monthly_contribution', (string) $member->preferred_monthly_contribution)
            ->set('application_fee_paid', true)
            ->set('fee_override_note', 'Paid by bank transfer, receipt on file.')
            ->call('approve');

        $member->refresh();
        $this->assertSame('active', $member->status);
        $this->assertTrue($member->application_fee_paid);
        $this->assertSame('manual', $member->application_fee_source);
        $this->assertSame($treasurer->id, $member->application_fee_marked_by);

        $payment = ApplicationFeePayment::where('member_id', $member->id)->firstOrFail();
        $this->assertSame('manual', $payment->source);
        $this->assertSame('success', $payment->status);
        $this->assertSame($treasurer->id, $payment->recorded_by);
        $this->assertEquals(1000, (float) $payment->admin_amount);
        $this->assertEquals(4000, (float) $payment->profit_amount);
        $this->assertSame('Paid by bank transfer, receipt on file.', $payment->paystack_response['note']);
    }

    public function test_changing_the_split_does_not_rewrite_amounts_on_already_recorded_payments(): void
    {
        $member = $this->registerApplicant();
        $treasurer = User::factory()->create();
        $treasurer->assignRole('treasurer');

        Livewire::actingAs($treasurer)
            ->test(PendingApplications::class)
            ->call('openApprove', $member->id)
            ->set('approved_monthly_contribution', (string) $member->preferred_monthly_contribution)
            ->set('application_fee_paid', true)
            ->set('fee_override_note', 'Paid in cash.')
            ->call('approve');

        $payment = ApplicationFeePayment::where('member_id', $member->id)->firstOrFail();
        $this->assertEquals(1000, (float) $payment->admin_amount);

        // Chairman changes the split going forward.
        \App\Models\Setting::set('application_fee_admin_pct', 50);
        \App\Models\Setting::set('application_fee_profit_pct', 50);

        $payment->refresh();
        $this->assertEquals(1000, (float) $payment->admin_amount, 'A payment already recorded must keep the split that applied when it was paid.');
        $this->assertEquals(20, (float) $payment->admin_pct);
    }

    public function test_webhook_rejects_an_invalid_signature(): void
    {
        $member = $this->registerApplicant();

        $payment = ApplicationFeePayment::create([
            'member_id' => $member->id,
            'reference' => 'FEE-TEST-003',
            'amount' => 5000,
            'status' => 'pending',
            'initiated_at' => now(),
        ]);

        $payload = ['event' => 'charge.success', 'data' => ['reference' => 'FEE-TEST-003']];

        $response = $this->postJson(route('webhooks.paystack'), $payload, [
            'x-paystack-signature' => 'not-a-real-signature',
        ]);

        $response->assertStatus(400);
        $this->assertSame('pending', $payment->fresh()->status);
        $this->assertFalse($member->fresh()->application_fee_paid);
    }

    public function test_webhook_with_a_valid_signature_marks_the_fee_paid(): void
    {
        $member = $this->registerApplicant();

        $payment = ApplicationFeePayment::create([
            'member_id' => $member->id,
            'reference' => 'FEE-TEST-004',
            'amount' => 5000,
            'status' => 'pending',
            'initiated_at' => now(),
        ]);

        Http::fake([
            'api.paystack.co/transaction/verify/*' => Http::response([
                'status' => true,
                'data' => [
                    'status' => 'success',
                    'reference' => 'FEE-TEST-004',
                    'amount' => 500000,
                    'currency' => 'NGN',
                    'channel' => 'bank_transfer',
                ],
            ], 200),
        ]);

        $body = json_encode(['event' => 'charge.success', 'data' => ['reference' => 'FEE-TEST-004']]);
        $signature = hash_hmac('sha512', $body, 'sk_test_fake');

        $response = $this->call('POST', route('webhooks.paystack'), [], [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_x-paystack-signature' => $signature,
        ], $body);

        $response->assertStatus(200);
        $this->assertTrue($member->fresh()->application_fee_paid);
        $this->assertSame('success', $payment->fresh()->status);
        $this->assertSame('bank_transfer', $payment->fresh()->channel);
    }
}
