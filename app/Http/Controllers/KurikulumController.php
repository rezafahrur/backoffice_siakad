<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Kurikulum;
use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\KurikulumDetail;
use Illuminate\Support\Facades\DB;

class KurikulumController extends Controller
{

    public function index()
    {
        $kurikulums = Kurikulum::with(['programStudi', 'semesters'])->get();

        return view('master.kurikulum.index', compact('kurikulums'));
    }

    public function create()
    {
        $semesters = Semester::all();
        $programStudis = ProgramStudi::all();
        $matakuliah = MataKuliah::all();
        return view('master.kurikulum.create', compact('semesters', 'programStudis', 'matakuliah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kurikulum' => 'required',
            'program_studi_id' => 'required',
            'semester' => 'required',
            'semester_angka' => 'required|integer|min:1|max:8',
            'sum_sks_lulus' => 'required|numeric',
            'sum_sks_wajib' => 'required|numeric',
            'sum_sks_pilihan' => 'required|numeric',
            'matakuliah_id' => 'required|array',
        ]);

        // Mengatur status data lama menjadi tidak aktif jika ditambah data baru yang aktif
        if ($request->status == 1) {
            Kurikulum::where('program_studi_id', $request->program_studi_id)
            ->where('semester_angka', $request->semester_angka)
            ->update(['status' => 0]);
        }

        // Save kurikulum baru dengan status aktif
        $kurikulum = Kurikulum::create(array_merge(
            $request->only('nama_kurikulum', 'program_studi_id', 'semester', 'semester_angka', 'sum_sks_lulus', 'sum_sks_wajib', 'sum_sks_pilihan'),
            ['status' => $request->status]
        ));

        // Save detail kurikulum
        foreach ($request->matakuliah_id as $matkulId) {
            KurikulumDetail::create([
                'kurikulum_id' => $kurikulum->id,
                'matakuliah_id' => $matkulId,
            ]);
        }

        return redirect()->route('kurikulum.index')->with('success', 'Kurikulum berhasil ditambahkan.');
    }


    public function show($id)
    {
        $kurikulum = Kurikulum::with(['programStudi', 'semesters', 'kurikulumDetails' => function ($query) {
            $query->whereNotNull('matakuliah_id');
        }, 'kurikulumDetails.matakuliah'])
            ->whereHas('kurikulumDetails', function ($query) {
                $query->whereNotNull('matakuliah_id');
            })
        ->findOrFail($id);
        return view('master.kurikulum.detail', compact('kurikulum'));
    }

    public function edit($id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $semesters = Semester::all();
        $programStudis = ProgramStudi::all();
        $matakuliah = MataKuliah::all();
        $matakuliahSelected = KurikulumDetail::where('kurikulum_id', $id)->pluck('matakuliah_id')->toArray();

        return view('master.kurikulum.edit', compact('kurikulum', 'semesters', 'programStudis', 'matakuliah', 'matakuliahSelected'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_kurikulum' => 'required',
                'program_studi_id' => 'required',
                'semester' => 'required',
                'semester_angka' => 'required|integer|min:1|max:8',
                'sum_sks_lulus' => 'required|numeric',
                'sum_sks_wajib' => 'required|numeric',
                'sum_sks_pilihan' => 'required|numeric',
                'matakuliah_id' => 'required|array',
            ]);

            $kurikulum = Kurikulum::findOrFail($id);

            // Mengatur status data lama menjadi tidak aktif jika data yang diupdate menjadi aktif
            if ($request->status == 1 && $kurikulum->status == 0) {
                Kurikulum::where('program_studi_id', $request->program_studi_id)
                ->where('semester_angka', $request->semester_angka)
                ->update(['status' => 0]);
            }

            // Update kurikulum
            $kurikulum->update(array_merge(
                $request->only('nama_kurikulum', 'program_studi_id', 'semester', 'semester_angka', 'sum_sks_lulus', 'sum_sks_wajib', 'sum_sks_pilihan'),
                ['status' => $request->status]
            ));

            // Delete detail kurikulum lama
            KurikulumDetail::where('kurikulum_id', $id)->update(['matakuliah_id' => null]);

            // Save detail kurikulum
            foreach ($request->matakuliah_id as $matkulId) {
                KurikulumDetail::updateOrcreate(
                    ['kurikulum_id' => $id, 'matakuliah_id' => null],
                    ['matakuliah_id' => $matkulId]
                );
            }
            return redirect()->route('kurikulum.index')->with('success', 'Kurikulum berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function destroy($id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $kurikulum->delete();
        return redirect()->route('kurikulum.index')->with('success', 'Kurikulum berhasil dihapus.');
    }

    public function getMatakuliah(Request $request, $programStudiId, $semester)
    {
        // Validasi nilai semester
        if (is_null($semester) || !is_numeric($semester)) {
            return response()->json(['message' => 'Invalid semester value'], 400);
        }

        try {
            $matkul = MataKuliah::where('program_studi_id', '=', $programStudiId)
                ->where(DB::raw('SUBSTRING(kode_matakuliah, 6, 1)'), '=', $semester)
                ->get(['id', 'kode_matakuliah', 'nama_matakuliah']);

            if ($matkul->isEmpty()) {
                return response()->json(['message' => 'Matakuliah not found'], 404);
            }

            return response()->json($matkul);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Method to get Mata Kuliah details and calculate SKS
    public function getMataKuliahDetails(Request $request)
    {
        // Validate if mataKuliahIds exist in the request
        $request->validate([
            'mataKuliahIds' => 'required|array'
        ]);

        $mataKuliahIds = $request->mataKuliahIds;

        // Fetch the Mata Kuliah details by IDs
        $mataKuliahDetails = MataKuliah::whereIn('id', $mataKuliahIds)->get();

        // Check if any Mata Kuliah found
        if ($mataKuliahDetails->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada detail Mata Kuliah yang ditemukan.'
            ], 404);
        }

        // Return Mata Kuliah details as JSON
        return response()->json($mataKuliahDetails);
    }
}
