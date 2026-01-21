<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /**
         * Employee lifecycle events (hiring, promotions, terminations, rehires)
         */
        Schema::create('employee_lifecycle_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->enum('event_type', [
                'hired',
                'promoted',
                'demoted',
                'transferred',
                'salary_changed',
                'terminated',
                'rehired',
                'status_changed',
                'leave_started',
                'leave_ended',
            ]);
            
            $table->string('title', 150);
            $table->text('description')->nullable();
            
            // Event-specific data stored as JSON
            $table->json('event_data')->nullable(); // e.g., old_job_title, new_job_title, old_department, new_department
            
            // Effective date for the event
            $table->date('effective_date');
            
            // Reference to related records (foreign keys added after tables are created)
            $table->unsignedBigInteger('related_salary_change_id')->nullable();
            $table->unsignedBigInteger('related_termination_settlement_id')->nullable();
            
            $table->timestamps();
            
            $table->index(['company_id', 'employee_id', 'event_type'], 'emp_lifecycle_comp_emp_type_idx');
            $table->index(['company_id', 'effective_date'], 'emp_lifecycle_comp_date_idx');
        });

        /**
         * Salary change history (tracks all salary structure changes)
         */
        Schema::create('salary_change_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Reference to salary structure
            $table->foreignId('old_salary_structure_id')->nullable()->constrained('salary_structures')->nullOnDelete();
            $table->foreignId('new_salary_structure_id')->nullable()->constrained('salary_structures')->nullOnDelete();
            
            // Reference to employee salary structure records
            $table->foreignId('old_employee_salary_structure_id')->nullable()
                ->constrained('employee_salary_structures')->nullOnDelete();
            $table->foreignId('new_employee_salary_structure_id')->nullable()
                ->constrained('employee_salary_structures')->nullOnDelete();
            
            // Change reason
            $table->enum('change_reason', [
                'hiring',
                'promotion',
                'annual_increase',
                'adjustment',
                'demotion',
                'contract_renewal',
                'market_adjustment',
                'other',
            ]);
            
            $table->text('reason_notes')->nullable();
            
            // Effective dates
            $table->date('effective_from');
            $table->date('effective_to')->nullable(); // null means current
            
            // Snapshot of old and new salary components (JSON for flexibility)
            $table->json('old_salary_components')->nullable(); // snapshot of components before change
            $table->json('new_salary_components')->nullable(); // snapshot of components after change
            
            // Calculated totals for comparison
            $table->decimal('old_total_gross', 14, 2)->nullable();
            $table->decimal('new_total_gross', 14, 2)->nullable();
            $table->decimal('old_total_net', 14, 2)->nullable();
            $table->decimal('new_total_net', 14, 2)->nullable();
            
            // Percentage change
            $table->decimal('percentage_change', 5, 2)->nullable();
            
            $table->timestamps();
            
            $table->index(['company_id', 'employee_id', 'effective_from'], 'salary_chg_comp_emp_from_idx');
            $table->index(['company_id', 'change_reason'], 'salary_chg_comp_reason_idx');
        });

        /**
         * Termination settlements (final payroll calculations)
         */
        Schema::create('termination_settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Termination details
            $table->date('termination_date');
            $table->enum('termination_type', [
                'voluntary_resignation',
                'involuntary_termination',
                'retirement',
                'end_of_contract',
                'layoff',
                'dismissal',
            ]);
            
            $table->enum('termination_reason', [
                'resignation',
                'retirement',
                'end_of_contract',
                'performance',
                'misconduct',
                'redundancy',
                'mutual_agreement',
                'other',
            ])->nullable();
            
            $table->text('termination_notes')->nullable();
            
            // Settlement calculation
            $table->enum('settlement_status', [
                'draft',
                'calculated',
                'approved',
                'paid',
                'cancelled',
            ])->default('draft');
            
            // Final payroll period
            $table->date('final_period_start');
            $table->date('final_period_end');
            $table->date('settlement_pay_date');
            
            // Settlement amounts
            $table->decimal('accrued_salary', 14, 2)->default(0); // Unpaid salary for final period
            $table->decimal('unused_leave_payout', 14, 2)->default(0); // Unused vacation/sick leave
            $table->decimal('severance_pay', 14, 2)->default(0); // If applicable
            $table->decimal('notice_pay', 14, 2)->default(0); // Payment in lieu of notice
            $table->decimal('bonus_payout', 14, 2)->default(0); // Prorated bonus if applicable
            $table->decimal('other_allowances', 14, 2)->default(0); // Other entitlements
            
            // Deductions
            $table->decimal('outstanding_loans', 14, 2)->default(0); // Outstanding employee loans
            $table->decimal('advance_deductions', 14, 2)->default(0); // Salary advances to recover
            $table->decimal('other_deductions', 14, 2)->default(0); // Other deductions
            
            // Totals
            $table->decimal('total_earnings', 14, 2)->default(0);
            $table->decimal('total_deductions', 14, 2)->default(0);
            $table->decimal('net_settlement_amount', 14, 2)->default(0);
            
            $table->char('currency', 3)->default('USD');
            
            // Reference to final payroll run (if processed through normal payroll)
            $table->foreignId('final_payroll_run_id')->nullable()
                ->constrained('payroll_runs')->nullOnDelete();
            
            // Reference to payslip generated for settlement
            $table->foreignId('settlement_payslip_id')->nullable()
                ->constrained('payslips')->nullOnDelete();
            
            // Approval workflow
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_notes')->nullable();
            
            // Payment tracking
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_reference')->nullable();
            $table->text('payment_notes')->nullable();
            
            $table->timestamps();
            
            $table->index(['company_id', 'employee_id']);
            $table->index(['company_id', 'settlement_status']);
            $table->index(['company_id', 'termination_date']);
        });

        // Add foreign key constraints for related records in employee_lifecycle_events
        Schema::table('employee_lifecycle_events', function (Blueprint $table) {
            $table->foreign('related_salary_change_id', 'emp_lifecycle_salary_chg_fk')
                ->references('id')
                ->on('salary_change_history')
                ->nullOnDelete();
            
            $table->foreign('related_termination_settlement_id', 'emp_lifecycle_term_settle_fk')
                ->references('id')
                ->on('termination_settlements')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('termination_settlements');
        Schema::dropIfExists('salary_change_history');
        Schema::dropIfExists('employee_lifecycle_events');
    }
};
