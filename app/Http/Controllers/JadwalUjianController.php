<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\JadwalUjian;
use Illuminate\Http\Request;
use App\Models\JadwalUjianDetail;
use App\Models\Kelas;
use App\Models\MataKuliah;
use App\Models\RuangKelas;
use App\Models\SkalaNilaiDetail;

class JadwalUjianController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        $jadwalUjians = JadwalUjian::with('details.ruangKelas', 'details.matakuliah')->get();
        return view('perkuliahan.jadwal-ujian.index', compact('jadwalUjians', 'kelas'));
    }

    public function create()
    {
        $ruangKelas = RuangKelas::all();
        $kelas = Kelas::all();
        $mataKuliah = MataKuliah::all();
        return view('perkuliahan.jadwal-ujian.create', compact('ruangKelas', 'kelas', 'mataKuliah'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kelas_id' => 'required|exists:m_kelas,id',
            'details' => 'required|array',
            'details.*.matakuliah_id' => 'required|exists:m_matakuliah,id',
            'details.*.ruang_kelas_id' => 'required|exists:m_ruang_kelas,id',
            'details.*.kode_jadwal_ujian' => 'required|string|max:10',
            'details.*.tanggal' => 'required|date',
            'details.*.jam_mulai' => 'required|date_format:H:i',
            'details.*.jam_akhir' => 'required|date_format:H:i|after:details.*.jam_mulai',
        ]);

        try {
            $jadwalUjian = JadwalUjian::create(['kelas_id' => $validatedData['kelas_id']]);
            
            foreach ($validatedData['details'] as $detail) {
                JadwalUjianDetail::create([
                    'jadwal_ujian_id' => $jadwalUjian->id,
                    'matakuliah_id' => $detail['matakuliah_id'],
                    'ruang_kelas_id' => $detail['ruang_kelas_id'],
                    'kode_jadwal_ujian' => $detail['kode_jadwal_ujian'],
                    'tanggal' => $detail['tanggal'],
                    'jam_mulai' => $detail['jam_mulai'],
                    'jam_akhir' => $detail['jam_akhir']
                ]);
            }

            return redirect()->route('jadwal-ujian.index')->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data gagal disimpan: ' . $e->getMessage());
        }
    }

    public function getMatakuliah($kelas_id)
    {
        $matakuliah = DB::table('t_kelas_detail')
            ->join('t_kurikulum_detail', 't_kelas_detail.kurikulum_detail_id', '=', 't_kurikulum_detail.id')
            ->join('m_matakuliah', 't_kurikulum_detail.matakuliah_id', '=', 'm_matakuliah.id')
            ->where('t_kelas_detail.kelas_id', $kelas_id)
            ->select('m_matakuliah.id', 'm_matakuliah.nama_matakuliah')
            ->get();

        return response()->json($matakuliah);
    }

    public function edit($id)
    {
        $jadwalUjian = JadwalUjian::find($id);
        return view('perkuliahan.jadwal-ujian.edit', compact('jadwalUjian'));
    }

    public function update(Request $request, $id)
    {
        $jadwalUjian = JadwalUjian::find($id);
        $jadwalUjian->update($request->all());
        return redirect()->route('jadwal-ujian.index')->with('success', 'Jadwal Ujian updated successfully.');
    }

    public function destroy($id)
    {
        $jadwalUjian = JadwalUjian::find($id);
        $jadwalUjian->delete();
        return redirect()->route('jadwal-ujian.index')->with('success', 'Jadwal Ujian deleted successfully.');
    }

    public function show($id)
    {
        $jadwalUjian = JadwalUjian::find($id);
        return view('perkuliahan.jadwal-ujian.detail', compact('jadwalUjian'));
    }
}
