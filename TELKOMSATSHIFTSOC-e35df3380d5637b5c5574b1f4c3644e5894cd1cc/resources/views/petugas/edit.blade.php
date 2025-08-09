<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Petugas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/editpetugas.css') }}">  
</head>
<body>
    @include('components.sidebar')

          <div id="jam" style="position: absolute; top: 20px; right: 30px; font-size: 14px; color: #555; z-index: 9999;"></div>
      <div id="jam"></div>
      
    <div class="main-content">
        <div class="container">
            <h1>Edit Petugas</h1>

            <form action="{{ route('petugas.update', $petugas->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <label for="nama">Nama</label>
                <input type="text" name="nama" value="{{ $petugas->nama }}" required>

                <label for="nik">NIK</label>
                <input type="text" name="nik" value="{{ $petugas->nik }}" required>

                <label for="ttd">Tanda Tangan (TTD)</label>
                <input type="file" name="ttd">

                <div class="preview-ttd">
                    @if ($petugas->ttd && file_exists(public_path('storage/' . $petugas->ttd)))
                        <img src="{{ asset('storage/' . $petugas->ttd) }}" alt="TTD {{ $petugas->nama }}">
                    @else
                        <p class="text-red">TTD belum tersedia atau file tidak ditemukan.</p>
                    @endif
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-green">Simpan</button>
                    <a href="{{ route('petugas.index') }}" class="btn-primary" style="text-decoration: none; padding: 10px 20px;">← Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>

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
    updateJam(); // pertama kali
});
</script>

</html>
