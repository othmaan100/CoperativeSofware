<?php

namespace App\Livewire\Savings;

use App\Models\ActivityLog;
use App\Models\SavingsProduct;
use App\Models\Setting;
use App\Models\WithdrawalCondition;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class WithdrawalConditionsManager extends Component
{
    public ?int $editingId = null;

    public string $savings_product_id = '';

    public string $rule_type = 'minimum_balance';

    public string $value = '';

    public string $description = '';

    public string $voluntary_deposit_lock_months = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('manage_withdrawal_conditions'), 403);
        $this->voluntary_deposit_lock_months = (string) Setting::get('voluntary_deposit_lock_months', 3);
    }

    public function saveVoluntaryDepositLockMonths(): void
    {
        $validated = $this->validate([
            'voluntary_deposit_lock_months' => ['required', 'integer', 'min:0', 'max:60'],
        ]);

        Setting::set('voluntary_deposit_lock_months', (int) $validated['voluntary_deposit_lock_months']);

        ActivityLog::record(
            'savings.voluntary_deposit_lock_months_changed',
            "Set the voluntary deposit hold period to {$validated['voluntary_deposit_lock_months']} month(s).",
            null,
            $validated
        );

        session()->flash('status', 'Voluntary deposit hold period updated.');
    }

    public function startCreate(): void
    {
        $this->reset(['editingId', 'savings_product_id', 'rule_type', 'value', 'description']);
        $this->rule_type = 'minimum_balance';
        $this->editingId = 0; // 0 = creating
    }

    public function edit(int $id): void
    {
        $condition = WithdrawalCondition::findOrFail($id);
        $this->editingId = $id;
        $this->savings_product_id = (string) $condition->savings_product_id;
        $this->rule_type = $condition->rule_type;
        $this->value = (string) $condition->value;
        $this->description = (string) $condition->description;
    }

    public function cancel(): void
    {
        $this->reset(['editingId', 'savings_product_id', 'rule_type', 'value', 'description']);
    }

    protected function rules(): array
    {
        return [
            'savings_product_id' => ['required', 'exists:savings_products,id'],
            'rule_type' => ['required', 'in:minimum_balance,minimum_membership_duration,max_withdrawal_pct_of_balance,cooling_period'],
            'value' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();
        $userId = Auth::id();

        if ($this->editingId) {
            $condition = WithdrawalCondition::findOrFail($this->editingId);
            $condition->update([...$validated, 'last_edited_by' => $userId]);
            ActivityLog::record('savings.withdrawal_condition_updated', "Updated withdrawal condition #{$condition->id} ({$condition->rule_type}).", $condition, $validated);
        } else {
            $condition = WithdrawalCondition::create([
                ...$validated,
                'created_by' => $userId,
                'last_edited_by' => $userId,
                'is_active' => true,
            ]);
            ActivityLog::record('savings.withdrawal_condition_created', "Created withdrawal condition ({$condition->rule_type}).", $condition, $validated);
        }

        $this->cancel();
        session()->flash('status', 'Withdrawal condition saved.');
    }

    public function toggleActive(int $id): void
    {
        $condition = WithdrawalCondition::findOrFail($id);
        $newState = ! $condition->is_active;
        $condition->update(['is_active' => $newState, 'last_edited_by' => Auth::id()]);
        ActivityLog::record(
            action: 'savings.withdrawal_condition_toggled',
            description: ($newState ? 'Enabled' : 'Disabled')." withdrawal condition #{$condition->id} ({$condition->rule_type}).",
            subject: $condition,
        );
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.savings.withdrawal-conditions-manager', [
            'conditions' => WithdrawalCondition::with(['product', 'createdBy', 'lastEditedBy'])->orderBy('savings_product_id')->get(),
            'products' => SavingsProduct::query()->where('is_active', true)->get(),
        ]);
    }
}
