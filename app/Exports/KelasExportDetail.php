<?php

namespace App\Exports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KelasExportDetail implements FromCollection, WithHeadings
{
    protected $kelasId;

    public function __construct($kelasId)
    {
        $this->kelasId = $kelasId;
    }

    /**
     * Return the collection of data to export.
     */
    public function collection()
    {
        // Fetch the Kelas model with its details and relations
        $kelas = Kelas::with('details.kurikulumDetail.matakuliah', 'details.hr')
            ->findOrFail($this->kelasId);

        // Map the data to prepare it for export
        $data = $kelas->details->map(function($detail) use ($kelas) {
            return [
                'Nama Kelas' => $kelas->nama_kelas,
                'Nama Program Studi' => $kelas->programStudi->nama_program_studi ?? 'N/A',
                'Nama Semester' => $kelas->semester->nama_semester ?? 'N/A',
                'Nama Kurikulum' => $kelas->kurikulum->nama_kurikulum ?? 'N/A',
                'Nama Mata Kuliah' => $detail->kurikulumDetail->matakuliah->nama_matakuliah ?? 'N/A',
                'Nama Dosen' => $detail->hr->nama ?? 'N/A',
                'Tatap Muka' => $detail->tatap_muka ?? 'N/A',
                'SKS Ajar' => $detail->sks_ajar ?? 'N/A',
                'Jenis Evaluasi' => $detail->jenis_evaluasi ?? 'N/A',
                'Lingkup Kelas' => $detail->lingkup_kelas ?? 'N/A',
                'Mode Kelas' => $detail->mode_kelas ?? 'N/A',
                'Aktivitas Partisipatif' => $detail->aktivitas_partisipatif ?? 'N/A',
                'Hasil Proyek' => $detail->hasil_proyek ?? 'N/A',
                'Tugas' => $detail->tugas ?? 'N/A',
                'Quiz' => $detail->quiz ?? 'N/A',
                'UTS' => $detail->uts ?? 'N/A',
                'UAS' => $detail->uas ?? 'N/A',
            ];
        });

        return $data;
    }

    /**
     * Headings for the export file.
     */
    public function headings(): array
    {
        return [
            'Nama Kelas',
            'Nama Program Studi',
            'Nama Semester',
            'Nama Kurikulum',
            'Nama Mata Kuliah',
            'Nama Dosen',
            'Tatap Muka',
            'SKS Ajar',
            'Jenis Evaluasi',
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
