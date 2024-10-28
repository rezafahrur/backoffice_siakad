<?php

namespace App\Http\Controllers;

use App\Models\PeriodePerkuliahan;
use App\Models\Semester;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PeriodePerkuliahanController extends Controller
{
    // Menampilkan daftar periode perkuliahan
    public function index(Request $request)
    {
        $periodePerkuliahans = PeriodePerkuliahan::all();

        return view('perkuliahan.periode-perkuliahan.index', compact('periodePerkuliahans'));
    }

    // Menampilkan form untuk membuat periode perkuliahan baru
    public function create()
    {
        $programStudi = ProgramStudi::all();
        $semesters = Semester::all();
        return view('perkuliahan.periode-perkuliahan.create', compact('programStudi', 'semesters'));
    }

    // Menyimpan periode perkuliahan baru ke dalam database
    public function store(Request $request)
    {
        try {

            $rulesData = [
                'semester_id' => 'required',
                'program_studi_id' => 'required',
                'tanggal_awal_kuliah' => 'required|date',
                'tanggal_akhir_kuliah' => 'required|date',
                'jml_target_mhs_baru' => 'required|integer',
                'jml_pendaftar_ikut_seleksi' => 'required|integer',
                'jml_pendaftar_lulus_seleksi' => 'required|integer',
                'jml_daftar_ulang' => 'required|integer',
                'jml_mengundurkan_diri' => 'required|integer',
                'jml_minggu_pertemuan' => 'required|integer',
            ];

            $validateData = $request->validate($rulesData);
            PeriodePerkuliahan::create($validateData);

            return redirect()->route('periode-perkuliahan.index')->with('success', 'Periode Perkuliahan berhasil ditambahkan.');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect()->route('periode-perkuliahan.index')->with('error', $message);
        }
    }

    // Menampilkan form untuk mengedit periode perkuliahan
    public function edit($id)
    {
        $periodePerkuliahan = PeriodePerkuliahan::findOrFail($id);
        $programStudi = ProgramStudi::all();
        $semesters = Semester::all();
        return view('perkuliahan.periode-perkuliahan.edit', compact('periodePerkuliahan', 'programStudi', 'semesters'));
    }

    // Memperbarui periode perkuliahan di dalam database
    public function update(Request $request, $id)
    {
        try {

            $rulesData = [
                'semester_id' => 'required',
                'program_studi_id' => 'required',
                'tanggal_awal_kuliah' => 'required|date',
                'tanggal_akhir_kuliah' => 'required|date',
                'jml_target_mhs_baru' => 'required|integer',
                'jml_pendaftar_ikut_seleksi' => 'required|integer',
                'jml_pendaftar_lulus_seleksi' => 'required|integer',
                'jml_daftar_ulang' => 'required|integer',
                'jml_mengundurkan_diri' => 'required|integer',
                'jml_minggu_pertemuan' => 'required|integer',
            ];

            $validateData = $request->validate($rulesData);

            $periodePerkuliahan = PeriodePerkuliahan::findOrFail($id);
            $periodePerkuliahan->update($validateData);

            return redirect()->route('periode-perkuliahan.index')->with('success', 'Periode Perkuliahan berhasil diubah.');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect()->route('periode-perkuliahan.index')->with('error', $message);
        }
    }

    // Menampilkan detail periode perkuliahan
    public function show($id)
    {
        $periodePerkuliahan = PeriodePerkuliahan::with('semester', 'programStudi')->findOrFail($id);
        return view('perkuliahan.periode-perkuliahan.show', compact('periodePerkuliahan'));
    }

    // Menghapus periode perkuliahan dari database
    public function destroy($id)
    {
        $periodePerkuliahan = PeriodePerkuliahan::findOrFail($id);
        $periodePerkuliahan->delete();

        return redirect()->route('periode-perkuliahan.index')->with('success', 'Periode Perkuliahan berhasil dihapus.');
    }

    public function chartData()
    {
        $data = PeriodePerkuliahan::with('semester', 'programStudi')
            ->select('semester_id', 'program_studi_id', 'jml_target_mhs_baru')
            ->get();

        $formattedData = $data->map(function ($item) {
            return [
                'semester' => $item->semester->nama_semester,
                'program_studi' => $item->programStudi->nama_program_studi,
                'jml_target_mhs_baru' => $item->jml_target_mhs_baru,
            ];
        });

        return response()->json($formattedData);
    }
}
