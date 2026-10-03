<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Widen savings_transactions.type from an ENUM to a plain VARCHAR so new
     * transaction types (e.g. opening_balance, for migrated members) don't
     * require an ALTER TABLE. Non-destructive: existing values are preserved
     * as-is since they're all valid strings.
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE savings_transactions MODIFY COLUMN type VARCHAR(255) NOT NULL');
        }
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE savings_transactions MODIFY COLUMN type ENUM(
                'contribution_deduction',
                'voluntary_deposit',
                'withdrawal',
                'reversal_credit',
                'reversal_debit'
            ) NOT NULL");
        }
    }
};
