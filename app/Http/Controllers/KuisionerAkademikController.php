<?php

namespace App\Http\Controllers;

use App\Models\KuisionerAkademik;
use Illuminate\Http\Request;

class KuisionerAkademikController extends Controller
{
    public function index()
    {
        $kuisioner = KuisionerAkademik::all();
        return view('surat-kuisioner/kuisioner-akademik', compact('kuisioner'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan_kuisioner' => 'required|string|max:255',
            'jawaban_kuisioner' => 'nullable|string|max:255',
        ]);

        KuisionerAkademik::create($request->all());
        return redirect()->route('kuisioner-akademik.index')->with('success', 'Kuisioner berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kuisioner = KuisionerAkademik::findOrFail($id);

        $request->validate([
            'pertanyaan_kuisioner' => 'required|string|max:255',
            'jawaban_kuisioner' => 'nullable|string|max:255',
        ]);

        $kuisioner->update($request->all());
        return redirect()->route('kuisioner-akademik.index')->with('success', 'Kuisioner berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kuisioner = KuisionerAkademik::findOrFail($id);
        $kuisioner->delete();
        return redirect()->route('kuisioner-akademik.index')->with('success', 'Kuisioner berhasil dihapus.');
    }
}
