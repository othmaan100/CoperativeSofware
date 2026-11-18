<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use App\Models\LoanLimitMultiplier;
use App\Models\LoanProduct;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class LoanProductsManager extends Component
{
    public ?int $activeId = null;

    public string $mode = '';

    // Rates (Chairman / Super Admin)
    public string $interest_admin_pct = '';

    public string $interest_profit_pct = '';

    // Rules (Super Admin)
    public string $max_tenure_months = '';

    public string $min_membership_months = '';

    public string $min_savings_balance = '';

    public bool $requires_guarantor = true;

    public string $min_guarantors = '';

    public string $max_guarantors = '';

    public bool $is_active = true;

    // Multiplier (Treasurer / Super Admin)
    public string $multiplier = '';

    public string $effective_from = '';

    // Application window (Treasurer / Super Admin)
    public string $applications_close_on = '';

    public function mount(): void
    {
        abort_unless(
            Auth::user()->canAny(['manage_loan_products', 'set_loan_interest_rates', 'manage_loan_limit_multiplier', 'open_loan_applications']),
            403
        );
    }

    public function openApplicationsForm(int $id): void
    {
        abort_unless(Auth::user()->can('open_loan_applications'), 403);

        $product = LoanProduct::findOrFail($id);
        abort_if($product->code === LoanProduct::COMMODITY, 400, 'Commodity loans are created through commodity cycles, not applications.');

        $this->activeId = $id;
        $this->mode = 'applications';
        $this->applications_close_on = $product->applications_close_on?->toDateString() ?? '';
        $this->resetErrorBag();
    }

    public function saveOpenApplications(): void
    {
        abort_unless(Auth::user()->can('open_loan_applications'), 403);

        $validated = $this->validate([
            'applications_close_on' => ['nullable', 'date', 'after_or_equal:today'],
        ], [
            'applications_close_on.after_or_equal' => 'The closing date cannot be in the past.',
        ]);

        $product = LoanProduct::findOrFail($this->activeId);
        abort_if($product->code === LoanProduct::COMMODITY, 400);
        abort_unless($product->is_active, 400, 'This loan product is inactive. Ask the Super Admin to activate it first.');

        $closeOn = $validated['applications_close_on'] ?: null;
        $product->update(['applications_open' => true, 'applications_close_on' => $closeOn]);

        ActivityLog::record(
            action: 'loan.applications_opened',
            description: "Opened applications for {$product->name}".($closeOn ? ' until '.\Illuminate\Support\Carbon::parse($closeOn)->format('d M Y') : ' (no closing date)').'.',
            subject: $product,
            properties: ['applications_close_on' => $closeOn],
        );

        session()->flash('status', "Applications for {$product->name} are now open".($closeOn ? ' until '.\Illuminate\Support\Carbon::parse($closeOn)->format('d M Y') : '').'.');
        $this->closeModal();
    }

    public function closeApplications(int $id): void
    {
        abort_unless(Auth::user()->can('open_loan_applications'), 403);

        $product = LoanProduct::findOrFail($id);
        $product->update(['applications_open' => false, 'applications_close_on' => null]);

        ActivityLog::record(
            action: 'loan.applications_closed',
            description: "Closed applications for {$product->name}.",
            subject: $product,
        );

        session()->flash('status', "Applications for {$product->name} are now closed. Applications already submitted are not affected.");
    }

    public function openRates(int $id): void
    {
        abort_unless(Auth::user()->can('set_loan_interest_rates'), 403);

        $product = LoanProduct::findOrFail($id);
        $this->activeId = $id;
        $this->mode = 'rates';
        $this->interest_admin_pct = (string) $product->interest_admin_pct;
        $this->interest_profit_pct = (string) $product->interest_profit_pct;
    }

    public function openRules(int $id): void
    {
        abort_unless(Auth::user()->can('manage_loan_products'), 403);

        $product = LoanProduct::findOrFail($id);
        $this->activeId = $id;
        $this->mode = 'rules';
        $this->max_tenure_months = (string) $product->max_tenure_months;
        $this->min_membership_months = (string) $product->min_membership_months;
        $this->min_savings_balance = (string) $product->min_savings_balance;
        $this->requires_guarantor = (bool) $product->requires_guarantor;
        $this->min_guarantors = (string) $product->min_guarantors;
        $this->max_guarantors = (string) $product->max_guarantors;
        $this->is_active = (bool) $product->is_active;
    }

    public function openMultiplier(int $id): void
    {
        abort_unless(Auth::user()->can('manage_loan_limit_multiplier'), 403);

        $product = LoanProduct::findOrFail($id);
        $this->activeId = $id;
        $this->mode = 'multiplier';
        $this->multiplier = (string) ($product->currentMultiplier()?->multiplier ?? '');
        $this->effective_from = now()->toDateString();
    }

    public function closeModal(): void
    {
        $this->reset([
            'activeId', 'mode', 'interest_admin_pct', 'interest_profit_pct',
            'max_tenure_months', 'min_membership_months', 'min_savings_balance',
            'requires_guarantor', 'min_guarantors', 'max_guarantors', 'is_active',
            'multiplier', 'effective_from', 'applications_close_on',
        ]);
    }

    public function saveRates(): void
    {
        abort_unless(Auth::user()->can('set_loan_interest_rates'), 403);

        $validated = $this->validate([
            'interest_admin_pct' => ['required', 'numeric', 'min:0', 'max:100'],
            'interest_profit_pct' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $product = LoanProduct::findOrFail($this->activeId);
        $product->update($validated);

        ActivityLog::record(
            action: 'loan.interest_rate_changed',
            description: "Updated interest split for {$product->name} to {$validated['interest_admin_pct']}% admin / {$validated['interest_profit_pct']}% profit.",
            subject: $product,
            properties: $validated,
        );

        session()->flash('status', 'Interest rate components updated. New applications will use this rate immediately; existing loans keep their approved snapshot.');
        $this->closeModal();
    }

    public function saveRules(): void
    {
        abort_unless(Auth::user()->can('manage_loan_products'), 403);

        $validated = $this->validate([
            'max_tenure_months' => ['required', 'integer', 'min:1'],
            'min_membership_months' => ['required', 'integer', 'min:0'],
            'min_savings_balance' => ['required', 'numeric', 'min:0'],
            'requires_guarantor' => ['boolean'],
            'min_guarantors' => ['nullable', 'integer', 'min:0', 'max:2'],
            'max_guarantors' => ['nullable', 'integer', 'min:0', 'max:2'],
            'is_active' => ['boolean'],
        ]);

        $product = LoanProduct::findOrFail($this->activeId);
        $product->update($validated);

        ActivityLog::record(
            action: 'loan.product_rules_updated',
            description: "Updated loan product rules for {$product->name}.",
            subject: $product,
            properties: $validated,
        );

        session()->flash('status', 'Loan product rules updated.');
        $this->closeModal();
    }

    public function saveMultiplier(): void
    {
        abort_unless(Auth::user()->can('manage_loan_limit_multiplier'), 403);

        $validated = $this->validate([
            'multiplier' => ['required', 'numeric', 'min:0.1'],
            'effective_from' => ['required', 'date'],
        ]);

        $product = LoanProduct::findOrFail($this->activeId);

        $product->limitMultipliers()->where('is_active', true)->update(['is_active' => false]);

        $product->limitMultipliers()->create([
            'multiplier' => $validated['multiplier'],
            'effective_from' => $validated['effective_from'],
            'set_by' => Auth::id(),
            'is_active' => true,
        ]);

        ActivityLog::record(
            action: 'loan.limit_multiplier_changed',
            description: "Set loan limit multiplier for {$product->name} to {$validated['multiplier']}x, effective {$validated['effective_from']}.",
            subject: $product,
            properties: $validated,
        );

        session()->flash('status', 'New loan limit multiplier set. Loans already approved keep the multiplier that applied to them at the time.');
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.loan-products-manager', [
            'products' => LoanProduct::with('limitMultipliers')->orderBy('name')->get(),
        ]);
    }
}
