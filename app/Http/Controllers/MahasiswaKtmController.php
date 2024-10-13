<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MahasiswaKtm;


class MahasiswaKtmController extends Controller
{
    public function index()
    {
        $mahasiswaKtms = MahasiswaKtm::with('mahasiswa.programStudi')->get();
        $path_file_ktm = 'http://127.0.0.1:9699';
        // dd($mahasiswaKtms);

        return view('mahasiswa.ktm-validation', compact('mahasiswaKtms', 'path_file_ktm'));
    }

    public function validateKtm($id)
    {
        $ktm = MahasiswaKtm::findOrFail($id);
        $ktm->status = 2; // Set status menjadi 3 (tervalidasi)
        $ktm->save();

        return back()->with('success', 'Foto KTM berhasil divalidasi!');
    }

    public function rejectKtm($id)
    {
        $ktm = MahasiswaKtm::findOrFail($id);
        $ktm->status = 0; // Set status menjadi 0 (ditolak)
        $ktm->save();

        return back()->with('success', 'Foto KTM ditolak!');
    }

    public function deleteKtm($id)
    {
        $ktm = MahasiswaKtm::findOrFail($id);
        $ktm->delete();

        return back()->with('success', 'Data KTM berhasil dihapus!');
    }

    public function updateStatus(Request $request, $id)
    {
        // Temukan data KTM berdasarkan ID
        $ktm = MahasiswaKtm::findOrFail($id);

        // Validasi input status
        $request->validate([
            'status' => 'required|in:0,1,2', // 0 = rejected, 1 = pending, 2 = validated
        ]);

        // Update status
        $ktm->status = $request->input('status');
        $ktm->save();

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Status KTM berhasil diperbarui!');
    }

}
