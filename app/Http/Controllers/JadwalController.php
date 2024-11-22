<?php

namespace App\Http\Controllers;

use App\Models\HR;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\Semester;
use App\Models\MataKuliah;
use App\Models\RuangKelas;
use App\Models\JadwalDetail;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\PaketMataKuliah;
use App\Models\RuangKelasDetail;
use App\Http\Requests\JadwalRequest;
use Yajra\DataTables\Facades\DataTables;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jadwal = Jadwal::get()->all();

        return view('perkuliahan.jadwal.index', compact('jadwal'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programStudi = ProgramStudi::all();
        $ruangKelas = RuangKelas::all();
        return view('perkuliahan.jadwal.create', compact('programStudi', 'ruangKelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getKelasByProdi($programStudiId)
    {
        $kelas = Kelas::where('program_studi_id', $programStudiId)->get();
        return response()->json($kelas);
    }

    public function getMataKuliah($kelasId)
    {
        $mataKuliah = MataKuliah::where('kelas_id', $kelasId)->get();
        return response()->json($mataKuliah);
    }

    public function getRuangKelasDetails($matkulId)
    {
        $ruangKelasDetails = RuangKelasDetail::where('is_available', true)->get();
        return response()->json($ruangKelasDetails);
    }

    public function store(Request $request)
    {
        $jadwal = Jadwal::create([
            'program_studi_id' => $request->program_studi,
            'kelas_id' => $request->kelas,
        ]);

        foreach ($request->details as $detail) {
            JadwalDetail::create([
                'jadwal_id' => $jadwal->id,
                'ruang_kelas_id' => $detail['ruang_kelas_id'],
                'ruang_kelas_detail_id' => $detail['ruang_kelas_detail_id'],
                'matkul_id' => $request->mata_kuliah,
                'jam_mulai' => $detail['jam_mulai'],
                'jam_selesai' => $detail['jam_selesai'],
            ]);
        }

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // mengambil data jadwal sama details nya, order by jadwal_hari dan jadwal_jam_mulai dari details
        $jadwal = Jadwal::with(['details' => function($query) {
            $query->orderBy('jadwal_hari')->orderBy('jadwal_jam_mulai');
        }])->findOrFail($id);
        return view('perkuliahan.jadwal.detail', compact('jadwal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // JadwalController.php
    public function edit($id)
    {
        $jadwal = Jadwal::with('details.paketMataKuliahDetail.matakuliah')->findOrFail($id);
        $paketMataKuliahs = PaketMataKuliah::where('status', 1)->get();
        $ruangKelas = RuangKelas::all();
        $hrs = Hr::all();

        return view('perkuliahan.jadwal.edit', compact('jadwal', 'paketMataKuliahs', 'ruangKelas', 'hrs'));
    }

    public function update(JadwalRequest $request, Jadwal $jadwal)
    {
        $jadwal->update($request->validated());

        // Delete existing details and add the updated ones
        $jadwal->details()->delete();

        foreach ($request->details as $detail) {
            $jadwal->details()->create($detail);
        }

        return redirect()->route('jadwal.index')->with('success', 'Data berhasil diubah');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        try {
            if ($jadwal->details) {
                foreach ($jadwal->details as $detail) {
                    $detail->delete();
                }
            }

            $jadwal->delete();

            return redirect()->route('jadwal.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('jadwal.index')->with('error', 'Data gagal dihapus');
        }
    }

    public function getPaketDetails($paketMataKuliahId)
    {
        $paketDetails = PaketMataKuliah::with('paketMataKuliahDetail.matakuliah')->find($paketMataKuliahId);
        $ruangKelas = RuangKelas::all();
        $hrs = Hr::all();

        // Filter out any paket details without a related matakuliah
        $filteredDetails = $paketDetails->paketMataKuliahDetail->filter(fn($detail) => $detail->matakuliah !== null);

        return response()->json([
            'details' => $filteredDetails,
            'ruangKelas' => $ruangKelas,
            'hrs' => $hrs
        ]);
    }
}
