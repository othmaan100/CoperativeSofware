<?php

namespace Database\Seeders;

use App\Models\SavingsProduct;
use App\Models\WithdrawalCondition;
use Illuminate\Database\Seeder;

class SavingsSeeder extends Seeder
{
    public function run(): void
    {
        $regular = SavingsProduct::query()->updateOrCreate(
            ['code' => SavingsProduct::REGULAR],
            [
                'name' => 'Regular Savings',
                'is_interest_bearing' => false,
                'description' => 'Funded by approved monthly salary deduction plus voluntary top-ups.',
                'is_active' => true,
            ]
        );

        SavingsProduct::query()->updateOrCreate(
            ['code' => SavingsProduct::TARGET],
            [
                'name' => 'Target/Special Savings',
                'is_interest_bearing' => false,
                'description' => 'Member-defined goal savings with an optional target amount and date.',
                'is_active' => true,
            ]
        );

        // Starting default — Chairman/Treasurer should confirm and adjust via the
        // Withdrawal Conditions screen; this is a placeholder, not a constitution figure.
        WithdrawalCondition::query()->firstOrCreate(
            ['savings_product_id' => $regular->id, 'rule_type' => 'minimum_balance'],
            [
                'value' => '5000',
                'description' => 'Minimum balance that must remain in Regular Savings after any withdrawal.',
                'is_active' => true,
            ]
        );
    }
}
