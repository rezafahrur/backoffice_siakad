<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Http\Controllers\MahasiswaController; // Import Controller
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    protected $controller;

    public function __construct()
    {
        $this->controller = new MahasiswaController(); // Inisialisasi controller
    }

    public function model(array $row)
    {
        // Siapkan data
        $data = [
            'nama' => $row['nama'],
            'email' => $row['email'],
            'jurusan' => $row['jurusan_id'],
            'program_studi' => $row['program_studi_id'],
            'registrasi_tanggal' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['registrasi_tanggal'])->format('Y-m-d'),
            'semester_berjalan' => 1,
            'status' => 0,
            'telp_rumah' => '0' . (string) $row['telepon_rumah'],
            'no_hp' => '0' . (string) $row['no_hp'],
            'alamat_domisili' => (string) $row['alamat_domisili'],
            'kode_pos' => (string) $row['kode_pos'],
            'is_filled' => 0, // Asumsikan nilai ini jika data tidak lengkap
        ];

        // Panggil fungsi quickAdd
        return $this->controller->quickAddImport($data);
    }
}
