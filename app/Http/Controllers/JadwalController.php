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
        // if($request->ajax()) {
        //     $jadwals = Jadwal::with(['paketMataKuliah:id,nama_paket_matakuliah'])->get();

        //     return DataTables::of($jadwals)
        //         ->addIndexColumn()
        //         ->addColumn('nama_paket_matakuliah', function($row) {
        //             return $row->paketMataKuliah ? $row->paketMataKuliah->nama_paket_matakuliah : 'N/A';
        //         })
        //         ->addColumn('action', function($row) {
        //             $user = auth()->user();

        //             $editBtn = '';
        //             $deleteBtn = '';
        //             $showBtn = '<a href="' . route('jadwal.show', $row->id) . '" class="btn icon btn-info btn-sm" title="Show"><i class="bi bi-eye"></i></a>';

        //             if ($user->can('update_jadwal')) {
        //                 $editBtn = '<a href="' . route('jadwal.edit', $row->id) . '" class="btn icon btn-warning btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></a>';
        //             }

        //             if ($user->can('delete_jadwal')) {
        //                 $deleteBtn = '<form action="' . route('jadwal.destroy', $row->id) . '" method="post" class="d-inline">
        //                                 ' . csrf_field() . method_field('DELETE') . '
        //                                 <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></button>
        //                               </form>';
        //             }

        //             return $showBtn . ' ' . $editBtn . ' ' . $deleteBtn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }

        $jadwals = Jadwal::with(['paketMataKuliah:id,nama_paket_matakuliah'])->get();

        return view('master.jadwal.index', compact('jadwals'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paketMataKuliahs = PaketMataKuliah::where('status', 1)
            ->whereDoesntHave('jadwal')
            ->get();
        return view('master.jadwal.create', compact('paketMataKuliahs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JadwalRequest $request)
    {
        try {
            $jadwal = Jadwal::create($request->validated());

            foreach ($request->details as $detail) {
                $jadwal->details()->create($detail);
            }

            return redirect()->route('jadwal.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'error' => $e->getMessage(),
                'toast_message' => 'Data Gagal Ditambahkan',
            ]);
        }
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
