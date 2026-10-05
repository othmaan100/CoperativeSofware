<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <livewire:announcements.announcements-widget />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-slate-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-1">Welcome, {{ auth()->user()->name }}</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Here's what you have access to on the FCE (T) Potiskum Staff Cooperative Society portal.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @can('view_own_application')
                        <a href="{{ route('my-application') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">My Application</h4>
                            <p class="text-sm text-gray-500">Track your membership application status.</p>
                        </a>
                    @endcan

                    @can('view_own_profile')
                        <a href="{{ route('my-profile') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">My Profile</h4>
                            <p class="text-sm text-gray-500">View and update your membership profile.</p>
                        </a>
                    @endcan

                    @can('view_all_members')
                        <a href="{{ route('members.index') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Members Directory</h4>
                            <p class="text-sm text-gray-500">Search, filter and export the membership register.</p>
                        </a>
                    @endcan

                    @can('approve_applications')
                        <a href="{{ route('treasurer.applications') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Pending Applications</h4>
                            <p class="text-sm text-gray-500">Review, approve or reject membership applications.</p>
                        </a>
                    @endcan

                    @can('review_change_requests')
                        <a href="{{ route('secretary.change-requests') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Change Requests</h4>
                            <p class="text-sm text-gray-500">Review member-submitted profile corrections.</p>
                        </a>
                    @endcan

                    @can('view_own_savings')
                        <a href="{{ route('my-savings') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">My Savings</h4>
                            <p class="text-sm text-gray-500">View balances, request a withdrawal, log a deposit.</p>
                        </a>
                    @endcan

                    @can('view_own_loans')
                        <a href="{{ route('my-loans') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">My Loans</h4>
                            <p class="text-sm text-gray-500">Apply for a loan, track repayment, and guarantor requests.</p>
                        </a>
                    @endcan

                    @can('view_own_shares')
                        <a href="{{ route('my-shares') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">My Shares</h4>
                            <p class="text-sm text-gray-500">Buy shares, track holdings, and request a withdrawal.</p>
                        </a>
                    @endcan

                    @can('view_own_dividends')
                        <a href="{{ route('my-dividends') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">My Dividends</h4>
                            <p class="text-sm text-gray-500">See dividends and savings interest credited to you each year.</p>
                        </a>
                    @endcan

                    @can('raise_complaint')
                        <a href="{{ route('support.my-tickets') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">My Tickets</h4>
                            <p class="text-sm text-gray-500">Raise a complaint or query and track its progress.</p>
                        </a>
                    @endcan

                    @can('request_commodity_loan')
                        <a href="{{ route('commodities.request') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Commodity Loan</h4>
                            <p class="text-sm text-gray-500">Request items from the catalogue, repaid by salary deduction.</p>
                        </a>
                    @endcan

                    @can('post_contribution_batch')
                        <a href="{{ route('treasurer.contribution-batches.index') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Contribution Batches</h4>
                            <p class="text-sm text-gray-500">Upload and post monthly salary deductions.</p>
                        </a>
                    @endcan

                    @can('import_members')
                        <a href="{{ route('treasurer.member-imports.index') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Member Data Import</h4>
                            <p class="text-sm text-gray-500">Migrate existing members from manual/paper records via CSV.</p>
                        </a>
                    @endcan

                    @can('confirm_voluntary_deposit')
                        <a href="{{ route('treasurer.voluntary-deposits') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Voluntary Deposits</h4>
                            <p class="text-sm text-gray-500">Confirm receipt of member-logged deposits.</p>
                        </a>
                    @endcan

                    @can('confirm_loan_repayment')
                        <a href="{{ route('treasurer.loan-repayment-intents') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Loan Repayment Confirmations</h4>
                            <p class="text-sm text-gray-500">Confirm receipt of member-logged lump-sum repayments.</p>
                        </a>
                    @endcan

                    @can('confirm_loan_repayment')
                        <a href="{{ route('treasurer.savings-loan-repayments') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Loan Repayments from Savings</h4>
                            <p class="text-sm text-gray-500">Approve transfers from a member's savings balance to their loan.</p>
                        </a>
                        <a href="{{ route('treasurer.loan-repayment-reversals') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Excess Repayment Reversals</h4>
                            <p class="text-sm text-gray-500">Apply or refund amounts repaid beyond what a loan owed.</p>
                        </a>
                    @endcan

                    @can('adjust_contribution')
                        <a href="{{ route('treasurer.contribution-change-requests') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Contribution Change Requests</h4>
                            <p class="text-sm text-gray-500">Review member requests to change their monthly contribution.</p>
                        </a>
                    @endcan

                    @can('treasurer_review_withdrawal')
                        <a href="{{ route('treasurer.withdrawals') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Withdrawal Requests</h4>
                            <p class="text-sm text-gray-500">Review, endorse and disburse withdrawals.</p>
                        </a>
                    @endcan

                    @can('chairman_authorize_withdrawal')
                        <a href="{{ route('chairman.withdrawals') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Withdrawal Authorization</h4>
                            <p class="text-sm text-gray-500">Give final sign-off on endorsed withdrawals.</p>
                        </a>
                    @endcan

                    @can('treasurer_review_loan')
                        <a href="{{ route('treasurer.loans') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Loan Applications</h4>
                            <p class="text-sm text-gray-500">Review, endorse and disburse member loans.</p>
                        </a>
                        <a href="{{ route('treasurer.loan-tenure-changes') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Loan Tenure Changes</h4>
                            <p class="text-sm text-gray-500">Request a longer tenure for a member's active loan.</p>
                        </a>
                    @endcan

                    @can('post_loan_repayment_batch')
                        <a href="{{ route('treasurer.loan-repayment-batches.index') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Loan Repayment Batches</h4>
                            <p class="text-sm text-gray-500">Upload and post monthly loan salary deductions.</p>
                        </a>
                    @endcan

                    @can('import_loans')
                        <a href="{{ route('treasurer.loan-imports.index') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Loan Import</h4>
                            <p class="text-sm text-gray-500">Migrate existing manually tracked loans via CSV.</p>
                        </a>
                    @endcan

                    @can('chairman_authorize_loan')
                        <a href="{{ route('chairman.loans') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Loan Authorizations</h4>
                            <p class="text-sm text-gray-500">Give final sign-off on Treasurer-endorsed loans.</p>
                        </a>
                        <a href="{{ route('chairman.loan-tenure-changes') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Loan Tenure Approvals</h4>
                            <p class="text-sm text-gray-500">Approve or decline Treasurer requests to extend a loan's tenure.</p>
                        </a>
                    @endcan

                    @canany(['manage_loan_products', 'set_loan_interest_rates', 'manage_loan_limit_multiplier'])
                        <a href="{{ route('admin.loan-products.index') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Loan Products</h4>
                            <p class="text-sm text-gray-500">Configure rates, tenure, and the savings-linked limit.</p>
                        </a>
                    @endcanany

                    @can('manage_commodity_catalogue')
                        <a href="{{ route('commodities.catalogue') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Commodity Catalogue</h4>
                            <p class="text-sm text-gray-500">Manage the items members can request.</p>
                        </a>
                    @endcan

                    @canany(['manage_commodity_cycles', 'price_commodity_cycle', 'verify_commodity_cycle', 'approve_commodity_cycle', 'authorize_commodity_cycle', 'release_commodity_goods'])
                        <a href="{{ route('commodities.cycles.index') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Commodity Cycles</h4>
                            <p class="text-sm text-gray-500">Open cycles, price demand, and release goods to members.</p>
                        </a>
                    @endcanany

                    @canany(['initiate_reversal', 'authorize_reversal'])
                        <a href="{{ route('reversals.index') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Reversals &amp; Corrections</h4>
                            <p class="text-sm text-gray-500">Initiate or authorize a correcting entry.</p>
                        </a>
                    @endcanany

                    @can('manage_withdrawal_conditions')
                        <a href="{{ route('withdrawal-conditions.index') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Withdrawal Rules</h4>
                            <p class="text-sm text-gray-500">Configure minimum balance and other conditions.</p>
                        </a>
                    @endcan

                    @can('confirm_share_purchase')
                        <a href="{{ route('treasurer.share-purchase-intents') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Share Purchase Confirmations</h4>
                            <p class="text-sm text-gray-500">Confirm receipt of member-logged share purchases.</p>
                        </a>
                    @endcan

                    @can('treasurer_review_share_withdrawal')
                        <a href="{{ route('treasurer.share-withdrawals') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Share Withdrawal Requests</h4>
                            <p class="text-sm text-gray-500">Review, endorse and disburse share withdrawals.</p>
                        </a>
                    @endcan

                    @can('chairman_authorize_share_withdrawal')
                        <a href="{{ route('chairman.share-withdrawals') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Share Withdrawal Authorization</h4>
                            <p class="text-sm text-gray-500">Give final sign-off on endorsed share withdrawals.</p>
                        </a>
                    @endcan

                    @can('manage_share_price')
                        <a href="{{ route('admin.share-price') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Share Price Settings</h4>
                            <p class="text-sm text-gray-500">Set the per-share price and minimum holding.</p>
                        </a>
                    @endcan

                    @can('manage_dividend_periods')
                        <a href="{{ route('treasurer.dividend-periods') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Dividend Periods</h4>
                            <p class="text-sm text-gray-500">Open periods, calculate allocations, and post to savings.</p>
                        </a>
                    @endcan

                    @can('declare_dividend_rates')
                        <a href="{{ route('chairman.dividend-declarations') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Dividend Declarations</h4>
                            <p class="text-sm text-gray-500">Declare the share dividend and savings interest rates.</p>
                        </a>
                    @endcan

                    @can('manage_budgets')
                        <a href="{{ route('treasurer.budget-manager') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Budget Manager</h4>
                            <p class="text-sm text-gray-500">Propose the annual budget and log operating expenses.</p>
                        </a>
                    @endcan

                    @can('approve_budgets')
                        <a href="{{ route('chairman.budget-approvals') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Budget Approvals</h4>
                            <p class="text-sm text-gray-500">Approve the annual budget and authorize expenses.</p>
                        </a>
                    @endcan

                    @canany(['initiate_welfare_claim', 'authorize_welfare_claim', 'disburse_welfare_claim'])
                        <a href="{{ route('welfare.claims.index') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Welfare Claims</h4>
                            <p class="text-sm text-gray-500">Death benefit claims awaiting authorization or disbursement.</p>
                        </a>
                    @endcanany

                    @can('post_welfare_levy')
                        <a href="{{ route('treasurer.welfare-levy-batches.index') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Welfare Levy Batches</h4>
                            <p class="text-sm text-gray-500">Record which members paid the welfare levy this period.</p>
                        </a>
                    @endcan

                    @can('manage_welfare_settings')
                        <a href="{{ route('chairman.welfare-settings') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Welfare Settings</h4>
                            <p class="text-sm text-gray-500">Set the welfare levy and death benefit payout amounts.</p>
                        </a>
                    @endcan

                    @can('view_savings_reports')
                        <a href="{{ route('reports.savings') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Savings Reports</h4>
                            <p class="text-sm text-gray-500">Totals, top savers, batches, withdrawals, reversals.</p>
                        </a>
                    @endcan

                    @can('view_loan_reports')
                        <a href="{{ route('reports.loans') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Loan Reports</h4>
                            <p class="text-sm text-gray-500">Portfolio, overdue loans, guarantor exposure, interest split.</p>
                        </a>
                    @endcan

                    @can('view_registration_fee_reports')
                        <a href="{{ route('reports.registration-fees') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Registration Fees</h4>
                            <p class="text-sm text-gray-500">Admin/profit split on application fees collected.</p>
                        </a>
                    @endcan

                    @can('view_share_reports')
                        <a href="{{ route('reports.shares') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Share Reports</h4>
                            <p class="text-sm text-gray-500">Total shares outstanding, share capital, top shareholders.</p>
                        </a>
                    @endcan

                    @can('view_dividend_reports')
                        <a href="{{ route('reports.dividends') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Dividend Reports</h4>
                            <p class="text-sm text-gray-500">Per-period totals against tracked profit, top recipients.</p>
                        </a>
                    @endcan

                    @can('view_financial_statements')
                        <a href="{{ route('reports.financial-statements') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Financial Statements</h4>
                            <p class="text-sm text-gray-500">Trial Balance, Income Statement and Balance Sheet by financial year.</p>
                        </a>
                    @endcan

                    @can('view_budget_reports')
                        <a href="{{ route('reports.budgets') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Budget Reports</h4>
                            <p class="text-sm text-gray-500">Budget vs. actual spend by category, for the financial year.</p>
                        </a>
                    @endcan

                    @can('view_welfare_reports')
                        <a href="{{ route('reports.welfare') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Welfare Fund Reports</h4>
                            <p class="text-sm text-gray-500">Fund balance, levy collections and death benefit payouts.</p>
                        </a>
                    @endcan

                    @can('manage_announcements')
                        <a href="{{ route('admin.announcements') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Manage Announcements</h4>
                            <p class="text-sm text-gray-500">Post a society-wide notice to every member.</p>
                        </a>
                    @endcan

                    @canany(['handle_complaints', 'handle_confidential_complaints'])
                        <a href="{{ route('support.tickets.index') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Support Tickets</h4>
                            <p class="text-sm text-gray-500">Handle member complaints and queries.</p>
                        </a>
                    @endcanany

                    @can('manage_users')
                        <a href="{{ route('admin.users.index') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">User Management</h4>
                            <p class="text-sm text-gray-500">View accounts, roles, and reset passwords.</p>
                        </a>
                    @endcan

                    @can('view_activity_log')
                        <a href="{{ route('admin.activity-log') }}" wire:navigate class="block p-4 rounded-lg border border-slate-200 dark:border-gray-700 hover:border-emerald-400 hover:shadow-md bg-white dark:bg-gray-800/50 transition">
                            <h4 class="font-medium text-slate-900 dark:text-white">Activity Log</h4>
                            <p class="text-sm text-gray-500">System-wide trail of logins and every major action.</p>
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
