<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kurikulum;
use App\Models\ProgramStudi;
use App\Models\Semester;

class KurikulumController extends Controller
{

    public function index()
    {
        $kurikulums = Kurikulum::with(['programStudi', 'semester'])->get();

        return view('master.kurikulum.index', compact('kurikulums'));
    }

    public function create()
    {
        $semesters = Semester::all();
        $programStudis = ProgramStudi::all();
        return view('master.kurikulum.create', compact('semesters', 'programStudis'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kurikulum' => 'required',
            'semester' => 'required',
            'sum_sks_lulus' => 'required|numeric',
            'sum_sks_wajib' => 'required|numeric',
            'sum_sks_pilihan' => 'required|numeric',
            'kode_prodi' => 'required',
        ]);

        Kurikulum::create($validatedData);
        return redirect()->route('kurikulum.index')->with('success', 'Kurikulum berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kurikulum = Kurikulum::with(['programStudi', 'semester'])->findOrFail($id);
        return view('master.kurikulum.detail', compact('kurikulum'));
    }

    public function edit($id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $semesters = Semester::all();
        $programStudis = ProgramStudi::all();
        return view('master.kurikulum.edit', compact('kurikulum', 'semesters', 'programStudis'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_kurikulum' => 'required',
            'semester' => 'required',
            'sum_sks_lulus' => 'required|numeric',
            'sum_sks_wajib' => 'required|numeric',
            'sum_sks_pilihan' => 'required|numeric',
            'kode_prodi' => 'required',
        ]);

        $kurikulum = Kurikulum::findOrFail($id);
        $kurikulum->update($validatedData);
        return redirect()->route('kurikulum.index')->with('success', 'Kurikulum berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        $kurikulum->delete();
        return redirect()->route('kurikulum.index')->with('success', 'Kurikulum berhasil dihapus.');
    }

}
