<?php

namespace App\Http\Controllers;

use App\Models\AktivitasMahasiswa;
use App\Models\AktivitasMahasiswaBimbing;
use Illuminate\Http\Request;
use App\Exports\AktivitasMahasiswaBimbingExport;
use Maatwebsite\Excel\Facades\Excel;

class AktivitasMahasiswaBimbingController extends Controller
{
    public function index()
    {
        $bimbingUji = AktivitasMahasiswaBimbing::with('aktivitasMahasiswa')->get();
        return view('master.aktivitas-bimbing-uji.index', compact('bimbingUji'));
    }

    public function create()
    {
        $aktivitas = AktivitasMahasiswa::all();
        return view('master.aktivitas-bimbing-uji.create', compact('aktivitas'));
    }

    public function export()
    {
        return Excel::download(new AktivitasMahasiswaBimbingExport, 'aktivitas-mahasiswa-bimbingUji.xlsx');
    }

    public function store(Request $request)
    {
        $request->validate([
            'aktivitas_mahasiswa_id' => 'required',
            'nidn_dosen' => 'required',
            'nama_dosen' => 'required',
            'jenis_peran' => 'required',
            'urutan_pembimbing' => 'required',
            'kategori_kegiatan' => 'required',
        ]);

        AktivitasMahasiswaBimbing::create($request->all());
        return redirect()->route('bimbingUji.index')->with('success', 'Aktivitas berhasil ditambahkan.');
    }

    public function show($id)
    {
        $bimbingUji = AktivitasMahasiswaBimbing::findOrFail($id);
        return view('master.aktivitas-bimbing-uji.show', compact('bimbingUji'));
    }

    public function edit($id)
    {
        $bimbingUji = AktivitasMahasiswaBimbing::findOrFail($id);
        $aktivitas = AktivitasMahasiswa::all();
        return view('master.aktivitas-bimbing-uji.edit', compact('bimbingUji', 'aktivitas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'aktivitas_mahasiswa_id' => 'required',
            'nidn_dosen' => 'required',
            'nama_dosen' => 'required',
            'jenis_peran' => 'required',
            'urutan_pembimbing' => 'required',
            'kategori_kegiatan' => 'required',
        ]);

        $bimbingUji = AktivitasMahasiswaBimbing::findOrFail($id);
        $bimbingUji->update($request->all());
        return redirect()->route('bimbingUji.index')->with('success', 'Aktivitas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bimbingUji = AktivitasMahasiswaBimbing::findOrFail($id);
        $bimbingUji->delete();
        return redirect()->route('bimbingUji.index')->with('success', 'Aktivitas berhasil dihapus.');
    }
}
