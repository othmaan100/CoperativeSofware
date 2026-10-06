<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div x-data="{ sidebarOpen: false }">
    {{-- Slim top bar (all breakpoints) --}}
    <div class="sticky top-0 z-30 flex items-center h-16 bg-white dark:bg-gray-800 border-b border-slate-100 dark:border-gray-700 px-4 sm:px-6 lg:pl-64">
        <button @click="sidebarOpen = true" class="lg:hidden -ml-1 mr-3 p-2 rounded-md text-slate-500 hover:bg-slate-100 dark:hover:bg-gray-700">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2 lg:hidden">
            <x-application-logo class="h-8 w-8" />
            <span class="text-sm font-bold text-emerald-800 dark:text-emerald-400">FCE (T) Potiskum Coop</span>
        </a>

        <div class="ms-auto flex items-center gap-2">
            <livewire:notifications.notification-bell />

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile')" wire:navigate>
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <button wire:click="logout" class="w-full text-start">
                        <x-dropdown-link>
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </button>
                </x-slot>
            </x-dropdown>
        </div>
    </div>

    {{-- Mobile backdrop --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"
         style="display: none;"></div>

    {{-- Sidebar --}}
    <aside
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-slate-100 dark:border-gray-700 flex flex-col transform transition-transform duration-200 ease-in-out lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <div class="h-16 flex items-center gap-2 px-4 border-b border-slate-100 dark:border-gray-700 shrink-0">
            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2">
                <x-application-logo class="h-9 w-9" />
                <span class="leading-tight">
                    <span class="block text-sm font-bold text-emerald-800 dark:text-emerald-400">FCE (T) Potiskum</span>
                    <span class="block text-[11px] text-slate-500 dark:text-slate-400 -mt-0.5">Staff Cooperative Society</span>
                </span>
            </a>
            <button @click="sidebarOpen = false" class="ms-auto lg:hidden p-1 rounded-md text-slate-400 hover:bg-slate-100 dark:hover:bg-gray-700">
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('announcements.index')" :active="request()->routeIs('announcements.index')" wire:navigate>
                {{ __('Announcements') }}
            </x-sidebar-link>

            @can('view_own_application')
                <x-sidebar-link :href="route('my-application')" :active="request()->routeIs('my-application')" wire:navigate>
                    {{ __('My Application') }}
                </x-sidebar-link>
            @endcan

            @can('view_own_profile')
                <x-sidebar-link :href="route('my-profile')" :active="request()->routeIs('my-profile')" wire:navigate>
                    {{ __('My Profile') }}
                </x-sidebar-link>
            @endcan

            @can('view_all_members')
                <x-sidebar-link :href="route('members.index')" :active="request()->routeIs('members.*')" wire:navigate>
                    {{ __('Members') }}
                </x-sidebar-link>
            @endcan

            @can('approve_applications')
                <x-sidebar-link :href="route('treasurer.applications')" :active="request()->routeIs('treasurer.applications')" wire:navigate>
                    {{ __('Pending Applications') }}
                </x-sidebar-link>
            @endcan

            @can('review_change_requests')
                <x-sidebar-link :href="route('secretary.change-requests')" :active="request()->routeIs('secretary.change-requests')" wire:navigate>
                    {{ __('Change Requests') }}
                </x-sidebar-link>
            @endcan

            @can('view_own_savings')
                <x-sidebar-link :href="route('my-savings')" :active="request()->routeIs('my-savings')" wire:navigate>
                    {{ __('My Savings') }}
                </x-sidebar-link>
            @endcan

            @can('view_own_loans')
                <x-sidebar-link :href="route('my-loans')" :active="request()->routeIs('my-loans')" wire:navigate>
                    {{ __('My Loans') }}
                </x-sidebar-link>
                <x-sidebar-link :href="route('loans.guarantor-requests')" :active="request()->routeIs('loans.guarantor-requests')" wire:navigate>
                    {{ __('Guarantor Requests') }}
                </x-sidebar-link>
            @endcan

            @can('view_own_shares')
                <x-sidebar-link :href="route('my-shares')" :active="request()->routeIs('my-shares')" wire:navigate>
                    {{ __('My Shares') }}
                </x-sidebar-link>
            @endcan

            @can('view_own_dividends')
                <x-sidebar-link :href="route('my-dividends')" :active="request()->routeIs('my-dividends')" wire:navigate>
                    {{ __('My Dividends') }}
                </x-sidebar-link>
            @endcan

            @can('raise_complaint')
                <x-sidebar-link :href="route('support.my-tickets')" :active="request()->routeIs('support.my-tickets') || request()->routeIs('support.tickets.show')" wire:navigate>
                    {{ __('My Tickets') }}
                </x-sidebar-link>
            @endcan

            @can('request_commodity_loan')
                <x-sidebar-link :href="route('commodities.request')" :active="request()->routeIs('commodities.request')" wire:navigate>
                    {{ __('Commodity Loan') }}
                </x-sidebar-link>
            @endcan

            @canany(['view_all_members', 'approve_applications', 'review_change_requests', 'import_members'])
                <x-sidebar-group label="Membership" :active="request()->routeIs(['members.*', 'treasurer.applications', 'secretary.change-requests', 'treasurer.member-imports.*'])">
                    @can('view_all_members')
                        <x-sidebar-link :href="route('members.index')" :active="request()->routeIs('members.*')" wire:navigate>
                            {{ __('Members') }}
                        </x-sidebar-link>
                    @endcan

                    @can('approve_applications')
                        <x-sidebar-link :href="route('treasurer.applications')" :active="request()->routeIs('treasurer.applications')" wire:navigate>
                            {{ __('Pending Applications') }}
                        </x-sidebar-link>
                    @endcan

                    @can('review_change_requests')
                        <x-sidebar-link :href="route('secretary.change-requests')" :active="request()->routeIs('secretary.change-requests')" wire:navigate>
                            {{ __('Change Requests') }}
                        </x-sidebar-link>
                    @endcan

                    @can('import_members')
                        <x-sidebar-link :href="route('treasurer.member-imports.index')" :active="request()->routeIs('treasurer.member-imports.*')" wire:navigate>
                            {{ __('Member Import') }}
                        </x-sidebar-link>
                    @endcan
                </x-sidebar-group>
            @endcanany

            @canany(['post_contribution_batch', 'confirm_voluntary_deposit', 'adjust_contribution', 'treasurer_review_withdrawal', 'chairman_authorize_withdrawal', 'initiate_reversal', 'authorize_reversal', 'manage_withdrawal_conditions'])
                <x-sidebar-group label="Savings & Withdrawals" :active="request()->routeIs(['treasurer.contribution-batches.*', 'treasurer.withdrawal-imports.*', 'treasurer.voluntary-deposits', 'treasurer.contribution-change-requests', 'treasurer.withdrawals', 'chairman.withdrawals', 'reversals.*', 'withdrawal-conditions.*'])">
                    @can('post_contribution_batch')
                        <x-sidebar-link :href="route('treasurer.contribution-batches.index')" :active="request()->routeIs('treasurer.contribution-batches.*')" wire:navigate>
                            {{ __('Contributions') }}
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('treasurer.withdrawal-imports.index')" :active="request()->routeIs('treasurer.withdrawal-imports.*')" wire:navigate>
                            {{ __('Withdrawal Import') }}
                        </x-sidebar-link>
                    @endcan

                    @can('confirm_voluntary_deposit')
                        <x-sidebar-link :href="route('treasurer.voluntary-deposits')" :active="request()->routeIs('treasurer.voluntary-deposits')" wire:navigate>
                            {{ __('Voluntary Deposits') }}
                        </x-sidebar-link>
                    @endcan

                    @can('adjust_contribution')
                        <x-sidebar-link :href="route('treasurer.contribution-change-requests')" :active="request()->routeIs('treasurer.contribution-change-requests')" wire:navigate>
                            {{ __('Contribution Changes') }}
                        </x-sidebar-link>
                    @endcan

                    @can('treasurer_review_withdrawal')
                        <x-sidebar-link :href="route('treasurer.withdrawals')" :active="request()->routeIs('treasurer.withdrawals')" wire:navigate>
                            {{ __('Withdrawals') }}
                        </x-sidebar-link>
                    @endcan

                    @can('chairman_authorize_withdrawal')
                        <x-sidebar-link :href="route('chairman.withdrawals')" :active="request()->routeIs('chairman.withdrawals')" wire:navigate>
                            {{ __('Withdrawal Authorization') }}
                        </x-sidebar-link>
                    @endcan

                    @canany(['initiate_reversal', 'authorize_reversal'])
                        <x-sidebar-link :href="route('reversals.index')" :active="request()->routeIs('reversals.*')" wire:navigate>
                            {{ __('Reversals') }}
                        </x-sidebar-link>
                    @endcanany

                    @can('manage_withdrawal_conditions')
                        <x-sidebar-link :href="route('withdrawal-conditions.index')" :active="request()->routeIs('withdrawal-conditions.*')" wire:navigate>
                            {{ __('Withdrawal Rules') }}
                        </x-sidebar-link>
                    @endcan
                </x-sidebar-group>
            @endcanany

            @canany(['confirm_share_purchase', 'treasurer_review_share_withdrawal', 'chairman_authorize_share_withdrawal', 'manage_share_price'])
                <x-sidebar-group label="Share Capital" :active="request()->routeIs(['treasurer.share-purchase-intents', 'treasurer.share-withdrawals', 'chairman.share-withdrawals', 'admin.share-price'])">
                    @can('confirm_share_purchase')
                        <x-sidebar-link :href="route('treasurer.share-purchase-intents')" :active="request()->routeIs('treasurer.share-purchase-intents')" wire:navigate>
                            {{ __('Share Purchase Confirmations') }}
                        </x-sidebar-link>
                    @endcan

                    @can('treasurer_review_share_withdrawal')
                        <x-sidebar-link :href="route('treasurer.share-withdrawals')" :active="request()->routeIs('treasurer.share-withdrawals')" wire:navigate>
                            {{ __('Share Withdrawals') }}
                        </x-sidebar-link>
                    @endcan

                    @can('chairman_authorize_share_withdrawal')
                        <x-sidebar-link :href="route('chairman.share-withdrawals')" :active="request()->routeIs('chairman.share-withdrawals')" wire:navigate>
                            {{ __('Share Withdrawal Authorization') }}
                        </x-sidebar-link>
                    @endcan

                    @can('manage_share_price')
                        <x-sidebar-link :href="route('admin.share-price')" :active="request()->routeIs('admin.share-price')" wire:navigate>
                            {{ __('Share Price Settings') }}
                        </x-sidebar-link>
                    @endcan
                </x-sidebar-group>
            @endcanany

            @canany(['manage_dividend_periods', 'declare_dividend_rates'])
                <x-sidebar-group label="Dividends" :active="request()->routeIs(['treasurer.dividend-periods', 'chairman.dividend-declarations'])">
                    @can('manage_dividend_periods')
                        <x-sidebar-link :href="route('treasurer.dividend-periods')" :active="request()->routeIs('treasurer.dividend-periods')" wire:navigate>
                            {{ __('Dividend Periods') }}
                        </x-sidebar-link>
                    @endcan

                    @can('declare_dividend_rates')
                        <x-sidebar-link :href="route('chairman.dividend-declarations')" :active="request()->routeIs('chairman.dividend-declarations')" wire:navigate>
                            {{ __('Dividend Declarations') }}
                        </x-sidebar-link>
                    @endcan
                </x-sidebar-group>
            @endcanany

            @canany(['manage_budgets', 'approve_budgets'])
                <x-sidebar-group label="Budgeting" :active="request()->routeIs(['treasurer.budget-manager', 'chairman.budget-approvals'])">
                    @can('manage_budgets')
                        <x-sidebar-link :href="route('treasurer.budget-manager')" :active="request()->routeIs('treasurer.budget-manager')" wire:navigate>
                            {{ __('Budget Manager') }}
                        </x-sidebar-link>
                    @endcan

                    @can('approve_budgets')
                        <x-sidebar-link :href="route('chairman.budget-approvals')" :active="request()->routeIs('chairman.budget-approvals')" wire:navigate>
                            {{ __('Budget Approvals') }}
                        </x-sidebar-link>
                    @endcan
                </x-sidebar-group>
            @endcanany

            @canany(['initiate_welfare_claim', 'authorize_welfare_claim', 'disburse_welfare_claim', 'post_welfare_levy', 'manage_welfare_settings'])
                <x-sidebar-group label="Welfare Fund" :active="request()->routeIs(['welfare.claims.*', 'treasurer.welfare-levy-batches.*', 'chairman.welfare-settings'])">
                    @canany(['initiate_welfare_claim', 'authorize_welfare_claim', 'disburse_welfare_claim'])
                        <x-sidebar-link :href="route('welfare.claims.index')" :active="request()->routeIs('welfare.claims.*')" wire:navigate>
                            {{ __('Welfare Claims') }}
                        </x-sidebar-link>
                    @endcanany

                    @can('post_welfare_levy')
                        <x-sidebar-link :href="route('treasurer.welfare-levy-batches.index')" :active="request()->routeIs('treasurer.welfare-levy-batches.*')" wire:navigate>
                            {{ __('Welfare Levy Batches') }}
                        </x-sidebar-link>
                    @endcan

                    @can('manage_welfare_settings')
                        <x-sidebar-link :href="route('chairman.welfare-settings')" :active="request()->routeIs('chairman.welfare-settings')" wire:navigate>
                            {{ __('Welfare Settings') }}
                        </x-sidebar-link>
                    @endcan
                </x-sidebar-group>
            @endcanany

            @canany(['treasurer_review_loan', 'post_loan_repayment_batch', 'confirm_loan_repayment', 'import_loans', 'chairman_authorize_loan', 'manage_loan_products', 'set_loan_interest_rates', 'manage_loan_limit_multiplier', 'manage_commodity_catalogue', 'manage_commodity_cycles', 'price_commodity_cycle', 'verify_commodity_cycle', 'approve_commodity_cycle', 'authorize_commodity_cycle', 'release_commodity_goods'])
                <x-sidebar-group label="Loans" :active="request()->routeIs(['treasurer.loans', 'treasurer.loan-repayment-batches.*', 'treasurer.loan-repayment-intents', 'treasurer.savings-loan-repayments', 'treasurer.loan-repayment-reversals','treasurer.loan-tenure-changes', 'treasurer.loan-imports.*', 'chairman.loans', 'chairman.loan-tenure-changes', 'admin.loan-products.*', 'commodities.*'])">
                    @can('treasurer_review_loan')
                        <x-sidebar-link :href="route('treasurer.loans')" :active="request()->routeIs('treasurer.loans')" wire:navigate>
                            {{ __('Loan Applications') }}
                        </x-sidebar-link>
                    @endcan

                    @can('post_loan_repayment_batch')
                        <x-sidebar-link :href="route('treasurer.loan-repayment-batches.index')" :active="request()->routeIs('treasurer.loan-repayment-batches.*')" wire:navigate>
                            {{ __('Loan Repayment Batches') }}
                        </x-sidebar-link>
                    @endcan

                    @can('confirm_loan_repayment')
                        <x-sidebar-link :href="route('treasurer.loan-repayment-intents')" :active="request()->routeIs('treasurer.loan-repayment-intents')" wire:navigate>
                            {{ __('Loan Repayment Confirmations') }}
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('treasurer.savings-loan-repayments')" :active="request()->routeIs('treasurer.savings-loan-repayments')" wire:navigate>
                            {{ __('Loan Repayments from Savings') }}
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('treasurer.loan-repayment-reversals')" :active="request()->routeIs('treasurer.loan-repayment-reversals')" wire:navigate>
                            {{ __('Excess Repayment Reversals') }}
                        </x-sidebar-link>
                    @endcan

                    @can('treasurer_review_loan')
                        <x-sidebar-link :href="route('treasurer.loan-tenure-changes')" :active="request()->routeIs('treasurer.loan-tenure-changes')" wire:navigate>
                            {{ __('Loan Tenure Changes') }}
                        </x-sidebar-link>
                    @endcan

                    @can('import_loans')
                        <x-sidebar-link :href="route('treasurer.loan-imports.index')" :active="request()->routeIs('treasurer.loan-imports.*')" wire:navigate>
                            {{ __('Loan Import') }}
                        </x-sidebar-link>
                    @endcan

                    @can('chairman_authorize_loan')
                        <x-sidebar-link :href="route('chairman.loans')" :active="request()->routeIs('chairman.loans')" wire:navigate>
                            {{ __('Loan Authorizations') }}
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('chairman.loan-tenure-changes')" :active="request()->routeIs('chairman.loan-tenure-changes')" wire:navigate>
                            {{ __('Loan Tenure Approvals') }}
                        </x-sidebar-link>
                    @endcan

                    @canany(['manage_loan_products', 'set_loan_interest_rates', 'manage_loan_limit_multiplier'])
                        <x-sidebar-link :href="route('admin.loan-products.index')" :active="request()->routeIs('admin.loan-products.*')" wire:navigate>
                            {{ __('Loan Products') }}
                        </x-sidebar-link>
                    @endcanany

                    @can('manage_commodity_catalogue')
                        <x-sidebar-link :href="route('commodities.catalogue')" :active="request()->routeIs('commodities.catalogue')" wire:navigate>
                            {{ __('Commodity Catalogue') }}
                        </x-sidebar-link>
                    @endcan

                    @canany(['manage_commodity_cycles', 'price_commodity_cycle', 'verify_commodity_cycle', 'approve_commodity_cycle', 'authorize_commodity_cycle', 'release_commodity_goods'])
                        <x-sidebar-link :href="route('commodities.cycles.index')" :active="request()->routeIs('commodities.cycles.*')" wire:navigate>
                            {{ __('Commodity Cycles') }}
                        </x-sidebar-link>
                    @endcanany
                </x-sidebar-group>
            @endcanany

            @canany(['view_savings_reports', 'view_loan_reports', 'view_registration_fee_reports', 'view_share_reports', 'view_dividend_reports', 'view_financial_statements', 'view_budget_reports', 'view_welfare_reports'])
                <x-sidebar-group label="Reports" :active="request()->routeIs(['reports.savings', 'reports.loans', 'reports.registration-fees', 'reports.shares', 'reports.dividends', 'reports.financial-statements', 'reports.budgets', 'reports.welfare'])">
                    @can('view_savings_reports')
                        <x-sidebar-link :href="route('reports.savings')" :active="request()->routeIs('reports.savings')" wire:navigate>
                            {{ __('Savings Reports') }}
                        </x-sidebar-link>
                    @endcan

                    @can('view_loan_reports')
                        <x-sidebar-link :href="route('reports.loans')" :active="request()->routeIs('reports.loans')" wire:navigate>
                            {{ __('Loan Reports') }}
                        </x-sidebar-link>
                    @endcan

                    @can('view_registration_fee_reports')
                        <x-sidebar-link :href="route('reports.registration-fees')" :active="request()->routeIs('reports.registration-fees')" wire:navigate>
                            {{ __('Registration Fees') }}
                        </x-sidebar-link>
                    @endcan

                    @can('view_share_reports')
                        <x-sidebar-link :href="route('reports.shares')" :active="request()->routeIs('reports.shares')" wire:navigate>
                            {{ __('Share Reports') }}
                        </x-sidebar-link>
                    @endcan

                    @can('view_dividend_reports')
                        <x-sidebar-link :href="route('reports.dividends')" :active="request()->routeIs('reports.dividends')" wire:navigate>
                            {{ __('Dividend Reports') }}
                        </x-sidebar-link>
                    @endcan

                    @can('view_financial_statements')
                        <x-sidebar-link :href="route('reports.financial-statements')" :active="request()->routeIs('reports.financial-statements')" wire:navigate>
                            {{ __('Financial Statements') }}
                        </x-sidebar-link>
                    @endcan

                    @can('view_budget_reports')
                        <x-sidebar-link :href="route('reports.budgets')" :active="request()->routeIs('reports.budgets')" wire:navigate>
                            {{ __('Budget Reports') }}
                        </x-sidebar-link>
                    @endcan

                    @can('view_welfare_reports')
                        <x-sidebar-link :href="route('reports.welfare')" :active="request()->routeIs('reports.welfare')" wire:navigate>
                            {{ __('Welfare Fund Reports') }}
                        </x-sidebar-link>
                    @endcan
                </x-sidebar-group>
            @endcanany

            @can('manage_users')
                <x-sidebar-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" wire:navigate>
                    {{ __('User Management') }}
                </x-sidebar-link>
            @endcan

            @can('view_activity_log')
                <x-sidebar-link :href="route('admin.activity-log')" :active="request()->routeIs('admin.activity-log')" wire:navigate>
                    {{ __('Activity Log') }}
                </x-sidebar-link>
            @endcan

            @can('manage_announcements')
                <x-sidebar-link :href="route('admin.announcements')" :active="request()->routeIs('admin.announcements')" wire:navigate>
                    {{ __('Manage Announcements') }}
                </x-sidebar-link>
            @endcan

            @canany(['handle_complaints', 'handle_confidential_complaints'])
                <x-sidebar-link :href="route('support.tickets.index')" :active="request()->routeIs('support.tickets.index') || request()->routeIs('support.tickets.show')" wire:navigate>
                    {{ __('Support Tickets') }}
                </x-sidebar-link>
            @endcanany
        </nav>

        <div class="shrink-0 border-t border-slate-100 dark:border-gray-700 p-4">
            <div class="font-medium text-sm text-slate-800 dark:text-slate-200 truncate" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
            <div class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ auth()->user()->email }}</div>

            <div class="mt-3 flex items-center gap-3 text-sm">
                <a href="{{ route('profile') }}" wire:navigate class="text-slate-600 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400">
                    {{ __('Profile') }}
                </a>
                <span class="text-slate-300 dark:text-gray-600">&middot;</span>
                <button wire:click="logout" class="text-slate-600 dark:text-slate-300 hover:text-red-600">
                    {{ __('Log Out') }}
                </button>
            </div>
        </div>
    </aside>
</div>
