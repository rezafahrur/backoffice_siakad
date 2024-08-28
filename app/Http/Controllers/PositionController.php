<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    //crud position
    public function index(Request $request)
    {
        // $position = Position::paginate(100);
        // return view('master.position.index', compact('position'));
        if($request->ajax()) {
            $position = Position::query();

            return DataTables::of($position)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $editBtn = '<a href="' . route('position.edit', $row->id) . '" class="btn icon btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $deleteBtn = '<form action="' . route('position.destroy', $row->id) . '" method="post" class="d-inline">
                                      ' . csrf_field() . method_field('DELETE') . '
                                      <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-sm btn-danger" title="Delete">
                                          <i class="bi bi-trash"></i>
                                      </button>
                                  </form>';
                    $showBtn = '<a href="' . route('position.show', $row->id) . '" class="btn icon btn-sm btn-info" title="Show"><i class="bi bi-eye"></i></a>';
                    return $editBtn . ' ' . $deleteBtn . ' ' . $showBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.position.index');
    }

    public function create()
    {
        return view('master.position.create');
    }

    public function store(Request $request)
    {
        $rulesData = [
            'posisi' => 'required|unique:m_position,posisi|max:60'
        ];

        $validateData = $request->validate($rulesData);

        Position::create($validateData);

        return redirect()->route('position.index')->with('success', 'Position berhasil ditambahkan');
    }

    public function edit($id)
    {
        $position = Position::find($id);
        return view('master.position.edit', compact('position'));
    }

    public function update(Request $request, $id)
    {
        $rulesData = [
            'posisi' => 'required|unique:m_position,posisi|max:60'
        ];

        $validateData = $request->validate($rulesData);

        Position::find($id)->update($validateData);

        return redirect()->route('position.index')->with('success', 'Position berhasil diupdate');
    }

    public function destroy($id)
    {
        Position::find($id)->delete();
        return redirect()->route('position.index')->with('success', 'Position berhasil dihapus');
    }

    public function show($id)
    {
        $position = Position::find($id);
        return view('master.position.show', compact('position'));
    }


}
