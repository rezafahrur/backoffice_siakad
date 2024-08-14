<?php

namespace App\Http\Controllers;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramStudiController extends Controller
{
    //index
    public function index(Request $request)
{
    $program_studi = ProgramStudi::paginate(5); 
    return view('master.prodi.index', compact('program_studi'));
}


    //create
    public function create()
    {
        return redirect()->route('prodi.index')->with('success', 'Program Studi berhasil ditambahkan');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'kode_program_studi' => 'required',
            'nama_program_studi' => 'required'
        ]);

        ProgramStudi::create($request->all());
        return redirect()->route('prodi.index')->with('success', 'Program Studi berhasil ditambahkan');
    }

    //edit
    public function edit($id)
    {
        $program_studi = ProgramStudi::find($id);
        return view('master.prodi.edit', compact('program_studi'));
    }

    //update
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_program_studi' => 'required',
            'nama_program_studi' => 'required'
        ]);

        ProgramStudi::find($id)->update($request->all());
        return redirect()->route('prodi.index')->with('success', 'Program Studi berhasil diupdate');
    }

    //destroy
    public function destroy($id)
    {
        ProgramStudi::find($id)->delete();
        return redirect()->route('prodi.index')->with('success', 'Program Studi berhasil dihapus');
    }

    //show
    public function show($id)
    {
        $program_studi = ProgramStudi::find($id);
        return view('master.prodi.show', compact('program_studi'));
    }
}
