<?php

namespace App\Exports;

use App\Models\Kurikulum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;


class KurikulumExport implements FromCollection, WithHeadings, WithColumnWidths, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch the required data from Kurikulum model
        return Kurikulum::where('status', 1) // Filter by status
            ->select('nama_kurikulum', 'semester', 'sum_sks_lulus', 'sum_sks_wajib', 'sum_sks_pilihan', 'program_studi_id')
            ->with('programStudi') // Eager load the Program Studi relation
            ->get()
            ->map(function ($kurikulum) {
            return [
                'nama_kurikulum' => $kurikulum->nama_kurikulum,
                'kode_semester' => $kurikulum->semester,
                'jumlah_sks_lulus' => $kurikulum->sum_sks_lulus,
                'jumlah_sks_wajib' => $kurikulum->sum_sks_wajib,
                'jumlah_sks_pilihan' => $kurikulum->sum_sks_pilihan,
                'kode_prodi' => $kurikulum->programStudi->kode_prodi,
                'nama_prodi' => $kurikulum->programStudi->nama_program_studi,
            ];
            }
        );
    }

    /**
     * Define the headers for the Excel file.
     */
    public function headings(): array
    {
        return [
            'Nama Kurikulum',
            'Kode Semester',
            'Jumlah SKS Lulus',
            'Jumlah SKS Wajib',
            'Jumlah SKS Pilihan',
            'Kode Prodi',
            'Nama Prodi',
        ];
    }

    /**
     * Define the column widths for the Excel file.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 24,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 30,
        ];
    }

    // event
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Add comments to the heading
                $sheet->getComment('A1')->getText()->createTextRun('Nama Kurikulum');
                $sheet->getComment('B1')->getText()->createTextRun('Kode Semester');
                $sheet->getComment('C1')->getText()->createTextRun('Jumlah SKS Lulus');
                $sheet->getComment('D1')->getText()->createTextRun('Jumlah SKS Wajib');
                $sheet->getComment('E1')->getText()->createTextRun('Jumlah SKS Pilihan');
                $sheet->getComment('F1')->getText()->createTextRun('Kode Prodi');
                $sheet->getComment('G1')->getText()->createTextRun('Nama Prodi');

                // Set the row height
                $sheet->getRowDimension(1)->setRowHeight(20);

                // Set the heading font style
                $sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                ]);
            }
        ];
    }
}
