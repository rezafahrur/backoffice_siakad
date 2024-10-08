<?php

namespace App\Exports;

use App\Models\AktivitasMahasiswa;
use App\Models\AktivitasMahasiswaBimbing;
use App\Models\AktivitasMahasiswaPeserta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;

class AktivitasMahasiswaBimbingExport implements FromCollection, WithHeadings, WithColumnWidths, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch the required data from AktivitasMahasiswaBimbing model
        return AktivitasMahasiswaBimbing::with('aktivitasMahasiswa') // Eager load the Program Studi relation
            ->get()
            ->map(function ($bimbing) {
                return [
                    'kode_aktivitas' => $bimbing->aktivitasMahasiswa->kode_aktivitas,
                    'nidn_dosen' => $bimbing->nidn_dosen,
                    'nama_dosen' => $bimbing->nama_dosen,
                    'jenis_peran' => $bimbing->jenis_peran,
                    'urutan_pembimbing' => $bimbing->urutan_pembimbing,
                    'kategori_kegiatan' => $bimbing->kategori_kegiatan,
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
            'NIDN Dosen',
            'Nama Dosen',
            'Jenis Peran',
            'Urutan Pembimbing',
            'Kategori Kegiatan',
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
                $comment->createTextRun('1 = Pembimbing' . "\n");
                $comment->createTextRun('2 = Penguji');

                // Set the row height
                $sheet->getRowDimension(1)->setRowHeight(20);

                // Set the heading font style
                $sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                ]);

                // Set the data font style
                $sheet->getStyle('A2:F' . $sheet->getHighestRow())->applyFromArray([
                    'alignment' => [
                        'horizontal' => 'left',
                    ],
                ]);
            },
        ];
    }
}
