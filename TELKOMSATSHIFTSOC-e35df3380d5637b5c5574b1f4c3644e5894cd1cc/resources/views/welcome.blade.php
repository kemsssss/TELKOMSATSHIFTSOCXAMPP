    <!DOCTYPE html>
    <html lang="id">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Berita Acara Shift SOC Telkomsat</title>
      <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
      <link rel="stylesheet" href="{{ asset('css/style.css') }}">  
    </head>

    <body style="margin: 0; font-family: Arial, sans-serif; display: flex;">

    <body>
       @include('components.sidebar')
  </div>
      <div id="jam" style="position: absolute; top: 20px; right: 30px; font-size: 14px; color: #555; z-index: 9999;"></div>
      <div id="jam"></div>
      

      <div class="container">
    <!-- Logo -->
    <div class="logo" style="text-align: center; margin-bottom: 20px;">
      <img src="https://uploads.onecompiler.io/42vf4qnqm/43scvhkgf/logotelkomsattt.png" alt="Logo Telkomsat" style="height: 100px;">
    </div>
        
        
        <h1>BERITA ACARA</h1>
        <h2>SERAH TERIMA SHIFT SOC TELKOMSAT</h2>
        <form action="{{ route('generate.pdf') }}" method="POST">
          @csrf
          
          
          
          <!-- Petugas Lama -->
          <div class="mb-4">
            <label class="block text-sm font-bold mb-1">Petugas Lama</label>
<div id="petugasLamaWrapper">
  <div class="input-wrapper">
    <select name="petugas_lama[]" class="select-petugas">
      @foreach ($petugas as $p)
        <option value="{{ $p->id }}">{{ $p->nama }}</option>
      @endforeach
    </select>
    <button type="button" class="btn-hapus" onclick="hapusInput(this)">Hapus</button>
  </div>
</div>

<button type="button" class="btn-tambah" onclick="tambahInput('petugasLamaWrapper', 'petugas_lama[]')">+ Tambah Petugas Lama</button>

          
          <label>Shift Petugas Lama</label>
          <select name="lama_shift" required>
            <option value="">-- Pilih Shift --</option>
            <option value="1 (06:30 - 14:30)">1 (06:30 - 14:30)</option>
            <option value="2 (14:30 - 22:30)">2 (14:30 - 22:30)</option>
            <option value="3 (22:30 - 06:30)">3 (22:30 - 06:30)</option>
          </select>
          
          <!-- Petugas Baru -->
          <div class="mb-4">
            <label class="block text-sm font-bold mb-1">Petugas Baru</label>
<div id="petugasBaruWrapper">
  <div class="input-wrapper">
    <select name="petugas_baru[]" class="select-petugas">
      @foreach ($petugas as $p)
        <option value="{{ $p->id }}">{{ $p->nama }} </option>
      @endforeach
    </select>
    <button type="button" class="btn-hapus" onclick="hapusInput(this)" style="display: none;">Hapus</button>
  </div>
</div>

<button type="button" class="btn-tambah" onclick="tambahInput('petugasBaruWrapper', 'petugas_baru[]')">+ Tambah Petugas Baru</button>


<label>Shift Petugas Baru</label>
<select name="baru_shift" required>
    <option value="">-- Pilih Shift --</option>
    <option value="1 (06:30 - 14:30)">1 (06:30 - 14:30)</option>
    <option value="2 (14:30 - 22:30)">2 (14:30 - 22:30)</option>
    <option value="3 (22:30 - 06:30)">3 (22:30 - 06:30)</option>
