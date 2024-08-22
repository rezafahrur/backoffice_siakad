<?php

namespace App\Http\Controllers;

use App\Http\Requests\SemesterRequest;
use App\Models\Semester;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $semester = Semester::query();

            return DataTables::of($semester)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $editBtn = '<a href="' . route('semester.edit', $row->id) . '" class="btn icon btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $deleteBtn = '<form action="' . route('semester.destroy', $row->id) . '" method="post" class="d-inline">
                                      ' . csrf_field() . method_field('DELETE') . '
                                      <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-sm btn-danger" title="Delete">
                                          <i class="bi bi-trash"></i>
                                      </button>
                                  </form>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action']) // Ensures that HTML code for the action buttons is rendered correctly
                ->make(true);
        }

        return view('master.semester.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.semester.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SemesterRequest $request)
    {
        $validateData = $request->validated();

        Semester::create($validateData);

        return redirect()->route('semester.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $semester = Semester::find($id);
        return view('master.semester.detail', compact('semester'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Semester $semester)
    {
        return view('master.semester.edit', compact('semester'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SemesterRequest $request, Semester $semester)
    {
        $validateData = $request->validated();

        $semester->update($validateData);

        return redirect()->route('semester.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semester $semester)
    {
        $semester->delete();

        return redirect()->route('semester.index')->with('success', 'Data berhasil dihapus');
    }
}
