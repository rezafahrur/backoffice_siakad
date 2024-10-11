<?php

namespace App\Imports;

use App\Models\Hr;
use App\Models\Ktp;
use App\Models\HrDetail;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HrImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Create or update KTP first
        $ktpData = [
            'nik' => $row['nik'],
            'nama' => $row['nama'],
            'alamat_jalan' => $row['alamat_jalan'],
            'alamat_rt' => $row['alamat_rt'],
            'alamat_rw' => $row['alamat_rw'],
            'lahir_tempat' => $row['lahir_tempat'],
            'lahir_tgl' => $row['lahir_tgl'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'agama' => $row['agama'],
            'golongan_darah' => $row['golongan_darah'],
            'kewarganegaraan' => $row['kewarganegaraan'],
        ];

        $ktp = Ktp::updateOrCreate(
            ['nik' => $row['nik']],
            $ktpData
        );

        // Create HR record
        $hrData = [
            'ktp_id' => $ktp->id,
            'nip' => $row['nip'],
            'gelar_depan' => $row['gelar_depan'],
            'nama' => $row['nama'],
            'gelar_belakang' => $row['gelar_belakang'],
            'email' => $row['email'],
        ];

        $hr = Hr::updateOrCreate(
            ['nip' => $row['nip']],
            $hrData
        );

        // Create HrDetail
        $hrDetailData = [
            'master_hr_id' => $hr->id,
            'hp' => $row['hp'],
        ];

        HrDetail::updateOrCreate(
            ['master_hr_id' => $hr->id],
            $hrDetailData
        );
    }
}
