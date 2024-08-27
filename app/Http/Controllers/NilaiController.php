<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\JadwalDetail;
use App\Models\Krs;
use App\Models\PaketMataKuliah;
use Illuminate\Http\Request;
use App\Models\PaketMataKuliahDetail;
use Illuminate\Support\Facades\Session;

class NilaiController extends Controller
{
    public function index()
    {
        $matakuliah = [];
        $mahasiswa = [];
        $paketMatkul= [];

        // Mendapatkan data paket jadwal berdasarkan hr_id dari session
        $paketJadwals = JadwalDetail::where('hr_id', '=', Session::get('hr_id'))->get();

        // Mencari data mata kuliah yang terkait dengan setiap paket jadwal
        foreach($paketJadwals as $paketJadwal) 
        {
            $paketMataKuliahDetails = PaketMataKuliahDetail::join('m_matakuliah', 't_paket_matakuliah_detail.matakuliah_id', '=', 'm_matakuliah.id')
                ->where('t_paket_matakuliah_detail.id', '=', $paketJadwal->paket_matakuliah_detail_id)
                ->select('t_paket_matakuliah_detail.matakuliah_id', 'm_matakuliah.nama_matakuliah')
                ->get();

            foreach($paketMataKuliahDetails as $paketMataKuliahDetail) 
            {
                array_push($matakuliah, [
                    'matakuliah_id' => $paketMataKuliahDetail->matakuliah_id,
                    'nama_matakuliah' => $paketMataKuliahDetail->nama_matakuliah
                ]);
            }
        }

        // Query untuk mendapatkan data mahasiswa yang join dengan tabel m_krs
        $mahasiswaKrsDetails = Mahasiswa::join('m_krs', 'm_mahasiswa.id', '=', 'm_krs.mahasiswa_id')
            ->select('m_mahasiswa.id as mahasiswa_id', 'm_mahasiswa.nama')
            ->get();

        // Menyimpan mahasiswa_id dan nama ke dalam array $mahasiswa
        foreach ($mahasiswaKrsDetails as $mahasiswaKrsDetail) 
        {
            array_push($mahasiswa, [
                'mahasiswa_id' => $mahasiswaKrsDetail->mahasiswa_id,
                'nama' => $mahasiswaKrsDetail->nama
            ]);
        }

        $paketDetail = PaketMataKuliah::join('m_krs', 'm_paket_matakuliah.id', '=', 'm_krs.paket_matakuliah_id')
            ->select('m_paket_matakuliah.id as paket_matakuliah_id', 'm_paket_matakuliah.nama_paket_matakuliah', 'm_paket_matakuliah.semester')
            ->get();

        foreach ($paketDetail as $paket)
        {
            array_push($paketMatkul, [
                'paket_matakuliah_id' => $paket->paket_matakuliah_id,
                'semester' => $paket->semester,
                'nama_paket_matakuliah' => $paket->nama_paket_matakuliah
            ]);
        }
        // Tampilkan hasil ke view
        return view('nilai.create', [
            'matakuliahs' => $matakuliah,
            'mahasiswas' => $mahasiswa,
            'paketMatkuls' => $paketMatkul
        ]);
    }
}
