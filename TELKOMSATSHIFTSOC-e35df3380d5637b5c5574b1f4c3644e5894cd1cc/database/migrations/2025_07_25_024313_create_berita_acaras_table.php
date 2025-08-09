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
        Schema::create('berita_acaras', function (Blueprint $table) {
            $table->id();
            $table->string('lama_shift');
            $table->string('baru_shift');
            $table->string('tiket')->nullable();
            $table->string('sangfor')->nullable();
            $table->string('jtn')->nullable();
            $table->string('web')->nullable();
            $table->string('checkpoint')->nullable();
            $table->string('sophos_ip')->nullable();
            $table->string('sophos_url')->nullable();
            $table->string('vpn')->nullable();
            $table->string('edr')->nullable();
            $table->string('daily_report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acaras');
    }
};
