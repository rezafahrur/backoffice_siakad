<?php

namespace App\Exports;

use App\Models\Kurikulum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class MatkulKurikulumExport implements FromCollection, WithHeadings, WithColumnWidths, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch the required data from KurikulumDetail
        return Kurikulum::with(['kurikulumDetails.mataKuliah', 'programStudi'])
            ->where('status', 1) // Filter active Kurikulums
            ->get()
            ->flatMap(function ($kurikulum) {
                return $kurikulum->kurikulumDetails->filter(function ($detail) {
                    // Skip if matakuliah is null
                    return $detail->matakuliah !== null;
                })->map(function ($detail) use ($kurikulum) {
                    $mataKuliah = $detail->matakuliah;

                    return [
                        'nama_kurikulum' => $kurikulum->nama_kurikulum,
                        'kode_mata_kuliah' => $mataKuliah->kode_matakuliah,
                        'nama_mata_kuliah' => $mataKuliah->nama_matakuliah,
                        'kode_prodi' => $kurikulum->programStudi->kode_program_studi,
                        'nama_prodi' => $kurikulum->programStudi->nama_program_studi,
                        'semester' => $kurikulum->semester_angka,
                        'wajib' => '1',
                    ];
                });
            });
    }

    /**
     * Define the headers for the Excel file.
     */
    public function headings(): array
    {
        return [
            'Nama Kurikulum',
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'Kode Prodi',
            'Nama Prodi',
            'Semester',
            'Wajib',
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
            'C' => 30,
            'D' => 20,
            'E' => 30,
            'F' => 10,
            'G' => 10,
        ];
    }

    /**
     * Register events for styling and other customizations.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Add comments to the heading
                $sheet->getComment('A1')->getText()->createTextRun('Nama Kurikulum');
                $sheet->getComment('B1')->getText()->createTextRun('Kode Mata Kuliah');
                $sheet->getComment('C1')->getText()->createTextRun('Nama Mata Kuliah');
                $sheet->getComment('D1')->getText()->createTextRun('Kode Prodi');
                $sheet->getComment('E1')->getText()->createTextRun('Nama Prodi');
                $sheet->getComment('F1')->getText()->createTextRun('Semester');
                $sheet->getComment('G1')->getText()->createTextRun('Wajib (Ya/Tidak)');

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
