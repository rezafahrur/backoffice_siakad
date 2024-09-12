<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\PaketMataKuliah;
use App\Models\PaketMataKuliahDetail;
use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PaketMataKuliahController extends Controller
{
    // Menampilkan daftar paket mata kuliah
    public function index(Request $request)
    {
        // if ($request->ajax()) {
        //     $paketMatakuliah = PaketMataKuliah::join('m_program_studi', 'm_paket_matakuliah.program_studi_id', '=', 'm_program_studi.id')
        //         ->select('m_paket_matakuliah.*', 'm_program_studi.nama_program_studi')
        //         ->get();

        //     return DataTables::of($paketMatakuliah)
        //         ->addIndexColumn()
        //         ->addColumn('action', function ($row) {
        //             $editBtn = '<a href="' . route('paket-matakuliah.edit', $row->id) . '" class="btn icon btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>';
        //             $deleteBtn = '<form action="' . route('paket-matakuliah.destroy', $row->id) . '" method="post" class="d-inline">
        //                               ' . csrf_field() . method_field('DELETE') . '
        //                               <button onclick="return confirm(\'Konfirmasi hapus data ?\')" class="btn icon btn-sm btn-danger" title="Delete">
        //                                   <i class="bi bi-trash"></i>
        //                               </button>
        //                           </form>';
        //             $showBtn = '<a href="' . route('paket-matakuliah.show', $row->id) . '" class="btn icon btn-sm btn-info" title="Detail"><i class="bi bi-eye"></i></a>';
        //             return $showBtn . ' ' . $editBtn . ' ' . $deleteBtn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
        $paketMatakuliahs = PaketMataKuliah::join('m_program_studi', 'm_paket_matakuliah.program_studi_id', '=', 'm_program_studi.id')
            ->select('m_paket_matakuliah.*', 'm_program_studi.nama_program_studi')
            ->get();

        return view('master.paket-matakuliah.index', compact('paketMatakuliahs'));
    }


    // Menampilkan form untuk membuat paket mata kuliah baru
    public function create()
    {
        $programStudi = ProgramStudi::all();
        $matakuliah = MataKuliah::all();
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

        // Mengatur status data lama menjadi tidak aktif jika data yang ditambah memilih status aktif
        if ($request->status == 1) {
            PaketMataKuliah::where('program_studi_id', $request->program_studi_id)
                ->where('semester', $request->semester)
                ->update(['status' => 0]);
        }

        // Menyimpan paket mata kuliah baru dengan status aktif
        $paketMatakuliah = PaketMataKuliah::create(array_merge(
            $request->only('nama_paket_matakuliah', 'program_studi_id', 'semester'),
            ['status' => $request->status]
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
        $paketMatakuliah = PaketMataKuliah::with(['programStudi', 'paketMataKuliahDetail' => function ($query) {
            $query->whereNotNull('matakuliah_id');
        }, 'paketMataKuliahDetail.matakuliah'])
            ->whereHas('paketMataKuliahDetail', function ($query) {
                $query->whereNotNull('matakuliah_id');
            })
            ->findOrFail($id);

        return view('master.paket-matakuliah.show', compact('paketMatakuliah'));
    }



    // Menampilkan form untuk mengedit paket mata kuliah
    public function edit($id)
    {
        $paketMatakuliah = PaketMataKuliah::findOrFail($id);
        $programStudi = ProgramStudi::all();
        $matakuliah = MataKuliah::all();  // Mengambil semua mata kuliah
        $matakuliahTerpilih = PaketMataKuliahDetail::where('paket_matakuliah_id', $id)->pluck('matakuliah_id')->toArray();

        // Cek apakah paket mata kuliah digunakan di jadwal
        $isUsedInJadwal = Jadwal::where('paket_matakuliah_id', $id)->exists();
        if ($isUsedInJadwal) {
            return redirect()->route('paket-matakuliah.index')->with('error', 'Paket Mata Kuliah tidak dapat diubah karena sedang digunakan di jadwal.');
        }

        return view('master.paket-matakuliah.edit', compact('paketMatakuliah', 'programStudi', 'matakuliah', 'matakuliahTerpilih'));
    }


    // Memperbarui paket mata kuliah di dalam databasez
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_paket_matakuliah' => 'required',
                'program_studi_id' => 'required',
                'semester' => 'required|integer|min:1|max:8',
                'matakuliah_id' => 'required|array',
            ]);

            $paketMatakuliah = PaketMataKuliah::findOrFail($id);

            // Mengatur status data lama yang sama menjadi tidak aktif jika data yang diedit memilih status aktif
            if ($request->status == 1) {
                PaketMataKuliah::where('program_studi_id', $request->program_studi_id)
                    ->where('semester', $request->semester)
                    ->update(['status' => 0]);
            }

            // Memperbarui paket mata kuliah yang ada
            $paketMatakuliah->update(array_merge(
                $request->only('nama_paket_matakuliah', 'program_studi_id', 'semester'),
                ['status' => $request->status] // Set status sesuai dengan input
            ));

            // null kan matakuliah_id detail yang lama (untuk dihapus)
            PaketMataKuliahDetail::where('paket_matakuliah_id', $id)->update(['matakuliah_id' => null]);

            // tambahkan detail mata kuliah yang baru. jika ada yang null dari data lama, gunakan data tersebut dan jika tidak ada maka buat data baru
            foreach ($request->matakuliah_id as $matakuliahId) {
                PaketMataKuliahDetail::updateOrCreate(
                    ['paket_matakuliah_id' => $id, 'matakuliah_id' => null],
                    ['matakuliah_id' => $matakuliahId]
                );
            }

            return redirect()->route('paket-matakuliah.index')->with('success', 'Paket Mata Kuliah berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error updating Paket Mata Kuliah: ' . $e->getMessage());
            return redirect()->route('paket-matakuliah.index')->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        // Cek apakah paket mata kuliah digunakan di jadwal
        $isUsedInJadwal = Jadwal::where('paket_matakuliah_id', $id)->exists();
        if ($isUsedInJadwal) {
            return redirect()->route('paket-matakuliah.index')->with('error', 'Paket Mata Kuliah tidak dapat dihapus karena sedang digunakan di jadwal.');
        }

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
            $mataKuliah = MataKuliah::where('program_studi_id', '=', $programStudiId)
                ->where(DB::raw('SUBSTRING(kode_matakuliah, 6, 1)'), '=', $semester)
                ->get(['id', 'kode_matakuliah', 'nama_matakuliah']);

            if ($mataKuliah->isEmpty()) {
                return response()->json(['message' => 'Mata Kuliah not found'], 404);
            }

            return response()->json($mataKuliah);
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error fetching Mata Kuliah: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