</select>

        <label>Tanggal Shift</label>
        <input type="date" name="tanggal_shift" value="{{ date('Y-m-d') }}">
            <label>Nomor Tiket</label>
            <input type="text" name="tiket_nomor" placeholder="#12345">
            
    <div class="section">
      <h3>Auto Blocking SOAR</h3>
      <div>
        <label for="soar_sangfor">SangFOR:</label>
        <input type="number" id="soar_sangfor" name="soar_sangfor" value="0" placeholder="Jumlah Sangfor">
      </div>
      <label for="soar_fortijtn">Forti-JTN:</label>
      <div>
        <input type="number" id="soar_fortijtn" name="soar_fortijtn" value="0" placeholder="Jumlah Forti-JTN">
      </div>
      <div>
        <label for="soar_fortiweb">FortiWeb:</label>
        <input type="number" id="soar_fortiweb" name="soar_fortiweb" value="0" placeholder="Jumlah FortiWeb">
      </div>
      <div>
        <label for="soar_checkpoint">CheckPoint:</label>
        <input type="number" id="soar_checkpoint" name="soar_checkpoint" value="0" placeholder="Jumlah CheckPoint">
      </div>
    </div>

    <!-- MANUAL BLOCKING DAN FOLLOWUP -->
    <div class="section">
      <h3>Manual Blocking dan FollowUP</h3>

      <div id="sophos-ip-group">
        <label>Sophos IP:</label>
        <input type="text" name="sophos_ip[]" placeholder="Mausukan IP (Jika Ingin Menambahkan Klik enter)">
      </div>

      <div id="sophos-url-group">
        <label>Sophos URL:</label>
        <input type="text" name="sophos_url[]" placeholder="Masukkan URL (Jika Ingin Menambahkan Klik enter)">
      </div>

      <div id="vpn-group">
        <label>VPN:</label>
        <input type="text" name="vpn[]" placeholder="Masukkan VPN (Jika Ingin Menambahkan Klik enter)">
      </div>

      <div id="edr-group">
        <label>EDR:</label>
        <input type="text" name="edr[]" placeholder="Masukkan EDR (Jika Ingin Menambahkan Klik enter)">
      </div>

      <div id="magnus-group">
        <label>Daily Report Magnus:</label>
        <input type="text" name="magnus[]" placeholder="Masukkan laporan Magnus (Jika Ingin Menambahkan Klik enter)">
      </div>
    </div>
    </ul>

    <div class="section">
      <p>Demikian berita acara ini dibuat dengan sebenar-benarnya sebagai bukti telah dilakukan serah terima shift SOC Telkomsat.</p>
    </div>        

<label>Petugas Lama:</label>
<select id="petugas_lama" name="petugas_lama[]" class="border rounded p-2" required>
    <option value="">Pilih Petugas Lama</option>
    @foreach($petugas as $p)
        <option value="{{ $p->id }}" data-nik="{{ $p->nik }}">{{ $p->nama }}</option>
    @endforeach
</select>

<!-- Preview info petugas lama -->
<div id="info_petugas_lama" class="mt-2">
    <p><strong>NIK:</strong> <span id="nik_lama"></span></p>
</div>

<br>

<label>Petugas Baru:</label>
<select id="petugas_baru" name="petugas_baru[]" class="border rounded p-2" required>
    <option value="">Pilih Petugas Baru</option>
    @foreach($petugas as $p)
        <option value="{{ $p->id }}" data-nik="{{ $p->nik }}">{{ $p->nama }}</option>
    @endforeach
</select>

<!-- Preview info petugas baru -->
<div id="info_petugas_baru" class="mt-2">
    <p><strong>NIK:</strong> <span id="nik_baru"></span></p>
</div>
        
<button type="submit" style="background-color: #28a745; color: white; padding: 8px 16px; border: none; border-radius: 5px;">
  Simpan
</button>

      </form>
      
      
    </div>
    </div>

