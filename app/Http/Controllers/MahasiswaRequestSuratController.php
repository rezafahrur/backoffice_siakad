<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MahasiswaRequestSurat;

class MahasiswaRequestSuratController extends Controller
{
    public function index()
    {
        // Ambil semua permintaan surat beserta relasinya
        $permintaanSurat = MahasiswaRequestSurat::with(['mahasiswa.programStudi', 'requestSuratDetail'])->get();
        // Tampilkan view request-surat
        return view('surat-kuisioner.request-surat', compact('permintaanSurat'));
    }

    public function proses(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'status' => 'required',
            'catatan' => 'nullable',
        ]);

        // Temukan permintaan surat berdasarkan ID
        $permintaan = MahasiswaRequestSurat::findOrFail($id);
        // Perbarui status dan catatan
        $permintaan->status = $request->input('status');
        $permintaan->catatan = $request->input('catatan');
        $permintaan->save();

        // Redirect ke index dengan pesan sukses
        return redirect()->route('permintaan-surat.index')->with('success', 'Status permintaan surat berhasil diubah.');
    }

    public function show($id)
    {
        // Temukan permintaan surat berdasarkan ID
        $permintaan = MahasiswaRequestSurat::with('mahasiswa')->findOrFail($id);
        // Pastikan untuk merujuk ke view detail yang sesuai
        return view('mahasiswa.request-surat-detail', compact('permintaan')); // Ganti 'request-surat-detail' dengan nama view yang sesuai
    }

    public function showDetail($id)
    {
        $permintaan = MahasiswaRequestSurat::with(['mahasiswa', 'semester', 'requestSuratDetail'])
            ->where('id', $id)
            ->first();

        if ($permintaan) {
            return response()->json([
                'mahasiswa' => $permintaan->mahasiswa,
                'semester' => $permintaan->semester,
                'jenis_surat' => $permintaan->jenis_surat,
                'status' => $permintaan->status,
                'catatan' => $permintaan->catatan,
                'request_detail' => $permintaan->requestSuratDetail
            ]);
        } else {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        dd($permintaan);
    }

    public function destroy($id)
    {
        // Temukan permintaan surat berdasarkan ID
        $permintaan = MahasiswaRequestSurat::findOrFail($id);
        // Hapus permintaan surat
        $permintaan->delete();

        // Redirect ke index dengan pesan sukses
        return redirect()->route('permintaan-surat.index')->with('success', 'Permintaan surat berhasil dihapus.');
    }
}
