<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktivitasMahasiswaPeserta;
use App\Models\AktivitasMahasiswa;
use App\Models\ProgramStudi;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;

class AktivitasMahasiswaPesertaController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        // Mengambil data lengkap beserta relasinya
        $peserta = AktivitasMahasiswaPeserta::with(['aktivitasMahasiswa', 'programStudi', 'mahasiswa', 'matakuliah'])->get();
        return view('master.aktivitas-peserta.index', compact('peserta'));
    }

    // Menampilkan form untuk menambah data baru
    public function create()
    {
        // Mengambil data untuk dropdown pilihan relasi
        $aktivitasMahasiswa = AktivitasMahasiswa::all();
        $programStudi = ProgramStudi::all();
        $mahasiswa = Mahasiswa::all();
        $matakuliah = Matakuliah::all();

        return view('master.aktivitas-peserta.create', compact('aktivitasMahasiswa', 'programStudi', 'mahasiswa', 'matakuliah'));
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
            'nilai_huruf' => 'required|string|max:2',
            'nilai_indeks' => 'required|numeric',
            'nilai_angka' => 'required|numeric',
        ]);

        // Menyimpan data baru
        AktivitasMahasiswaPeserta::create($request->all());

        return redirect()->route('master.aktivitas-peserta.index')->with('success', 'Data berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit data
    public function edit($id)
    {
        $peserta = AktivitasMahasiswaPeserta::with('matakuliah')->findOrFail($id);
        $aktivitasMahasiswa = AktivitasMahasiswa::all();
        $programStudi = ProgramStudi::all();
        $mahasiswa = Mahasiswa::all();
        $matakuliah = Matakuliah::all();

        return view('master.aktivitas-peserta.edit', compact('peserta', 'aktivitasMahasiswa', 'programStudi', 'mahasiswa', 'matakuliah'));
    }

    public function show($id)
    {
        $peserta = AktivitasMahasiswaPeserta::with(['aktivitasMahasiswa', 'mahasiswa', 'programStudi', 'matakuliah'])->findOrFail($id);
        return view('master.aktivitas-peserta.show', compact('peserta'));
    }


    // Mengupdate data yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'aktivitas_mahasiswa_id' => 'required|exists:aktivitas_mahasiswa,id',
            'program_studi_id' => 'required|exists:program_studi,id',
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'matakuliah_id' => 'required|array',
            'matakuliah_id.*' => 'exists:m_matakuliah,id',
            'sks' => 'required|integer|min:1|max:24',
            'jenis_peran' => 'required|string|max:255',
            'nilai_huruf' => 'required|string|max:2',
            'nilai_indeks' => 'required|numeric',
            'nilai_angka' => 'required|numeric',
        ]);

        // Mengupdate data
        $peserta = AktivitasMahasiswaPeserta::findOrFail($id);
        $peserta->update($request->except('matakuliah_id'));

        // Update hubungan dengan matakuliah
        $peserta->matakuliah()->sync($request->matakuliah_id);

        return redirect()->route('master.aktivitas-peserta.index')->with('success', 'Data berhasil diupdate');
    }

    // Menghapus data
    public function destroy($id)
    {
        $peserta = AktivitasMahasiswaPeserta::findOrFail($id);

        // Hapus hubungan dengan matakuliah sebelum menghapus
        $peserta->matakuliah()->detach();

        // Hapus data peserta
        $peserta->delete();

        return redirect()->route('aktivitas-peserta.index')->with('success', 'Data berhasil dihapus');
    }
}
