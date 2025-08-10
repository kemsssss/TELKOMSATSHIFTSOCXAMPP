<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'nik', 'ttd'];

    public function beritaAcarasSebagaiLama()
{
    return $this->belongsToMany(BeritaAcara::class, 'berita_acara_petugas_lama');
}

public function beritaAcarasSebagaiBaru()
{
    return $this->belongsToMany(BeritaAcara::class, 'berita_acara_petugas_baru');
}
}
