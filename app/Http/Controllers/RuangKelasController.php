<?php

namespace App\Http\Controllers;

use App\Models\RuangKelas;
use App\Models\RuangKelasDetail;
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
            'kode_ruang_kelas' => 'required|max:10',
            'nama_ruang_kelas' => 'required|max:30',
            'kapasitas' => 'required|numeric',
        ];

        $validateData = $request->validate($ruleData);

        $ruangKelas = RuangKelas::create($validateData);

        if ($request->has('schedules')) {
            foreach ($request->schedules as $hari => $jadwalHari) {
                foreach ($jadwalHari as $jamAwal => $detail) {
                    RuangKelasDetail::create([
                        'ruang_kelas_id' => $ruangKelas->id,
                        'hari' => $hari,
                        'jam_awal' => $detail['jam_awal'],
                        'jam_akhir' => $detail['jam_akhir'],
                        'is_available' => '1',
                    ]);
                }
            }
        }

        return redirect()->route('ruang-kelas.index')->with('success', 'Ruang Kelas berhasil ditambahkan');
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
            'kode_ruang_kelas' => 'required|max:10',
            'nama_ruang_kelas' => 'required|max:30',
            'kapasitas' => 'required|numeric',
        ];

        $validateData = $request->validate($ruleData);

        $kelas->update($validateData);

        return redirect()->route('ruang-kelas.index')->with('success', 'Ruang Kelas berhasil diubah');
    }

    public function destroy(RuangKelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('ruang-kelas.index')->with('success', 'Ruang Kelas berhasil dihapus');
    }
}
