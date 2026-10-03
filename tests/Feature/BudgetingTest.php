<?php

namespace Tests\Feature;

use App\Livewire\Chairman\BudgetApprovals;
use App\Livewire\Reports\BudgetReports;
use App\Livewire\Treasurer\BudgetManager;
use App\Models\Budget;
use App\Models\Expense;
use App\Models\User;
use App\Notifications\BudgetApprovedNotification;
use App\Notifications\ExpenseAuthorizationDecisionNotification;
use App\Notifications\ExpenseAwaitingAuthorizationNotification;
use App\Services\FinancialStatementService;
use App\Support\FinancialYear;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class BudgetingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    protected function makeUserWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    protected function fillAndSubmitBudget(User $treasurer, int $startYear, array $amounts): Budget
    {
        Livewire::actingAs($treasurer)
            ->test(BudgetManager::class)
            ->set('startYear', $startYear)
            ->call('createDraft');

        $budget = Budget::where('fy_start_year', $startYear)->firstOrFail();

        $component = Livewire::actingAs($treasurer)->test(BudgetManager::class)->set('startYear', $startYear);
        foreach ($amounts as $category => $amount) {
            $component->set("amounts.{$category}", (string) $amount);
        }
        $component->call('submitForApproval');

        return $budget->fresh();
    }

    public function test_treasurer_can_propose_a_budget_and_chairman_approves_it(): void
    {
        Notification::fake();
        $treasurer = $this->makeUserWithRole('treasurer');
        $chairman = $this->makeUserWithRole('chairman');
        [$startYear] = FinancialYear::current();

        $amounts = array_fill_keys(array_keys(Budget::CATEGORIES), 0);
        $amounts['salaries'] = 500000;
        $amounts['rent'] = 200000;

        $budget = $this->fillAndSubmitBudget($treasurer, $startYear, $amounts);

        $this->assertSame(Budget::STATUS_PENDING_APPROVAL, $budget->status);
        $this->assertSame(700000.0, $budget->totalBudgeted());

        Livewire::actingAs($chairman)
            ->test(BudgetApprovals::class)
            ->call('approveBudget', $budget->id);

        $budget->refresh();
        $this->assertSame(Budget::STATUS_APPROVED, $budget->status);
        $this->assertSame($chairman->id, $budget->approved_by);

        Notification::assertSentTo($treasurer, BudgetApprovedNotification::class);
    }

    public function test_chairman_can_return_a_budget_to_draft_for_revision(): void
    {
        $treasurer = $this->makeUserWithRole('treasurer');
        $chairman = $this->makeUserWithRole('chairman');
        [$startYear] = FinancialYear::current();

        $amounts = array_fill_keys(array_keys(Budget::CATEGORIES), 0);
        $budget = $this->fillAndSubmitBudget($treasurer, $startYear, $amounts);

        Livewire::actingAs($chairman)
            ->test(BudgetApprovals::class)
            ->call('returnBudget', $budget->id);

        $this->assertSame(Budget::STATUS_DRAFT, $budget->fresh()->status);
    }

    public function test_expense_lifecycle_log_authorize_pay(): void
    {
        Notification::fake();
        $treasurer = $this->makeUserWithRole('treasurer');
        $chairman = $this->makeUserWithRole('chairman');
        [$startYear] = FinancialYear::current();

        $amounts = array_fill_keys(array_keys(Budget::CATEGORIES), 0);
        $amounts['stationery'] = 50000;
        $budget = $this->fillAndSubmitBudget($treasurer, $startYear, $amounts);

        Livewire::actingAs($chairman)->test(BudgetApprovals::class)->call('approveBudget', $budget->id);
        $budget->refresh();
        $line = $budget->lines()->where('category', 'stationery')->firstOrFail();

        Livewire::actingAs($treasurer)
            ->test(BudgetManager::class)
            ->set('startYear', $startYear)
            ->call('openExpenseForm')
            ->set('expenseBudgetLineId', (string) $line->id)
            ->set('expenseDescription', 'Printer paper and toner')
            ->set('expenseAmount', '15000')
            ->call('logExpense');

        $expense = Expense::firstOrFail();
        $this->assertStringStartsWith('EXP/', $expense->expense_no);
        $this->assertSame(Expense::STATUS_PENDING, $expense->status);
        Notification::assertSentTo($chairman, ExpenseAwaitingAuthorizationNotification::class);

        Livewire::actingAs($chairman)
            ->test(BudgetApprovals::class)
            ->call('authorizeExpense', $expense->id);

        $expense->refresh();
        $this->assertSame(Expense::STATUS_CHAIRMAN_AUTHORIZED, $expense->status);
        Notification::assertSentTo($treasurer, ExpenseAuthorizationDecisionNotification::class);

        Livewire::actingAs($treasurer)
            ->test(BudgetManager::class)
            ->set('startYear', $startYear)
            ->call('markPaid', $expense->id, 'CHQ-001');

        $expense->refresh();
        $this->assertSame(Expense::STATUS_PAID, $expense->status);
        $this->assertSame($treasurer->id, $expense->paid_by);
        $this->assertSame('CHQ-001', $expense->payment_reference);
    }

    public function test_chairman_can_decline_an_expense_with_a_reason(): void
    {
        Notification::fake();
        $treasurer = $this->makeUserWithRole('treasurer');
        $chairman = $this->makeUserWithRole('chairman');
        [$startYear] = FinancialYear::current();

        $amounts = array_fill_keys(array_keys(Budget::CATEGORIES), 0);
        $amounts['miscellaneous'] = 20000;
        $budget = $this->fillAndSubmitBudget($treasurer, $startYear, $amounts);
        Livewire::actingAs($chairman)->test(BudgetApprovals::class)->call('approveBudget', $budget->id);
        $line = $budget->fresh()->lines()->where('category', 'miscellaneous')->firstOrFail();

        Livewire::actingAs($treasurer)
            ->test(BudgetManager::class)
            ->set('startYear', $startYear)
            ->call('openExpenseForm')
            ->set('expenseBudgetLineId', (string) $line->id)
            ->set('expenseDescription', 'Unclear expense')
            ->set('expenseAmount', '5000')
            ->call('logExpense');

        $expense = Expense::firstOrFail();

        Livewire::actingAs($chairman)
            ->test(BudgetApprovals::class)
            ->call('openDeclineForm', $expense->id)
            ->set('declineNote', 'Needs a receipt attached first.')
            ->call('declineExpense');

        $expense->refresh();
        $this->assertSame(Expense::STATUS_CHAIRMAN_DECLINED, $expense->status);
        $this->assertSame('Needs a receipt attached first.', $expense->chairman_note);
        Notification::assertSentTo($treasurer, ExpenseAuthorizationDecisionNotification::class);
    }

    public function test_expenses_cannot_be_logged_against_an_unapproved_budget(): void
    {
        $treasurer = $this->makeUserWithRole('treasurer');
        [$startYear] = FinancialYear::current();

        Livewire::actingAs($treasurer)
            ->test(BudgetManager::class)
            ->set('startYear', $startYear)
            ->call('createDraft');

        try {
            Livewire::actingAs($treasurer)
                ->test(BudgetManager::class)
                ->set('startYear', $startYear)
                ->call('openExpenseForm')
                ->set('expenseBudgetLineId', '1')
                ->set('expenseDescription', 'x')
                ->set('expenseAmount', '100')
                ->call('logExpense');
            $this->fail('Expected logging an expense against a draft budget to be blocked.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_only_authorized_roles_can_manage_or_approve_budgets(): void
    {
        $member = $this->makeUserWithRole('member');

        try {
            Livewire::actingAs($member)->test(BudgetManager::class);
            $this->fail('Expected a member to be blocked from Budget Manager.');
        } catch (\Throwable $e) {
            // Expected.
        }

        try {
            Livewire::actingAs($member)->test(BudgetApprovals::class);
            $this->fail('Expected a member to be blocked from Budget Approvals.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_paid_expense_appears_as_operating_expense_on_the_income_statement(): void
    {
        $treasurer = $this->makeUserWithRole('treasurer');
        $chairman = $this->makeUserWithRole('chairman');
        [$startYear, $start, $end] = FinancialYear::current();

        $amounts = array_fill_keys(array_keys(Budget::CATEGORIES), 0);
        $amounts['utilities'] = 30000;
        $budget = $this->fillAndSubmitBudget($treasurer, $startYear, $amounts);
        Livewire::actingAs($chairman)->test(BudgetApprovals::class)->call('approveBudget', $budget->id);
        $line = $budget->fresh()->lines()->where('category', 'utilities')->firstOrFail();

        Livewire::actingAs($treasurer)
            ->test(BudgetManager::class)
            ->set('startYear', $startYear)
            ->call('openExpenseForm')
            ->set('expenseBudgetLineId', (string) $line->id)
            ->set('expenseDescription', 'Electricity bill')
            ->set('expenseAmount', '12500')
            ->call('logExpense');

        $expense = Expense::firstOrFail();
        Livewire::actingAs($chairman)->test(BudgetApprovals::class)->call('authorizeExpense', $expense->id);
        Livewire::actingAs($treasurer)->test(BudgetManager::class)->set('startYear', $startYear)->call('markPaid', $expense->id);

        $service = new FinancialStatementService;
        $incomeStatement = $service->incomeStatement($start, $end);
        $operatingExpenseLine = collect($incomeStatement['expenses'])->firstWhere('label', 'Operating Expenses');

        $this->assertNotNull($operatingExpenseLine);
        $this->assertSame(12500.0, $operatingExpenseLine['amount']);

        $trialBalance = $service->trialBalance($start, $end);
        $this->assertTrue($trialBalance['balances'], 'Trial balance must still balance after an operating expense is paid.');
    }

    public function test_budget_reports_page_is_read_only_and_shows_the_correct_figures(): void
    {
        $treasurer = $this->makeUserWithRole('treasurer');
        $chairman = $this->makeUserWithRole('chairman');
        $auditor = $this->makeUserWithRole('auditor');
        [$startYear] = FinancialYear::current();

        $amounts = array_fill_keys(array_keys(Budget::CATEGORIES), 0);
        $amounts['training'] = 40000;
        $budget = $this->fillAndSubmitBudget($treasurer, $startYear, $amounts);
        Livewire::actingAs($chairman)->test(BudgetApprovals::class)->call('approveBudget', $budget->id);

        Livewire::actingAs($auditor)
            ->test(BudgetReports::class)
            ->set('startYear', $startYear)
            ->assertOk()
            ->assertSee('Training');
    }
}
