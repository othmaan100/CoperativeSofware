<?php

use App\Livewire\Admin\ActivityLogViewer;
use App\Livewire\Admin\LoanProductsManager;
use App\Livewire\Admin\SharePriceManager;
use App\Livewire\Admin\UserManagement;
use App\Livewire\Announcements\AnnouncementsBoard;
use App\Livewire\Announcements\AnnouncementsManager;
use App\Livewire\Chairman\DividendDeclarations;
use App\Livewire\Chairman\LoanAuthorizations;
use App\Livewire\Chairman\ShareWithdrawalsAuthorization;
use App\Livewire\Chairman\WithdrawalsAuthorization;
use App\Livewire\Commodities\CatalogueManager;
use App\Livewire\Commodities\CycleShow;
use App\Livewire\Commodities\CyclesIndex;
use App\Livewire\Commodities\RequestCommodity;
use App\Livewire\Loans\ApplyForLoan;
use App\Livewire\Loans\GuarantorRequests;
use App\Livewire\Loans\LoanShow;
use App\Livewire\Loans\MyLoans;
use App\Livewire\Notifications\NotificationsIndex;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PaystackController;
use App\Livewire\Members\MemberDirectory;
use App\Livewire\Members\MemberShow;
use App\Livewire\Members\MyApplication;
use App\Livewire\Members\MyDividends;
use App\Livewire\Members\MyProfile;
use App\Livewire\Members\PayApplicationFee;
use App\Livewire\Members\RegisterApplication;
use App\Livewire\Reports\DividendReports;
use App\Livewire\Reports\FinancialStatements;
use App\Livewire\Support\MyTickets;
use App\Livewire\Support\TicketQueue;
use App\Livewire\Support\TicketShow;
use App\Livewire\Reports\LoanReports;
use App\Livewire\Reports\RegistrationFeeReports;
use App\Livewire\Reports\SavingsReports;
use App\Livewire\Reports\ShareReports;
use App\Livewire\Savings\MySavings;
use App\Livewire\Savings\RequestCompleteWithdrawal;
use App\Livewire\Savings\RequestWithdrawal;
use App\Livewire\Savings\ReversalsBoard;
use App\Livewire\Savings\SavingsStatement;
use App\Livewire\Savings\WithdrawalConditionsManager;
use App\Livewire\Secretary\ChangeRequests;
use App\Livewire\Shares\MyShares;
use App\Livewire\Shares\RequestShareWithdrawal;
use App\Livewire\Treasurer\ContributionBatches;
use App\Livewire\Treasurer\ContributionBatchShow;
use App\Livewire\Treasurer\ContributionChangeRequests;
use App\Livewire\Treasurer\DividendPeriods;
use App\Livewire\Treasurer\InitiateDeceasedDisbursement;
use App\Livewire\Treasurer\LoanApplications;
use App\Livewire\Treasurer\LoanImports;
use App\Livewire\Treasurer\LoanImportShow;
use App\Livewire\Treasurer\LoanRepaymentBatches;
use App\Livewire\Treasurer\LoanRepaymentBatchShow;
use App\Livewire\Treasurer\LoanRepaymentIntents;
use App\Livewire\Treasurer\MemberImports;
use App\Livewire\Treasurer\MemberImportShow;
use App\Livewire\Treasurer\PendingApplications;
use App\Livewire\Treasurer\SharePurchaseIntents;
use App\Livewire\Treasurer\ShareWithdrawalsReview;
use App\Livewire\Treasurer\VoluntaryDeposits;
use App\Livewire\Treasurer\WithdrawalsReview;
use App\Models\Member;
use App\Models\SavingsAccount;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'activeMembers' => Member::query()->active()->count(),
        'totalSavings' => (float) SavingsAccount::query()->sum('balance'),
        'departments' => Member::query()->whereNotNull('department')->distinct()->count('department'),
    ]);
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Paystack redirects here without necessarily preserving auth state reliably
// across some browsers/webviews, so this route stays outside the auth group;
// the controller looks the payment up by its own reference, not the session.
Route::get('payments/paystack/callback', [PaystackController::class, 'callback'])->name('payments.paystack.callback');
Route::post('webhooks/paystack', [PaystackController::class, 'webhook'])->name('webhooks.paystack');

