<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProgramStudiController extends Controller
{
    //index
    public function index(Request $request)
    {
        $prodi = ProgramStudi::all();

        return view('master.prodi.index', compact('prodi'));
    }


    //create
    public function create()
    {
        return view('master.prodi.create');
    }

    //store
    public function store(Request $request)
    {
        $rulesData = [
            'kode_program_studi' => 'required|max:5',
            'kode_prodi' => 'nullable',
            'nama_program_studi' => 'required|max:40',
            'nama_singkat' => 'nullable'
        ];

        $validateData = $request->validate($rulesData);

        ProgramStudi::create($validateData);

        return redirect()->route('prodi.index')->with('success', 'Program Studi berhasil ditambahkan');
    }

    //show
    public function show($id)
    {
        $prodi = ProgramStudi::find($id);
        return view('master.prodi.show', compact('prodi'));
    }

    //edit
    public function edit(ProgramStudi $prodi)
    {
        return view('master.prodi.edit', compact('prodi'));
    }

    //update
    public function update(Request $request, ProgramStudi $prodi)
    {
        $rulesData = [
            'kode_program_studi' => 'required|max:5',
            'kode_prodi' => 'nullable',
            'nama_program_studi' => 'required|max:40',
            'nama_singkat' => 'nullable'
        ];

        $validateData = $request->validate($rulesData);

        $prodi->update($validateData);

        return redirect()->route('prodi.index')->with('success', 'Program Studi berhasil diupdate');
    }

    //destroy
    public function destroy(ProgramStudi $prodi)
    {
        $prodi->delete();
        return redirect()->route('prodi.index')->with('success', 'Program Studi berhasil dihapus');
    }
}
