<?php

namespace Database\Seeders;

use App\Models\LoanLimitMultiplier;
use App\Models\LoanProduct;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        // Emergency/Special Loan is configured identically to the Regular Loan
        // for now, per society instruction — split out later once its own
        // rate/tenure/eligibility rule is decided.
        $products = [
            [
                'code' => LoanProduct::REGULAR,
                'name' => 'Regular/Ordinary Loan',
            ],
            [
                'code' => LoanProduct::EMERGENCY,
                'name' => 'Emergency/Special Loan',
            ],
        ];

        foreach ($products as $definition) {
            $product = LoanProduct::query()->updateOrCreate(
                ['code' => $definition['code']],
                [
                    'name' => $definition['name'],
                    'interest_admin_pct' => 2.00,
                    'interest_profit_pct' => 8.00,
                    'max_tenure_months' => 12,
                    'min_membership_months' => 6,
                    'min_savings_balance' => 0,
                    'requires_guarantor' => true,
                    'min_guarantors' => 1,
                    'max_guarantors' => 2,
                    'disbursement_type' => 'cash_or_bank',
                    'default_after_days_overdue' => 30,
                    'guarantor_grace_days' => 7,
                    'is_active' => true,
                ]
            );

            LoanLimitMultiplier::query()->firstOrCreate(
                ['loan_product_id' => $product->id, 'is_active' => true],
                [
                    'multiplier' => 3.00,
                    'effective_from' => now()->toDateString(),
                    'set_by' => null,
                ]
            );
        }

        // The Commodity Loan product record is created now so it can be
        // referenced (e.g. by loans.loan_product_id) once the Commodity Loan
        // workflow itself is built; it has no guarantor and no cash multiplier.
        LoanProduct::query()->updateOrCreate(
            ['code' => LoanProduct::COMMODITY],
            [
                'name' => 'Commodity Loan',
                'interest_admin_pct' => 2.00,
                'interest_profit_pct' => 8.00,
                'max_tenure_months' => 3,
                'min_membership_months' => 0,
                'min_savings_balance' => 0,
                'requires_guarantor' => false,
                'min_guarantors' => null,
                'max_guarantors' => null,
                'disbursement_type' => 'goods',
                'default_after_days_overdue' => 30,
                'guarantor_grace_days' => 7,
                'is_active' => true,
            ]
        );
    }
}
