<?php

namespace App\Exports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class KelasExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Fetching Kelas with the necessary relationships
        return Kelas::with(['details.kurikulumDetail.matakuliah', 'programStudi', 'semester'])
            ->get()
            ->flatMap(function ($kelas) {
                return $kelas->details->map(function ($detail) use ($kelas) {
                    return [
                        //nama_semester
                        'Semester' => $kelas->semester->kode_semester ?? 'N/A',
                        'Kode Mata Kuliah' => $detail->kurikulumDetail->matakuliah->kode_matakuliah ?? 'N/A',
                        'Nama Mata Kuliah' => $detail->kurikulumDetail->matakuliah->nama_matakuliah ?? 'N/A',
                        'Nama Kelas' => $kelas->nama_kelas ?? 'N/A',
                        'Tanggal Mulai Efektif' => $kelas->tanggal_mulai ?? 'N/A',
                        'Tanggal Akhir Efektif' => $kelas->tanggal_akhir ?? 'N/A',
                        'Bahasan' => isset($detail->kurikulumDetail->matakuliah->bahasan) ? $detail->kurikulumDetail->matakuliah->bahasan : '',
                        'Lingkup Kelas' => $detail->lingkup_kelas ?? 'N/A',
                        'Mode Kelas' => $detail->mode_kelas ?? 'N/A',
                        'Kode Prodi' => $kelas->programStudi->id ?? 'N/A',
                        'Nama Program Studi' => $kelas->programStudi->nama_program_studi ?? 'N/A',
                        'SKS Tatap Muka' => $detail->kurikulumDetail->matakuliah->sks_tatap_muka ?? 'N/A',
                        'SKS Praktek' => $detail->kurikulumDetail->matakuliah->sks_praktek ?? 'N/A',
                        'SKS Praktek Lapangan' => $detail->kurikulumDetail->matakuliah->sks_praktek_lapangan ?? 'N/A',
                        'SKS Simulasi' => $detail->kurikulumDetail->matakuliah->sks_simulasi ?? 'N/A',
                    ];
                });
            });
    }

    /**
     * Headings for the export file.
     */
    public function headings(): array
    {
        return [
            'Semester',
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'Nama Kelas',
            'Tanggal Mulai Efektif',
            'Tanggal Akhir Efektif',
            'Bahasan',
            'Lingkup Kelas',
            'Mode Kuliah',
            'Kode Prodi',
            'Nama Program Studi',
            'SKS Tatap Muka',
            'SKS Praktek',
            'SKS Praktek Lapangan',
            'SKS Simulasi',
        ];
    }
}
