<?php

namespace App\Exports;

use App\Models\PembelajaranPlan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PembelajaranPlanExport implements FromCollection, WithHeadings, WithColumnWidths, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch the required data from the database
        return PembelajaranPlan::with(['matakuliah', 'programStudi', 'details'])
            ->get()
            ->flatMap(function ($pembelajaran) {
                return $pembelajaran->details->map(function ($detail) use ($pembelajaran) {
                    return [
                        'kode_mata_kuliah' => $pembelajaran->matakuliah->kode_matakuliah,
                        'nama_mata_kuliah' => $pembelajaran->matakuliah->nama_matakuliah,
                        'pertemuan' => $detail->pertemuan,
                        'materi_indonesia' => $detail->materi_indo,
                        'materi_inggris' => $detail->materi_eng,
                        'kode_prodi' => $pembelajaran->programStudi->kode_program_studi,
                        'nama_prodi' => $pembelajaran->programStudi->nama_program_studi,
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
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'Pertemuan',
            'Materi Indonesia',
            'Materi Inggris',
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
            'B' => 30,
            'C' => 15,
            'D' => 30,
            'E' => 30,
            'F' => 15,
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
                $sheet->getComment('A1')->getText()->createTextRun('Kode Mata Kuliah');
                $sheet->getComment('B1')->getText()->createTextRun('Nama Mata Kuliah');
                $sheet->getComment('C1')->getText()->createTextRun('Pertemuan');
                $sheet->getComment('D1')->getText()->createTextRun('Materi Indonesia');
                $sheet->getComment('E1')->getText()->createTextRun('Materi Inggris');
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
