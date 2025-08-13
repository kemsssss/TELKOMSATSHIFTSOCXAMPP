<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('berita_acaras', function (Blueprint $table) {
            $table->string('prtg1')->nullable()->after('edr');
            $table->string('prtg_status1')->nullable()->after('prtg1');
            $table->string('prtg2')->nullable()->after('prtg_status1');
            $table->string('prtg_status2')->nullable()->after('prtg2');
        });
    }

    public function down(): void
    {
        Schema::table('berita_acaras', function (Blueprint $table) {
            $table->dropColumn(['prtg1', 'prtg_status1', 'prtg2', 'prtg_status2']);
        });
    }
};
