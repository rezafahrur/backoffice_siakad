<?php

namespace App\Http\Controllers;

use App\Models\PaketMataKuliah;
use App\Models\PaketMataKuliahDetail;
use App\Models\Matakuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama_paket_matakuliah' => 'required',
    //         'program_studi_id' => 'required',
    //         'semester' => 'required|integer|min:1|max:8',
    //         'matakuliah_id' => 'required|array',
    //     ]);

    //     $paketMatakuliah = PaketMataKuliah::create($request->only('nama_paket_matakuliah', 'program_studi_id', 'semester', 'status'));

    //     foreach ($request->matakuliah_id as $matakuliahId) {
    //         PaketMataKuliahDetail::create([
    //             'paket_matakuliah_id' => $paketMatakuliah->id,
    //             'matakuliah_id' => $matakuliahId,
    //         ]);
    //     }

    //     return redirect()->route('paket-matakuliah.index')->with('success', 'Paket Mata Kuliah berhasil ditambahkan.');
    // }

    public function store(Request $request)
{
    $request->validate([
        'nama_paket_matakuliah' => 'required',
        'program_studi_id' => 'required',
        'semester' => 'required|integer|min:1|max:8',
        'matakuliah_id' => 'required|array',
    ]);

    // Mengatur status data lama menjadi tidak aktif
    PaketMataKuliah::where('program_studi_id', $request->program_studi_id)
        ->where('semester', $request->semester)
        ->update(['status' => 0]);

    // Menyimpan paket mata kuliah baru dengan status aktif
    $paketMatakuliah = PaketMataKuliah::create(array_merge(
        $request->only('nama_paket_matakuliah', 'program_studi_id', 'semester'),
        ['status' => 1]  // Set status menjadi aktif
    ));

    // Menambahkan detail mata kuliah
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
    
        // Mengatur status data lama yang sama menjadi tidak aktif (kecuali yang sedang diupdate)
        PaketMataKuliah::where('program_studi_id', $request->program_studi_id)
            ->where('semester', $request->semester)
            ->where('id', '<>', $id)
            ->update(['status' => 0]);
    
        // Memperbarui paket mata kuliah yang ada
        $paketMatakuliah->update(array_merge(
            $request->only('nama_paket_matakuliah', 'program_studi_id', 'semester'),
            ['status' => $request->status] // Set status sesuai dengan input
        ));
    
        // Hapus detail lama dan tambahkan detail baru
        PaketMataKuliahDetail::where('paket_matakuliah_id', $id)->delete();
        foreach ($request->matakuliah_id as $matakuliahId) {
            PaketMataKuliahDetail::create([
                'paket_matakuliah_id' => $paketMatakuliah->id,
                'matakuliah_id' => $matakuliahId,
            ]);
        }
    
        return redirect()->route('paket-matakuliah.index')->with('success', 'Paket Mata Kuliah berhasil diperbarui.');
    }
    

    public function destroy($id)
    {
        // Hapus detail yang terkait
        PaketMataKuliahDetail::where('paket_matakuliah_id', $id)->delete();
        
        // Hapus paket mata kuliah
        PaketMataKuliah::destroy($id);

        return redirect()->route('paket-matakuliah.index')->with('success', 'Paket Mata Kuliah berhasil dihapus.');
    }


    public function getMataKuliah(Request $request, $programStudiId, $semester)
{
    // Validasi nilai semester
    if (is_null($semester) || !is_numeric($semester)) {
        return response()->json(['message' => 'Invalid semester value'], 400);
    }

    try {
        $mataKuliah = Matakuliah::where('program_studi_id', '=', $programStudiId)
                                ->where(DB::raw('SUBSTRING(kode_matakuliah, 6, 1)'), '=', $semester)
                                ->get(['id', 'kode_matakuliah', 'nama_matakuliah']);
        
        if ($mataKuliah->isEmpty()) {
            return response()->json(['message' => 'Mata Kuliah not found'], 404);
        }
        
        return response()->json($mataKuliah);
    } catch (\Exception $e) {
        // Log error untuk debugging
        \Log::error('Error fetching Mata Kuliah: '.$e->getMessage());
        return response()->json(['message' => 'Internal Server Error'], 500);
    }
}

     
}
