<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktivitasMahasiswa;
use App\Models\ProgramStudi;
use App\Models\Semester;
use App\Exports\AktivitasMahasiswaExport;
use Maatwebsite\Excel\Facades\Excel;

class AktivitasMahasiswaController extends Controller
{
    public function index()
    {
        $aktivitas = AktivitasMahasiswa::with(['programStudi', 'semester'])->get();
        return view('master.aktivitas-mahasiswa.index', compact('aktivitas'));
    }

    public function create()
    {
        $prodi = ProgramStudi::all();
        $semester = Semester::all();
        return view('master.aktivitas-mahasiswa.create', compact('prodi', 'semester'));
    }

    public function export()
    {
        return Excel::download(new AktivitasMahasiswaExport, 'aktivitas-mahasiswa.xlsx');
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_studi_id' => 'required',
            'semester_id' => 'required',
            'kode_aktivitas' => 'required',
            'jenis_aktivitas' => 'required',
            'judul' => 'required|max:255',
            'lokasi' => 'nullable',
            'jenis_anggota' => 'nullable',
            'nomor_sk_tugas' => 'nullable',
            'tanggal_sk_tugas' => 'nullable',
            'keterangan_aktivitas' => 'nullable',
            'tanggal_mulai' => 'nullable',
            'tanggal_selesai' => 'nullable',
        ]);

        AktivitasMahasiswa::create($request->all());

        return redirect()->route('aktivitas.index')->with('success', 'Aktivitas mahasiswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $aktivitas = AktivitasMahasiswa::findOrFail($id);
        $prodi = ProgramStudi::all();
        $semester = Semester::all();
        return view('master.aktivitas-mahasiswa.edit', compact('aktivitas', 'prodi', 'semester'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'program_studi_id' => 'required',
            'semester_id' => 'required',
            'kode_aktivitas' => 'required',
            'jenis_aktivitas' => 'required',
            'judul' => 'required|max:255',
            'lokasi' => 'nullable',
            'jenis_anggota' => 'nullable',
            'nomor_sk_tugas' => 'nullable',
            'tanggal_sk_tugas' => 'nullable',
            'keterangan_aktivitas' => 'nullable',
            'tanggal_mulai' => 'nullable',
            'tanggal_selesai' => 'nullable',
        ]);

        $aktivitas = AktivitasMahasiswa::findOrFail($id);
        $aktivitas->update($request->all());

        return redirect()->route('aktivitas.index')->with('success', 'Aktivitas mahasiswa berhasil diperbarui.');
    }

    public function show($id)
    {
        $aktivitas = AktivitasMahasiswa::findOrFail($id);
        return view('master.aktivitas-mahasiswa.show', compact('aktivitas'));
    }

    public function destroy($id)
    {
        $aktivitas = AktivitasMahasiswa::findOrFail($id);
        $aktivitas->delete();

        return redirect()->route('aktivitas.index')->with('success', 'Aktivitas mahasiswa berhasil dihapus.');
    }
}
