<?php

namespace App\Exports;

use App\Models\Jurusan;
use App\Models\ProgramStudi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class MahasiswaExport implements FromCollection, WithHeadings, WithColumnWidths, WithColumnFormatting, WithEvents
{
    protected $dataLengkap;

    public function __construct($dataLengkap)
    {
        $this->dataLengkap = $dataLengkap;
    }

    public function collection()
    {
        if ($this->dataLengkap) {
            // Kembalikan collection dengan data lengkap
            return collect([
                // Ganti dengan data mahasiswa lengkap
            ]);
        } else {
            // Kembalikan collection dengan data tidak lengkap
            return collect([
                // Ganti dengan data mahasiswa tidak lengkap
            ]);
        }
    }

    public function headings(): array
    {
        if ($this->dataLengkap) {
            return [
                'NIM',
                'Nama',
                'Email',
                'NISN',
                'Jurusan',
                'Program Studi',
                'Tanggal Registrasi',
                'Status',
                'Semester Berjalan',
                'Telepon Rumah',
                'No HP',
                'Alamat Domisili',
                'Kode Pos',
                'NPWP',
                'Jenis Tinggal',
                'Alat Transportasi',
                'Terima KPS',
                'No KPS',
                'Kebutuhan Khusus Mahasiswa',
                'Is Filled',
                'NIK',
                'Alamat Jalan',
                'Alamat RT',
                'Alamat RW',
                'Alamat Prov Code',
                'Alamat Kotakab Code',
                'Alamat Kec Code',
                'Alamat Kel Code',
                'Lahir Tempat',
                'Lahir Tgl',
                'Jenis Kelamin',
                'Agama',
                'Golongan Darah',
                'Kewarganegaraan',
                // Lanjutkan untuk kolom lainnya...
            ];
        } else {
            return [
                'Nama',
                'Email',
                'Jurusan Id',
                'Program Studi Id',
                'Registrasi Tanggal',
                'Telepon Rumah',
                'No Hp',
                'Alamat Domisili',
                'Kode Pos',
            ];
        }
    }

    // 1. Mengatur lebar kolom
    public function columnWidths(): array
    {
        if ($this->dataLengkap) {
            return [
                'A' => 20,
                'B' => 30,
                'C' => 30,
                'D' => 20,
                'E' => 20,
                'F' => 30,
                'G' => 20,
                'H' => 20,
                'I' => 20,
                'J' => 20,
                'K' => 20,
                'L' => 30,
                'M' => 20,
                'N' => 20,
                'O' => 20,
                'P' => 20,
                'Q' => 20,
                'R' => 20,
                'S' => 30,
                'T' => 20,
                'U' => 20,
                'V' => 20,
                'W' => 20,
                'X' => 20,
                'Y' => 20,
                'Z' => 20,
                // Lanjutkan untuk kolom lainnya...
            ];
        } else {
            return [
                'A' => 30,
                'B' => 30,
                'C' => 20,
                'D' => 20,
                'E' => 20,
                'F' => 20,
                'G' => 20,
                'H' => 30,
                'I' => 20,
            ];
        }
    }

    // 2. Format kolom tanggal
    public function columnFormats(): array
    {
        if ($this->dataLengkap) {
            return [
                'A' => NumberFormat::FORMAT_TEXT,
                'B' => NumberFormat::FORMAT_TEXT,
                'C' => NumberFormat::FORMAT_TEXT,
                'D' => NumberFormat::FORMAT_TEXT,
                'E' => NumberFormat::FORMAT_TEXT,
                'F' => NumberFormat::FORMAT_TEXT,
                'G' => NumberFormat::FORMAT_DATE_YYYYMMDD,
                'H' => NumberFormat::FORMAT_TEXT,
                'I' => NumberFormat::FORMAT_TEXT,
                'J' => NumberFormat::FORMAT_TEXT,
                'K' => NumberFormat::FORMAT_TEXT,
                'L' => NumberFormat::FORMAT_TEXT,
                'M' => NumberFormat::FORMAT_TEXT,
                'N' => NumberFormat::FORMAT_TEXT,
                'O' => NumberFormat::FORMAT_TEXT,
                'P' => NumberFormat::FORMAT_TEXT,
                'Q' => NumberFormat::FORMAT_TEXT,
                'R' => NumberFormat::FORMAT_TEXT,
                'S' => NumberFormat::FORMAT_TEXT,
                'T' => NumberFormat::FORMAT_TEXT,
                'U' => NumberFormat::FORMAT_TEXT,
                'V' => NumberFormat::FORMAT_TEXT,
                'W' => NumberFormat::FORMAT_TEXT,
                'X' => NumberFormat::FORMAT_TEXT,
                'Y' => NumberFormat::FORMAT_TEXT,
                'Z' => NumberFormat::FORMAT_TEXT,
                // Lanjutkan untuk kolom lainnya...
            ];
        } else {
            return [
                'A' => NumberFormat::FORMAT_TEXT,
                'B' => NumberFormat::FORMAT_TEXT,
                'C' => NumberFormat::FORMAT_TEXT,
                'D' => NumberFormat::FORMAT_TEXT,
                'E' => NumberFormat::FORMAT_DATE_YYYYMMDD,
                'F' => NumberFormat::FORMAT_TEXT,
                'G' => NumberFormat::FORMAT_TEXT,
                'H' => NumberFormat::FORMAT_TEXT,
                'I' => NumberFormat::FORMAT_TEXT,
            ];
        }
    }

    // 3. Tambahkan catatan menggunakan WithEvents
    public function registerEvents(): array
    {
        if ($this->dataLengkap) {
            return [
                AfterSheet::class => function (AfterSheet $event) {
                    $sheet = $event->sheet->getDelegate();

                    // Tambahkan komentar pada heading
                    $sheet->getComment('A1')->getText()->createTextRun('NIM Mahasiswa');
                    $sheet->getComment('B1')->getText()->createTextRun('Nama Lengkap Mahasiswa');

                    // Atur tinggi baris (row height)
                    $sheet->getRowDimension(1)->setRowHeight(20);

                    // Atur gaya huruf heading
                    $sheet->getStyle('A1:Z1')->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 12,
                        ],
                    ]);
                }
            ];
        } else {
            return [
                AfterSheet::class => function (AfterSheet $event) {
                    $sheet = $event->sheet->getDelegate();

                    // Tambahkan komentar pada heading
                    $sheet->getComment('A1')->setWidth('200pt')->getText()->createTextRun('Nama Mahasiswa');

                    $sheet->getComment('B1')->setWidth('200pt')->getText()->createTextRun('Email Mahasiswa (Tidak boleh sama)');

                    $jurusan = Jurusan::all();
                    $jurusanDescription = 'Jurusan yang tersedia : ' . "\n";
                    foreach ($jurusan as $j) {
                        $jurusanDescription .= $j->id . ' - ' . $j->nama_jurusan . "\n";
                    }
                    $sheet->getComment('C1')->setWidth('200pt')->getText()->createTextRun($jurusanDescription);

                    $prodi = ProgramStudi::all();
                    $prodiDescription = 'Program Studi yang tersedia : ' . "\n";
                    foreach ($prodi as $p) {
                        $prodiDescription .= $p->id . ' - ' . $p->nama_program_studi . "\n";
                    }
                    $sheet->getComment('D1')->setWidth('200pt')->setHeight('100pt')->getText()->createTextRun($prodiDescription);

                    $sheet->getComment('E1')->setWidth('200pt')->getText()->createTextRun('Tanggal Registrasi Mahasiswa (Format : YYYY-MM-DD)');
                    $sheet->getComment('F1')->setWidth('200pt')->getText()->createTextRun('Telepon Rumah Mahasiswa');
                    $sheet->getComment('G1')->setWidth('200pt')->getText()->createTextRun('No HP Mahasiswa');
                    $sheet->getComment('H1')->setWidth('200pt')->getText()->createTextRun('Alamat Domisili Mahasiswa');
                    $sheet->getComment('I1')->setWidth('200pt')->getText()->createTextRun('Kode Pos Mahasiswa');

                    // Atur tinggi baris (row height)
                    $sheet->getRowDimension(1)->setRowHeight(20);

                    // Atur gaya huruf heading
                    $sheet->getStyle('A1:I1')->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 12,
                        ],
                    ]);
                }
            ];
        }
    }
}
