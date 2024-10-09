<?php

namespace App\Exports;

use App\Models\AktivitasMahasiswa;
use App\Models\AktivitasMahasiswaPeserta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;

class AktivitasMahasiswaPesertaExport implements FromCollection, WithHeadings, WithColumnWidths, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch the required data from AktivitasMahasiswaPeserta model
        return AktivitasMahasiswaPeserta::with('aktivitasMahasiswa', 'programStudi', 'mahasiswa', 'matakuliah') // Eager load the Program Studi relation
            ->get()
            ->map(function ($peserta) {
                return [
                    'kode_aktivitas' => $peserta->aktivitasMahasiswa->kode_aktivitas,
                    'nim' => $peserta->mahasiswa->nim . ' ',
                    'nama' => $peserta->mahasiswa->nama,
                    'jenis_peran' => $peserta->jenis_peran,
                    'kode_matakuliah' => $peserta->matakuliah->kode_matakuliah,
                    'nama_matakuliah' => $peserta->matakuliah->nama_matakuliah,
                    'kode_prodi' => $peserta->programStudi->kode_prodi ?? '',
                    'nama_prodi' => $peserta->programStudi->nama_program_studi ?? '',
                    'sks' => $peserta->sks,
                    'nilai_huruf' => $peserta->nilai_huruf,
                    'nilai_indeks' => $peserta->nilai_indeks,
                    'nilai_angka' => $peserta->nilai_angka,
                ];
            });
    }

    /**
     * Define the headers for the Excel file.
     */
    public function headings(): array
    {
        return [
            'Kode Aktivitas',
            'NIM',
            'Nama',
            'Jenis Peran',
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'Kode Prodi',
            'Nama Prodi',
            'SKS',
            'Nilai Huruf',
            'Nilai Indeks',
            'Nilai Angka',
        ];
    }

    /**
     * Define the column widths for the Excel file.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 11,
            'B' => 15,
            'C' => 14,
            'D' => 11,
            'E' => 16,
            'F' => 16,
            'G' => 16,
            'H' => 13,
            'I' => 6,
            'J' => 10,
            'K' => 11,
            'L' => 10,
        ];
    }

    /**
     * Register events to format the sheet after it is created.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $comment = $sheet->getComment('D1')->getText();
                $comment->createTextRun('1 = Ketua' . "\n");
                $comment->createTextRun('2 = Anggota' . "\n");
                $comment->createTextRun('3 = Personal');

                // Set the row height
                $sheet->getRowDimension(1)->setRowHeight(20);

                // Set the heading font style
                $sheet->getStyle('A1:L1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                ]);

                // Set the data font style
                $sheet->getStyle('A2:L' . $sheet->getHighestRow())->applyFromArray([
                    'alignment' => [
                        'horizontal' => 'left',
                    ],
                ]);
            },
        ];
    }
}
