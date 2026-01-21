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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->unique(); // e.g. starter, pro, enterprise
            $table->string('name', 150);
            $table->enum('billing_model', ['per_employee', 'tier']);
            $table->decimal('base_price', 12, 2)->default(0);
            $table->decimal('price_per_employee', 12, 2)->nullable();
            $table->integer('min_employees')->nullable();
            $table->integer('max_employees')->nullable();
            $table->integer('trial_days')->default(14);
            $table->char('currency', 3)->default('USD');
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};

