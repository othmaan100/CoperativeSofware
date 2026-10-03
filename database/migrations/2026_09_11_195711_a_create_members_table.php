<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // For official use
            $table->string('application_no')->unique();
            $table->string('membership_no')->unique()->nullable();

            // Section A - Personal Information
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female']);
            $table->string('ippis_number')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->text('home_address');
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->string('email')->nullable();
            $table->string('photo_path')->nullable();

            // Section B - Employment Information (locked after approval)
            $table->string('department');
            $table->string('staff_id')->unique();
            $table->date('date_of_first_appointment')->nullable();
            $table->enum('employment_status', ['permanent', 'contract', 'casual']);
            $table->string('rank_grade')->nullable();

            // Section C - Membership Commitment
            $table->decimal('preferred_monthly_contribution', 12, 2);
            $table->decimal('approved_monthly_contribution', 12, 2)->nullable();
            $table->string('mode_of_deduction')->default('salary_deduction');
            $table->string('member_category')->default('regular_staff');

            // Section D - Declaration
            $table->boolean('declaration_accepted')->default(false);
            $table->string('declaration_signed_name')->nullable();

            // Status & lifecycle
            $table->enum('status', ['pending', 'active', 'suspended', 'dormant', 'exited', 'deceased'])->default('pending');
            $table->boolean('application_fee_paid')->default(false);
            $table->timestamp('application_fee_paid_at')->nullable();

            $table->timestamp('applied_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamp('dormant_flagged_at')->nullable();
            $table->timestamp('last_contribution_at')->nullable();

            $table->foreignId('exit_requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('exit_requested_at')->nullable();
            $table->boolean('exit_treasurer_cleared')->default(false);
            $table->foreignId('exit_cleared_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('exit_cleared_at')->nullable();
            $table->timestamp('exited_at')->nullable();
            $table->text('exit_reason')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
