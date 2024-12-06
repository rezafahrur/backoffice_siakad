<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\MataKuliah;
use App\Models\KelasDetail;
use App\Exports\NilaiExport;
use App\Imports\NilaiImport;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Requests\NilaiRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiKomponenEvaluasiExport;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nilais = Nilai::with(['programStudi', 'kelas', 'matakuliah'])->get();

        return view('perkuliahan.nilai.index', compact('nilais'));
    }

    //export
    public function export()
    {
        return Excel::download(new NilaiExport, 'nilai.xlsx');
    }

    //NilaiKomponenEvaluasiExport
    public function exportKomponenEvaluasi()
    {
        return Excel::download(new NilaiKomponenEvaluasiExport, 'nilai_komponen_evaluasi.xlsx');
    }

    public function downloadTemplate()
    {
        // file template di public/template/nilai.xlsx
        $filePath = public_path('templetes/templete_nilai.xlsx'); // Sesuaikan path sesuai folder Anda
        $fileName = 'template_nilai.xlsx';

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File template tidak ditemukan.');
        }

        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
                'program_studi_id' => 'required',
                'kelas_id' => 'required',
                'matakuliah_id' => 'required',
            ]);

            // Import Excel menggunakan class NilaiImport
            Excel::import(new NilaiImport($request->program_studi_id, $request->kelas_id, $request->matakuliah_id), $request->file('file'));

            return response()->json(['success' => true, 'message' => 'Data nilai berhasil diimport.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programStudi = ProgramStudi::all();
        // $kelas = Kelas::all();
        // $matakuliah = collect();
        return view('perkuliahan.nilai.create', compact('programStudi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NilaiRequest $request)
    {
        try {
            // Buat record nilai utama
            $nilai = Nilai::create($request->validated());

            // Loop melalui setiap detail nilai yang diinputkan
            foreach ($request->details as $detail) {
                // Simpan detail nilai ke database
                $nilai->details()->create($detail);
            }

            // Redirect ke halaman index nilai dengan pesan sukses
            return redirect()->route('nilai.index')->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            // Jika terjadi error, redirect kembali dengan input dan pesan error
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
        $nilai = Nilai::with(['programStudi', 'kelas', 'matakuliah', 'details'])->findOrFail($id);

        return view('perkuliahan.nilai.detail', compact('nilai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $nilai = Nilai::with(['programStudi', 'kelas', 'matakuliah', 'details'])->findOrFail($id);

        return view('perkuliahan.nilai.edit', compact('nilai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NilaiRequest $request, Nilai $nilai)
    {
        try {
            // Loop through the details and update only the relevant fields
            foreach ($request->details as $detail) {
                $nilai->details()->updateOrCreate(
                    ['mahasiswa_id' => $detail['mahasiswa_id']],
                    [
                        'hasil_proyek' => $detail['hasil_proyek'],
                        'aktivitas_partisipatif' => $detail['aktivitas_partisipatif'],
                        'quiz' => $detail['quiz'],
                        'tugas' => $detail['tugas'],
                        'uts' => $detail['uts'],
                        'uas' => $detail['uas'],
                        'nilai_angka' => $detail['nilai_angka'],
                        'nilai_huruf' => $detail['nilai_huruf'],
                        'nilai_indeks' => $detail['nilai_indeks'],
                    ]
                );
            }

            return redirect()->route('nilai.index')->with('success', 'Data berhasil diperbarui.');
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
    public function destroy(Nilai $nilai)
    {
        try {
            if ($nilai->details) {
                foreach ($nilai->details as $detail) {
                    $detail->delete();
                }
            }

            $nilai->delete();

            return redirect()->route('nilai.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error', $e->getMessage(),
                'toast_message' => 'Data Gagal Dihapus',
            ]);
        }
    }

    public function getKelasByProgramStudi($programStudiId)
    {
        // Ambil semua kelas berdasarkan program studi
        $kelas = Kelas::where('program_studi_id', $programStudiId)->get();

        return response()->json([
            'kelas' => $kelas,
        ]);
    }

    public function getMatakuliahByKelas($kelasId)
    {
        // Ambil ID mata kuliah yang sudah ada di tabel nilai
        $existingMatakuliahIds = Nilai::where('kelas_id', $kelasId)
            ->pluck('matakuliah_id')
            ->toArray();

        // Ambil data mata kuliah berdasarkan kelas melalui KelasDetail
        $matakuliah = KelasDetail::with('kurikulumDetail.matakuliah')
            ->where('kelas_id', $kelasId)
            ->whereHas('kurikulumDetail.matakuliah', function ($query) use ($existingMatakuliahIds) {
                $query->whereNotIn('id', $existingMatakuliahIds); // Hindari mata kuliah yang sudah ada di Nilai
            })
            ->get()
            ->pluck('kurikulumDetail.matakuliah')
            ->unique('id'); // Hindari duplikasi mata kuliah berdasarkan id

        return response()->json([
            'matakuliah' => $matakuliah,
        ]);
    }

    // public function getKelasMataKuliah($programStudiId)
    // {
    //     // Ambil semua kelas berdasarkan program studi
    //     $kelas = Kelas::where('program_studi_id', $programStudiId)->get();

    //     // Ambil ID mata kuliah yang sudah ada di tabel nilai
    //     $existingMatakuliahIds = Nilai::whereIn('kelas_id', $kelas->pluck('id'))
    //         ->pluck('matakuliah_id')
    //         ->toArray();

    //     // Ambil data mata kuliah berdasarkan kelas melalui KelasDetail
    //     $matakuliah = KelasDetail::with('kurikulumDetail.matakuliah')
    //         ->whereIn('kelas_id', $kelas->pluck('id'))
    //         ->whereHas('kurikulumDetail.matakuliah', function ($query) use ($existingMatakuliahIds) {
    //             $query->whereNotIn('id', $existingMatakuliahIds); // Hindari mata kuliah yang sudah ada di Nilai
    //         })
    //         ->get()
    //         ->pluck('kurikulumDetail.matakuliah')
    //         ->flatten()  // Mengubah hasilnya menjadi koleksi datar
    //         ->unique('id'); // Hindari duplikasi mata kuliah berdasarkan id

    //     return response()->json([
    //         'kelas' => $kelas,
    //         'matakuliah' => $matakuliah,
    //     ]);
    // }




    public function getMahasiswaByKelas($kelasId)
    {
        $mahasiswas = Krs::with('mahasiswa')->where('kelas_id', $kelasId)->get()->pluck('mahasiswa');
        return response()->json($mahasiswas);
    }
}
