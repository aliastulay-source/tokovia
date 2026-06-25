<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama');          // nama produk
            $table->text('deskripsi');       // deskripsi produk
            $table->integer('harga');        // harga produk
            $table->integer('stok');         // stok produk
            $table->string('gambar')->nullable(); // foto produk
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};