<?php

namespace App\Livewire\Loans;

use App\Models\Loan;
use App\Models\LoanGuarantor;
use App\Models\LoanProduct;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ApplyForLoan extends Component
{
    public Member $member;

    public string $loan_product_id = '';

    public string $principal_amount = '';

    public string $tenure_months = '';

    public string $guarantor_1_staff_id = '';

    public string $guarantor_1_pledged_amount = '';

    public string $guarantor_2_staff_id = '';

    public string $guarantor_2_pledged_amount = '';

    public function mount(): void
    {
        $this->member = Auth::user()->member()->firstOrFail();

        abort_unless($this->member->status === 'active', 403, 'Only active members can apply for a loan.');
        abort_unless(Auth::user()->can('apply_for_loan'), 403);
    }

    #[Computed]
    public function products()
    {
        return LoanProduct::query()->where('is_active', true)->orderBy('name')->get();
    }

    #[Computed]
    public function selectedProduct(): ?LoanProduct
    {
        return $this->loan_product_id ? $this->products->firstWhere('id', (int) $this->loan_product_id) : null;
    }

    #[Computed]
    public function eligibility(): ?array
    {
        if (! $this->selectedProduct) {
            return null;
        }

        return Loan::evaluateEligibility($this->member, $this->selectedProduct, (float) ($this->principal_amount ?: 0));
    }

    protected function rules(): array
    {
        $product = $this->selectedProduct;

        $rules = [
            'loan_product_id' => ['required', 'exists:loan_products,id'],
            'principal_amount' => ['required', 'numeric', 'min:1'],
            'tenure_months' => ['required', 'integer', 'min:1', 'max:'.($product?->max_tenure_months ?? 12)],
        ];

        if ($product && $product->requires_guarantor) {
            $rules['guarantor_1_staff_id'] = ['required', 'string'];
            $rules['guarantor_1_pledged_amount'] = ['required', 'numeric', 'min:1'];

            if ((int) $product->max_guarantors >= 2) {
                $rules['guarantor_2_staff_id'] = [(int) $product->min_guarantors >= 2 ? 'required' : 'nullable', 'string'];
                $rules['guarantor_2_pledged_amount'] = ['nullable', 'numeric', 'min:1', 'required_with:guarantor_2_staff_id'];
            }
        }

        return $rules;
    }

    protected function resolveGuarantor(string $staffId): Member
    {
        $guarantor = Member::query()->where('staff_id', $staffId)->where('status', 'active')->first();

        if (! $guarantor) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'guarantor_1_staff_id' => "No active member found for Staff ID {$staffId}.",
            ]);
        }

        if ($guarantor->id === $this->member->id) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'guarantor_1_staff_id' => 'You cannot guarantee your own loan.',
            ]);
        }

        return $guarantor;
    }

    public function submit(): void
    {
        $validated = $this->validate();
        $product = LoanProduct::findOrFail($validated['loan_product_id']);

        $eligibility = Loan::evaluateEligibility($this->member, $product, (float) $validated['principal_amount']);

        if (! empty($eligibility['violations'])) {
            $this->addError('principal_amount', implode(' ', $eligibility['violations']));

            return;
        }

        $guarantorInputs = [];

        if ($product->requires_guarantor) {
            $staffIds = array_filter([$this->guarantor_1_staff_id, $this->guarantor_2_staff_id]);

            if (count(array_unique($staffIds)) !== count($staffIds)) {
                $this->addError('guarantor_2_staff_id', 'Guarantors must be two different members.');

                return;
            }

            $guarantor1 = $this->resolveGuarantor($this->guarantor_1_staff_id);
            $guarantorInputs[] = ['member' => $guarantor1, 'amount' => (float) $this->guarantor_1_pledged_amount];

            if ($this->guarantor_2_staff_id !== '') {
                $guarantor2 = $this->resolveGuarantor($this->guarantor_2_staff_id);
                $guarantorInputs[] = ['member' => $guarantor2, 'amount' => (float) $this->guarantor_2_pledged_amount];
            }
        }

        $amounts = Loan::computeAmounts((float) $validated['principal_amount'], $product, (int) $validated['tenure_months']);
        $multiplierRecord = $product->currentMultiplier();

        $loan = DB::transaction(function () use ($validated, $product, $amounts, $multiplierRecord, $guarantorInputs) {
            $loan = Loan::create([
                'member_id' => $this->member->id,
                'loan_product_id' => $product->id,
                'loan_no' => Loan::generateLoanNo(),
                'principal_amount' => $validated['principal_amount'],
                'interest_admin_pct' => $product->interest_admin_pct,
                'interest_profit_pct' => $product->interest_profit_pct,
                'total_interest' => $amounts['total_interest'],
                'interest_admin_amount' => $amounts['interest_admin_amount'],
                'interest_profit_amount' => $amounts['interest_profit_amount'],
                'total_repayable' => $amounts['total_repayable'],
                'tenure_months' => $validated['tenure_months'],
                'monthly_installment' => $amounts['monthly_installment'],
                'multiplier_applied' => $multiplierRecord?->multiplier,
                'outstanding_balance' => $amounts['total_repayable'],
                'status' => $product->requires_guarantor ? 'pending_guarantor' : 'pending',
                'applied_at' => now(),
            ]);

            foreach ($guarantorInputs as $input) {
                $loan->guarantors()->create([
                    'guarantor_member_id' => $input['member']->id,
                    'pledged_amount' => $input['amount'],
                    'status' => LoanGuarantor::STATUS_INVITED,
                ]);
            }

            return $loan;
        });

        session()->flash('status', "Loan application {$loan->loan_no} submitted".($product->requires_guarantor ? '. Waiting for your guarantor(s) to accept.' : ' for Treasurer review.'));
        $this->redirectRoute('my-loans', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.loans.apply-for-loan');
    }
}
