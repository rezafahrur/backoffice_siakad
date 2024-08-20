<?php

namespace App\Http\Controllers;

use App\Models\PaketMataKuliah;
use App\Models\PaketMataKuliahDetail;
use App\Models\Matakuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class PaketMataKuliahController extends Controller
{
    // Menampilkan daftar paket mata kuliah
    public function index()
{
    $paketMatakuliah = PaketMataKuliah::with('programStudi')->get();
    return view('master.paket-matakuliah.index', compact('paketMatakuliah'));
}


    // Menampilkan form untuk membuat paket mata kuliah baru
    public function create()
    {
        $programStudi = ProgramStudi::all();
        $matakuliah = Matakuliah::all();
        return view('master.paket-matakuliah.create', compact('programStudi', 'matakuliah'));
    }

    // Menyimpan paket mata kuliah baru ke dalam database
    public function store(Request $request)
    {
        $request->validate([
            'nama_paket_matakuliah' => 'required',
            'program_studi_id' => 'required',
            'semester' => 'required|integer|min:1|max:8',
            'matakuliah_id' => 'required|array',
        ]);

        $paketMatakuliah = PaketMataKuliah::create($request->only('nama_paket_matakuliah', 'program_studi_id', 'semester', 'status'));

        foreach ($request->matakuliah_id as $matakuliahId) {
            PaketMataKuliahDetail::create([
                'paket_matakuliah_id' => $paketMatakuliah->id,
                'matakuliah_id' => $matakuliahId,
            ]);
        }

        return redirect()->route('paket-matakuliah.index')->with('success', 'Paket Mata Kuliah berhasil ditambahkan.');
    }

    // Menampilkan detail paket mata kuliah
    public function show($id)
    {
        // Menggunakan nama relasi yang benar
        $paketMatakuliah = PaketMataKuliah::with('programStudi', 'paketMataKuliahDetail.matakuliah')->findOrFail($id);
        return view('master.paket-matakuliah.show', compact('paketMatakuliah'));
    }
    
    

    // Menampilkan form untuk mengedit paket mata kuliah
    public function edit($id)
    {
        $paketMatakuliah = PaketMataKuliah::findOrFail($id);
        $programStudi = ProgramStudi::all();
        $matakuliah = Matakuliah::all();  // Mengambil semua mata kuliah
        $matakuliahTerpilih = PaketMataKuliahDetail::where('paket_matakuliah_id', $id)->pluck('matakuliah_id')->toArray();

        return view('master.paket-matakuliah.edit', compact('paketMatakuliah', 'programStudi', 'matakuliah', 'matakuliahTerpilih'));
    }


    // Memperbarui paket mata kuliah di dalam databasez
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_paket_matakuliah' => 'required',
            'program_studi_id' => 'required',
            'semester' => 'required|integer|min:1|max:8',
            'matakuliah_id' => 'required|array',
        ]);

        $paketMatakuliah = PaketMataKuliah::findOrFail($id);
        $paketMatakuliah->update($request->only('nama_paket_matakuliah', 'program_studi_id', 'semester', 'status'));

        // Hapus detail yang lama dan tambahkan yang baru
        PaketMataKuliahDetail::where('paket_matakuliah_id', $id)->delete();
        foreach ($request->matakuliah_id as $matakuliahId) {
            PaketMataKuliahDetail::create([
                'paket_matakuliah_id' => $paketMatakuliah->id,
                'matakuliah_id' => $matakuliahId,
            ]);
        }

        return redirect()->route('paket-matakuliah.index')->with('success', 'Paket Mata Kuliah berhasil diperbarui.');
    }

    // Menghapus paket mata kuliah dari database
// Menghapus paket mata kuliah dari database
public function destroy($id)
{
    // Hapus detail yang terkait
    PaketMataKuliahDetail::where('paket_matakuliah_id', $id)->delete();
    
    // Hapus paket mata kuliah
    PaketMataKuliah::destroy($id);

    return redirect()->route('paket-matakuliah.index')->with('success', 'Paket Mata Kuliah berhasil dihapus.');
}


    // Method untuk mendapatkan mata kuliah berdasarkan program studi dan semester yang dipilih
    public function getMataKuliah(Request $request)
    {
        $kodeProgramStudi = $request->query('kode_prodi');
        $semester = $request->query('semester');
    
        $mataKuliah = Matakuliah::where('kode_matakuliah', 'LIKE', $kodeProgramStudi . '%')
                                ->where('kode_matakuliah', 'LIKE', '%' . $semester . '%')
                                ->get(['id', 'kode_matakuliah', 'nama_matakuliah']);
    
        // Mengabaikan bagian terakhir dari kode mata kuliah
        $mataKuliah->transform(function ($item) {
            $item->kode_matakuliah = substr($item->kode_matakuliah, 0, -3);
            return $item;
        });
    
        return response()->json($mataKuliah);
    }
    
    
    
    
}