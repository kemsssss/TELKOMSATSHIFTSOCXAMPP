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

    $lastPetugasLama = $petugasLama->firstWhere('id', end($validated['petugas_lama']));
    $lastPetugasBaru = $petugasBaru->firstWhere('id', end($validated['petugas_baru']));

    $lama_ttd = $lastPetugasLama && $lastPetugasLama->ttd ? $this->getBase64FromStorage($lastPetugasLama->ttd) : null;
    $baru_ttd = $lastPetugasBaru && $lastPetugasBaru->ttd ? $this->getBase64FromStorage($lastPetugasBaru->ttd) : null;
    $logo     = $this->getBase64FromStorage('logotelkomsat/Logo-Telkomsat.png');

    // Simpan ke DB, array jadi string dengan "\n"
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

    // Data untuk PDF
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
        'prtg1'          => explode("\n", $beritaAcara->prtg1 ?? ''),
        'prtg_status1'   => explode("\n", $beritaAcara->prtg_status1 ?? ''),
        'prtg2'          => explode("\n", $beritaAcara->prtg2 ?? ''),
        'prtg_status2'   => explode("\n", $beritaAcara->prtg_status2 ?? ''),
        'nomortiket_magnus' => explode("\n", $beritaAcara->nomortiket_magnus ?? ''),
        'detail_magnus'     => explode("\n", $beritaAcara->detail_magnus ?? ''),
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
            'sophos_ip'    => 'nullable|string',
            'sophos_ip.*'  => 'nullable|string',
            'sophos_url'   => 'nullable|string',
            'sophos_url.*' => 'nullable|string',
            'vpn'          => 'nullable|string',
            'vpn.*'        => 'nullable|string',
            'edr'          => 'nullable|string',
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
            'nomortiket_magnus'   => 'nullable|string',
            'nomortiket_magnus.*' => 'nullable|string',
            'detail_magnus'       => 'nullable|string',
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
            $path = public_path('storage/' . $relativePath);
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

        /**
     * Export data BeritaAcara ke ZIP berisi file CSV per bulan.
     */
    public function exportZipPerBulan(Request $request)
    {

        // Filter by tanggal/bulan jika ada
        $query = BeritaAcara::with(['petugasLama', 'petugasBaru']);
        // Filter tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_shift', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_shift', '<=', $request->end_date);
        }
        // Filter bulan
        if ($request->filled('start_month')) {
            $startMonth = $request->start_month . '-01';
            $query->whereDate('tanggal_shift', '>=', $startMonth);
        }
        if ($request->filled('end_month')) {
            // Ambil akhir bulan
            $endMonth = \Carbon\Carbon::parse($request->end_month . '-01')->endOfMonth()->format('Y-m-d');
            $query->whereDate('tanggal_shift', '<=', $endMonth);
        }
        $beritaAcaras = $query->orderBy('tanggal_shift')->get();

        // Jika tidak ada data, tampilkan error
        if ($beritaAcaras->isEmpty()) {
            return back()->with('error', 'Tidak ada data Berita Acara untuk range/filter yang dipilih.');
        }

        // Pastikan folder zip dan temp ada
        $zipDir = storage_path('app/public/zip');
        $tempDir = storage_path('app/public/zip/temp_pdf');
        if (!is_dir($zipDir)) {
            mkdir($zipDir, 0777, true);
        }
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $pdfFiles = [];
        foreach ($beritaAcaras as $row) {
            // Data untuk PDF (ambil dari method print, ringkas)
            $petugas_lama = $row->petugasLama;
            $petugas_baru = $row->petugasBaru;
            $lastPetugasLama = $petugas_lama->last();
            $lastPetugasBaru = $petugas_baru->last();
            $data = [
                'petugas_lama'   => $petugas_lama,
                'petugas_baru'   => $petugas_baru,
                'lama_shift'     => $row->lama_shift,
                'baru_shift'     => $row->baru_shift,
                'tanggal_shift'  => $row->tanggal_shift,
                'tiket_nomor'    => $row->tiket,
                'sangfor'        => $row->sangfor,
                'fortijtn'       => $row->jtn,
                'fortiweb'       => $row->web,
                'checkpoint'     => $row->checkpoint,
                'sophos_ip'      => explode("\n", $row->sophos_ip ?? ''),
                'sophos_url'     => explode("\n", $row->sophos_url ?? ''),
                'vpn'            => explode("\n", $row->vpn ?? ''),
                'edr'            => explode("\n", $row->edr ?? ''),
                'lama_ttd'       => $this->getBase64FromStorage($lastPetugasLama->ttd ?? null),
                'baru_ttd'       => $this->getBase64FromStorage($lastPetugasBaru->ttd ?? null),
                'lama_nama'      => $lastPetugasLama->nama ?? '-',
                'lama_nik'       => $lastPetugasLama->nik ?? '-',
                'baru_nama'      => $lastPetugasBaru->nama ?? '-',
                'baru_nik'       => $lastPetugasBaru->nik ?? '-',
                'logo'           => $this->getBase64FromStorage('logotelkomsat/Logo-Telkomsat.png'),
                'prtg1'          => explode("\n", $row->prtg1 ?? ''),
                'prtg_status1'   => explode("\n", $row->prtg_status1 ?? ''),
                'prtg2'          => explode("\n", $row->prtg2 ?? ''),
                'prtg_status2'   => explode("\n", $row->prtg_status2 ?? ''),
                'nomortiket_magnus' => explode("\n", $row->nomortiket_magnus ?? ''),
                'detail_magnus'     => explode("\n", $row->detail_magnus ?? ''),
            ];
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('berita-acara', $data);
            $pdfFileName = 'Berita_Acara_' . $row->id . '.pdf';
            $pdfPath = $tempDir . DIRECTORY_SEPARATOR . $pdfFileName;
            $pdf->save($pdfPath);
            $pdfFiles[$pdfFileName] = $pdfPath;
        }

        // Buat ZIP
        $zipFileName = 'berita_acara_perbulan_'.date('Ymd_His').'.zip';
        $zipPath = $zipDir . DIRECTORY_SEPARATOR . $zipFileName;
        $zip = new \ZipArchive();
        $openResult = $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        if ($openResult === TRUE) {
            foreach ($pdfFiles as $filename => $filePath) {
                $zip->addFile($filePath, $filename);
            }
            $zip->close();
        } else {
            // Hapus file PDF sementara jika gagal
            foreach ($pdfFiles as $filePath) { if (file_exists($filePath)) unlink($filePath); }
            return back()->with('error', 'Gagal membuat file ZIP. Kode error: ' . $openResult . ' | Path: ' . $zipPath);
        }

        // Hapus file PDF sementara
        foreach ($pdfFiles as $filePath) {
            if (file_exists($filePath)) unlink($filePath);
        }

        // Debug: cek apakah file berhasil dibuat
        if (!file_exists($zipPath)) {
            return back()->with('error', 'ZIP gagal dibuat. Path: ' . $zipPath);
        }

        // Download file ZIP
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }


    
}