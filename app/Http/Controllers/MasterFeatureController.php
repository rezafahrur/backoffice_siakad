<?php

namespace App\Http\Controllers;

use App\Models\MasterFeature;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class MasterFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $masterFeature = MasterFeature::all();

        return view('master.feature.index', compact('masterFeature'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $masterFeature = MasterFeature::all();
        return view('master.feature.create', compact('masterFeature'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:m_feature,name',
        ]);
    
        // Menyimpan fitur baru
        $masterFeature = MasterFeature::create([
            'name' => $request->name,
        ]);
    
        // Menambahkan permissions terkait langsung ke tabel permissions
        $permissions = ['create', 'read', 'update', 'delete'];
        foreach ($permissions as $perm) {
            Permission::create([
                'name' => "{$perm}_{$masterFeature->name}",
                'guard_name' => 'hr',
                'feature_id' => $masterFeature->id, // Menyimpan ID fitur
            ]);
        }
    
        return redirect()->route('feature.index')->with('success', 'Fitur dan permissions berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterFeature $masterFeature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $masterFeature = MasterFeature::findOrFail($id);
        return view('master.feature.edit', compact('masterFeature'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterFeature $masterFeature)
    {
        $request->validate([
            'name' => 'required|unique:m_feature,name,' . $masterFeature->id,
        ]);

        $masterFeature->update([
            'name' => $request->name,
        ]);

        return redirect()->route('features.index')->with('success', 'Fitur berhasil diperbarui');
    }

    //destroy
    public function destroy($id)
    {
        $masterFeature = MasterFeature::findOrFail($id);
        $masterFeature->delete();

        return redirect()->route('feature.index')->with('success', 'Fitur berhasil dihapus');
    } 
    
}
