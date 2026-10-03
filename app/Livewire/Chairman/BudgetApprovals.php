<?php

namespace App\Livewire\Chairman;

use App\Models\ActivityLog;
use App\Models\Budget;
use App\Models\Expense;
use App\Models\User;
use App\Notifications\BudgetApprovedNotification;
use App\Notifications\ExpenseAuthorizationDecisionNotification;
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

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.chairman.budget-approvals', [
            'pendingBudgets' => Budget::query()->where('status', Budget::STATUS_PENDING_APPROVAL)->with('lines')->latest('fy_start_year')->get(),
            'pendingExpenses' => Expense::query()->where('status', Expense::STATUS_PENDING)->with(['budgetLine.budget', 'initiatedBy'])->latest()->paginate(15),
        ]);
    }
}
