<?php

namespace App\Http\Controllers;

use App\Models\RuangKelas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RuangKelasController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kelas = RuangKelas::query();

            return DataTables::of($kelas)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $editBtn = '<a href="' . route('kelas.edit', $row->id) . '" class="btn icon btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $deleteBtn = '<form action="' . route('kelas.destroy', $row->id) . '" method="post" class="d-inline">
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

        return view('master.ruang-kelas.index');

        // $search = $request->input('search');

        // $kelas = RuangKelas::when($search, function ($query, $search) {
        //     $query->where('kode_ruang_kelas', 'like', '%' . $search . '%')
        //         ->orWhere('nama_ruang_kelas', 'like', '%' . $search . '%');
        // })
        // ->paginate(3);

        // return view('master.ruang-kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('master.ruang-kelas.create');
    }

    public function store(Request $request)
    {
        $ruleData = [
            'kode_ruang_kelas' => 'required',
            'nama_ruang_kelas' => 'required',
            'kapasitas' => 'required',
        ];

        $validateData = $request->validate($ruleData);

        RuangKelas::create($validateData);

        return redirect()->route('kelas.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $ruangKelas = RuangKelas::find($id);
        return view('master.ruang-kelas.detail', compact('ruangKelas'));
    //     return view(RuangKelasController::KELAS_VIEW['detail'], [
    //         'title' => 'Detail Ruang Kelas',
    //         'kelas' => $ruangKelas,
    //         'kelas_route' => RuangKelasController::KELAS_ROUTE,
    //     ]);
    }

    public function edit(RuangKelas $kelas)
    {
        return view('master.ruang-kelas.edit', compact('kelas'));
        // $kelas = RuangKelas::find($id);
        // return view('master.ruang-kelas.edit', compact('kelas'));
        // return view(RuangKelasController::KELAS_VIEW['edit'], [
        //     'title' => 'Edit Ruang Kelas',
        //     'kelas' => $kelas,
        //     'kelas_route' => RuangKelasController::KELAS_ROUTE,
        // ]);
    }

    public function update(Request $request, RuangKelas $kelas)
    {
        $ruleData = [
            'kode_ruang_kelas' => 'required',
            'nama_ruang_kelas' => 'required',
            'kapasitas' => 'required',
        ];

        $validateData = $request->validate($ruleData);

        $kelas->update($validateData);

        return redirect()->route('kelas.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy(RuangKelas $kelas)
    {
        // $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Data berhasil dihapus');
    }
}
