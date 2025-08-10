<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Berita Acara Shift</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { 
            box-sizing: border-box; 
        }
        
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            line-height: 1.6;
        }
        
        .sidebar {
            position: fixed;
            left: 0; 
            top: 0; 
            bottom: 0;
            width: 240px;
            background-color: #1d3557;
            color: white;
            padding: 20px;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .main-content {
            margin-left: 240px;
            padding: 30px;
            min-height: 100vh;
        }
        
        #jam {
            position: absolute; 
            top: 20px; 
            right: 30px; 
            font-size: 14px; 
            color: #555; 
            z-index: 9999;
            background: white;
            padding: 8px 12px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #1d3557;
            text-align: center;
            margin-bottom: 25px;
            font-size: 2rem;
            font-weight: 600;
        }
        
        h3 {
            color: #1d3557;
            margin: 25px 0 15px 0;
            font-size: 1.2rem;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 8px;
        }
        
        hr {
            border: none;
            height: 1px;
            background-color: #e5e7eb;
            margin: 30px 0 10px 0;
        }
        
        form {
            max-width: 960px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        
        label {
            font-weight: 600;
            margin-top: 15px;
            display: block;
            color: #1f2937;
            margin-bottom: 6px;
        }
        
        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            resize: vertical;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        
        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }
        
        textarea {
            min-height: 80px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .multi-input {
            margin-bottom: 10px;
        }
        
        .mb-3 {
            margin-bottom: 20px;
        }
        
        select.select-petugas {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            margin-top: 6px;
            margin-bottom: 10px;
            background-color: white;
            transition: border-color 0.3s ease;
        }
        
        .input-wrapper {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            align-items: center;
        }
        
        .input-wrapper select {
            width: calc(100% - 90px);
            margin: 0;
        }
        
        button {
            background-color: #0d6efd;
            color: white;
            padding: 14px 28px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 30px;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
            font-weight: 500;
        }
        
        button:hover {
            background-color: #0b5ed7;
        }
        
        .btn-tambah {
            background: #10b981;
            margin-top: 10px;
            margin-bottom: 20px;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            width: auto;
        }
        
        .btn-tambah:hover {
            background-color: #059669;
        }
        
        .btn-hapus {
            background-color: #ef4444;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            white-space: nowrap;
            transition: background-color 0.3s ease;
            width: 70px;
        }
        
        .btn-hapus:hover {
            background-color: #dc2626;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px 15px;
            }
            
            #jam {
                position: relative;
                top: 0;
                right: 0;
                margin-bottom: 20px;
                text-align: center;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .input-wrapper {
                flex-direction: column;
                gap: 8px;
            }
            
            .input-wrapper select {
                width: 100%;
            }
            
            .btn-hapus {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    @include('components.sidebar')
</div>

<div id="jam"></div>

<div class="main-content">
    <h1>📜 Edit Data Berita Acara Shift</h1>

    <form action="{{ route('beritaacara.update', $beritaAcara->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="tanggal" class="form-label">📅 Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal"
                   value="{{ old('tanggal', \Carbon\Carbon::parse($beritaAcara->tanggal)->format('Y-m-d')) }}">
        </div>

        <hr><h3>👥 Petugas Lama</h3>
        <div id="petugasLamaWrapper">
            @foreach ($beritaAcara->petugasLama as $petugasDipilih)
                <div class="input-wrapper">
                    <select name="petugas_lama[]" class="select-petugas" required>
                        @foreach ($petugas as $p)
                            <option value="{{ $p->id }}" {{ $p->id == $petugasDipilih->id ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn-hapus" onclick="hapusInput(this)">Hapus</button>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn-tambah" onclick="tambahInput('petugasLamaWrapper', 'petugas_lama[]')">+ Tambah Petugas Lama</button>

        <div class="form-row">
            <div>
                <label for="lama_shift">⏰ Shift Petugas Lama</label>
                <select name="lama_shift" id="lama_shift" class="select-petugas" required>
                    <option value="">-- Pilih Shift --</option>
                    <option value="1 (06:30 - 14:30)" {{ $beritaAcara->lama_shift == '1 (06:30 - 14:30)' ? 'selected' : '' }}>1 (06:30 - 14:30)</option>
                    <option value="2 (14:30 - 22:30)" {{ $beritaAcara->lama_shift == '2 (14:30 - 22:30)' ? 'selected' : '' }}>2 (14:30 - 22:30)</option>
                    <option value="3 (22:30 - 06:30)" {{ $beritaAcara->lama_shift == '3 (22:30 - 06:30)' ? 'selected' : '' }}>3 (22:30 - 06:30)</option>
                </select>
            </div>
        </div>

        <hr><h3>🆕 Petugas Baru</h3>
        <div id="petugasBaruWrapper">
            @foreach ($beritaAcara->petugasBaru as $petugasDipilih)
                <div class="input-wrapper">
                    <select name="petugas_baru[]" class="select-petugas" required>
                        @foreach ($petugas as $p)
                            <option value="{{ $p->id }}" {{ $p->id == $petugasDipilih->id ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn-hapus" onclick="hapusInput(this)">Hapus</button>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn-tambah" onclick="tambahInput('petugasBaruWrapper', 'petugas_baru[]')">+ Tambah Petugas Baru</button>

        <div class="form-row">
            <div>
                <label for="baru_shift">⏰ Shift Petugas Baru</label>
                <select name="baru_shift" id="baru_shift" class="select-petugas" required>
                    <option value="">-- Pilih Shift --</option>
                    <option value="1 (06:30 - 14:30)" {{ $beritaAcara->baru_shift == '1 (06:30 - 14:30)' ? 'selected' : '' }}>1 (06:30 - 14:30)</option>
                    <option value="2 (14:30 - 22:30)" {{ $beritaAcara->baru_shift == '2 (14:30 - 22:30)' ? 'selected' : '' }}>2 (14:30 - 22:30)</option>
                    <option value="3 (22:30 - 06:30)" {{ $beritaAcara->baru_shift == '3 (22:30 - 06:30)' ? 'selected' : '' }}>3 (22:30 - 06:30)</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="tiket">🎫 No Tiket</label>
            <textarea name="tiket" id="tiket">{{ $beritaAcara->tiket }}</textarea>
        </div>

        <h3>🛡️ Tools Keamanan</h3>
        <div class="form-row">
            <div>
                <label for="sangfor">🛡️ Sangfor (SOAR)</label>
                <textarea name="sangfor" id="sangfor">{{ $beritaAcara->sangfor }}</textarea>
            </div>
            <div>
                <label for="jtn">🛡️ FortiJTN</label>
                <textarea name="jtn" id="jtn">{{ $beritaAcara->jtn }}</textarea>
            </div>
            <div>
                <label for="web">🛡️ FortiWeb</label>
                <textarea name="web" id="web">{{ $beritaAcara->web }}</textarea>
            </div>
        </div>

        <div class="form-row">
            <div>
                <label for="checkpoint">🛡️ Checkpoint</label>
                <textarea name="checkpoint" id="checkpoint">{{ $beritaAcara->checkpoint }}</textarea>
            </div>
            <div>
                <label for="sophos_ip">🌐 Sophos IP</label>
                <textarea name="sophos_ip" id="sophos_ip">{{ $beritaAcara->sophos_ip }}</textarea>
            </div>
            <div>
                <label for="sophos_url">🔗 Sophos URL</label>
                <textarea name="sophos_url" id="sophos_url">{{ $beritaAcara->sophos_url }}</textarea>
            </div>
        </div>

        <div class="form-row">
            <div>
                <label for="vpn">🔐 VPN</label>
                <textarea name="vpn" id="vpn">{{ $beritaAcara->vpn }}</textarea>
            </div>
            <div>
                <label for="edr">🧠 EDR</label>
                <textarea name="edr" id="edr">{{ $beritaAcara->edr }}</textarea>
            </div>
            <div>
                <label for="daily_report">📄 Daily Report Magnus</label>
                <textarea name="daily_report" id="daily_report">{{ $beritaAcara->daily_report }}</textarea>
            </div>
        </div>

        <button type="submit">💾 Simpan Perubahan</button>
    </form>
</div>

<script>
function tambahPetugas(tipe) {
    const container = document.getElementById(`petugas${tipe}Container`);
    const div = document.createElement('div');
    div.classList.add('form-row', 'multi-input');
    div.innerHTML = `
        <input type="text" name="nama_${tipe.toLowerCase()}[]" placeholder="Nama Petugas ${tipe}" required>
        <input type="text" name="nik_${tipe.toLowerCase()}[]" placeholder="NIK ${tipe}" required>
    `;
    container.appendChild(div);
}

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

function tambahInput(wrapperId, name) {
    const wrapper = document.getElementById(wrapperId);
    const firstInput = wrapper.querySelector('.input-wrapper');
    const newInput = firstInput.cloneNode(true);

    // Reset value select
    const select = newInput.querySelector('select');
    if (select) select.selectedIndex = 0;

    wrapper.appendChild(newInput);

    // Tampilkan tombol hapus di semua kolom
    const allInputs = wrapper.querySelectorAll('.input-wrapper');
    allInputs.forEach(input => {
        const btn = input.querySelector('.btn-hapus');
        if (btn) btn.style.display = 'inline-block';
    });
}

function hapusInput(button) {
    const wrapper = button.closest('#petugasLamaWrapper') || button.closest('#petugasBaruWrapper');
    const allInputs = wrapper.querySelectorAll('.input-wrapper');

    if (allInputs.length > 1) {
        button.parentElement.remove();

        // Kalau tinggal satu, sembunyikan tombol hapus
        const remainingInputs = wrapper.querySelectorAll('.input-wrapper');
        if (remainingInputs.length === 1) {
            const btn = remainingInputs[0].querySelector('.btn-hapus');
            if (btn) btn.style.display = 'none';
        }
    }
}

window.onload = function () {
    ['petugasLamaWrapper', 'petugasBaruWrapper'].forEach(wrapperId => {
        const wrapper = document.getElementById(wrapperId);
        if (wrapper) {
            const allInputs = wrapper.querySelectorAll('.input-wrapper');
            if (allInputs.length === 1) {
                const btn = allInputs[0].querySelector('.btn-hapus');
                if (btn) btn.style.display = 'none';
            }
        }
    });
}
</script>

</body>
</html>