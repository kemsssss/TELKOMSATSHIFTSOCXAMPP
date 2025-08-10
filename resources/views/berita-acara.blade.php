<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Berita Acara Shift SOC</title>
  <style>
    @page {
      size: A4;
      margin: 10mm;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #000;
      margin: 20px;
    }

    h2 {
      text-align: center;
      font-size: 14pt;
      text-transform: uppercase;
      margin-bottom: 20px;
    }

    p {
      text-align: justify;
      margin-bottom: 10px;
    }

    .logo {
      text-align: center;
      margin-bottom: 8px;
    }

    .logo img {
      height: 100px;
    }

    .section {
      margin-bottom: 16px;
      page-break-inside: avoid;
    }

    ul, ol {
      margin-left: 20px;
      padding-left: 10px;
    }

    table.ttd-table {
      width: 100%;
      margin-top: 40px;
      text-align: center;
      page-break-inside: avoid;
    }

    table.ttd-table td {
      width: 50%;
      vertical-align: top;
    }

    .ttd-img {
      height: 100px;
      margin-bottom: 20px;
    }

    .ttd-label {
      text-decoration: underline;
      font-weight: normal;
    }

    @media print {
      .no-print {
        display: none;
      }
    }
  </style>
</head>
<body>

@php
  $logoPath = public_path('storage/logotelkomsat/logotelkomsattt.png');
  $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null;
@endphp

@if($logoBase64)
  <div class="logo">
    <img src="{{ $logoBase64 }}" alt="Logo Telkomsat">
  </div>
@endif

<h2>BERITA ACARA SERAH TERIMA SHIFT SOC  <span style="color: red;">TELKOMSAT</span></h2>

<div class="section">
  <p><strong>Yang bertanda tangan di bawah ini:</strong></p>
  @foreach ($petugas_lama as $petugas)
    <p>Nama: {{ $petugas->nama }}</p>
    <p>NIK: {{ $petugas->nik }}</p>
  @endforeach
  <p>Shift Lama: {{ $lama_shift }}</p>

  <p><strong>Serah terima shift dengan:</strong></p>
  @foreach ($petugas_baru as $petugas)
    <p>Nama: {{ $petugas->nama }}</p>
    <p>NIK: {{ $petugas->nik }}</p>
  @endforeach
  <p>Shift Baru: {{ $baru_shift }}</p>
</div>

<div class="section">
  <p>Pada hari <strong>{{ $tanggal_shift }}</strong>, dengan ini kami melakukan pergantian shift SOC dengan detail pekerjaan sebagai berikut:</p>

  <ol>
    <li>
      <strong>Tiket yang dibuat:</strong><br>
      {{ trim($tiket_nomor ?? '') !== '' ? $tiket_nomor : '-' }}
    </li>

    <li>
      <strong>Auto Blocking SOAR:</strong>
      <ul>
        <li>SangFOR = {{ trim($sangfor ?? '') !== '' ? $sangfor : '-' }}</li>
        <li>Forti-JTN = {{ trim($fortijtn ?? '') !== '' ? $fortijtn : '-' }}</li>
        <li>FortiWeb = {{ trim($fortiweb ?? '') !== '' ? $fortiweb : '-' }}</li>
        <li>CheckPoint = {{ trim($checkpoint ?? '') !== '' ? $checkpoint : '-' }}</li>
      </ul>
    </li>

    <li>
      <strong>Manual Blocking dan FollowUP:</strong>
      <ul>
        <li>Sophos IP = {{ !empty($sophos_ip) ? implode(', ', $sophos_ip) : '-' }}</li>
        <li>Sophos URL = {{ !empty($sophos_url) ? implode(', ', $sophos_url) : '-' }}</li>
        <li>VPN = {{ !empty($vpn) ? implode(', ', $vpn) : '-' }}</li>
        <li>EDR = {{ !empty($edr) ? implode(', ', $edr) : '-' }}</li>
        <li>Daily Report Magnus = {{ !empty($magnus) ? implode(', ', $magnus) : '-' }}</li>
      </ul>
    </li>
  </ol>
</div>

<div class="section">
  <p>Sekian telah kami laksanakan pekerjaan tersebut dengan baik. Demikian berita acara ini dibuat dengan sebaik-baiknya.</p>
</div>

{{-- TTD Table Layout --}}
<table class="ttd-table">
  <tr>
    <td>Petugas Lama</td>
    <td>Petugas Baru</td>
  </tr>
  <tr>
    <td>
      @if ($lama_ttd)
        <img src="{{ $lama_ttd }}" class="ttd-img" alt="TTD Petugas Lama"><br>
      @else
        <i>TTD tidak tersedia</i><br>
      @endif
    </td>
    <td>
      @if ($baru_ttd)
        <img src="{{ $baru_ttd }}" class="ttd-img" alt="TTD Petugas Baru"><br>
      @else
        <i>TTD tidak tersedia</i><br>
      @endif
    </td>
  </tr>
  <tr>
    <td class="ttd-label">
      {{ $lama_nama ?? '-' }}<br>NIK: {{ $lama_nik ?? '-' }}
    </td>
    <td class="ttd-label">
      {{ $baru_nama ?? '-' }}<br>NIK: {{ $baru_nik ?? '-' }}
    </td>
  </tr>
</table>

</body>
</html>
