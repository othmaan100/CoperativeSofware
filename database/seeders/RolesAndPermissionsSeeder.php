<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            // Module 1 — Member Management
            'view_own_application',
            'view_own_profile',
            'edit_own_profile',
            'request_exit',
            'view_all_members',
            'approve_applications',
            'reject_applications',
            'adjust_contribution',
            'mark_application_fee_paid',
            'review_change_requests',
            'edit_locked_fields',
            'manage_member_status',
            'export_reports',
            'view_registration_fee_reports',
            'manage_registration_fee_settings',

            // Module 2 — Savings & Withdrawals
            'view_own_savings',
            'request_withdrawal',
            'make_voluntary_deposit',
            'post_contribution_batch',
            'confirm_voluntary_deposit',
            'treasurer_review_withdrawal',
            'chairman_authorize_withdrawal',
            'disburse_withdrawal',
            'initiate_reversal',
            'authorize_reversal',
            'manage_withdrawal_conditions',
            'manage_savings_products',
            'view_savings_reports',
            'import_members',

            // Module 3 — Loans & Loan Repayment
            'view_own_loans',
            'apply_for_loan',
            'treasurer_review_loan',
            'chairman_authorize_loan',
            'disburse_loan',
            'post_loan_repayment_batch',
            'confirm_loan_repayment',
            'manage_loan_products',
            'set_loan_interest_rates',
            'manage_loan_limit_multiplier',
            'import_loans',
            'view_loan_reports',

            // Module 4 — Share Capital
            'view_own_shares',
            'purchase_shares',
            'request_share_withdrawal',
            'confirm_share_purchase',
            'treasurer_review_share_withdrawal',
            'chairman_authorize_share_withdrawal',
            'disburse_share_withdrawal',
            'manage_share_price',
            'view_share_reports',

            // Module 5 — Dividends & Savings Interest
            'view_own_dividends',
            'manage_dividend_periods',
            'declare_dividend_rates',
            'calculate_dividends',
            'post_dividends',
            'view_dividend_reports',

            // Module 3B — Commodity Loans
            'request_commodity_loan',
            'manage_commodity_catalogue',
            'manage_commodity_cycles',
            'price_commodity_cycle',
            'verify_commodity_cycle',
            'approve_commodity_cycle',
            'authorize_commodity_cycle',
            'release_commodity_goods',

            // System — activity log
            'view_activity_log',

            // Module 6 — Documents & Announcements
            'manage_member_documents',
            'manage_loan_documents',
            'manage_announcements',

            // Module 7 — Financial Statements
            'view_financial_statements',

            // Module 8 — Complaints & Support Tickets
            'raise_complaint',
            'raise_complaint_on_behalf',
            'handle_complaints',
            'handle_confidential_complaints',

            // Module 9 — Budgeting
            'manage_budgets',
            'approve_budgets',
            'view_budget_reports',

            // Module 10 — Welfare / Death Benefit Fund
            'initiate_welfare_claim',
            'authorize_welfare_claim',
            'disburse_welfare_claim',
            'post_welfare_levy',
            'manage_welfare_settings',
            'view_welfare_reports',

            // Super Admin — system/user administration
            'manage_users',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $roles = [
            'applicant' => [
                'view_own_application',
            ],
            'member' => [
                'view_own_application',
                'view_own_profile',
                'edit_own_profile',
                'request_exit',
                'view_own_savings',
                'request_withdrawal',
                'make_voluntary_deposit',
                'view_own_loans',
                'apply_for_loan',
                'request_commodity_loan',
                'view_own_shares',
                'purchase_shares',
                'request_share_withdrawal',
                'view_own_dividends',
                'raise_complaint',
            ],
            'treasurer' => [
                'view_all_members',
                'approve_applications',
                'reject_applications',
                'adjust_contribution',
                'mark_application_fee_paid',
                'manage_member_status',
                'export_reports',
                'post_contribution_batch',
                'confirm_voluntary_deposit',
                'treasurer_review_withdrawal',
                'disburse_withdrawal',
                'initiate_reversal',
                'manage_withdrawal_conditions',
                'view_savings_reports',
                'import_members',
                'treasurer_review_loan',
                'disburse_loan',
                'post_loan_repayment_batch',
                'confirm_loan_repayment',
                'manage_loan_limit_multiplier',
                'import_loans',
                'view_loan_reports',
                'view_registration_fee_reports',
                'confirm_share_purchase',
                'treasurer_review_share_withdrawal',
                'disburse_share_withdrawal',
                'manage_share_price',
                'view_share_reports',
                'manage_dividend_periods',
                'calculate_dividends',
                'post_dividends',
                'view_dividend_reports',
                'manage_member_documents',
                'manage_loan_documents',
                'view_financial_statements',
                'raise_complaint_on_behalf',
                'handle_complaints',
                'manage_budgets',
                'view_budget_reports',
                'initiate_welfare_claim',
                'disburse_welfare_claim',
                'post_welfare_levy',
                'view_welfare_reports',
            ],
            'chairman' => [
                'view_all_members',
                'chairman_authorize_withdrawal',
                'authorize_reversal',
                'manage_withdrawal_conditions',
                'view_savings_reports',
                'chairman_authorize_loan',
                'set_loan_interest_rates',
                'view_loan_reports',
                'authorize_commodity_cycle',
                'view_registration_fee_reports',
                'manage_registration_fee_settings',
                'chairman_authorize_share_withdrawal',
                'manage_share_price',
                'view_share_reports',
                'declare_dividend_rates',
                'view_dividend_reports',
                'manage_loan_documents',
                'manage_announcements',
                'view_financial_statements',
                'handle_complaints',
                'handle_confidential_complaints',
                'approve_budgets',
                'view_budget_reports',
                'authorize_welfare_claim',
                'manage_welfare_settings',
                'view_welfare_reports',
            ],
            'secretary' => [
                'view_all_members',
                'review_change_requests',
                'export_reports',
                'manage_commodity_catalogue',
                'manage_commodity_cycles',
                'price_commodity_cycle',
                'manage_member_documents',
                'manage_announcements',
                'raise_complaint_on_behalf',
                'handle_complaints',
                'initiate_welfare_claim',
            ],
            'exco' => [
                'view_all_members',
                'view_savings_reports',
                'export_reports',
                'view_loan_reports',
                'view_registration_fee_reports',
                'view_share_reports',
                'view_dividend_reports',
                'handle_complaints',
                'view_budget_reports',
                'view_welfare_reports',
            ],
            'loan_officer' => [
                'view_all_members',
            ],
            'auditor' => [
                'view_all_members',
                'verify_commodity_cycle',
                'view_activity_log',
                'view_financial_statements',
                'view_budget_reports',
                'view_welfare_reports',
            ],
            'store_officer' => [
                'view_all_members',
                'approve_commodity_cycle',
                'release_commodity_goods',
            ],
            'super_admin' => $permissions,
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::findOrCreate($roleName);
            $role->syncPermissions($rolePermissions);
        }
    }
}
