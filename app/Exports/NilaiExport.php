<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NilaiExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Menyediakan koleksi data Nilai yang akan diekspor.
     */
    public function collection()
    {
        // Mengambil semua data Nilai beserta relasinya
        return Nilai::with('programStudi', 'kelas', 'matakuliah', 'details.mahasiswa')->get();
    }

    /**
     * Mapping data untuk tiap baris pada export Excel.
     */
    public function map($nilai): array
    {
        // Memetakan data dari Nilai dan NilaiDetail
        return $nilai->details->map(function ($detail) use ($nilai) {
            return [
                $nilai->programStudi->nama_program_studi ?? 'N/A',
                $nilai->kelas->nama_kelas ?? 'N/A',
                $nilai->matakuliah->nama_matakuliah ?? 'N/A',
                $detail->mahasiswa->nama ?? 'N/A',
                $detail->hasil_proyek ?? 0,
                $detail->quiz ?? 0,
                $detail->tugas ?? 0,
                $detail->uts ?? 0,
                $detail->uas ?? 0,
                $detail->aktivitas_partisipatif ?? 0,
                $detail->nilai_huruf ?? 'N/A',
                $detail->nilai_indeks ?? 0,
                $detail->nilai_angka ?? 0,
            ];
        })->toArray();
    }

    /**
     * Menyediakan header untuk file Excel.
     */
    public function headings(): array
    {
        return [
            'Program Studi',
            'Kelas',
            'Mata Kuliah',
            'Mahasiswa',
            'Hasil Proyek',
            'Quiz',
            'Tugas',
            'UTS',
            'UAS',
            'Aktivitas Partisipatif',
            'Nilai Huruf',
            'Nilai Indeks',
            'Nilai Angka',
        ];
    }
}
