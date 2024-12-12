<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpmbPendaftar;
use Barryvdh\DomPDF\Facade\Pdf;

class SpmbPendaftarController extends Controller
{
    public function index()
    {
        $pendaftar = SpmbPendaftar::with('user')->get();
        return view('mahasiswa.spmb.spmb', compact('pendaftar'));
    }

    /**
     * Update status pendaftar.
     */
    public function updateStatus(Request $request, $id)
    {
        // Temukan data pendaftar SPMB berdasarkan ID
        $spmb = SpmbPendaftar::findOrFail($id);

        // Validasi input status
        $request->validate([
            'status' => 'required|in:0,1,2',
        ]);

        // Update status
        $spmb->status = $request->input('status');
        $spmb->save();

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Status pendaftar berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cari SPMB berdasarkan ID
        $spmb = SpmbPendaftar::findOrFail($id);

        // Hapus SPMB
        $spmb->delete();

        // Redirect dengan pesan sukses
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function validate($id)
    {
        $spmb = SpmbPendaftar::findOrFail($id);
        $spmb->status = 1;
        $spmb->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function rejectPendaftar($id)
    {
        $spmb = SpmbPendaftar::findOrFail($id);
        $spmb->status = 0; // Set status menjadi 0 (ditolak)
        $spmb->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function exportAllPDF()
    {
        // Ambil semua data pendaftar dengan status = 1
        $pendaftar = SpmbPendaftar::where('status', 1)->with('user')->get();

        // Jika tidak ada data, kembalikan pesan error atau file kosong
        if ($pendaftar->isEmpty()) {
            return abort(404, 'Tidak ada pendaftar dengan status yang valid.');
        }

        // Load view untuk PDF
        $pdf = PDF::loadView('mahasiswa.spmb.export-pdf', compact('pendaftar'));

        // Mengembalikan file PDF untuk diunduh
        return $pdf->download('pendaftar.pdf');
    }
}
