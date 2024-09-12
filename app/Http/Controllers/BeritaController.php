<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $berita = Berita::with('kategoriBerita')->get();

        return view('master.berita.index', compact('berita'));
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
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }


    //show
    public function show($id)
    {
        $berita = Berita::find($id);
        return view('master.berita.show', compact('berita'));
    }
}
