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

        $description = $request->isi_berita; // Mengambil data dari input form

        // Mengolah gambar dalam Summernote (jika ada)
        $dom = new \DomDocument();
        @$dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $imageFiles = $dom->getElementsByTagName('img');

        foreach ($imageFiles as $item => $image) {
            $data = $image->getAttribute('src');

            // Proses gambar yang di-encode dengan base64
            if (strpos($data, 'data:image') !== false) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);

                $imageData = base64_decode($data);
                $image_name = "/upload/" . time() . $item . '.png';
                $path = public_path() . $image_name;

                file_put_contents($path, $imageData);

                $image->removeAttribute('src');
                $image->setAttribute('src', $image_name);
            }
        }

        $description = $dom->saveHTML();

        // Inisialisasi filePath sebagai null
        $filePath = null;

        // Handle file upload
        if ($request->hasFile('path_photo')) {
            $file = $request->file('path_photo');
            $filePath = $file->store('berita_photos', 'public');
        }

        // Membuat berita baru
        Berita::create([
            'kategori_berita_id' => $request->kategori_berita_id,
            'judul_berita' => $request->judul_berita,
            'path_photo' => $filePath, // Gunakan nilai $filePath, meskipun null
            'isi_berita' => $description,
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

        $berita = Berita::findOrFail($id);

        $description = $request->isi_berita;
        $dom = new \DomDocument();
        @$dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $imageFiles = $dom->getElementsByTagName('img');

        foreach ($imageFiles as $item => $image) {
            $data = $image->getAttribute('src');

            if (strpos($data, 'data:image') !== false) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);

                $imageData = base64_decode($data);
                $image_name = "/upload/" . time() . $item . '.png';
                $path = public_path() . $image_name;

                file_put_contents($path, $imageData);

                $image->removeAttribute('src');
                $image->setAttribute('src', $image_name);
            }
        }

        $description = $dom->saveHTML();

        if ($request->hasFile('path_photo')) {
            if ($berita->path_photo && Storage::disk('public')->exists($berita->path_photo)) {
                Storage::disk('public')->delete($berita->path_photo);
            }

            $file = $request->file('path_photo');
            $filePath = $file->store('berita_photos', 'public');
        } else {
            $filePath = $berita->path_photo;
        }

        $berita->update([
            'kategori_berita_id' => $request->kategori_berita_id,
            'judul_berita' => $request->judul_berita,
            'path_photo' => $filePath,
            'isi_berita' => $description,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diubah.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->path_photo && Storage::disk('public')->exists($berita->path_photo)) {
            Storage::disk('public')->delete($berita->path_photo);
        }

        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function show($id)
    {
        $berita = Berita::find($id);
        return view('master.berita.show', compact('berita'));
    }
}
