<?php

namespace App\Exports;

use App\Models\AktivitasMahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;

class AktivitasMahasiswaExport implements FromCollection, WithHeadings, WithColumnWidths, WithColumnFormatting, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch the required data from AktivitasMahasiswa model
        return AktivitasMahasiswa::with('programStudi', 'semester') // Eager load the Program Studi relation
            ->get()
            ->map(function ($aktivitas) {
                return [
                    'kode_aktivitas' => $aktivitas->kode_aktivitas,
                    'kode_semester' => $aktivitas->semester->nama_semester ?? '',
                    'jenis_aktivitas' => $aktivitas->jenis_aktivitas,
                    'judul' => $aktivitas->judul,
                    'lokasi' => $aktivitas->lokasi,
                    'nomor_sk_tugas' => $aktivitas->nomor_sk_tugas,
                    'jenis_anggota' => (string) $aktivitas->jenis_anggota,
                    'kode_prodi' => $aktivitas->programStudi->kode_prodi ?? '',
                    'nama_prodi' => $aktivitas->programStudi->nama_program_studi ?? '',
                    'keterangan_aktivitas' => $aktivitas->keterangan_aktivitas,
                    'tanggal_mulai' => $aktivitas->tanggal_mulai,
                    'tanggal_selesai' => $aktivitas->tanggal_selesai,
                ];
            });
    }

    /**
     * Define the headers for the Excel file.
     */
    public function headings(): array
    {
        return [
            'ID Aktivitas',
            'Semester',
            'Jenis Aktivitas',
            'Judul',
            'Lokasi',
            'Nomor SK Tugas',
            'Jenis Anggota',
            'Kode Prodi',
            'Nama Prodi',
            'Keterangan Aktivitas',
            'Tanggal Mulai',
            'Tanggal Selesai',
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
            'D' => 26,
            'E' => 16,
            'F' => 16,
            'G' => 16,
            'H' => 13,
            'I' => 30,
            'J' => 30,
            'K' => 20,
            'L' => 13,
            'M' => 14,
        ];
    }

    /**
     * Define column formatting for Excel.
     */
    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_TEXT,
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

                $comment = $sheet->getComment('G1')->getText();
                $comment->createTextRun('0 = Personal' . "\n");
                $comment->createTextRun('1 = Kelompok');

                // Set the row height
                $sheet->getRowDimension(1)->setRowHeight(20);

                // Set the heading font style
                $sheet->getStyle('A1:M1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                ]);

                // Set the data font style
                $sheet->getStyle('A2:M' . $sheet->getHighestRow())->applyFromArray([
                    'alignment' => [
                        'horizontal' => 'left',
                    ],
                ]);
            },
        ];
    }
}
