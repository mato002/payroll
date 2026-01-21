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
         * Companies (tenants)
         */
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('legal_name')->nullable();
            $table->string('registration_number', 100)->nullable();
            $table->string('tax_id', 100)->nullable();
            $table->char('country', 2)->nullable();
            $table->string('timezone', 64)->nullable();
            $table->char('currency', 3)->default('USD');
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('subscription_status', ['trial', 'active', 'past_due', 'canceled', 'paused'])
                ->default('trial');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * Company ↔ User membership (multi-company)
         */
        Schema::create('company_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_owner')->default(false);
            $table->enum('status', ['invited', 'active', 'suspended'])->default('active');
            $table->timestamp('invited_at')->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();

            $table->unique(['company_id', 'user_id']);
        });

        /**
         * Roles & permissions (RBAC)
         */
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->string('description')->nullable();
            $table->boolean('is_system')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'slug']);
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['role_id', 'permission_id']);
        });

        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['company_id', 'user_id', 'role_id']);
        });

        /**
         * Employees
         */
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('employee_code', 50);
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('national_id', 100)->nullable();
            $table->date('hire_date');
            $table->date('termination_date')->nullable();
            $table->enum('employment_status', ['active', 'terminated', 'on_leave', 'probation'])->default('active');
            $table->enum('employment_type', ['full_time', 'part_time', 'contractor', 'intern'])->default('full_time');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('job_title', 150)->nullable();
            $table->enum('pay_frequency', ['monthly', 'bi_weekly', 'weekly', 'custom'])->default('monthly');
            $table->string('bank_account_number', 100)->nullable();
            $table->string('bank_name', 150)->nullable();
            $table->string('bank_branch', 150)->nullable();
            $table->string('tax_number', 100)->nullable();
            $table->string('social_security_number', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'employee_code']);
        });

        /**
         * Salary structures and components
         */
        Schema::create('salary_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name', 150);
            $table->string('description')->nullable();
            $table->enum('pay_frequency', ['monthly', 'bi_weekly', 'weekly', 'custom'])->default('monthly');
            $table->char('currency', 3)->nullable();
            $table->boolean('is_default')->default(false);
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('salary_structure_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('salary_structure_id')->constrained()->cascadeOnDelete();
            $table->string('name', 150);
            $table->string('code', 50);
            $table->enum('type', ['earning', 'deduction', 'contribution']);
            $table->enum('calculation_type', ['fixed', 'percentage_of_basic', 'percentage_of_gross', 'formula']);
            $table->decimal('amount', 12, 2)->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->string('formula')->nullable();
            $table->boolean('taxable')->default(true);
            $table->boolean('included_in_gross')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Custom name to avoid MySQL's 64-char index name limit
            $table->unique(
                ['company_id', 'salary_structure_id', 'code'],
                'sal_struct_comp_co_struct_code_unique'
            );
        });

        Schema::create('employee_salary_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('salary_structure_id')->constrained()->cascadeOnDelete();
            $table->date('effective_from');
            $table->date('effective_to')->nullable();
            $table->boolean('is_current')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Custom name to avoid MySQL index name length limits
            $table->index(
                ['company_id', 'employee_id', 'is_current'],
                'emp_salary_struct_co_emp_current_idx'
            );
        });

        Schema::create('employee_salary_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_salary_structure_id')->constrained()->cascadeOnDelete();
            $table->foreignId('salary_structure_component_id')->constrained()->cascadeOnDelete();
            $table->decimal('override_amount', 12, 2)->nullable();
            $table->decimal('override_percentage', 5, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'employee_salary_structure_id', 'salary_structure_component_id'], 'employee_salary_component_unique');
        });

        /**
         * Payroll runs and items
         */
        Schema::create('payroll_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name', 150);
            $table->date('period_start_date');
            $table->date('period_end_date');
            $table->date('pay_date');
            $table->enum('status', ['draft', 'processing', 'completed', 'closed', 'canceled'])->default('draft');
            $table->enum('pay_frequency', ['monthly', 'bi_weekly', 'weekly', 'off_cycle'])->default('monthly');
            $table->string('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->decimal('total_gross_amount', 14, 2)->default(0);
            $table->decimal('total_net_amount', 14, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['company_id', 'status', 'pay_date']);
        });

        Schema::create('payroll_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payroll_run_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('salary_structure_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('gross_amount', 14, 2);
            $table->decimal('total_earnings', 14, 2);
            $table->decimal('total_deductions', 14, 2);
            $table->decimal('total_contributions', 14, 2)->default(0);
            $table->decimal('net_amount', 14, 2);
            $table->char('currency', 3);
            $table->enum('status', ['draft', 'calculated', 'locked', 'reversed'])->default('draft');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'payroll_run_id', 'employee_id']);
        });

        Schema::create('payroll_item_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payroll_item_id')->constrained()->cascadeOnDelete();
            $table->enum('component_type', ['earning', 'deduction', 'contribution']);
            $table->string('component_code', 50);
            $table->string('component_name', 150);
            $table->decimal('base_amount', 14, 2);
            $table->decimal('calculated_amount', 14, 2);
            $table->boolean('taxable')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * Payslips
         */
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payroll_run_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payroll_item_id')->constrained()->cascadeOnDelete();
            $table->string('payslip_number', 50);
            $table->date('issue_date');
            $table->decimal('gross_amount', 14, 2);
            $table->decimal('total_earnings', 14, 2);
            $table->decimal('total_deductions', 14, 2);
            $table->decimal('net_amount', 14, 2);
            $table->char('currency', 3);
            $table->enum('status', ['generated', 'sent', 'viewed', 'locked'])->default('generated');
            $table->string('pdf_url')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'payslip_number']);
            $table->unique(['company_id', 'payroll_run_id', 'employee_id'], 'payslip_company_run_employee_unique');
        });

        /**
         * Subscriptions & billing
         */
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('external_subscription_id', 100)->nullable();
            $table->string('plan_code', 100);
            $table->enum('billing_cycle', ['monthly', 'yearly', 'custom'])->default('monthly');
            $table->enum('status', ['trial', 'active', 'past_due', 'canceled', 'paused'])->default('trial');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('trial_end_date')->nullable();
            $table->date('next_billing_date')->nullable();
            $table->decimal('base_price', 12, 2);
            $table->decimal('per_employee_price', 12, 2)->nullable();
            $table->integer('max_employees_included')->nullable();
            $table->char('currency', 3)->default('USD');
            $table->boolean('auto_renew')->default(true);
            $table->timestamps();

            $table->index(['company_id', 'status']);
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_id')->nullable()->constrained()->nullOnDelete();
            $table->string('invoice_number', 50);
            $table->date('issue_date');
            $table->date('due_date');
            $table->date('period_start_date')->nullable();
            $table->date('period_end_date')->nullable();
            $table->enum('status', ['draft', 'issued', 'paid', 'partially_paid', 'void', 'refunded'])->default('issued');
            $table->decimal('subtotal_amount', 14, 2);
            $table->decimal('tax_amount', 14, 2)->default(0);
            $table->decimal('total_amount', 14, 2);
            $table->decimal('amount_paid', 14, 2)->default(0);
            $table->char('currency', 3)->default('USD');
            $table->text('notes')->nullable();
            $table->string('external_invoice_id', 100)->nullable();
            $table->timestamps();

            $table->unique(['company_id', 'invoice_number']);
            $table->index(['company_id', 'status', 'due_date']);
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->decimal('quantity', 10, 2)->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('line_total', 14, 2);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        /**
         * Audit logs
         */
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event_type', 100);
            $table->string('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('entity_type', 150)->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['company_id', 'event_type', 'created_at'], 'audit_logs_company_event_created_index');
            $table->index(['company_id', 'entity_type', 'entity_id'], 'audit_logs_company_entity_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('payslips');
        Schema::dropIfExists('payroll_item_details');
        Schema::dropIfExists('payroll_items');
        Schema::dropIfExists('payroll_runs');
        Schema::dropIfExists('employee_salary_components');
        Schema::dropIfExists('employee_salary_structures');
        Schema::dropIfExists('salary_structure_components');
        Schema::dropIfExists('salary_structures');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('company_user');
        Schema::dropIfExists('companies');
    }
};

