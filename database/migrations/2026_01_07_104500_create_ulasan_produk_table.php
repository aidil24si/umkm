<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan_produk', function (Blueprint $table) {
            $table->id('ulasan_id');
            $table->foreignId('produk_id')->constrained('produk', 'produk_id')->onDelete('cascade');
            $table->unsignedBigInteger('warga_id');
            $table->tinyInteger('rating')->unsigned();
            $table->text('komentar')->nullable();
            $table->timestamps();

            $table->foreign('warga_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan_produk');
    }
};
