<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Berita Acara Shift SOC Telkomsat</title>
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <style>
    /* Tambahan kecil styling supaya tombol hapus bagus */
    .btn-hapus {
      background-color: transparent;
      border: none;
      color: #dc3545;
      cursor: pointer;
      font-weight: bold;
      margin-left: 8px;
    }
    .input-wrapper {
      display: flex;
      align-items: center;
      margin-bottom: 6px;
    }
    .input-wrapper select,
    .input-wrapper input[type="text"] {
      flex: 1;
      padding: 6px 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
  </style>
</head>

<body style="margin: 0; font-family: Arial, sans-serif; display: flex;">

  @include('components.sidebar')

  <div class="container" style="padding: 20px; max-width: 900px; width: 100%;">
    <!-- Jam realtime -->
    <div id="jam" style="position: absolute; top: 20px; right: 30px; font-size: 14px; color: #555; z-index: 9999;"></div>

    <!-- Logo -->
    <div class="logo" style="text-align: center; margin-bottom: 20px;">
      <img src="https://uploads.onecompiler.io/42vf4qnqm/43scvhkgf/logotelkomsattt.png" alt="Logo Telkomsat" style="height: 100px;" />
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
            <select name="petugas_lama[]" class="select-petugas" required>
              @foreach ($petugas as $p)
                <option value="{{ $p->id }}">{{ $p->nama }}</option>
              @endforeach
            </select>
            <button type="button" class="btn-hapus" onclick="hapusInput(this)" style="display:none;">Hapus</button>
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
      </div>

      <!-- Petugas Baru -->
      <div class="mb-4">
        <label class="block text-sm font-bold mb-1">Petugas Baru</label>
        <div id="petugasBaruWrapper">
          <div class="input-wrapper">
            <select name="petugas_baru[]" class="select-petugas" required>
              @foreach ($petugas as $p)
                <option value="{{ $p->id }}">{{ $p->nama }}</option>
              @endforeach
            </select>
            <button type="button" class="btn-hapus" onclick="hapusInput(this)" style="display:none;">Hapus</button>
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
      </div>

      <label>Tanggal Shift</label>
      <input type="date" name="tanggal_shift" value="{{ date('Y-m-d') }}" required />

      <label>Nomor Tiket</label>
      <input type="text" name="tiket_nomor" placeholder="#12345" />

      <!-- Auto Blocking SOAR -->
      <div class="section">
        <h3>Auto Blocking SOAR</h3>
        <div>
          <label for="soar_sangfor">SangFOR:</label>
          <input type="number" id="soar_sangfor" name="soar_sangfor" value="0" placeholder="Jumlah Sangfor" />
        </div>
        <div>
          <label for="soar_fortijtn">Forti-JTN:</label>
          <input type="number" id="soar_fortijtn" name="soar_fortijtn" value="0" placeholder="Jumlah Forti-JTN" />
        </div>
        <div>
          <label for="soar_fortiweb">FortiWeb:</label>
          <input type="number" id="soar_fortiweb" name="soar_fortiweb" value="0" placeholder="Jumlah FortiWeb" />
        </div>
        <div>
          <label for="soar_checkpoint">CheckPoint:</label>
          <input type="number" id="soar_checkpoint" name="soar_checkpoint" value="0" placeholder="Jumlah CheckPoint" />
        </div>
      </div>

      <!-- MANUAL BLOCKING DAN FOLLOWUP -->
      <div class="section">
        <h3>Manual Blocking dan FollowUP</h3>

        <div id="sophos-ip-group">
          <label>Sophos IP:</label>
          <input type="text" name="sophos_ip[]" placeholder="Masukkan IP Sophos (Jika Ingin Menambahkan Klik enter)" />
        </div>

        <div id="sophos-url-group">
          <label>Sophos URL:</label>
          <input type="text" name="sophos_url[]" placeholder="Masukkan URL Sophos (Jika Ingin Menambahkan Klik enter)" />
        </div>

        <div id="vpn-group">
          <label>VPN:</label>
          <input type="text" name="vpn[]" placeholder="Masukkan VPN (Jika Ingin Menambahkan Klik enter)" />
        </div>

        <div id="edr-group">
          <label>EDR:</label>
          <input type="text" name="edr[]" placeholder="Masukkan EDR (Jika Ingin Menambahkan Klik enter)" />
        </div>

        <div id="magnus-group">
          <label>Daily Report Magnus:</label>
          <input type="text" name="magnus[]" placeholder="Masukkan laporan Magnus (Jika Ingin Menambahkan Klik enter)" />
        </div>
      </div>

      <!-- PRTG BAKTI -->
      <div class="section">
        <h3>PRTG BAKTI</h3>

        <div id="prtg1-group">
          <label for="prtg1" class="block font-semibold">PRTG 1 (Link)</label>
          <textarea
            name="prtg1[]"
            class="border rounded w-full p-2 mt-1 resize-none"
            placeholder="Masukkan link PRTG 1"
            style="height: 80px; background-color: #f9f9f9; font-size: 14px;"
          ></textarea>
        </div>

        <div id="prtg_status1-group">
          <label for="prtg_status1" class="block font-semibold">PRTG Status 1</label>
          <textarea
            name="prtg_status1[]"
            class="border rounded w-full p-2 mt-1 resize-none"
            placeholder="Masukkan status PRTG 1"
          ></textarea>
        </div>

        <div id="prtg2-group">
          <label for="prtg2" class="block font-semibold">PRTG 2 (Link)</label>
          <textarea
            name="prtg2[]"
            class="border rounded w-full p-2 mt-1 resize-none"
            placeholder="Masukkan link PRTG 2 (Tekan Enter untuk baris baru)"
          ></textarea>
        </div>

        <div id="prtg_status2-group">
          <label for="prtg_status2" class="block font-semibold">PRTG Status 2</label>
          <textarea
            name="prtg_status2[]"
            class="border rounded w-full p-2 mt-1 resize-none"
            placeholder="Masukkan status PRTG 2 (Tekan Enter untuk baris baru)"
          ></textarea>
        </div>
      </div>

      <div class="section" style="margin-top: 20px;">
        <p>
          Demikian berita acara ini dibuat dengan sebenar-benarnya sebagai bukti telah dilakukan serah terima shift SOC Telkomsat.
        </p>
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

  <script>
    // Dynamic input tambah/hapus untuk Petugas Lama dan Baru
    function tambahInput(wrapperId, name) {
      const wrapper = document.getElementById(wrapperId);
      const firstInput = wrapper.querySelector(".input-wrapper");
      const newInput = firstInput.cloneNode(true);

      // Reset value select
      newInput.querySelector("select").value = "";

      // Tampilkan tombol hapus jika lebih dari 1 kolom
      const allInputs = wrapper.querySelectorAll(".input-wrapper");
      allInputs.forEach((input) => {
        const btn = input.querySelector(".btn-hapus");
        if (btn) btn.style.display = "inline-block";
      });

      wrapper.appendChild(newInput);
    }

    function hapusInput(button) {
      const wrapper = button.closest("#petugasBaruWrapper") || button.closest("#petugasLamaWrapper");
      const allInputs = wrapper.querySelectorAll(".input-wrapper");

      if (allInputs.length > 1) {
        button.parentElement.remove();

        // Jika hanya 1 tersisa, sembunyikan tombol hapus
        const remainingInputs = wrapper.querySelectorAll(".input-wrapper");
        if (remainingInputs.length === 1) {
          const btn = remainingInputs[0].querySelector(".btn-hapus");
          if (btn) btn.style.display = "none";
        }
      }
    }

    // Saat halaman load, sembunyikan tombol hapus jika hanya 1 input
    window.onload = function () {
      ["petugasLamaWrapper", "petugasBaruWrapper"].forEach((wrapperId) => {
        const wrapper = document.getElementById(wrapperId);
        if (wrapper) {
          const allInputs = wrapper.querySelectorAll(".input-wrapper");
          if (allInputs.length === 1) {
            const btn = allInputs[0].querySelector(".btn-hapus");
            if (btn) btn.style.display = "none";
          }
        }
      });
    };
  </script>

  <script>
    // Setup dynamic input dengan tombol enter untuk manual blocking dan PRTG
    function setupDynamicInput(groupId, inputName) {
      const group = document.getElementById(groupId);

      const placeholderMap = {
        "sophos-ip-group": "Masukkan IP Sophos (Jika Ingin Menambahkan Klik enter)",
        "sophos-url-group": "Masukkan URL Sophos (Jika Ingin Menambahkan Klik enter)",
        "vpn-group": "Masukkan VPN (Jika Ingin Menambahkan Klik enter)",
        "edr-group": "Masukkan EDR (Jika Ingin Menambahkan Klik enter)",
        "magnus-group": "Masukkan laporan Magnus (Jika Ingin Menambahkan Klik enter)",
        "prtg1-group": "Masukkan link PRTG 1",
        "prtg_status1-group": "Masukkan status PRTG 1",
        "prtg2-group": "Masukkan link PRTG 2 (Tekan Enter untuk baris baru)",
        "prtg_status2-group": "Masukkan status PRTG 2 (Tekan Enter untuk baris baru)",
      };

      function addInput() {
        const wrapper = document.createElement("div");
        wrapper.className = "flex items-center mt-2";

        let newInput;
        // Jika groupId berisi 'prtg', buat textarea, bukan input
        if (groupId.startsWith("prtg")) {
          newInput = document.createElement("textarea");
          newInput.style.height = "80px";
          newInput.style.backgroundColor = "#f9f9f9";
          newInput.style.fontSize = "14px";
          newInput.className = "border rounded w-full p-2 mt-1 resize-none";
        } else {
          newInput = document.createElement("input");
          newInput.type = "text";
          newInput.className = "border rounded w-full p-2";
        }

        newInput.name = inputName + "[]";
        newInput.placeholder = placeholderMap[groupId] || "Masukkan data";

        const deleteBtn = document.createElement("button");
        deleteBtn.type = "button";
        deleteBtn.className = "ml-2 text-red-500";
        deleteBtn.textContent = "🗑️";
        deleteBtn.onclick = () => group.removeChild(wrapper);

        wrapper.appendChild(newInput);
        wrapper.appendChild(deleteBtn);
        group.appendChild(wrapper);

        newInput.addEventListener("keydown", handleEnter);
        newInput.focus();
      }

      function handleEnter(e) {
        if (e.key === "Enter") {
          e.preventDefault();
          if (e.target.value.trim() !== "") {
            addInput();
          }
        }
      }

      // Pasang listener enter di input pertama (jika ada)
      const firstInput = group.querySelector("input, textarea");
      if (firstInput) firstInput.addEventListener("keydown", handleEnter);
    }

    setupDynamicInput("sophos-ip-group", "sophos_ip");
    setupDynamicInput("sophos-url-group", "sophos_url");
    setupDynamicInput("vpn-group", "vpn");
    setupDynamicInput("edr-group", "edr");
    setupDynamicInput("magnus-group", "magnus");
    setupDynamicInput("prtg1-group", "prtg1");
    setupDynamicInput("prtg_status1-group", "prtg_status1");
    setupDynamicInput("prtg2-group", "prtg2");
    setupDynamicInput("prtg_status2-group", "prtg_status2");
  </script>

  <script>
    // Update jam dan tanggal realtime
    document.addEventListener("DOMContentLoaded", function () {
      function updateJam() {
        const jamElement = document.getElementById("jam");
        const now = new Date();

        const options = { day: "numeric", month: "long", year: "numeric" };
        const tanggal = now.toLocaleDateString("id-ID", options);
        const waktu = now.toLocaleTimeString("id-ID");

        jamElement.textContent = `${tanggal} - ${waktu}`;
      }

      setInterval(updateJam, 1000);
      updateJam();
    });
  </script>

  <script>
    // Fetch data petugas (NIK) dinamis, contoh endpoint /petugas/{id} yang mengembalikan json { nik, ttd }
    function fetchPetugas(id, targetNik, targetTtd) {
      if (!id) return;
      fetch(`/petugas/${id}`)
        .then((res) => res.json())
        .then((data) => {
          document.getElementById(targetNik).innerText = data.nik || "-";
          if (targetTtd && data.ttd) {
            document.getElementById(targetTtd).src = `/${data.ttd}`;
          }
        })
        .catch(() => {
          document.getElementById(targetNik).innerText = "-";
          if (targetTtd) {
            document.getElementById(targetTtd).src = "";
          }
        });
    }

    // Contoh event untuk preview NIK (jika ada select petugas_lama/bbaru di luar dynamic)
    document.querySelectorAll('select[name="petugas_lama[]"]').forEach((el) =>
      el.addEventListener("change", function () {
        fetchPetugas(this.value, "nik_lama");
      })
    );

    document.querySelectorAll('select[name="petugas_baru[]"]').forEach((el) =>
      el.addEventListener("change", function () {
        fetchPetugas(this.value, "nik_baru");
      })
    );
  </script>
</body>
</html>
