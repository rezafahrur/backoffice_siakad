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
        // if($request->ajax()) {
        //     $program_studi = ProgramStudi::query();

        //     return DataTables::of($program_studi)
        //         ->addIndexColumn()
        //         ->addColumn('action', function($row) {
        //             $editBtn = '<a href="' . route('prodi.edit', $row->id) . '" class="btn icon btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>';
        //             $deleteBtn = '<form action="' . route('prodi.destroy', $row->id) . '" method="post" class="d-inline">
        //                               ' . csrf_field() . method_field('DELETE') . '
        //                               <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-sm btn-danger" title="Delete">
        //                                   <i class="bi bi-trash"></i>
        //                               </button>
        //                           </form>';
        //             $showBtn = '<a href="' . route('prodi.show', $row->id) . '" class="btn icon btn-sm btn-info" title="Show"><i class="bi bi-eye"></i></a>';
        //             return $editBtn . ' ' . $deleteBtn . ' ' . $showBtn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }

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
            'kode_program_studi' => 'required|max:3',
            'nama_program_studi' => 'required|max:40'
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
            'kode_program_studi' => 'required|max:3',
            'nama_program_studi' => 'required|max:40'
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
