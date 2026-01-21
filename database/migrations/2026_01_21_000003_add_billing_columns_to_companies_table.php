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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('billing_email')->nullable()->after('tax_id');
            $table->string('stripe_customer_id', 100)->nullable()->after('billing_email');
            $table->string('paystack_customer_code', 100)->nullable()->after('stripe_customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'billing_email',
                'stripe_customer_id',
                'paystack_customer_code',
            ]);
        });
    }
};

