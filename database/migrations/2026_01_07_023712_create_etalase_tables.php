<?php

// database/migrations/xxxx_xx_xx_create_etalase_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modifikasi tabel users bawaan untuk role admin/warga
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('warga'); // 'admin' atau 'warga'
            $table->string('kontak')->nullable();
            $table->string('alamat')->nullable();
        });

        Schema::create('umkm', function (Blueprint $table) {
            $table->id('umkm_id');
            $table->unsignedBigInteger('pemilik_warga_id'); // FK ke users
            $table->string('nama_usaha');
            $table->string('gambar_logo')->nullable(); // Implementasi tabel media
            $table->text('alamat');
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('kategori');
            $table->string('kontak');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('pemilik_warga_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('produk', function (Blueprint $table) {
            $table->id('produk_id');
            $table->foreignId('umkm_id')->references('umkm_id')->on('umkm')->onDelete('cascade');
            $table->string('nama_produk');
            $table->string('gambar_produk')->nullable();
            $table->text('deskripsi');
            $table->decimal('harga', 12, 2);
            $table->integer('stok');
            $table->enum('status', ['tersedia', 'habis', 'arsip'])->default('tersedia');
            $table->timestamps();
        });

        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('pesanan_id');
            $table->string('nomor_pesanan')->unique();
            $table->unsignedBigInteger('warga_id'); // FK ke users
            $table->decimal('total', 12, 2);
            $table->enum('status', ['pending', 'dibayar', 'dikirim', 'selesai', 'batal']);
            $table->text('alamat_kirim');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('metode_bayar');
            $table->string('bukti_bayar')->nullable();
            $table->timestamps();

            $table->foreign('warga_id')->references('id')->on('users');
        });

        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id('detail_id');
            $table->foreignId('pesanan_id')->references('pesanan_id')->on('pesanan')->onDelete('cascade');
            $table->foreignId('produk_id')->references('produk_id')->on('produk');
            $table->integer('qty');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
        
        // Tabel ulasan_produk bisa ditambahkan serupa...
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('produk');
        Schema::dropIfExists('umkm');
        // Rollback kolom users manual jika perlu
    }
};