<?php

namespace App\Http\Controllers;

use App\Models\RuangKelas;
use App\Models\RuangKelasDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RuangKelasController extends Controller
{

    public function index(Request $request)
    {
        $kelas = RuangKelas::all();

        return view('master.ruang-kelas.index', compact('kelas'));
    }


    public function create()
    {
        return view('master.ruang-kelas.create');
    }

    public function store(Request $request)
    {
        $ruleData = [
            'kode_ruang_kelas' => 'required|max:10',
            'nama_ruang_kelas' => 'required|max:30',
            'kapasitas' => 'required|numeric',
        ];

        $validateData = $request->validate($ruleData);

        $ruangKelas = RuangKelas::create($validateData);

        if ($request->has('schedules')) {
            foreach ($request->schedules as $hari => $jadwalHari) {
                foreach ($jadwalHari as $jamAwal => $detail) {
                    RuangKelasDetail::create([
                        'ruang_kelas_id' => $ruangKelas->id,
                        'hari' => $hari,
                        'jam_awal' => $detail['jam_awal'],
                        'jam_akhir' => $detail['jam_akhir'],
                        'is_available' => '1',
                    ]);
                }
            }
        }

        return redirect()->route('ruang-kelas.index')->with('success', 'Ruang Kelas berhasil ditambahkan');
    }

    public function show($id)
    {
        // Mengambil data Ruang Kelas berdasarkan ID
        $ruangKelas = RuangKelas::findOrFail($id);

        // Mengambil jadwal yang terkait dengan ruang kelas (hanya Senin hingga Jumat)
        $schedules = RuangKelasDetail::where('ruang_kelas_id', $id)
            ->whereIn('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']) // Filter hanya hari Senin - Jumat
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')") // Mengurutkan berdasarkan hari
            ->orderBy('jam_awal')
            ->orderBy('id', 'asc') // Mengurutkan berdasarkan id dari yang terlama ke terbaru
            ->get()
            ->groupBy('hari'); // Mengelompokkan berdasarkan hari

        // Mengarahkan ke view untuk menampilkan ruang kelas dan jadwalnya
        return view('master.ruang-kelas.detail', compact('ruangKelas', 'schedules'));
    }

    public function edit(RuangKelas $kelas)
    {
        $ruangKelas = $kelas;

        // Mengambil data jadwal yang terkait dengan ruang kelas
        $schedules = RuangKelasDetail::where('ruang_kelas_id', $kelas->id)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_awal')
            ->get()
            ->groupBy('hari');

        return view('master.ruang-kelas.edit', compact('ruangKelas', 'schedules'));
    }

    public function update(Request $request, RuangKelas $kelas)
    {
        $ruleData = [
            'kode_ruang_kelas' => 'required|max:10',
            'nama_ruang_kelas' => 'required|max:30',
            'kapasitas' => 'required|numeric',
        ];

        $validateData = $request->validate($ruleData);

        try {
            $kelas->update($validateData);

            // Jika ada jadwal baru yang di-generate, tambahkan ke database
            if ($request->has('schedules')) {
                // Cek apakah ada jadwal yang masih terpakai
                $jadwalTerpakai = RuangKelasDetail::where('ruang_kelas_id', $kelas->id)
                    ->where('is_available', '0')
                    ->exists();

                if ($jadwalTerpakai) {
                    return redirect()->back()->with('error', 'Jadwal masih terpakai, tidak dapat merubah jadwal lama.');
                }

                // Hapus jadwal lama
                RuangKelasDetail::where('ruang_kelas_id', $kelas->id)->delete();

                // Tambahkan jadwal baru
                foreach ($request->schedules as $hari => $jadwalHari) {
                    foreach ($jadwalHari as $jamAwal => $detail) {
                        RuangKelasDetail::create([
                            'ruang_kelas_id' => $kelas->id,
                            'hari' => $hari,
                            'jam_awal' => $detail['jam_awal'],
                            'jam_akhir' => $detail['jam_akhir'],
                            'is_available' => '1',
                        ]);
                    }
                }
            }

            return redirect()->route('ruang-kelas.index')->with('success', 'Ruang Kelas berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function destroy(RuangKelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('ruang-kelas.index')->with('success', 'Ruang Kelas berhasil dihapus');
    }
}
