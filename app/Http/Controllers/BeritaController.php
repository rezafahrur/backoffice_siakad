<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BeritaController extends Controller
{
    // public function index()
    // {
    //     $berita = Berita::with('kategoriBerita')->get();
    //     return view('master.berita.index', compact('berita'));
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $berita = Berita::with('kategoriBerita')->get();

            return DataTables::of($berita)
                ->addIndexColumn()
                ->addColumn('photo', function ($row) {
                    return '<img src="'.asset('storage/'.$row->path_photo).'" alt="photo" style="width: 100px">';
                })
                ->addColumn('kategori_berita', function ($row) {
                    return strtoupper($row->kategoriBerita->kategori_berita ?? 'N/A'); // Convert to uppercase
                })
                ->addColumn('judul_berita', function ($row) {
                    return strtoupper($row->judul_berita); // Convert to uppercase
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="'.route('berita.show', $row->id).'" class="btn icon btn-primary btn-sm" title="Detail"><i class="bi bi-eye"></i></a> ';
                    $btn .= '<a href="'.route('berita.edit', $row->id).'" class="btn icon btn-warning btn-sm" title="Edit"><i class="bi bi-pencil-square"></i></a> ';
                    $btn .= '<button class="btn icon btn-danger btn-delete" data-id="'.$row->id.'" title="Delete"><i class="bi bi-trash"></i></button>';
                    // $btn .= '<form action="'.route('berita.destroy', $row->id).'" method="post" class="d-inline">
                    //             '.csrf_field().method_field('DELETE').'
                    //             <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></button>
                    //         </form>';
                    return $btn;
                })
                ->rawColumns(['photo', 'action'])
                ->make(true);
        }

        return view('master.berita.index');
    }



    public function create()
    {
        $kategoriBerita = KategoriBerita::all();
        return view('master.berita.create', compact('kategoriBerita'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_berita_id' => 'required',
            'judul_berita' => 'required',
            'path_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Nullable karena tidak selalu diperlukan
            'isi_berita' => 'required',
        ]);

        // Initialize filePath as null
        $filePath = null;

        // Handle the file upload
        if ($request->hasFile('path_photo')) {
            $file = $request->file('path_photo');
            $filePath = $file->store('berita_photos', 'public');
        }

        // Create the berita with the uploaded file path
        Berita::create([
            'kategori_berita_id' => $request->kategori_berita_id,
            'judul_berita' => $request->judul_berita,
            'path_photo' => $filePath, // Use the value of $filePath, even if it's null
            'isi_berita' => $request->isi_berita,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        $kategoriBerita = KategoriBerita::all();
        return view('master.berita.edit', compact('berita', 'kategoriBerita'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'kategori_berita_id' => 'required',
        'judul_berita' => 'required',
        'path_photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        'isi_berita' => 'required',
    ]);

    // Find the berita by ID
    $berita = Berita::findOrFail($id);

    // Handle the file upload if a new file is provided
    if ($request->hasFile('path_photo')) {
        // Delete the old file if it exists
        if ($berita->path_photo && Storage::disk('public')->exists($berita->path_photo)) {
            Storage::disk('public')->delete($berita->path_photo);
        }

        // Store the new file
        $file = $request->file('path_photo');
        $filePath = $file->store('berita_photos', 'public');
    } else {
        // If no new file is uploaded, keep the old path
        $filePath = $berita->path_photo;
    }

    // Update the berita with the uploaded file path
    $berita->update([
        'kategori_berita_id' => $request->kategori_berita_id,
        'judul_berita' => $request->judul_berita,
        'path_photo' => $filePath,
        'isi_berita' => $request->isi_berita,
    ]);

    return redirect()->route('berita.index')->with('success', 'Berita berhasil diubah.');
}


    public function destroy($id)
    {
        // Find the berita by ID
        $berita = Berita::findOrFail($id);

        // Delete the file associated with the berita if it exists
        if ($berita->path_photo && Storage::disk('public')->exists($berita->path_photo)) {
            Storage::disk('public')->delete($berita->path_photo);
        }

        // Delete the berita from the database
        $berita->delete();

        // Return a JSON response for AJAX requests
        return response()->json(['success' => 'Berita berhasil dihapus.']);
    }


    //show
    public function show($id)
    {
        $berita = Berita::find($id);
        return view('master.berita.show', compact('berita'));
    }
}
