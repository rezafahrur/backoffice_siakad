<?php

namespace App\Exports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EvaluasiPembelajaranExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Return the collection of data to export.
     */
    public function collection()
    {
        // Mengambil data Kelas dengan relasi 'details' dan 'kurikulumDetail'
        return Kelas::with(['programStudi', 'semester', 'kurikulum', 'details.kurikulumDetail.matakuliah', 'details.hr'])->get();
    }

    /**
     * Map data untuk setiap row di Excel
     */
    public function map($kelas): array
    {
        // Mengambil data detail pertama dari kelas
        $detail = $kelas->details->first();

        return [
            optional($kelas->semester)->nama_semester ?? 'N/A',       // Nama Semester
            optional($detail->kurikulumDetail->matakuliah)->kode_matakuliah ?? 'N/A', // Kode Mata Kuliah
            optional($detail->kurikulumDetail->matakuliah)->nama_matakuliah ?? 'N/A', // Nama Mata Kuliah
            $kelas->nama_kelas ?? 'N/A',            // Nama Kelas
            $detail->aktivitas_partisipatif ?? 'N/A', // Aktivitas Partisipatif
            $detail->hasil_proyek ?? 'N/A',
            $detail->tugas ?? 'N/A',
            $detail->quiz ?? 'N/A',
            $detail->uts ?? 'N/A',
            $detail->uas ?? 'N/A',
            optional($kelas->programStudi)->nama_program_studi ?? 'N/A', // Nama Program Studi

        ];
    }

    /**
     * Headings untuk kolom di Excel
     */
    public function headings(): array
    {
        return [
            'Nama Semester',
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'Nama Kelas',
            'Aktivitas Partisipatif (%)',
            'Hasil Proyek (%)',
            'Tugas (%)',
            'Quiz (%)',
            'UTS (%)',
            'UAS (%)',
            'Nama Prodi',
        ];
    }
}
