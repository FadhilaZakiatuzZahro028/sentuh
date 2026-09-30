
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_links', function (Blueprint $table) {
            $table->id();

            // Relasi ke bisnis
            $table->foreignId('business_id')
                ->constrained('businesses')
                ->restrictOnDelete();

            // Informasi tombol
            $table->string('label', 100);
            $table->string('type', 50);
            $table->string('url', 2048);

            // Pengaturan tampilan
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_links');
    }
};
