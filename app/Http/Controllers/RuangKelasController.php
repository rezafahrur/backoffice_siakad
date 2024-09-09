<?php

namespace App\Http\Controllers;

use App\Models\RuangKelas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RuangKelasController extends Controller
{

    public function index(Request $request)
    {
        $kelas = RuangKelas::all();

        return view('master.ruang-kelas.index', compact('kelas'));
    }


    public function create()
    {
        return view('master.ruang-kelas.create');
    }

    public function store(Request $request)
    {
        $ruleData = [
            'kode_ruang_kelas' => 'required|unique:m_ruang_kelas,kode_ruang_kelas|max:10',
            'nama_ruang_kelas' => 'required|unique:m_ruang_kelas,nama_ruang_kelas|max:30',
            'kapasitas' => 'required|numeric',
        ];

        $validateData = $request->validate($ruleData);

        RuangKelas::create($validateData);

        return redirect()->route('kelas.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $ruangKelas = RuangKelas::find($id);
        return view('master.ruang-kelas.detail', compact('ruangKelas'));
    }

    public function edit(RuangKelas $kelas)
    {
        return view('master.ruang-kelas.edit', compact('kelas'));
    }

    public function update(Request $request, RuangKelas $kelas)
    {
        $ruleData = [
            'kode_ruang_kelas' => 'required|max:10|unique:m_ruang_kelas,kode_ruang_kelas,' . $kelas->id,
            'nama_ruang_kelas' => 'required|max:30|unique:m_ruang_kelas,nama_ruang_kelas,' . $kelas->id,
            'kapasitas' => 'required|numeric',
        ];

        $validateData = $request->validate($ruleData);

        $kelas->update($validateData);

        return redirect()->route('kelas.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy(RuangKelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Data berhasil dihapus');
    }
}
