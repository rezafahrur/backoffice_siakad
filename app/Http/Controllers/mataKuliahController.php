<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MataKuliahController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $matkul = MataKuliah::join('m_program_studi', 'm_program_studi.id', '=', 'm_matakuliah.program_studi_id')->select('m_matakuliah.*', 'm_program_studi.nama_program_studi')->get();

            return DataTables::of($matkul)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="' . route('mata-kuliah.edit', $row->id) . '" class="btn icon btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $deleteBtn = '<form action="' . route('mata-kuliah.destroy', $row->id) . '" method="post" class="d-inline">
                                      ' . csrf_field() . method_field('DELETE') . '
                                      <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-sm btn-danger" title="Delete">
                                          <i class="bi bi-trash"></i>
                                      </button>
                                  </form>';
                    // $showBtn = '<a href="' . route('mata-kuliah.show', $row->id) . '" class="btn icon btn-info" title="Show"><i class="bi bi-eye"></i></a>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('master.mata-kuliah.index');
    }

    //create
    public function create()
    {
        $matkul = ProgramStudi::get();
        return view('master.mata-kuliah.create', ['matkuls' => $matkul]);
    }

    //store
    public function store(Request $request)

    {
        $rulesData = [
            'program_studi_id' => 'required',
            'kode_matakuliah' => 'required',
            'nama_matakuliah' => 'required',
            'sks' => 'required',
        ];

        $validateData = $request->validate($rulesData);
        MataKuliah::create($validateData);

        return redirect()->route('mata-kuliah.index')->with('success', 'Mata Kuliah berhasil ditambahkan');
    }

    public function show($id)
    {
        $matkul = MataKuliah::join('m_program_studi', 'm_program_studi.id', '=', 'm_matakuliah.program_studi_id')->select('m_matakuliah.*', 'm_program_studi.nama_program_studi')->find($id);

        return view('master.mata-kuliah.detail', compact('matkul'));
    }

    //edit
    public function edit($id)
    {
        $matkul = MataKuliah::findOrFail($id);
        $programStudis = ProgramStudi::all();

        return view('master.mata-kuliah.edit', [
            'matkul' => $matkul,
            'programStudis' => $programStudis
        ]);
    }

    //update
    public function update(Request $request, $id)
    {
        $rulesData = [
            'program_studi_id' => 'required',
            'kode_matakuliah' => 'required',
            'nama_matakuliah' => 'required',
            'sks' => 'required',
        ];

        $validateData = $request->validate($rulesData);
        MataKuliah::find($id)->update($validateData);

        return redirect()->route('mata-kuliah.index')->with('success', 'Mata Kuliah berhasil diperbarui');
    }


    public function destroy(mataKuliah $matkul)
    {
        $matkul->delete();
        return redirect()->route('mata-kuliah.index')->with('success', 'Mata Kuliah berhasil dihapus');
    }
}
