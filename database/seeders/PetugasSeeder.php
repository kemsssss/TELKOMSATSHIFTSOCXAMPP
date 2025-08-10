<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('petugas')->insert([
            [
                'nama' => 'Budi',
                'nik' => '12345678',
                'ttd' => 'storage/ttd/budi.png',
            ],
            [
                'nama' => 'Kemal',
                'nik' => '87654321',
                'ttd' => 'storage/ttd/kemal.png',
            ],
            [
                'nama' => 'Ari',
                'nik' => '56781234',
                'ttd' => 'storage/ttd/ari.png',
            ],
        ]);
    }
}
