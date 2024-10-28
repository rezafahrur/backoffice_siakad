<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalSementara;
use App\Models\Kelas;

class JadwalSementaraController extends Controller
{
    public function index()
    {
        $jadwals = JadwalSementara::with('kelas')->get();

        return view('feature.jadwal_sementara.index', compact('jadwals'));
    }

    public function create()
    {
        $kelas = Kelas::whereDoesntHave('jadwalSementara')->get();
        return view('feature.jadwal_sementara.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file = $request->file('file');
        $file_name = 'JADWAL_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('upload/jadwal-images'), $file_name);

        JadwalSementara::create([
            'kelas_id' => $request->kelas_id,
            'file' => $file_name,
        ]);

        return redirect()->route('jadwal-sementara.index')->with('success', 'Jadwal sementara berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jadwal = JadwalSementara::findOrFail($id);
        $kelas = Kelas::all();
        return view('feature.jadwal_sementara.edit', compact('jadwal', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kelas_id' => 'required',
            'file' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $jadwal = JadwalSementara::findOrFail($id);

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($jadwal->file) {
                $oldFilePath = public_path('upload/jadwal-images/' . $jadwal->file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $file = $request->file('file');
            $file_name = 'JADWAL_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/jadwal-images'), $file_name);
            $jadwal->file = $file_name;
        }

        $jadwal->kelas_id = $request->kelas_id;
        $jadwal->save();

        return redirect()->route('jadwal-sementara.index')->with('success', 'Jadwal sementara berhasil diubah!');
    }

    public function destroy($id)
    {
        $jadwal = JadwalSementara::findOrFail($id);

        // Hapus file
        if ($jadwal->file) {
            $oldFilePath = public_path('upload/jadwal-images/' . $jadwal->file);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        $jadwal->delete();

        return redirect()->route('jadwal-sementara.index')->with('success', 'Jadwal sementara berhasil dihapus!');
    }
}

