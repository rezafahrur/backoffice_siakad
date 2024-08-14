<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Requests\TahunAjaranRequest;

class TahunAjaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $tahunAjaran = TahunAjaran::when($search, function ($query, $search) {
            $query->where('tahun_ajaran', 'like', '%' . $search . '%');
        })
        ->paginate(10);

        return view('master.tahun-ajaran.index', compact('tahunAjaran'));
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


