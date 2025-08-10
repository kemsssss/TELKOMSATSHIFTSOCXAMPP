<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Berita Acara Shift</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('css/table.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f9;
      margin: 0;
      padding: 0;
    }

    h1 {
      text-align: center;
      margin: 20px 0;
      color: #880000;
      font-weight: bold;
      text-transform: uppercase;
    }

    .table-container {
      overflow-x: auto;
      padding: 20px;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      background-color: #ffffff;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
      font-size: 14px;
      color: #1a1a1a;
      text-align: center;
    }

    thead {
      background-color: #d70000;
      color: #fff;
    }

    th, td {
      padding: 10px 12px;
      text-align: center;
      border: 1px solid #ddd;
      vertical-align: middle;
    }

    tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tbody tr:hover {
      background-color: #f1f1f1;
    }

    .btn-icon {
  background: none;
  border: none;
  color: #007bff;
  font-size: 16px;
  cursor: pointer;
  padding: 5px;
}

.btn-icon:hover {
  color: #0056b3;
}

.btn-delete {
  color: #dc3545;
}

.btn-delete:hover {
  color: #fff;
}

    @media (max-width: 768px) {
      table {
        font-size: 13px;
      }

      th, td {
        padding: 8px;
      }

      .btn {
        font-size: 12px;
        padding: 4px 8px;
      }
    }
  </style>
</head>
<body>

  <div class="sidebar">
    @include('components.sidebar')
  </div>

  <div id="jam" style="position: absolute; top: 20px; right: 30px; font-size: 14px; color: #555;"></div>

  <div class="main-content">
    <h1>Tabel Berita Acara Shift SOC Telkomsat</h1>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Petugas Lama</th>
            <th>NIK Petugas Lama</th>
            <th>Shift Petugas Lama</th>
            <th>Nama Petugas Baru</th>
            <th>NIK Petugas Baru</th>
            <th>Shift Petugas Baru</th>
            <th>No Tiket</th>
            <th>Sangfor</th>
            <th>FortiJTN</th>
            <th>FortiWeb</th>
            <th>Checkpoint</th>
            <th>Sophos IP</th>
            <th>Sophos URL</th>
            <th>VPN</th>
            <th>EDR</th>
            <th>Daily Report Magnus</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($beritaAcaras as $index => $data)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $data->created_at->format('d-m-Y') }}</td>

              {{-- Petugas Lama --}}
              <td>{!! $data->petugasLama->pluck('nama')->unique()->implode('<br>') !!}</td>
              <td>{!! $data->petugasLama->pluck('nik')->unique()->implode('<br>') !!}</td>
              <td>{{ $data->lama_shift }}</td>

              {{-- Petugas Baru --}}
              <td>{!! $data->petugasBaru->pluck('nama')->unique()->implode('<br>') !!}</td>
              <td>{!! $data->petugasBaru->pluck('nik')->unique()->implode('<br>') !!}</td>
              <td>{{ $data->baru_shift }}</td>

              {{-- Tiket dan Blok --}}
              <td>{!! nl2br(e($data->tiket)) !!}</td>
              <td>{!! nl2br(str_replace(',', "\n", e($data->sangfor))) !!}</td>
              <td>{!! nl2br(str_replace(',', "\n", e($data->jtn))) !!}</td>
              <td>{!! nl2br(str_replace(',', "\n", e($data->web))) !!}</td>
              <td>{!! nl2br(str_replace(',', "\n", e($data->checkpoint))) !!}</td>
              <td>{!! nl2br(str_replace(',', "\n", e($data->sophos_ip))) !!}</td>
              <td>{!! nl2br(str_replace(',', "\n", e($data->sophos_url))) !!}</td>
              <td>{!! nl2br(str_replace(',', "\n", e($data->vpn))) !!}</td>
              <td>{!! nl2br(str_replace(',', "\n", e($data->edr))) !!}</td>
              <td>{!! nl2br(e($data->daily_report)) !!}</td>

              <td style="white-space: nowrap;">
  <div style="display: flex; gap: 6px; align-items: center;">
    
    {{-- Edit --}}
    <a href="{{ route('beritaacara.edit', $data->id) }}" 
       class="btn-icon btn-delete" 
       title="Edit">
      <i class="fas fa-edit" style="color:#dc3545;"></i>
    </a>

    {{-- Print --}}
    <a href="{{ route('beritaacara.print', $data->id) }}" 
       class="btn-icon btn-delete" 
       title="Print" 
       target="_blank">
      <i class="fas fa-print"style="color:#dc3545;"></i>
    </a>

    {{-- Delete --}}
    <form action="{{ route('beritaacara.destroy', $data->id) }}" 
          method="POST" 
          style="display: inline;" 
          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
      @csrf
      @method('DELETE')
      <button type="submit" 
              class="btn-icon btn-delete" 
              title="Hapus">
        <i class="fas fa-trash"></i>
      </button>
    </form>

  </div>
</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      function updateJam() {
        const jamElement = document.getElementById('jam');
        const now = new Date();
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        const tanggal = now.toLocaleDateString('id-ID', options);
        const waktu = now.toLocaleTimeString('id-ID');
        jamElement.textContent = `${tanggal} - ${waktu}`;
      }

      setInterval(updateJam, 1000);
      updateJam();
    });
  </script>

</body>
</html>
