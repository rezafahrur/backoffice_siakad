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
        return Kelas::with(['programStudi', 'semester', 'kurikulum', 'details'])->get();
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
            $kelas->kapasitas,
            $kelas->tanggal_mulai,
            $kelas->tanggal_akhir,
            $detail ? $detail->tatap_muka : null,          // Tatap Muka
            $detail ? $detail->sks_ajar : null,            // SKS Ajar
            $detail ? $detail->jenis_evaluasi : null,      // Jenis Evaluasi
            $detail ? $detail->description : null,         // Deskripsi
            $detail ? $detail->lingkup_kelas : null,       // Lingkup Kelas
            $detail ? $detail->mode_kelas : null,          // Mode Kelas
            $detail ? $detail->aktivitas_partisipatif : null, // Aktivitas Partisipatif
            $detail ? $detail->hasil_proyek : null,        // Hasil Proyek
            $detail ? $detail->tugas : null,               // Tugas
            $detail ? $detail->quiz : null,                // Quiz
            $detail ? $detail->uts : null,                 // UTS
            $detail ? $detail->uas : null,                 // UAS
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
            'Kapasitas',
            'Tanggal Mulai',
            'Tanggal Akhir',
            'Tatap Muka',
            'SKS Ajar',
            'Jenis Evaluasi',
            'Deskripsi',
            'Lingkup Kelas',
            'Mode Kelas',
            'Aktivitas Partisipatif',
            'Hasil Proyek',
            'Tugas',
            'Quiz',
            'UTS',
            'UAS',
        ];
    }
}
