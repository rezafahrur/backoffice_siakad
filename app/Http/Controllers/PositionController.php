<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    //crud position
    public function index(Request $request)
    {
        $position = Position::paginate(100);
        return view('master.position.index', compact('position'));
    }
    
    public function create()
    {
        return view('master.position.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'posisi' => 'required'
        ]);

        Position::create($request->all());
        return redirect()->route('position.index')->with('success', 'Position berhasil ditambahkan');
    }

    public function edit($id)
    {
        $position = Position::find($id);
        return view('master.position.edit', compact('position'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'posisi' => 'required'
        ]);

        Position::find($id)->update($request->all());
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
