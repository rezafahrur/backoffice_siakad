<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    // Menampilkan daftar posisi dan peran
    public function index(Request $request)
    {
        // if ($request->ajax()) {
        //     $position = Position::query();

        //     return DataTables::of($position)
        //         ->addIndexColumn()
        //         ->addColumn('action', function ($row) {
        //             $editBtn = '<a href="' . route('position.edit', $row->id) . '" class="btn icon btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>';
        //             $deleteBtn = '<form action="' . route('position.destroy', $row->id) . '" method="post" class="d-inline">
        //                               ' . csrf_field() . method_field('DELETE') . '
        //                               <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-sm btn-danger" title="Delete">
        //                                   <i class="bi bi-trash"></i>
        //                               </button>
        //                           </form>';
        //             $showBtn = '<a href="' . route('position.show', $row->id) . '" class="btn icon btn-sm btn-info" title="Show"><i class="bi bi-eye"></i></a>';
        //             return $editBtn . ' ' . $deleteBtn . ' ' . $showBtn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
        $positions = Position::all();

        return view('master.position.index', compact('positions'));
    }

    // Membuat posisi baru dan peran yang terkait
    public function create()
    {
        $permissions = Permission::all();
        $features = DB::table('m_feature')->get();
        return view('master.position.create', compact('permissions', 'features'));
    }

    // Menyimpan posisi baru dan menetapkan peran serta permission
    public function store(Request $request)
    {
        $rulesData = [
            'posisi' => 'required|unique:m_position,posisi|max:60',
            'permissions' => 'array'
        ];

        $validateData = $request->validate($rulesData);

        $position = Position::create($validateData);

        // Buat role dengan nama posisi
        $role = Role::create(['name' => $position->posisi, 'guard_name' => 'hr']);

        // Menetapkan permission ke role yang baru dibuat
        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('position.index')->with('success', 'Posisi berhasil ditambahkan');
    }

    // Mengedit posisi dan peran yang terkait
    public function edit($id)
    {
        $position = Position::find($id);
        $permissions = Permission::all();
        $features = DB::table('m_feature')->get();
        $rolePermissions = Role::where('name', $position->posisi)->first()->permissions->pluck('name')->toArray();

        return view('master.position.edit', compact('position', 'permissions', 'rolePermissions', 'features'));
    }

    // Memperbarui posisi dan role serta permissions yang terkait
    public function update(Request $request, $id)
    {
        $rulesData = [
            'posisi' => 'required|unique:m_position,posisi,' . $id . '|max:60',
            'permissions' => 'array'
        ];

        $validateData = $request->validate($rulesData);

        $position = Position::find($id);
        $position->update($validateData);

        // Update role dengan nama posisi
        $role = Role::where('name', $position->posisi)->first();
        if ($role) {
            $role->update(['name' => $request->posisi, 'guard_name' => 'hr']);
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('position.index')->with('success', 'Posisi berhasil diupdate');
    }

    // Menghapus posisi dan role yang terkait
    public function destroy($id)
    {
        $position = Position::find($id);

        // Hapus role terkait
        $role = Role::where('name', $position->posisi)->first();
        if ($role) {
            $role->delete();
        }

        $position->delete();
        return redirect()->route('position.index')->with('success', 'Posisi berhasil dihapus');
    }

    // Menampilkan detail posisi
    public function show($id)
    {
        $position = Position::find($id);
        $features = DB::table('m_feature')->get();
        $rolePermissions = Role::where('name', $position->posisi)->first()->permissions->pluck('name')->toArray();
        return view('master.position.show', compact('position', 'features', 'rolePermissions'));
    }

    // Menambahkan permission baru
    public function addPermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name'
        ]);

        Permission::create(['name' => $request->name, 'guard_name' => 'hr']);

        return redirect()->route('position.index')->with('success', 'Permission berhasil ditambahkan');
    }
}
