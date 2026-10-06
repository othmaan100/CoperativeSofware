<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Withdrawals paid out before the system was in use, imported from the
     * manual books. Each posted row becomes a disbursed withdrawal request and
     * a savings debit dated to when the withdrawal actually happened.
     */
    public function up(): void
    {
        Schema::create('withdrawal_import_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uploaded_by')->constrained('users');
            $table->string('file_path');
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->unsignedInteger('total_records')->default(0);
            $table->string('status')->default('validated');
            $table->json('rows')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
        });

        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->boolean('is_legacy_import')->default(false)->after('status');
            $table->unsignedBigInteger('withdrawal_import_batch_id')->nullable()->after('is_legacy_import');
            $table->foreign('withdrawal_import_batch_id', 'wr_import_batch_fk')->references('id')->on('withdrawal_import_batches')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->dropForeign('wr_import_batch_fk');
            $table->dropColumn(['is_legacy_import', 'withdrawal_import_batch_id']);
        });

        Schema::dropIfExists('withdrawal_import_batches');
    }
};
