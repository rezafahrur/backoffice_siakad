<?php

namespace App\Http\Controllers;

use App\Models\mataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class mataKuliahController extends Controller
{
    //
    public function index()
    {
        $data = mataKuliah::join('m_program_studi', 'm_program_studi.id', '=', 'm_matakuliah.program_studi_id')->select('m_matakuliah.*', 'm_program_studi.nama_program_studi')->get();
        $num = 1;
        return view('master.mataKuliah.index', ['datas' => $data, 'nums' => $num]);
    }

    //create
    public function create()
    {
        $matkul = ProgramStudi::get();
        return view('master.mataKuliah.create', ['matkuls' => $matkul]);
    }

    //store
    public function store(Request $request)
    
    {
        $request->validate([
            'program_studi_id' => 'required',
            'kode_matakuliah' => 'required',
            'nama_matakuliah' => 'required',
            'sks' => 'required',
        ]);

        mataKuliah::create($request->all());
        return redirect()->route('mataKuliah.index')->with('success', 'Mata Kuliah berhasil ditambahkan');
    }

    //edit
    public function edit($id)
    {
        $matkul = mataKuliah::findOrFail($id);
                $programStudis = ProgramStudi::all();
        
                return view('master.mataKuliah.edit', [
                    'matkul' => $matkul,
                    'programStudis' => $programStudis
                ]);
    }

    //update
    public function update(Request $request, $id)
    {
        $request->validate([
            'program_studi_id' => 'required',
            'kode_matakuliah' => 'required',
            'nama_matakuliah' => 'required',
            'sks' => 'required',
        ]);

        mataKuliah::find($id)->update($request->all());
        return redirect()->route('mataKuliah.index')->with('success', 'Mata Kuliah berhasil diperbarui');
    }


    public function destroy($id)
    {
        $data = mataKuliah::find($id);

        if ($data) {
            $data->delete();

            return redirect()->route('mataKuliah.index')->with(
                'success',
                'Data MataKuliah Berhasil Dihapus'
            );
        } else {
            return redirect()->route('mataKuliah.index')->with(
                'error',
                'Data MataKuliah Tidak Ditemukan'
            );
        }
    }

        //show
        public function show($id)
        {
            $matkul = mataKuliah::join('m_program_studi', 'm_program_studi.id', '=', 'm_matakuliah.program_studi_id')->select('m_matakuliah.*', 'm_program_studi.nama_program_studi')->find($id);

            return view('master.mataKuliah.detail', compact('matkul'));
        }
}