<script>
// 1. Input dinamis (tekan Enter)
function setupDynamicInput(groupId, inputName) {
  const group = document.getElementById(groupId);

  group.addEventListener('keydown', function (e) {
    if (e.target.tagName === 'INPUT' && e.key === 'Enter') {
      e.preventDefault();

      if (e.target.value.trim() === '') return;

      const wrapper = document.createElement('div');
      wrapper.className = 'input-wrapper';

      const newInput = document.createElement('input');
      newInput.type = 'text';
      newInput.name = inputName + '[]';
      newInput.placeholder = e.target.placeholder;
      newInput.className = e.target.className;

      const deleteBtn = document.createElement('button');
      deleteBtn.className = 'delete-btn ml-2 text-red-500';
      deleteBtn.innerHTML = '🗑️';
      deleteBtn.type = 'button';
      deleteBtn.onclick = () => group.removeChild(wrapper);

      wrapper.appendChild(newInput);
      wrapper.appendChild(deleteBtn);
      group.appendChild(wrapper);

      newInput.focus();
    }
  });
}

setupDynamicInput('sophos-ip-group', 'sophos_ip');
setupDynamicInput('sophos-url-group', 'sophos_url');
setupDynamicInput('vpn-group', 'vpn');
setupDynamicInput('edr-group', 'edr');
setupDynamicInput('magnus-group', 'magnus');
</script>

<script>
// 2. Fetch data petugas (NIK dan TTD) dinamis
function fetchPetugas(id, targetNik, targetTtd) {
  if (!id) return;
  fetch(`/petugas/${id}`)
    .then(res => res.json())
    .then(data => {
      document.getElementById(targetNik).innerText = data.nik || '-';
      if (targetTtd && data.ttd) {
        document.getElementById(targetTtd).src = `/${data.ttd}`;
      }
    })
    .catch(() => {
      document.getElementById(targetNik).innerText = '-';
      if (targetTtd) {
        document.getElementById(targetTtd).src = '';
      }
    });
}

document.getElementById('petugas_lama').addEventListener('change', function () {
  fetchPetugas(this.value, 'nik_lama', 'ttd_lama');
});

document.getElementById('petugas_baru').addEventListener('change', function () {
  fetchPetugas(this.value, 'nik_baru', 'ttd_baru');
});
</script>

<script>
// 3. Update jam dan tanggal realtime
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
// 4. Tambah input petugas secara dinamis
function tambahInput(wrapperId, name) {
  const wrapper = document.getElementById(wrapperId);
  const div = document.createElement("div");
  div.classList.add("flex", "items-center", "mb-2");
  div.innerHTML = `
    <select name="${name}" class="form-select">
      @foreach($petugas as $p)
        <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->nik }})</option>
      @endforeach
    </select>
    <button type="button" class="ml-2 text-red-500" onclick="hapusInput(this)">Hapus</button>
  `;
  wrapper.appendChild(div);
}

function hapusInput(button) {
  button.parentElement.remove();
}
</script>

<script>
  function tambahInput(wrapperId, name) {
    const wrapper = document.getElementById(wrapperId);
    const firstInput = wrapper.querySelector('.input-wrapper');
    const newInput = firstInput.cloneNode(true);

    // Reset value
    newInput.querySelector('select').value = '';

    // Tampilkan tombol hapus jika lebih dari 1 kolom
    const allInputs = wrapper.querySelectorAll('.input-wrapper');
    allInputs.forEach(input => {
      const btn = input.querySelector('.btn-hapus');
      if (btn) btn.style.display = 'inline-block';
    });

    wrapper.appendChild(newInput);
  }

  function hapusInput(button) {
    const wrapper = button.closest('#petugasBaruWrapper') || button.closest('#petugasLamaWrapper');
    const allInputs = wrapper.querySelectorAll('.input-wrapper');

    if (allInputs.length > 1) {
      button.parentElement.remove();

      // Jika setelah hapus cuma tinggal 1, sembunyikan tombol hapus yang tersisa
      const remainingInputs = wrapper.querySelectorAll('.input-wrapper');
      if (remainingInputs.length === 1) {
        const btn = remainingInputs[0].querySelector('.btn-hapus');
        if (btn) btn.style.display = 'none';
      }
    }
  }

  // Sembunyikan tombol hapus jika hanya satu kolom saat halaman dimuat
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