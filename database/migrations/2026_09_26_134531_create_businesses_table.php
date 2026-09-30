
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();

            // Identitas bisnis
            $table->string('name', 150);
            $table->string('slug', 160)->unique();
            $table->string('category', 100);
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();

            // Tampilan halaman bisnis
            $table->string('logo_path')->nullable();
            $table->string('cover_path')->nullable();
            $table->string('accent_color', 7)->nullable();

            // Status publikasi
            $table->string('status', 20)->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
