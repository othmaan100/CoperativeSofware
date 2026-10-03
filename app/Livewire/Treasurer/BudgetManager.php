<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\Budget;
use App\Models\BudgetLine;
use App\Models\Expense;
use App\Models\User;
use App\Notifications\ExpenseAwaitingAuthorizationNotification;
use App\Support\FinancialYear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BudgetManager extends Component
{
    public int $startYear;

    public array $amounts = [];

    public bool $showExpenseForm = false;

    public string $expenseBudgetLineId = '';

    public string $expenseDescription = '';

    public string $expenseAmount = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('manage_budgets'), 403);
        [$this->startYear] = FinancialYear::current();
    }

    public function updatedStartYear(): void
    {
        $this->amounts = [];
    }

    protected function currentBudget(): ?Budget
    {
        return Budget::query()->with('lines')->where('fy_start_year', $this->startYear)->first();
    }

    public function createDraft(): void
    {
        abort_if($this->currentBudget(), 400, 'A budget already exists for this financial year.');

        DB::transaction(function () {
            $budget = Budget::create([
                'fy_start_year' => $this->startYear,
                'status' => Budget::STATUS_DRAFT,
                'proposed_by' => Auth::id(),
            ]);

            foreach (array_keys(Budget::CATEGORIES) as $category) {
                $budget->lines()->create([
                    'category' => $category,
                    'budgeted_amount' => 0,
                ]);
            }
        });

        session()->flash('status', 'Draft budget created. Fill in the amounts and submit for approval.');
    }

    protected function rules(): array
    {
        $rules = [];
        foreach (array_keys(Budget::CATEGORIES) as $category) {
            $rules["amounts.{$category}"] = ['required', 'numeric', 'min:0'];
        }

        return $rules;
    }

    public function saveDraft(): void
    {
        $budget = $this->currentBudget();
        abort_unless($budget && $budget->status === Budget::STATUS_DRAFT, 400);

        $validated = $this->validate();

        foreach ($budget->lines as $line) {
            $line->update(['budgeted_amount' => $validated['amounts'][$line->category] ?? 0]);
        }

        session()->flash('status', 'Budget amounts saved.');
    }

    public function submitForApproval(): void
    {
        $budget = $this->currentBudget();
        abort_unless($budget && $budget->status === Budget::STATUS_DRAFT, 400);

        $this->validate();
        $this->saveDraft();

        $budget->update([
            'status' => Budget::STATUS_PENDING_APPROVAL,
            'proposed_at' => now(),
        ]);

        ActivityLog::record('budget.submitted', "Submitted the {$this->startYear} budget for approval (total ₦".number_format($budget->totalBudgeted(), 2).').', $budget);

        session()->flash('status', 'Budget submitted for Chairman approval.');
    }

    public function openExpenseForm(): void
    {
        $this->reset(['expenseBudgetLineId', 'expenseDescription', 'expenseAmount']);
        $this->showExpenseForm = true;
    }

    public function closeExpenseForm(): void
    {
        $this->showExpenseForm = false;
    }

    protected function expenseRules(): array
    {
        return [
            'expenseBudgetLineId' => ['required', 'exists:budget_lines,id'],
            'expenseDescription' => ['required', 'string', 'max:255'],
            'expenseAmount' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    public function logExpense(): void
    {
        $budget = $this->currentBudget();
        abort_unless($budget && $budget->status === Budget::STATUS_APPROVED, 400, 'The budget for this year must be approved before expenses can be logged against it.');

        $validated = $this->validate($this->expenseRules(), [], [
            'expenseBudgetLineId' => 'category',
            'expenseDescription' => 'description',
            'expenseAmount' => 'amount',
        ]);

        $expense = Expense::create([
            'expense_no' => Expense::generateExpenseNo(),
            'budget_line_id' => $validated['expenseBudgetLineId'],
            'description' => $validated['expenseDescription'],
            'amount' => $validated['expenseAmount'],
            'status' => Expense::STATUS_PENDING,
            'initiated_by' => Auth::id(),
        ]);

        ActivityLog::record(
            action: 'expense.logged',
            description: "Logged expense {$expense->expense_no}: {$expense->description} (₦{$expense->amount}).",
            subject: $expense,
        );

        Notification::send(User::permission('approve_budgets')->get(), new ExpenseAwaitingAuthorizationNotification($expense));

        $this->closeExpenseForm();
        session()->flash('status', "Expense {$expense->expense_no} logged, awaiting Chairman authorization.");
    }

    public function markPaid(int $expenseId, string $paymentReference = ''): void
    {
        $expense = Expense::findOrFail($expenseId);
        abort_unless($expense->status === Expense::STATUS_CHAIRMAN_AUTHORIZED, 400);

        $expense->update([
            'status' => Expense::STATUS_PAID,
            'paid_by' => Auth::id(),
            'paid_at' => now(),
            'payment_reference' => $paymentReference ?: null,
        ]);

        ActivityLog::record('expense.paid', "Marked expense {$expense->expense_no} as paid.", $expense, ['amount' => (float) $expense->amount]);

        session()->flash('status', "Expense {$expense->expense_no} marked as paid.");
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $budget = $this->currentBudget();

        if ($budget && empty($this->amounts)) {
            foreach ($budget->lines as $line) {
                $this->amounts[$line->category] = (string) $line->budgeted_amount;
            }
        }

        [$currentStartYear] = FinancialYear::current();

        return view('livewire.treasurer.budget-manager', [
            'label' => FinancialYear::labelFor($this->startYear),
            // Budgets are planned ahead of time, so offer next year too —
            // not just years with existing activity like other reports do.
            'availableYears' => array_unique(array_merge([$currentStartYear + 1], FinancialYear::availableStartYears())),
            'categories' => Budget::CATEGORIES,
            'budget' => $budget,
            'expenses' => $budget ? Expense::query()->whereIn('budget_line_id', $budget->lines->pluck('id'))->with('budgetLine')->latest()->get() : collect(),
        ]);
    }
}
