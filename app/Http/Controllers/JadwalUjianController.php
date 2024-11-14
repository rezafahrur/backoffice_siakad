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
        try {
            // Simpan jadwal ujian baru
            $jadwalUjian = JadwalUjian::create(['kelas_id' => $request->kelas_id]);
            
            // Simpan setiap detail jadwal ujian
            foreach ($request->details as $detail) {
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
            // Tangkap error dan tampilkan di console log jika menggunakan AJAX
            return response()->json(['error' => 'Data gagal disimpan: ' . $e->getMessage()], 500);
        }
    }
    
    

    //update
    public function update(Request $request, $id)
    {
        try {
            // Temukan jadwal ujian berdasarkan ID
            $jadwalUjian = JadwalUjian::findOrFail($id);
            
            // Update kelas_id pada jadwal ujian
            $jadwalUjian->update(['kelas_id' => $request->kelas_id]);
            
            // Hapus detail jadwal ujian lama
            $jadwalUjian->details()->delete();
    
            // Tambahkan detail jadwal ujian baru
            foreach ($request->details as $detail) {
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
    
            return redirect()->route('jadwal-ujian.index')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            // Menangkap error dan mengembalikan pesan error ke halaman sebelumnya
            return redirect()->back()->withErrors(['update_error' => 'Data gagal diupdate: ' . $e->getMessage()]);
        }
    }
    
    
    

    public function getMatakuliah($kelas_id)
    {
        // Periksa apakah kelas_id diterima dengan benar
        if(!$kelas_id) {
            return response()->json(['error' => 'Kelas tidak ditemukan'], 400);
        }
    
        try {
            // Query untuk mengambil mata kuliah terkait kelas
            $matakuliah = DB::table('t_kelas_detail')
                ->join('t_kurikulum_detail', 't_kelas_detail.kurikulum_detail_id', '=', 't_kurikulum_detail.id')
                ->join('m_matakuliah', 't_kurikulum_detail.matakuliah_id', '=', 'm_matakuliah.id')
                ->where('t_kelas_detail.kelas_id', $kelas_id)
                ->select('m_matakuliah.id', 'm_matakuliah.nama_matakuliah')
                ->get();
    
            // Mengembalikan data dalam format JSON
            return response()->json($matakuliah);
        } catch (\Exception $e) {
            // Tangani error jika ada masalah
            \Log::error('Error fetching mata kuliah: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan dalam mengambil data mata kuliah'], 500);
        }
    }
    
    

    public function edit($id)
    {
        $jadwalUjians = JadwalUjian::with('details.ruangKelas', 'details.matakuliah')->find($id);
        $kelas = Kelas::all();
        $ruangKelas = RuangKelas::all();
        $mataKuliah = MataKuliah::all();
        return view('perkuliahan.jadwal-ujian.edit', compact('jadwalUjians', 'kelas', 'ruangKelas', 'mataKuliah'));
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
