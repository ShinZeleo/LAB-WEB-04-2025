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
        Schema::create('fishes', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT
            $table->string('name', 100); // Nama ikan, max 100 chars
            $table->enum('rarity', ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret']); // Tingkat kelangkaan
            $table->decimal('base_weight_min', 8, 2); // Berat minimum (kg), format: 999999.99
            $table->decimal('base_weight_max', 8, 2); // Berat maksimum (kg), format: 999999.99
            $table->integer('sell_price_per_kg'); // Harga jual per kg (Coins)
            $table->decimal('catch_probability', 5, 2); // Probabilitas tertangkap 0.01 - 100.00
            $table->text('description')->nullable(); // Deskripsi ikan, boleh kosong
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fishes');
    }
};