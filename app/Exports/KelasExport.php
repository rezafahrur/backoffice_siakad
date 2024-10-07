<?php

namespace App\Exports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KelasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Return the collection of data to export.
     */
    public function collection()
    {
        // Mengambil data Kelas dengan relasi 'details'
        return Kelas::with(['programStudi', 'semester', 'kurikulum', 'details.hr'])->get();
    }

    /**
     * Map data untuk setiap row di Excel
     */
    public function map($kelas): array
    {
        // Mengambil data detail pertama dari kelas untuk export
        // Asumsi: Satu kelas hanya punya satu detail, jika banyak maka Anda bisa mengadaptasi agar semua detail diexport
        $detail = $kelas->details->first();

        return [
            optional($kelas->programStudi)->nama_program_studi,  // Nama Program Studi
            optional($kelas->semester)->nama_semester,      // Nama Semester
            optional($kelas->kurikulum)->nama_kurikulum,     // Nama Kurikulum
            $kelas->nama_kelas,
            optional($detail->hr)->nama ?? 'N/A',            // Nama Dosen
            $kelas->kapasitas,
            $kelas->tanggal_mulai,
            $kelas->tanggal_akhir,     
        ];
    }

    /**
     * Headings untuk kolom di Excel
     */
    public function headings(): array
    {
        return [
            'Program Studi',
            'Semester',
            'Kurikulum',
            'Nama Kelas',
            'Nama Dosen',
            'Kapasitas',
            'Tanggal Mulai',
            'Tanggal Akhir',
        ];
    }
}
