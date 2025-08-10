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
        Schema::create('berita_acara_petugas_baru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berita_acara_id')->constrained()->onDelete('cascade');
            $table->foreignId('petugas_id')->constrained()->onDelete('cascade');
            $table->string('shift')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acara_petugas_baru');
    }
};
