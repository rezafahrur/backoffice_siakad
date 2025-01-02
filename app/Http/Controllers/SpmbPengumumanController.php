<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpmbPengumuman;
use Illuminate\Support\Facades\Storage;

class SpmbPengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = SpmbPengumuman::all();
        return view('mahasiswa.spmb_pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('mahasiswa.spmb_pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_pengumuman' => 'nullable|mimes:pdf|max:2048',
            'deskripsi' => 'required|string',
        ]);

        // Upload Gambar Pengumuman
        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('pengumuman/gambar', 'public');
        }

        // Upload File Pengumuman
        $file = null;
        if ($request->hasFile('file_pengumuman')) {
            $file = $request->file('file_pengumuman')->store('pengumuman/file', 'public');
        }

        // Simpan ke Database
        SpmbPengumuman::create([
            'judul' => $request->judul,
            'gambar' => $gambar,
            'file_pengumuman' => $file,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('spmb_pengumuman.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function edit($id)
    {
        $pengumuman = SpmbPengumuman::findOrFail($id);
        return view('mahasiswa.spmb_pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $pengumuman = SpmbPengumuman::findOrFail($id);

        $request->validate([
            'judul_pengumuman' => 'required|string|max:255',
            'gambar_pengumuman' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_pengumuman' => 'nullable|mimes:pdf|max:2048',
            'deskripsi_pengumuman' => 'required|string',
        ]);

        // Update Gambar Pengumuman
        if ($request->hasFile('gambar_pengumuman')) {
            if ($pengumuman->gambar) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }
            $pengumuman->gambar = $request->file('gambar_pengumuman')->store('pengumuman/gambar', 'public');
        }

        // Update File Pengumuman
        if ($request->hasFile('file_pengumuman')) {
            if ($pengumuman->file_pengumuman) {
                Storage::disk('public')->delete($pengumuman->file_pengumuman);
            }
            $pengumuman->file_pengumuman = $request->file('file_pengumuman')->store('pengumuman/file', 'public');
        }

        // Update Data
        $pengumuman->update([
            'judul' => $request->judul_pengumuman,
            'deskripsi' => $request->deskripsi_pengumuman,
        ]);

        return redirect()->route('spmb_pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengumuman = SpmbPengumuman::findOrFail($id);

        if ($pengumuman->gambar) {
            Storage::disk('public')->delete($pengumuman->gambar);
        }

        if ($pengumuman->file_pengumuman) {
            Storage::disk('public')->delete($pengumuman->file_pengumuman);
        }

        $pengumuman->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus');
    }
}
