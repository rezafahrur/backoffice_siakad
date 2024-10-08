<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class NilaiExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    /**
     * Menyediakan koleksi data Nilai yang akan diekspor.
     */
    public function collection()
    {
        // Mengambil semua data Nilai beserta relasinya
        return Nilai::with(['programStudi', 'kelas.semester', 'matakuliah', 'details.mahasiswa'])->get();
    }

    /**
     * Mapping data untuk tiap baris pada export Excel.
     */
    public function map($nilai): array
    {
        // Memetakan data dari Nilai dan NilaiDetail
        return $nilai->details->map(function ($detail) use ($nilai) {
            return [
                ($detail->mahasiswa->nim ?? 'N/A') . ' ',
                $detail->mahasiswa->nama ?? 'N/A',
                $nilai->matakuliah->kode_matakuliah ?? 'N/A',
                $nilai->matakuliah->nama_matakuliah ?? 'N/A',
                $nilai->kelas->nama_kelas ?? 'N/A',
                $nilai->kelas->semester->nama_semester ?? 'N/A',
                $detail->nilai_huruf ?? 'N/A',
                $detail->nilai_indeks ?? 0,
                $detail->nilai_angka ?? 0,
                $nilai->programStudi->kode_prodi ?? 'N/A',
                $nilai->programStudi->nama_program_studi ?? 'N/A',
            ];
        })->toArray();
    }

    /**
     * Menentukan format kolom.
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,  // Kolom NIM (A) diformat sebagai teks
        ];
    }

    /**
     * Headings untuk file yang diekspor.
     */
    public function headings(): array
    {
        return [
            'NIM',
            'Nama Mahasiswa',
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'Semester',
            'Nama Kelas',
            'Nilai Huruf',
            'Nilai Indeks',
            'Nilai Angka',
            'Kode Prodi',
            'Nama Prodi',
        ];
    }
}
