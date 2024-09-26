<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Requests\NilaiRequest;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nilais = Nilai::with(['programStudi', 'kelas', 'matakuliah'])->get();

        return view('master.nilai.index', compact('nilais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programStudi = ProgramStudi::all();
        // $kelas = Kelas::all();
        // $matakuliah = collect();
        return view('master.nilai.create', compact('programStudi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NilaiRequest $request)
    {
        try {
            $nilai = Nilai::create($request->validated());

            foreach ($request->details as $detail) {
                $nilai->details()->create($detail);
            }
            return redirect()->route('nilai.index')->with('success', 'Data berhasil disimpan');
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
        $nilai = Nilai::with(['programStudi', 'kelas', 'matakuliah', 'details'])->findOrFail($id);

        return view('master.nilai.detail', compact('nilai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $nilai = Nilai::with(['programStudi', 'kelas', 'matakuliah', 'details'])->findOrFail($id);

        return view('master.nilai.edit', compact('nilai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NilaiRequest $request, Nilai $nilai)
    {
        // dd($request->all());
        try {
            $nilai->update($request->validated());

            // update or create nilai detail
            foreach ($request->details as $detail) {
                $nilai->details()->updateOrCreate(
                    ['mahasiswa_id' => $detail['mahasiswa_id']],
                    $detail
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

    public function getKelasMataKuliah($programStudiId)
    {
        $kelas = Kelas::where('program_studi_id', $programStudiId)->get();

        // get matakuliah from kelas details to kurikulum details to matakuliah
        $matakuliah = collect();
        foreach ($kelas as $k) {
            $matakuliah = $matakuliah->merge($k->details->pluck('kurikulumDetail.matakuliah'));
        }

        // remove duplicate matakuliah
        $matakuliah = $matakuliah->unique('id');

        return response()->json([
            'kelas' => $kelas,
            'matakuliah' => $matakuliah
        ]);
    }

    public function getMahasiswaByKelas($kelasId)
    {
        $mahasiswas = Krs::with('mahasiswa')->where('kelas_id', $kelasId)->get()->pluck('mahasiswa');
        return response()->json($mahasiswas);
    }
}
