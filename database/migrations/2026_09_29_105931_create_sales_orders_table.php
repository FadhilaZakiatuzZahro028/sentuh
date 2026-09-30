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
    Schema::create('sales_orders', function (Blueprint $table) {
        $table->id();

        $table->string('order_number', 30)->unique();

        $table->date('order_date');

        $table->string('customer_code', 50);
        $table->string('customer_name', 150);
        $table->string('customer_contact', 100)->nullable();

        $table->decimal('subtotal', 14, 2)->default(0);

        $table->decimal('estimated_direct_cost', 14, 2)->default(0);
        $table->decimal('actual_direct_cost', 14, 2)->default(0);

        $table->string('status', 20)->default('draft');

        $table->text('notes')->nullable();

        $table->timestamps();

        $table->index('order_date');
        $table->index('status');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
