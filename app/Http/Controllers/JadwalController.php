<?php

namespace App\Http\Controllers;

use App\Http\Requests\JadwalRequest;
use App\Models\HR;
use App\Models\Jadwal;
use App\Models\RuangKelas;
use App\Models\PaketMataKuliah;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $jadwals = Jadwal::with(['paketMataKuliah:id,nama_paket_matakuliah'])->get();

            return DataTables::of($jadwals)
                ->addIndexColumn()
                ->addColumn('nama_paket_matakuliah', function($row) {
                    return $row->paketMataKuliah ? $row->paketMataKuliah->nama_paket_matakuliah : 'N/A';
                })
                ->addColumn('action', function($row) {
                    $editBtn = '<a href="' . route('jadwal.edit', $row->id) . '" class="btn icon btn-warning btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $deleteBtn = '<form action="' . route('jadwal.destroy', $row->id) . '" method="post" class="d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>';
                    $showBtn = '<a href="' . route('jadwal.show', $row->id) . '" class="btn icon btn-info btn-sm" title="Show"><i class="bi bi-eye"></i></a>';
                    return $showBtn . ' ' . $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('master.jadwal.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paketMataKuliahs = PaketMataKuliah::where('status', 1)->get();
        return view('master.jadwal.create', compact('paketMataKuliahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JadwalRequest $request)
    {
        $jadwal = Jadwal::create($request->validated());

        foreach ($request->details as $detail) {
            $jadwal->details()->create($detail);
        }

        return redirect()->route('jadwal.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // mengambil data jadwal sama details nya
        $jadwal = Jadwal::with('details.paketMataKuliahDetail.matakuliah')->findOrFail($id);
        return view('master.jadwal.detail', compact('jadwal'));
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

        return view('master.jadwal.edit', compact('jadwal', 'paketMataKuliahs', 'ruangKelas', 'hrs'));
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
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Data berhasil dihapus');
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
