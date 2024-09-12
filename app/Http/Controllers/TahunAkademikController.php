<?php

namespace App\Http\Controllers;

use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'semester_id' => 'required|exists:m_semester,id',
        ]);

        // Update tahun akademik
        $tahunAkademik = TahunAkademik::findOrFail($id);
        $tahunAkademik->semester_id = $request->input('semester_id');
        $tahunAkademik->save();

        // Redirect kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Tahun Akademik berhasil diperbarui.');
    }
}

