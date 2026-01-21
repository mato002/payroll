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
        Schema::create('report_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('report_code', 50); // e.g., 'tax_summary', 'pension', 'annual_summary'
            $table->string('report_name', 150);
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->integer('year')->nullable(); // For annual reports
            $table->enum('format', ['pdf', 'excel', 'csv'])->default('pdf');
            $table->enum('status', ['queued', 'processing', 'completed', 'failed'])->default('queued');
            $table->string('storage_path')->nullable(); // Path to generated file
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('error_message')->nullable();
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'report_code', 'status']);
            $table->index(['company_id', 'generated_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_runs');
    }
};