Route::middleware('auth')->group(function () {
    Route::get('my/application', MyApplication::class)->name('my-application');
    Route::get('my/application/pay-fee', PayApplicationFee::class)->name('my-application.pay-fee');
    Route::get('my/profile', MyProfile::class)->name('my-profile');

    Route::get('members', MemberDirectory::class)->name('members.index');
    Route::get('members/{member}', MemberShow::class)->name('members.show');

    Route::get('treasurer/applications', PendingApplications::class)->name('treasurer.applications');
    Route::get('secretary/change-requests', ChangeRequests::class)->name('secretary.change-requests');

    // Module 2 — Savings & Withdrawals
    Route::get('my/savings', MySavings::class)->name('my-savings');
    Route::get('savings/{account}/statement', SavingsStatement::class)->name('savings.statement');
    Route::get('savings/withdraw', RequestWithdrawal::class)->name('savings.withdraw');
    Route::get('savings/complete-withdraw', RequestCompleteWithdrawal::class)->name('savings.complete-withdraw');

    Route::get('treasurer/contribution-batches', ContributionBatches::class)->name('treasurer.contribution-batches.index');
    Route::get('treasurer/contribution-batches/{batch}', ContributionBatchShow::class)->name('treasurer.contribution-batches.show');
    Route::get('treasurer/voluntary-deposits', VoluntaryDeposits::class)->name('treasurer.voluntary-deposits');
    Route::get('voluntary-deposits/{intent}/receipt', [\App\Http\Controllers\ReceiptController::class, 'depositReceipt'])->name('voluntary-deposits.receipt');
    Route::get('loan-repayment-intents/{intent}/receipt', [\App\Http\Controllers\ReceiptController::class, 'repaymentReceipt'])->name('loan-repayment-intents.receipt');
    Route::get('treasurer/contribution-change-requests', ContributionChangeRequests::class)->name('treasurer.contribution-change-requests');
    Route::get('treasurer/withdrawals', WithdrawalsReview::class)->name('treasurer.withdrawals');
    Route::get('treasurer/members/{member}/deceased-disbursement', InitiateDeceasedDisbursement::class)->name('treasurer.deceased-disbursement');
    Route::get('treasurer/member-imports', MemberImports::class)->name('treasurer.member-imports.index');
    Route::get('treasurer/member-imports/{batch}', MemberImportShow::class)->name('treasurer.member-imports.show');

    Route::get('chairman/withdrawals', WithdrawalsAuthorization::class)->name('chairman.withdrawals');

    Route::get('reversals', ReversalsBoard::class)->name('reversals.index');
    Route::get('withdrawal-conditions', WithdrawalConditionsManager::class)->name('withdrawal-conditions.index');

    Route::get('reports/savings', SavingsReports::class)->name('reports.savings');

    Route::get('admin/users', UserManagement::class)->name('admin.users.index');
    Route::get('admin/activity-log', ActivityLogViewer::class)->name('admin.activity-log');

    // Module 3 — Loans & Loan Repayment
    Route::get('my/loans', MyLoans::class)->name('my-loans');
    Route::get('loans/apply', ApplyForLoan::class)->name('loans.apply');
    Route::get('loans/guarantor-requests', GuarantorRequests::class)->name('loans.guarantor-requests');

    Route::get('treasurer/loans', LoanApplications::class)->name('treasurer.loans');
    Route::get('treasurer/loan-repayment-batches', LoanRepaymentBatches::class)->name('treasurer.loan-repayment-batches.index');
    Route::get('treasurer/loan-repayment-batches/{batch}', LoanRepaymentBatchShow::class)->name('treasurer.loan-repayment-batches.show');
    Route::get('treasurer/loan-repayment-intents', LoanRepaymentIntents::class)->name('treasurer.loan-repayment-intents');
    Route::get('treasurer/savings-loan-repayments', \App\Livewire\Treasurer\SavingsLoanRepayments::class)->name('treasurer.savings-loan-repayments');
    Route::get('treasurer/loan-repayment-reversals', \App\Livewire\Treasurer\LoanRepaymentReversals::class)->name('treasurer.loan-repayment-reversals');
    Route::get('treasurer/loan-tenure-changes', \App\Livewire\Treasurer\LoanTenureChanges::class)->name('treasurer.loan-tenure-changes');
    Route::get('treasurer/loan-imports', LoanImports::class)->name('treasurer.loan-imports.index');
    Route::get('treasurer/loan-imports/{batch}', LoanImportShow::class)->name('treasurer.loan-imports.show');

    Route::get('chairman/loans', LoanAuthorizations::class)->name('chairman.loans');
    Route::get('chairman/loan-tenure-changes', \App\Livewire\Chairman\LoanTenureApprovals::class)->name('chairman.loan-tenure-changes');

    Route::get('admin/loan-products', LoanProductsManager::class)->name('admin.loan-products.index');

    Route::get('loans/{loan}', LoanShow::class)->name('loans.show');
    Route::get('reports/loans', LoanReports::class)->name('reports.loans');
    Route::get('reports/registration-fees', RegistrationFeeReports::class)->name('reports.registration-fees');
    Route::get('reports/shares', ShareReports::class)->name('reports.shares');

    // Module 4 — Share Capital
    Route::get('my/shares', MyShares::class)->name('my-shares');
    Route::get('shares/withdraw', RequestShareWithdrawal::class)->name('shares.withdraw');

    Route::get('treasurer/share-purchase-intents', SharePurchaseIntents::class)->name('treasurer.share-purchase-intents');
    Route::get('treasurer/share-withdrawals', ShareWithdrawalsReview::class)->name('treasurer.share-withdrawals');

    Route::get('chairman/share-withdrawals', ShareWithdrawalsAuthorization::class)->name('chairman.share-withdrawals');

    Route::get('admin/share-price', SharePriceManager::class)->name('admin.share-price');

    // Module 5 — Dividends & Savings Interest
    Route::get('my/dividends', MyDividends::class)->name('my-dividends');
    Route::get('treasurer/dividend-periods', DividendPeriods::class)->name('treasurer.dividend-periods');
    Route::get('chairman/dividend-declarations', DividendDeclarations::class)->name('chairman.dividend-declarations');
    Route::get('reports/dividends', DividendReports::class)->name('reports.dividends');

    // Module 6 — Documents, Notifications & Announcements
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('notifications', NotificationsIndex::class)->name('notifications.index');
    Route::get('announcements', AnnouncementsBoard::class)->name('announcements.index');
    Route::get('admin/announcements', AnnouncementsManager::class)->name('admin.announcements');

    // Module 7 — Financial Statements
    Route::get('reports/financial-statements', FinancialStatements::class)->name('reports.financial-statements');

    // Module 8 — Complaints & Support Tickets
    Route::get('support/my-tickets', MyTickets::class)->name('support.my-tickets');
    Route::get('support/tickets', TicketQueue::class)->name('support.tickets.index');
    Route::get('support/tickets/{ticket}', TicketShow::class)->name('support.tickets.show');

    // Module 9 — Budgeting
    Route::get('treasurer/budget-manager', \App\Livewire\Treasurer\BudgetManager::class)->name('treasurer.budget-manager');
    Route::get('chairman/budget-approvals', \App\Livewire\Chairman\BudgetApprovals::class)->name('chairman.budget-approvals');
    Route::get('reports/budgets', \App\Livewire\Reports\BudgetReports::class)->name('reports.budgets');

    // Module 10 — Welfare / Death Benefit Fund
    Route::get('members/{member}/welfare-claim', \App\Livewire\Welfare\InitiateClaim::class)->name('welfare.claims.create');
    Route::get('welfare/claims', \App\Livewire\Welfare\ClaimsIndex::class)->name('welfare.claims.index');
    Route::get('welfare/claims/{claim}', \App\Livewire\Welfare\ClaimShow::class)->name('welfare.claims.show');
    Route::get('treasurer/welfare-levy-batches', \App\Livewire\Treasurer\WelfareLevyBatches::class)->name('treasurer.welfare-levy-batches.index');
    Route::get('treasurer/welfare-levy-batches/{batch}', \App\Livewire\Treasurer\WelfareLevyBatchShow::class)->name('treasurer.welfare-levy-batches.show');
    Route::get('chairman/welfare-settings', \App\Livewire\Chairman\WelfareSettings::class)->name('chairman.welfare-settings');
    Route::get('reports/welfare', \App\Livewire\Reports\WelfareReports::class)->name('reports.welfare');

    // Module 3B — Commodity Loans
    Route::get('commodities/request', RequestCommodity::class)->name('commodities.request');
    Route::get('commodities/catalogue', CatalogueManager::class)->name('commodities.catalogue');
    Route::get('commodities/cycles', CyclesIndex::class)->name('commodities.cycles.index');
    Route::get('commodities/cycles/{cycle}', CycleShow::class)->name('commodities.cycles.show');
});

require __DIR__.'/auth.php';
