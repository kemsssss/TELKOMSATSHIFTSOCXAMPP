<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\BeritaAcara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class BeritaAcaraController extends Controller
{
    public function showForm() {
        $petugas = Petugas::all();
        return view('welcome', compact('petugas'));
    }

    public function cetakPDF(Request $request) {
        $validated = $request->validate([
            'petugas_lama'    => 'required|array|min:1',
            'petugas_lama.*'  => 'exists:petugas,id',
            'petugas_baru'    => 'required|array|min:1',
            'petugas_baru.*'  => 'exists:petugas,id',
            'lama_shift'      => 'required|string',
            'baru_shift'      => 'required|string',
            'tanggal_shift'   => 'required|date',
            // prtg fields are arrays (multiple inputs)
            'prtg1'           => 'nullable|array',
            'prtg1.*'         => 'nullable|string',
            'prtg_status1'    => 'nullable|array',
            'prtg_status1.*'  => 'nullable|string',
            'prtg2'           => 'nullable|array',
            'prtg2.*'         => 'nullable|string',
            'prtg_status2'    => 'nullable|array',
            'prtg_status2.*'  => 'nullable|string',
                'nomortiket_magnus'   => 'nullable|array',
    'nomortiket_magnus.*' => 'nullable|string',
    'detail_magnus'       => 'nullable|array',
    'detail_magnus.*'     => 'nullable|string',
        ]);

        $petugasLama = Petugas::whereIn('id', $validated['petugas_lama'])->get();
        $petugasBaru = Petugas::whereIn('id', $validated['petugas_baru'])->get();

        // Ambil ID terakhir yg dipilih
        $lastPetugasLamaId = end($validated['petugas_lama']);
        $lastPetugasBaruId = end($validated['petugas_baru']);

        // Temukan petugas berdasarkan ID
        $lastPetugasLama = $petugasLama->firstWhere('id', $lastPetugasLamaId);
        $lastPetugasBaru = $petugasBaru->firstWhere('id', $lastPetugasBaruId);

        // TTD
        $lama_ttd = $lastPetugasLama && $lastPetugasLama->ttd ? $this->getBase64FromStorage($lastPetugasLama->ttd) : null;
        $baru_ttd = $lastPetugasBaru && $lastPetugasBaru->ttd ? $this->getBase64FromStorage($lastPetugasBaru->ttd) : null;

        // Logo
        $logo = $this->getBase64FromStorage('logotelkomsat/Logo-Telkomsat.png');

        $cekDuplikat = BeritaAcara::where('tanggal_shift', $validated['tanggal_shift'])
            ->where('lama_shift', $validated['lama_shift'])
            ->whereHas('petugasLama', function ($q) use ($validated) {
                $q->whereIn('petugas_id', $validated['petugas_lama']);
            })
            ->exists();

        if ($cekDuplikat) {
            $tanggalKemarin = now()->subDay()->toDateString();
            if (!($validated['lama_shift'] == 3 && $validated['tanggal_shift'] == $tanggalKemarin)) {
                return back()->with('error', 'Berita acara untuk shift dan tanggal ini sudah dibuat.');
            }
        }

        // Simpan ke DB (aman: implode array -> string untuk kolom multiline)
        $beritaAcara = BeritaAcara::create([
            'lama_shift'     => $validated['lama_shift'],
            'baru_shift'     => $validated['baru_shift'],
            'tanggal_shift'  => $validated['tanggal_shift'],
            'tiket'          => $request->input('tiket_nomor'),
            'sangfor'        => $request->input('soar_sangfor'),
            'jtn'            => $request->input('soar_fortijtn'),
            'web'            => $request->input('soar_fortiweb'),
            'checkpoint'     => $request->input('soar_checkpoint'),
            'sophos_ip'      => implode("\n", array_filter($request->input('sophos_ip', []))),
            'sophos_url'     => implode("\n", array_filter($request->input('sophos_url', []))),
            'vpn'            => implode("\n", array_filter($request->input('vpn', []))),
            'edr'            => implode("\n", array_filter($request->input('edr', []))),
            'prtg1'          => implode("\n", array_filter($request->input('prtg1', []))),
            'prtg_status1'   => implode("\n", array_filter($request->input('prtg_status1', []))),
            'prtg2'          => implode("\n", array_filter($request->input('prtg2', []))),
            'prtg_status2'   => implode("\n", array_filter($request->input('prtg_status2', []))),
            'nomortiket_magnus' => implode("\n", array_filter($request->input('nomortiket_magnus', []))),
    'detail_magnus'     => implode("\n", array_filter($request->input('detail_magnus', []))),
        ]);

        $beritaAcara->petugasLama()->sync($validated['petugas_lama']);
        $beritaAcara->petugasBaru()->sync($validated['petugas_baru']);

        // Data untuk PDF (kita kirim array dari request supaya view bisa looping)
        $data = [
            'petugas_lama'   => $petugasLama,
            'petugas_baru'   => $petugasBaru,
            'lama_shift'     => $validated['lama_shift'],
            'baru_shift'     => $validated['baru_shift'],
            'tanggal_shift'  => $validated['tanggal_shift'],
            'tiket_nomor'    => $request->input('tiket_nomor'),
            'sangfor'        => $request->input('soar_sangfor'),
            'fortijtn'       => $request->input('soar_fortijtn'),
            'fortiweb'       => $request->input('soar_fortiweb'),
            'checkpoint'     => $request->input('soar_checkpoint'),
            'sophos_ip'      => $request->input('sophos_ip', []),
            'sophos_url'     => $request->input('sophos_url', []),
            'vpn'            => $request->input('vpn', []),
            'edr'            => $request->input('edr', []),
            'magnus'         => $request->input('magnus', []),
            'lama_ttd'       => $lama_ttd,
            'baru_ttd'       => $baru_ttd,
            'lama_nama'      => $lastPetugasLama->nama ?? '-',
            'lama_nik'       => $lastPetugasLama->nik ?? '-',
            'baru_nama'      => $lastPetugasBaru->nama ?? '-',
            'baru_nik'       => $lastPetugasBaru->nik ?? '-',
            'logo'           => $logo,
            'prtg1'          => $request->input('prtg1', []),
            'prtg_status1'   => $request->input('prtg_status1', []),
            'prtg2'          => $request->input('prtg2', []),
            'prtg_status2'   => $request->input('prtg_status2', []),
                'nomortiket_magnus' => $request->input('nomortiket_magnus', []),
    'detail_magnus'     => $request->input('detail_magnus', []),
        ];

        return Pdf::loadView('berita-acara', $data)->stream('serah-terima-shift-SOC.pdf');
    }

    public function print($id)
    {
        $beritaAcara = BeritaAcara::with(['petugasLama', 'petugasBaru'])->findOrFail($id);

        $petugas_lama = $beritaAcara->petugasLama;
        $petugas_baru = $beritaAcara->petugasBaru;

        $lastPetugasLama = $petugas_lama->last();
        $lastPetugasBaru = $petugas_baru->last();

        $data = [
            'petugas_lama'   => $petugas_lama,
            'petugas_baru'   => $petugas_baru,
            'lama_shift'     => $beritaAcara->lama_shift,
            'baru_shift'     => $beritaAcara->baru_shift,
            'tanggal_shift'  => $beritaAcara->tanggal_shift,
            'tiket_nomor'    => $beritaAcara->tiket,
            'sangfor'        => $beritaAcara->sangfor,
            'fortijtn'       => $beritaAcara->jtn,
            'fortiweb'       => $beritaAcara->web,
            'checkpoint'     => $beritaAcara->checkpoint,
            'sophos_ip'      => explode("\n", $beritaAcara->sophos_ip ?? ''),
            'sophos_url'     => explode("\n", $beritaAcara->sophos_url ?? ''),
            'vpn'            => explode("\n", $beritaAcara->vpn ?? ''),
            'edr'            => explode("\n", $beritaAcara->edr ?? ''),
            'lama_ttd'       => $this->getBase64FromStorage($lastPetugasLama->ttd ?? null),
            'baru_ttd'       => $this->getBase64FromStorage($lastPetugasBaru->ttd ?? null),
            'lama_nama'      => $lastPetugasLama->nama ?? '-',
            'lama_nik'       => $lastPetugasLama->nik ?? '-',
            'baru_nama'      => $lastPetugasBaru->nama ?? '-',
            'baru_nik'       => $lastPetugasBaru->nik ?? '-',
            'logo'           => $this->getBase64FromStorage('logotelkomsat/Logo-Telkomsat.png'),
            'prtg1'        => explode("\n", $beritaAcara->prtg1 ?? ''),
            'prtg_status1' => explode("\n", $beritaAcara->prtg_status1 ?? ''),
            'prtg2'        => explode("\n", $beritaAcara->prtg2 ?? ''),
            'prtg_status2' => explode("\n", $beritaAcara->prtg_status2 ?? ''),
'nomortiket_magnus' => json_decode($beritaAcara->nomortiket_magnus ?? '[]', true),
'detail_magnus'     => json_decode($beritaAcara->detail_magnus ?? '[]', true),


        ];

        return Pdf::loadView('berita-acara', $data)->stream('Serah Terima Shift SOC.pdf');
    }

    public function getPetugas($id)
    {
        $petugas = Petugas::findOrFail($id);

        return response()->json([
            'nama' => $petugas->nama,
            'nik' => $petugas->nik,
            'ttd' => $petugas->ttd,
        ]);
    }

    public function index()
    {
        $beritaAcaras = BeritaAcara::with(['petugasLama', 'petugasBaru'])->get();
        return view('table', compact('beritaAcaras'));
    }

    public function edit($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);
        $petugas = Petugas::all(); // Ambil semua petugas
        return view('edittable', compact('beritaAcara', 'petugas'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tiket'        => 'nullable|string',
            'sangfor'      => 'nullable|string',
            'jtn'          => 'nullable|string',
            'web'          => 'nullable|string',
            'checkpoint'   => 'nullable|string',
            // allow array inputs on update (same shape as create)
            'sophos_ip'    => 'nullable|array',
            'sophos_ip.*'  => 'nullable|string',
            'sophos_url'   => 'nullable|array',
            'sophos_url.*' => 'nullable|string',
            'vpn'          => 'nullable|array',
            'vpn.*'        => 'nullable|string',
            'edr'          => 'nullable|array',
            'edr.*'        => 'nullable|string',
            'petugas_lama' => 'nullable|array',
            'petugas_lama.*' => 'exists:petugas,id',
            'petugas_baru' => 'nullable|array',
            'petugas_baru.*' => 'exists:petugas,id',
            'lama_shift'   => 'nullable|string',
            'baru_shift'   => 'nullable|string',
            'tanggal_shift' => 'nullable|date',
            'prtg1'         => 'nullable|string',
            'prtg1.*'       => 'nullable|string',
            'prtg_status1'  => 'nullable|string',
            'prtg_status1.*'=> 'nullable|string',
            'prtg2'         => 'nullable|string',
            'prtg2.*'       => 'nullable|string',
            'prtg_status2'  => 'nullable|string',
            'prtg_status2.*'=> 'nullable|string',
                'nomortiket_magnus'   => 'nullable|array',
    'nomortiket_magnus.*' => 'nullable|string',
    'detail_magnus'       => 'nullable|array',
    'detail_magnus.*'     => 'nullable|string',
        ]);

        $beritaAcara = BeritaAcara::findOrFail($id);

        // Konversi array -> string untuk kolom multiline sebelum update
$fieldsToImplode = [
    'sophos_ip','sophos_url','vpn','edr',
    'nomortiket_magnus','detail_magnus',
    'prtg1','prtg_status1','prtg2','prtg_status2'
];

        foreach ($fieldsToImplode as $field) {
            if (isset($validated[$field]) && is_array($validated[$field])) {
                $validated[$field] = implode("\n", array_filter($validated[$field], function($v) {
                    return $v !== null && trim($v) !== '';
                }));
            }
        }

        // Lakukan update (relasi akan disinkronkan di bawah)
        $beritaAcara->update($validated);

        // Sinkronisasi petugas lama
        if ($request->filled('petugas_lama')) {
            $beritaAcara->petugasLama()->sync($request->petugas_lama);
        }

        // Sinkronisasi petugas baru
        if ($request->filled('petugas_baru')) {
            $beritaAcara->petugasBaru()->sync($request->petugas_baru);
        }

        return redirect()->route('table')->with('success', 'Data Berita Acara berhasil diperbarui.');
    }

    private function getBase64FromStorage($relativePath)
    {
        if (!$relativePath) return '';

        if (Storage::disk('public')->exists($relativePath)) {
            $path = Storage::disk('public')->path($relativePath);
            $mime = mime_content_type($path);
            $base64 = base64_encode(file_get_contents($path));
            return "data:{$mime};base64,{$base64}";
        }
        return '';
    }

    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $beritaAcara = BeritaAcara::findOrFail($id);

        // Jika ada relasi many-to-many, detach dulu biar data pivot ikut hilang
        $beritaAcara->petugasLama()->detach();
        $beritaAcara->petugasBaru()->detach();

        // Hapus data utama
        $beritaAcara->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('beritaacara.index')
                         ->with('success', 'Data berhasil dihapus.');
    }
}