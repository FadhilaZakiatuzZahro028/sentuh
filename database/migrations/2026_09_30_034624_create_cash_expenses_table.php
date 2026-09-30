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
    Schema::create('cash_expenses', function (Blueprint $table) {
        $table->id();

        $table->foreignId('cash_account_id')
            ->constrained('cash_accounts')
            ->restrictOnDelete();

        $table->date('expense_date');

        $table->string('category', 100);

        $table->string('description', 255);

        $table->decimal('amount', 14, 2);

        $table->string('reference', 100)->nullable();

        $table->text('notes')->nullable();

        $table->timestamps();

        $table->index('expense_date');
        $table->index('category');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_expenses');
    }
};
