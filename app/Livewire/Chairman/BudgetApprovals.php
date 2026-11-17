<?php

namespace App\Livewire\Chairman;

use App\Models\ActivityLog;
use App\Models\Budget;
use App\Models\Expense;
use App\Models\User;
use App\Notifications\BudgetApprovedNotification;
use App\Notifications\ExpenseAuthorizationDecisionNotification;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class BudgetApprovals extends Component
{
    use WithPagination;

    public string $declineNote = '';

    public ?int $decliningExpenseId = null;

    /** Financial-year start year to filter the decision history by; '' = all years. */
    public string $historyYear = '';

    protected const DECISION_ACTIONS = ['budget.approved', 'budget.returned', 'expense.authorized', 'expense.declined'];

    public function mount(): void
    {
        abort_unless(Auth::user()->can('approve_budgets'), 403);
    }

    public function approveBudget(int $budgetId): void
    {
        $budget = Budget::findOrFail($budgetId);
        abort_unless($budget->status === Budget::STATUS_PENDING_APPROVAL, 400);

        $budget->update([
            'status' => Budget::STATUS_APPROVED,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        ActivityLog::record('budget.approved', "Approved the {$budget->fy_start_year} budget (total ₦".number_format($budget->totalBudgeted(), 2).').', $budget);

        Notification::send(User::permission('manage_budgets')->get(), new BudgetApprovedNotification($budget));

        session()->flash('status', 'Budget approved.');
    }

    public function returnBudget(int $budgetId): void
    {
        $budget = Budget::findOrFail($budgetId);
        abort_unless($budget->status === Budget::STATUS_PENDING_APPROVAL, 400);

        $budget->update(['status' => Budget::STATUS_DRAFT]);

        ActivityLog::record('budget.returned', "Returned the {$budget->fy_start_year} budget to draft for revision.", $budget);

        session()->flash('status', 'Budget returned to the Treasurer for revision.');
    }

    public function authorizeExpense(int $expenseId): void
    {
        $expense = Expense::findOrFail($expenseId);
        abort_unless($expense->status === Expense::STATUS_PENDING, 400);

        $expense->update([
            'status' => Expense::STATUS_CHAIRMAN_AUTHORIZED,
            'chairman_reviewed_by' => Auth::id(),
            'chairman_reviewed_at' => now(),
        ]);

        ActivityLog::record('expense.authorized', "Authorized expense {$expense->expense_no}.", $expense);

        $expense->initiatedBy?->notify(new ExpenseAuthorizationDecisionNotification($expense, true));

        session()->flash('status', "Expense {$expense->expense_no} authorized.");
    }

    public function openDeclineForm(int $expenseId): void
    {
        $this->decliningExpenseId = $expenseId;
        $this->declineNote = '';
    }

    public function closeDeclineForm(): void
    {
        $this->decliningExpenseId = null;
        $this->declineNote = '';
    }

    public function declineExpense(): void
    {
        $expense = Expense::findOrFail($this->decliningExpenseId);
        abort_unless($expense->status === Expense::STATUS_PENDING, 400);

        $this->validate(['declineNote' => ['required', 'string', 'max:255']]);

        $expense->update([
            'status' => Expense::STATUS_CHAIRMAN_DECLINED,
            'chairman_reviewed_by' => Auth::id(),
            'chairman_reviewed_at' => now(),
            'chairman_note' => $this->declineNote,
        ]);

        ActivityLog::record('expense.declined', "Declined expense {$expense->expense_no}: {$this->declineNote}", $expense);

        $expense->initiatedBy?->notify(new ExpenseAuthorizationDecisionNotification($expense, false));

        $this->closeDeclineForm();
        session()->flash('status', "Expense {$expense->expense_no} declined.");
    }

    public function updatedHistoryYear(): void
    {
        $this->resetPage('historyPage');
    }

    /**
     * Past budget and expense decisions, read from the activity log — the
     * only place a budget being returned for revision is recorded, since
     * the budget row itself just goes back to draft. Filtered by the
     * financial year of the budget each decision belongs to.
     */
    protected function decisionHistory()
    {
        $year = $this->historyYear === '' ? null : (int) $this->historyYear;

        return ActivityLog::query()
            ->whereIn('action', self::DECISION_ACTIONS)
            ->whereHasMorph('subject', [Budget::class, Expense::class], function ($query, string $type) use ($year) {
                if ($year === null) {
                    return;
                }
                if ($type === Budget::class) {
                    $query->where('fy_start_year', $year);
                } else {
                    $query->whereHas('budgetLine.budget', fn ($b) => $b->where('fy_start_year', $year));
                }
            })
            ->with(['subject' => fn (MorphTo $morph) => $morph->morphWith([
                Budget::class => ['lines'],
                Expense::class => ['budgetLine.budget'],
            ])])
            ->latest('created_at')
            ->latest('id')
            ->paginate(15, pageName: 'historyPage');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $historyYears = Budget::query()->distinct()->pluck('fy_start_year')->all();
        rsort($historyYears);

        return view('livewire.chairman.budget-approvals', [
            'pendingBudgets' => Budget::query()->where('status', Budget::STATUS_PENDING_APPROVAL)->with('lines')->latest('fy_start_year')->get(),
            'pendingExpenses' => Expense::query()->where('status', Expense::STATUS_PENDING)->with(['budgetLine.budget', 'initiatedBy'])->latest()->paginate(15),
            'decisions' => $this->decisionHistory(),
            'historyYears' => $historyYears,
        ]);
    }
}
