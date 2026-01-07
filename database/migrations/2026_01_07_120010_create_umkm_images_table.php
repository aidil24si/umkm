<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkm_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkm', 'umkm_id')->onDelete('cascade');
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm_images');
    }
};
