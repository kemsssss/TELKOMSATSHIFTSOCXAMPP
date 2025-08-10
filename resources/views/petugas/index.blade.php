<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Petugas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/petugas.css') }}">  
</head>
<body>
    @include('components.sidebar')

    <div class="main-content">
        <div class="container">

                  <div id="jam" style="position: absolute; top: 20px; right: 30px; font-size: 14px; color: #555; z-index: 9999;"></div>
      <div id="jam"></div>
    
            <header class="header-bar">
                <h1>Daftar Petugas</h1>
            </header>

            <!-- Form Pencarian dan Tambah -->
            <section class="form-bar">
                <form method="GET" action="{{ route('petugas.index') }}">
                    <input type="text" name="cari" placeholder="Cari nama atau NIK" value="{{ request('cari') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
                <a href="{{ route('petugas.create') }}" class="btn btn-green">+ Tambah Petugas</a>
            </section>

            @if (session('success'))
                <div class="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Daftar Petugas -->
            <section class="card-grid">
                @forelse ($petugas as $p)
                    <div class="card">
                        <p><strong>Nama:</strong> {{ $p->nama }}</p>
                        <p><strong>NIK:</strong> {{ $p->nik }}</p>

                        @if ($p->ttd && file_exists(public_path('storage/' . $p->ttd)))
                            <img src="{{ asset('storage/' . $p->ttd) }}" alt="TTD {{ $p->nama }}">
                        @else
                            <p class="text-red">TTD belum tersedia atau file tidak ditemukan.</p>
                        @endif

                        <div class="actions">
                            <a href="{{ route('petugas.edit', $p->id) }}" class="btn btn-yellow">Edit</a>
                            <form action="{{ route('petugas.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="no-data">Tidak ada data petugas.</div>
                @endforelse
            </section>

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
    updateJam(); // pertama kali
});
</script>
</body>
</html>
