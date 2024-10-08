<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $berita = Berita::with('kategoriBerita')->get();

        return view('feature.berita.index', compact('berita'));
    }

    public function create()
    {
        $kategoriBerita = KategoriBerita::all();
        return view('feature.berita.create', compact('kategoriBerita'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_berita_id' => 'required',
            'judul_berita' => 'required',
            'path_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isi_berita' => 'required',
        ]);

        // Mengambil data dari input form
        $description = $request->isi_berita;

        // Mengolah gambar dalam Summernote (jika ada)
        $dom = new \DomDocument();
        @$dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Mengambil tag img
        $imageFiles = $dom->getElementsByTagName('img');

        // Looping tag img
        foreach ($imageFiles as $item => $image) {
            $data = $image instanceof \DOMElement ? $image->getAttribute('src') : '';

            // Jika tag img memiliki data:image
            if (strpos($data, 'data:image') !== false) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);

                // Decode base64
                $imageData = base64_decode($data);
                $image_name = "/storage/isi_berita_photos/" . time() . $item . '.png';
                $path = public_path() . $image_name;

                // Menyimpan gambar
                file_put_contents($path, $imageData);

                // Menghapus attribute src
                if ($image instanceof \DOMElement) {
                    $image->removeAttribute('src');
                    // Menambahkan attribute src dengan path gambar
                    $image->setAttribute('src', $image_name);
                }
            }
        }

        $description = $dom->saveHTML();

        // Inisialisasi filePath sebagai menampilkan path foto
        $filePath = null;

        // Handle file upload
        if ($request->hasFile('path_photo')) {
            $file = $request->file('path_photo');
            $filePath = $file->store('berita_photos', 'public');
        }

        // dd($filePath , $request->all());

        // Membuat berita baru
        Berita::create([
            'kategori_berita_id' => $request->kategori_berita_id,
            'judul_berita' => $request->judul_berita,
            'path_photo' => $filePath,
            'isi_berita' => $description,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        $kategoriBerita = KategoriBerita::all();
        return view('feature.berita.edit', compact('berita', 'kategoriBerita'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_berita_id' => 'required',
            'judul_berita' => 'required',
            'path_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'isi_berita' => 'required',
        ]);

        $berita = Berita::findOrFail($id);

        $description = $request->isi_berita;

        $dom = new \DomDocument();
        @$dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $imageFiles = $dom->getElementsByTagName('img');

        foreach ($imageFiles as $item => $image) {
            $data = $image instanceof \DOMElement ? $image->getAttribute('src') : '';

            if (strpos($data, 'data:image') !== false) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);

                $imageData = base64_decode($data);
                $image_name = "/storage/isi_berita_photos/" . time() . $item . '.png';
                $path = public_path() . $image_name;

                file_put_contents($path, $imageData);

                if ($image instanceof \DOMElement) {
                    $image->removeAttribute('src');
                    $image->setAttribute('src', $image_name);
                }
            }
        }

        $description = $dom->saveHTML();

        $filePath = $berita->path_photo;

        if ($request->hasFile('path_photo')) {
            if ($berita->path_photo && Storage::disk('public')->exists($berita->path_photo)) {
                Storage::disk('public')->delete($berita->path_photo);
            }

            $file = $request->file('path_photo');
            $filePath = $file->store('berita_photos', 'public');
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
        $berita = Berita::findOrFail($id);
        return view('feature.berita.show', compact('berita'));
    }
}
