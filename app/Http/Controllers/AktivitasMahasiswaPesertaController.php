<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktivitasMahasiswaPeserta;
use App\Models\AktivitasMahasiswa;
use App\Models\ProgramStudi;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Exports\AktivitasMahasiswaPesertaExport;
use Maatwebsite\Excel\Facades\Excel;

class AktivitasMahasiswaPesertaController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        // Mengambil data lengkap beserta relasinya
        $peserta = AktivitasMahasiswaPeserta::with(['aktivitasMahasiswa', 'programStudi', 'mahasiswa', 'matakuliah'])->get();
        return view('aktivitas-mahasiswa.aktivitas-peserta.index', compact('peserta'));
    }

    // Menampilkan form untuk menambah data baru
    public function create()
    {
        // Mengambil data untuk dropdown pilihan relasi
        $aktivitasMahasiswa = AktivitasMahasiswa::all();
        $programStudi = ProgramStudi::all();
        $mahasiswa = Mahasiswa::all();
        $matakuliah = Matakuliah::all();

        return view('aktivitas-mahasiswa.aktivitas-peserta.create', compact('aktivitasMahasiswa', 'programStudi', 'mahasiswa', 'matakuliah'));
    }

    public function export()
    {
        return Excel::download(new AktivitasMahasiswaPesertaExport, 'aktivitas-mahasiswa-peserta.xlsx');
    }

    // Menyimpan data baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'aktivitas_mahasiswa_id' => 'required|exists:m_aktivitas_mahasiswa,id',
            'program_studi_id' => 'required|exists:m_program_studi,id',
            'mahasiswa_id' => 'required|exists:m_mahasiswa,id',
            'matakuliah_id' => 'required',
            'sks' => 'required|integer|min:1|max:24',
            'jenis_peran' => 'required|string|max:255',
            'nilai_huruf' => 'required|regex:/^[A-Za-z]+$/|max:2', // Memastikan hanya huruf
            'nilai_indeks' => 'required|numeric',
            'nilai_angka' => 'required|numeric',
        ]);

        // Menyimpan data baru
        AktivitasMahasiswaPeserta::create($request->all());

        return redirect()->route('aktivitas-peserta.index')->with('success', 'Data berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit data
    public function edit($id)
    {
        $peserta = AktivitasMahasiswaPeserta::with('matakuliah')->findOrFail($id);
        $aktivitasMahasiswa = AktivitasMahasiswa::all();
        $programStudi = ProgramStudi::all();
        $mahasiswa = Mahasiswa::all();
        $matakuliah = Matakuliah::all();

        return view('aktivitas-mahasiswa.aktivitas-peserta.edit', compact('peserta', 'aktivitasMahasiswa', 'programStudi', 'mahasiswa', 'matakuliah'));
    }

    public function show($id)
    {
        $peserta = AktivitasMahasiswaPeserta::with(['aktivitasMahasiswa', 'mahasiswa', 'programStudi', 'matakuliah'])->findOrFail($id);
        return view('aktivitas-mahasiswa.aktivitas-peserta.show', compact('peserta'));
    }


    // Mengupdate data yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'aktivitas_mahasiswa_id' => 'required|exists:m_aktivitas_mahasiswa,id',
            'program_studi_id' => 'required|exists:m_program_studi,id',
            'mahasiswa_id' => 'required|exists:m_mahasiswa,id',
            'matakuliah_id' => 'required',
            'sks' => 'required|integer|min:1|max:24',
            'jenis_peran' => 'required|string|max:255',
            'nilai_huruf' => 'required|regex:/^[A-Za-z]+$/|max:2', // Memastikan hanya huruf
            'nilai_indeks' => 'required|numeric',
            'nilai_angka' => 'required|numeric',
        ]);

        // Mengupdate data
        $peserta = AktivitasMahasiswaPeserta::findOrFail($id);
        $peserta->update($request->all());

        return redirect()->route('aktivitas-peserta.index')->with('success', 'Data berhasil diupdate');
    }

    // Menghapus data
    public function destroy($id)
    {
        $peserta = AktivitasMahasiswaPeserta::findOrFail($id);
        $peserta->delete();

        return redirect()->route('aktivitas-peserta.index')->with('success', 'Data berhasil dihapus');
    }
}
