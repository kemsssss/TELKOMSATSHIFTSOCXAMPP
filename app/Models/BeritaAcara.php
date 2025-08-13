<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    use HasFactory;

    protected $fillable = [
        'lama_nama',
        'lama_nik',
        'lama_shift',
        'baru_nama',
        'baru_nik',
        'baru_shift',
        'tiket',
        'sangfor',
        'jtn',
        'web',
        'checkpoint',
        'sophos_ip',
        'sophos_url',
        'vpn',
        'edr',
        'daily_report',
        'lama_ttd',
        'baru_ttd',
        'tanggal_shift',
        'prtg1',
        'prtg_status1',
        'prtg2', 
        'prtg_status2',
        'nomortiket_magnus',
        'detail_magnus',
    ];

    protected $casts = [
        'sophos_ip' => 'array',
        'sophos_url' => 'array',
        'vpn' => 'array',
        'edr' => 'array',
        'nomortiket_magnus' => 'array', 
        'detail_magnus'=> 'array',
    ];

    public function petugasLama()
{
    return $this->belongsToMany(Petugas::class, 'berita_acara_petugas_lama')->withPivot('shift')->withTimestamps();;
}

public function petugasBaru()
{
    return $this->belongsToMany(Petugas::class, 'berita_acara_petugas_baru')->withPivot('shift')->withTimestamps();;
}
}
