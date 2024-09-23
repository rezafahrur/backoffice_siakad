<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\SkalaNilai;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class SkalaNilaiController extends Controller
{
    public function index() {
        $skalaNilai = SkalaNilai::with(['semester', 'programStudi'])->get();
        return view('master.skala-nilai.index', compact('skalaNilai'));
    }

    public function create () {
        $semesters = Semester::all();
        $programStudis = ProgramStudi::all();
        return view('master.skala-nilai.create', compact('semesters', 'programStudis'));
    }

    public function store(Request $request) {
        // Tambahkan validasi
        $request->validate([
            'semester_id' => 'required',
            'program_studi_id' => 'required',
            'nilai_huruf' => 'required|alpha|size:1', // Memastikan input berupa huruf dan hanya satu karakter
            'nilai_indeks' => 'required|numeric',
            'bobot_minimum' => 'required|numeric',
            'bobot_maksimum' => 'required|numeric',
            'tgl_mulai_efektif' => 'required|date',
            'tgl_akhir_efektif' => 'required|date',
        ], [
            'nilai_huruf.size' => 'Nilai huruf harus berupa satu huruf.',
            'nilai_huruf.alpha' => 'Nilai huruf harus berupa huruf alfabet.',
        ]);
    
        try {
            // Simpan data
            SkalaNilai::create([
                'semester_id' => $request->semester_id,
                'program_studi_id' => $request->program_studi_id,
                'nilai_huruf' => $request->nilai_huruf,
                'nilai_indeks' => $request->nilai_indeks,
                'bobot_minimum' => $request->bobot_minimum,
                'bobot_maksimum' => $request->bobot_maksimum,
                'tgl_mulai_efektif' => $request->tgl_mulai_efektif,
                'tgl_akhir_efektif' => $request->tgl_akhir_efektif,
            ]);
    
            return redirect()->route('skala-nilai.index')->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->route('skala-nilai.index')->with('error', 'Data gagal disimpan');
        }
    }
    
    
    

    public function show ($id) {
        $skalaNilai = SkalaNilai::with('semester', 'programStudi')->find($id);
        return view('master.skala-nilai.show', compact('skalaNilai'));
    }

    public function edit ($id) {
        $semesters = Semester::all();
        $programStudis = ProgramStudi::all();
        $skalaNilai = SkalaNilai::find($id);
        return view('master.skala-nilai.edit', compact('semesters', 'programStudis', 'skalaNilai'));
    }

    public function update(Request $request, $id) {
        // Tambahkan validasi
        $request->validate([
            'semester_id' => 'required',
            'program_studi_id' => 'required',
            'nilai_huruf' => 'required|alpha|size:1', // Validasi agar hanya satu huruf
            'nilai_indeks' => 'required|numeric',
            'bobot_minimum' => 'required|numeric',
            'bobot_maksimum' => 'required|numeric',
            'tgl_mulai_efektif' => 'required|date',
            'tgl_akhir_efektif' => 'required|date',
        ], [
            'nilai_huruf.size' => 'Nilai huruf harus berupa satu huruf.',
            'nilai_huruf.alpha' => 'Nilai huruf harus berupa huruf alfabet.',
        ]);
    
        try {
            // Cari data SkalaNilai berdasarkan ID
            $skalaNilai = SkalaNilai::find($id);
    
            if (!$skalaNilai) {
                return redirect()->route('skala-nilai.index')->with('error', 'Data tidak ditemukan');
            }
    
            // Update data
            $skalaNilai->update([
                'semester_id' => $request->semester_id,
                'program_studi_id' => $request->program_studi_id,
                'nilai_huruf' => $request->nilai_huruf,
                'nilai_indeks' => $request->nilai_indeks,
                'bobot_minimum' => $request->bobot_minimum,
                'bobot_maksimum' => $request->bobot_maksimum,
                'tgl_mulai_efektif' => $request->tgl_mulai_efektif,
                'tgl_akhir_efektif' => $request->tgl_akhir_efektif,
            ]);
    
            return redirect()->route('skala-nilai.index')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->route('skala-nilai.index')->with('error', 'Data gagal diupdate');
        }
    }
    

    public function destroy ($id) {
        try {
            SkalaNilai::find($id)->delete();
            return redirect()->route('skala-nilai.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('skala-nilai.index')->with('error', 'Data gagal dihapus');
        }
    }


}
