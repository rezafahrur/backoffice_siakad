<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Requests\TahunAjaranRequest;
use Yajra\DataTables\Facades\DataTables;

class TahunAjaranController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tahunAjaran = TahunAjaran::query();

            return DataTables::of($tahunAjaran)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $editBtn = '<a href="' . route('tahun-ajaran.edit', $row->id) . '" class="btn icon btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $deleteBtn = '<form action="' . route('tahun-ajaran.destroy', $row->id) . '" method="post" class="d-inline">
                                      ' . csrf_field() . method_field('DELETE') . '
                                      <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-danger" title="Delete">
                                          <i class="bi bi-trash"></i>
                                      </button>
                                  </form>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action']) // Ensures that HTML code for the action buttons is rendered correctly
                ->make(true);
        }

        return view('master.tahun-ajaran.index');
    }

    public function create()
    {
        return view('master.tahun-ajaran.create');
    }

    public function store(TahunAjaranRequest $request)
    {
        $validateData = $request->validated();

        TahunAjaran::create($validateData);

        return redirect()->route('tahun-ajaran.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $tahunAjaran = TahunAjaran::find($id);
        return view('master.tahun-ajaran.detail', compact('tahunAjaran'));
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('master.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    public function update(TahunAjaranRequest $request, TahunAjaran $tahunAjaran)
    {
        $validateData = $request->validated();

        $tahunAjaran->update($validateData);

        return redirect()->route('tahun-ajaran.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();

        return redirect()->route('tahun-ajaran.index')->with('success', 'Data berhasil dihapus');
    }
}


