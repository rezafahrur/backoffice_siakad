<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class HrTemplateExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'nik',                 // KTP fields
            'nama',
            'alamat_jalan',
            'alamat_rt',
            'alamat_rw',
            'lahir_tempat',
            'lahir_tgl',
            'jenis_kelamin',
            'agama',
            'golongan_darah',
            'kewarganegaraan',
            'nip',                 // HR fields
            'gelar_depan',
            'gelar_belakang',
            'email',        // Foreign key to positions
            'hp',                  // HR Detail fields
        ];
    }
}
