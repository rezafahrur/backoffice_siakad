<?php

namespace App\Exports;

use App\Models\EvaluasiPlan; // Pastikan Anda menggunakan model EvaluasiPlan
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class EvaluasiPlanExport implements FromCollection, WithHeadings, WithColumnWidths, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch the required data from EvaluasiPlan model
        return EvaluasiPlan::with(['matakuliah', 'programStudi', 'details'])
            ->get()
            ->flatMap(function ($evaluasi) {
                return $evaluasi->details->map(function ($detail) use ($evaluasi) {
                    return [
                        'kode_mata_kuliah' => $evaluasi->matakuliah->kode_matakuliah,
                        'nama_mata_kuliah' => $evaluasi->matakuliah->nama_matakuliah,
                        'jenis_evaluasi' => $detail->jenis_evaluasi,
                        'nama_evaluasi' => $detail->nama_evaluasi,
                        'deskripsi_indonesia' => $detail->desc_indo,
                        'deskripsi_inggris' => $detail->desc_eng,
                        'bobot' => $detail->bobot,
                        'nomor_urut' => $detail->no_urut,
                        'kode_prodi' => $evaluasi->programStudi->kode_program_studi,
                        'nama_prodi' => $evaluasi->programStudi->nama_program_studi,
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
            'Jenis Evaluasi',
            'Nama Evaluasi',
            'Deskripsi Indonesia',
            'Deskripsi Inggris',
            'Bobot',
            'Nomor Urut',
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
            'C' => 20,
            'D' => 30,
            'E' => 40,
            'F' => 40,
            'G' => 15,
            'H' => 15,
            'I' => 20,
            'J' => 30,
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
                $sheet->getComment('C1')->getText()->createTextRun('Jenis Evaluasi');
                $sheet->getComment('D1')->getText()->createTextRun('Nama Evaluasi');
                $sheet->getComment('E1')->getText()->createTextRun('Deskripsi Indonesia');
                $sheet->getComment('F1')->getText()->createTextRun('Deskripsi Inggris');
                $sheet->getComment('G1')->getText()->createTextRun('Bobot');
                $sheet->getComment('H1')->getText()->createTextRun('Nomor Urut');
                $sheet->getComment('I1')->getText()->createTextRun('Kode Prodi');
                $sheet->getComment('J1')->getText()->createTextRun('Nama Prodi');

                // Set the row height
                $sheet->getRowDimension(1)->setRowHeight(20);

                // Set the heading font style
                $sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                ]);
            }
        ];
    }
}
