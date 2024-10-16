<?php

namespace App\Http\Controllers;

use App\Exports\EvaluasiPembelajaranExport;
use App\Exports\KelasExport;
use App\Exports\KelasExportDetail;
use App\Exports\MataKuliahExport;
use App\Http\Requests\KelasRequest;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Models\Semester;
use App\Models\Kurikulum;
use App\Models\HR;
use Maatwebsite\Excel\Facades\Excel;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $kelas = Kelas::with('programStudi', 'semester', 'kurikulum')->get();
        // dd($kelas);
        return view('perkuliahan.kelas.index', compact('kelas'));
    }

    public function exportEvaluasi()
    {
        return Excel::download(new EvaluasiPembelajaranExport, 'Evaluasi-Pembelajaran.xlsx');
    }

        public function exportDetail($id)
    {
        return Excel::download(new KelasExportDetail($id), 'kelas_detail.xlsx');
    }

    public function exportKelas()
    {
        return Excel::download(new KelasExport, 'kelas.xlsx');
    }

    //exportMatakuliah
    public function exportMatakuliah()
    {
        return Excel::download(new MataKuliahExport, 'matakuliah.xlsx');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programStudi = ProgramStudi::all();
        $semester = Semester::all();
        $kurikulum = Kurikulum::all();
        // get HR where role position_id = 6, which is dosen
        $dosen = HR::where('position_id', 6)->get();

        return view('perkuliahan.kelas.create', compact('programStudi', 'semester', 'kurikulum', 'dosen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KelasRequest $request)
    {
        try {

            $kelas = Kelas::create($request->validated());

            foreach ($request->details as $detail) {
                // dd($detail);
                $kelas->details()->create($detail);
            }

            return redirect()->route('kelas.index')->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'error' => $e->getMessage(),
                'toast_message' => 'Data Gagal Disimpan',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kelas = Kelas::with('programStudi', 'semester', 'kurikulum', 'details')->findOrFail($id);
        // dd($kelas);

        return view('perkuliahan.kelas.detail', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kelas = Kelas::with('details.kurikulumDetail.matakuliah')->findOrFail($id);
        $programStudi = ProgramStudi::all();
        $semester = Semester::all();
        $kurikulum = Kurikulum::all();
        $dosen = HR::where('position_id', 6)->get(); // Dosen

        return view('perkuliahan.kelas.edit', compact('kelas', 'programStudi', 'semester', 'kurikulum', 'dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KelasRequest $request, Kelas $kelas)
    {
        try {
            $kelas->update($request->validated());

            $kelas->details()->delete();

            foreach ($request->details as $detail) {
                $kelas->details()->create($detail);
            }

            return redirect()->route('kelas.index')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'error' => $e->getMessage(),
                'toast_message' => 'Data Gagal Diperbarui',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        try {
            if ($kelas->details) {
                foreach ($kelas->details as $detail) {
                    $detail->delete();
                }
            }

            $kelas->delete();

            return redirect()->route('kelas.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => $e->getMessage(),
                'toast_message' => 'Data Gagal Dihapus',
            ]);
        }
    }

    // get kurikulum details
    public function getKurikulumDetails($kurikulumId)
    {
        // get kurikulum details dengan mata kuliah nya
        $kurikulum = Kurikulum::with('kurikulumDetails.matakuliah')->findOrFail($kurikulumId);

        // filter out any kurikulum details without a related mata kuliah
        $filteredDetails = $kurikulum->kurikulumDetails->filter(fn($detail) => $detail->matakuliah !== null);

        $dosen = HR::where('position_id', 6)->get(); // Dosen


        return response()->json([
            'details' => $filteredDetails,
            'dosen' => $dosen,
        ]);
    }
}
