<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jurusan = Jurusan::query();

            return DataTables::of($jurusan)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="' . route('jurusan.edit', $row->id) . '" class="btn icon btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $deleteBtn = '<form action="' . route('jurusan.destroy', $row->id) . '" method="post" class="d-inline">
                                      ' . csrf_field() . method_field('DELETE') . '
                                      <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-sm btn-danger" title="Delete">
                                          <i class="bi bi-trash"></i>
                                      </button>
                                  </form>';
                    // $showBtn = '<a href="' . route('jurusan.show', $row->id) . '" class="btn icon btn-info" title="Show"><i class="bi bi-eye"></i></a>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.jurusan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusan = Jurusan::get();
        return view('master.jurusan.create', ['jurusans' => $jurusan]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rulesData = [
            'kode_jurusan' => 'required|max:2',
            'nama_jurusan' => 'required|string|max:255|unique:m_jurusan,nama_jurusan',
        ];

        $validateData = $request->validate($rulesData);
        Jurusan::create($validateData);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jurusan = Jurusan::find($id);

        return view('master.jurusan.detail', compact('jurusan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan)
    {
        return view('master.jurusan.edit', compact('jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $rulesData = [
            'kode_jurusan' => 'required|max:2',
            'nama_jurusan' => 'required|string|max:255|unique:m_jurusan,nama_jurusan,' . $jurusan->id,
        ];

        $validateData = $request->validate($rulesData);
        $jurusan->update($validateData);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus');
    }
}
