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
    Schema::create('sales_order_payments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('sales_order_id')
            ->constrained('sales_orders')
            ->restrictOnDelete();

        $table->foreignId('cash_account_id')
            ->constrained('cash_accounts')
            ->restrictOnDelete();

        $table->decimal('amount', 14, 2);

        $table->dateTime('received_at');

        $table->string('reference', 100)->nullable();

        $table->text('notes')->nullable();

        $table->timestamps();

        $table->index('received_at');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_payments');
    }
};
