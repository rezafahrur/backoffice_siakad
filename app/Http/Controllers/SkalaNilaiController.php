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
        try {
            $data = $request->all();
    
            // Pastikan kolom deleted_at tidak diset secara manual saat penyimpanan
            SkalaNilai::create([
                'semester_id' => $data['semester_id'],
                'program_studi_id' => $data['program_studi_id'],
                'nilai_huruf' => $data['nilai_huruf'],
                'nilai_indeks' => $data['nilai_indeks'],
                'bobot_minimum' => $data['bobot_minimum'],
                'bobot_maksimum' => $data['bobot_maksimum'],
                'tgl_mulai_efektif' => $data['tgl_mulai_efektif'],
                'tgl_akhir_efektif' => $data['tgl_akhir_efektif'],
                // Pastikan deleted_at tetap null saat penyimpanan
                'deleted_at' => null,
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

    public function update (Request $request, $id) {
        try {
            $data = $request->all();

            SkalaNilai::find($id)->update([
                'semester_id' => $data['semester_id'],
                'program_studi_id' => $data['program_studi_id'],
                'nilai_huruf' => $data['nilai_huruf'],
                'nilai_indeks' => $data['nilai_indeks'],
                'bobot_minimum' => $data['bobot_minimum'],
                'bobot_maksimum' => $data['bobot_maksimum'],
                'tgl_mulai_efektif' => $data['tgl_mulai_efektif'],
                'tgl_akhir_efektif' => $data['tgl_akhir_efektif'],
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
