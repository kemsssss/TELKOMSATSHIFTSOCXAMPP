<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;
use Illuminate\Support\Facades\Storage;

class PetugasController extends Controller
{
    public function index(Request $request)
{
    $query = Petugas::query();

    if ($request->has('cari')) {
        $search = $request->input('cari');
        $query->where('nama', 'like', '%' . $search . '%')
              ->orWhere('nik', 'like', '%' . $search . '%');
    }

    $petugas = $query->latest()->get();

    return view('petugas.index', compact('petugas'));
}

    public function create()
    {
        return view('petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:petugas,nik',
            'ttd' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $ttdPath = $request->file('ttd')->store('ttd', 'public');

        Petugas::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'ttd' => $ttdPath,
        ]);

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);
        return view('petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:petugas,nik,' . $id,
            'ttd' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'nik' => $request->nik,
        ];

        if ($request->hasFile('ttd')) {
            // Hapus TTD lama jika ada
            if ($petugas->ttd && Storage::disk('public')->exists($petugas->ttd)) {
                Storage::disk('public')->delete($petugas->ttd);
            }

            // Upload TTD baru
            $data['ttd'] = $request->file('ttd')->store('ttd', 'public');
        }

        $petugas->update($data);

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);

        // Hapus file TTD
        if ($petugas->ttd && Storage::disk('public')->exists($petugas->ttd)) {
            Storage::disk('public')->delete($petugas->ttd);
        }

        $petugas->delete();

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil dihapus.');
    }
    public function show($id)
{
    $petugas = Petugas::findOrFail($id);
    return response()->json([
        'nik' => $petugas->nik,
        'ttd' => $petugas->ttd_path, // sesuaikan field gambar tanda tangan
    ]);
}

}
