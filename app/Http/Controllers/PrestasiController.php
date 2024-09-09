<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrestasiRequest;
use App\Models\Mahasiswa;
use App\Models\Prestasi;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PrestasiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $prestasi = Prestasi::with('mahasiswa', 'programStudi')->get();
            return DataTables::of($prestasi)
                ->addIndexColumn()
                ->addColumn('nama_mahasiswa', function ($row) {
                    return $row->mahasiswa ? $row->mahasiswa->nama : 'N/A';
                })
                ->addColumn('nim', function ($row) {
                    return $row->mahasiswa ? $row->mahasiswa->nim : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $showBtn = '<a href="' . route('prestasi.show', $row->id) . '" class="btn icon btn-sm btn-primary" title="Show"><i class="bi bi-eye"></i></a>';
                    $editBtn = '<a href="' . route('prestasi.edit', $row->id) . '" class="btn icon btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $deleteBtn = '<form action="' . route('prestasi.destroy', $row->id) . '" method="post" class="d-inline">
                                  ' . csrf_field() . method_field('DELETE') . '
                                  <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-sm btn-danger" title="Delete">
                                      <i class="bi bi-trash"></i>
                                  </button>';
                    return $showBtn . ' ' . $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.prestasi.index');
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        $programStudi = ProgramStudi::all();
        return view('master.prestasi.create')->with(compact('mahasiswa', 'programStudi'));
    }

    public function store(PrestasiRequest $request)
    {
        try {
            $data = $request->validated();

            Prestasi::create([
                'program_studi_id' => $data['program_studi_id'],
                'mahasiswa_id' => $data['mahasiswa_id'],
                'nama' => $data['nama_prestasi'],
                'jenis' => $data['jenis_prestasi'],
                'tingkat' => $data['tingkat_prestasi'],
                'tahun' => $data['tahun'],
                'penyelenggara' => $data['penyelenggara'],
                'peringkat' => $data['peringkat'],
                // 'bukti' => $data['bukti']->store('prestasi'),
            ]);
            return redirect()->route('prestasi.index')->with('success', 'Prestasi mahasiswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        // get mahasiswa with id from prestasi dan program studi
        $prestasi = Prestasi::findOrFail($id);
        $prestasi->load('mahasiswa', 'programStudi');
        return view('master.prestasi.show', compact('prestasi'));
    }

    public function edit(Prestasi $prestasi)
    {
        $mahasiswa = Mahasiswa::all();
        $programStudi = ProgramStudi::all();
        return view('master.prestasi.edit')->with(compact('prestasi', 'mahasiswa', 'programStudi'));
    }

    public function update(PrestasiRequest $request, Prestasi $prestasi)
    {
        try {
            $data = $request->validated();

            $prestasi->update([
                'program_studi_id' => $data['program_studi_id'],
                'mahasiswa_id' => $data['mahasiswa_id'],
                'nama' => $data['nama_prestasi'],
                'jenis' => $data['jenis_prestasi'],
                'tingkat' => $data['tingkat_prestasi'],
                'tahun' => $data['tahun'],
                'penyelenggara' => $data['penyelenggara'],
                'peringkat' => $data['peringkat'],
                // 'bukti' => $data['bukti']->store('prestasi'),
            ]);
            return redirect()->route('prestasi.index')->with('success', 'Prestasi mahasiswa berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Prestasi $prestasi)
    {
        $prestasi->delete();
        return redirect()->route('prestasi.index')->with('success', 'Prestasi mahasiswa berhasil dihapus.');
    }

    public function getMahasiswaByProdi(Request $request)
    {
        $mahasiswa = Mahasiswa::where('program_studi_id', $request->program_studi_id)->get();
        return response()->json($mahasiswa);
    }
}
