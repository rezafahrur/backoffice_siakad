<?php

namespace App\Exports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MataKuliahExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Kelas::with(['details.kurikulumDetail.matakuliah', 'programStudi', 'semester'])
        ->get()
        ->flatMap(function ($kelas) {
            return $kelas->details->map(function ($detail) use ($kelas) {
                return [
                    'Kode Mata Kuliah' => $detail->kurikulumDetail->matakuliah->kode_matakuliah ?? 'N/A',
                    'Nama Mata Kuliah' => $detail->kurikulumDetail->matakuliah->nama_matakuliah ?? 'N/A',
                    'Jenis Mata Kuliah' => isset($detail->kurikulumDetail->matakuliah->jenis_matakuliah)
                        ? strtoupper($detail->kurikulumDetail->matakuliah->jenis_matakuliah)
                        : 'N/A',
                    'SKS Tatap Muka' => $detail->kurikulumDetail->matakuliah->sks_tatap_muka ?? 'N/A',
                    'SKS Praktek' => $detail->kurikulumDetail->matakuliah->sks_praktek ?? 'N/A',
                    'SKS Praktek Lapangan' => $detail->kurikulumDetail->matakuliah->sks_praktek_lapangan ?? 'N/A',
                    'SKS Simulasi' => $detail->kurikulumDetail->matakuliah->sks_simulasi ?? 'N/A',
                    'Metode Belajar' => $detail->kurikulumDetail->matakuliah->metode_belajar ?? '',
                    'Tanggal Mulai Efektif' => $kelas->tanggal_mulai ?? 'N/A',
                    'Tanggal Akhir Efektif' => $kelas->tanggal_akhir ?? 'N/A',
                    'Kode Program Studi' => $kelas->programStudi->kode_program_studi ?? 'N/A',
                    'Nama Program Studi' => $kelas->programStudi->nama_program_studi ?? 'N/A',

                ];
            });
        });
    }

    public function headings(): array
    {
        return [
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'Jenis Mata Kuliah',
            'SKS Tatap Muka',
            'SKS Praktek',
            'SKS Praktek Lapangan',
            'SKS Simulasi',
            'Metode Belajar',
            'Tanggal Mulai Efektif',
            'Tanggal Akhir Efektif',
            'Kode Program Studi',
            'Nama Program Studi',
        ];
    }
}
