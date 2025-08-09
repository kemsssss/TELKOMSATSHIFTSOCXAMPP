<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Petugas</title>
    <link rel="stylesheet" href="{{ asset('css/createpetugas.css') }}">  
</head>
<body>

    {{-- Sidebar --}}
    @include('components.sidebar')

          <div id="jam" style="position: absolute; top: 20px; right: 30px; font-size: 14px; color: #555; z-index: 9999;"></div>
      <div id="jam"></div>
    <div class="content">
        <div class="container">
            <h1>Tambah Petugas</h1>

            @if ($errors->any())
                <div class="error-box">
                    <strong>Terjadi kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('petugas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label for="nama">Nama Petugas</label>
                <input type="text" name="nama" id="nama" placeholder="Contoh: Budi Santoso" value="{{ old('nama') }}" required>

                <label for="nik">NIK</label>
                <input type="text" name="nik" id="nik" placeholder="Contoh: 1234567890123456" value="{{ old('nik') }}" required>

                <label for="ttd">Tanda Tangan</label>
                <input type="file" name="ttd" id="ttd" accept="image/*" onchange="previewTTD(event)" required>

                <img id="ttd-preview" alt="Preview Tanda Tangan">

                <div class="buttons">
                    <a href="{{ route('petugas.index') }}" class="btn btn-back">← Kembali</a>
                    <button type="submit" class="btn btn-submit">Simpan Petugas</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewTTD(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const preview = document.getElementById('ttd-preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

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

</body>
</html>
