<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use App\Models\MahasiswaWaliDetail;
use App\Models\MahasiswaWali;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithEvents;
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
            return Mahasiswa::with('mahasiswaDetail', 'programStudi', 'jurusan', 'ktp', 'mahasiswaWali') // Eager load relasi
                ->where('is_filled', 1)
                ->get()
                ->map(function ($mahasiswa) {

                    $walicollect = $mahasiswa->id;

                    $mahasiswaWali1 = MahasiswaWali::where('mahasiswa_id', $walicollect)
                        ->where('status_kewalian', 'AYAH')
                        ->first();

                    $mahasiswaWali2 = MahasiswaWali::where('mahasiswa_id', $walicollect)
                        ->where('status_kewalian', 'IBU')
                        ->first();

                    // get detail wali jika ada
                    $wali1Detail = $mahasiswaWali1 ? MahasiswaWaliDetail::where('mahasiswa_wali_id', $mahasiswaWali1->id)->latest()->first() : null;
                    $wali2Detail = $mahasiswaWali2 ? MahasiswaWaliDetail::where('mahasiswa_wali_id', $mahasiswaWali2->id)->latest()->first() : null;
                    // $wali2Detail = MahasiswaWaliDetail::where('mahasiswa_wali_id', $mahasiswaWali2->id)->latest()->first();

                    $formatRT_RW = function ($value) {
                        if (is_null($value) || $value === '' || $value == '0') {
                            return '';
                        }
                        return ltrim($value, '0');
                    };

                    return [
                        'nim' => $mahasiswa->nim . ' ',
                        'kode_prodi' => $mahasiswa->programStudi->kode_program_studi ?? '',
                        'nama_prodi' => $mahasiswa->programStudi->nama_program_studi ?? '',
                        'nama' => $mahasiswa->nama,
                        'lahir_tempat' => $mahasiswa->ktp->lahir_tempat ?? '',
                        'lahir_tgl' => $mahasiswa->ktp->lahir_tgl ?? '',
                        'jenis_kelamin' => $mahasiswa->ktp->jenis_kelamin ?? '',
                        'nik' => " " . ($mahasiswa->ktp->nik ?? ''),
                        'agama' => $mahasiswa->ktp->agama ?? '',
                        'nisn' => $mahasiswa->nisn,
                        'npwp' => $mahasiswa->npwp . ' ',
                        'kewarganegaraan' => $mahasiswa->ktp->kewarganegaraan ?? '',
                        'alamat_jalan' => $mahasiswa->ktp->alamat_jalan ?? '',
                        'alamat_rt' => $formatRT_RW($mahasiswa->ktp->alamat_rt),
                        'alamat_rw' => $formatRT_RW($mahasiswa->ktp->alamat_rw),
                        'alamat_kel_code' => $mahasiswa->ktp->village->name ?? '',
                        'alamat_kec_code' => $mahasiswa->ktp->alamat_kec_code ?? '',
                        'kode_pos' => $mahasiswa->mahasiswaDetail->kode_pos,
                        'jenis_tinggal' => $mahasiswa->jenis_tinggal ?? '',
                        'alat_transportasi' => $mahasiswa->alat_transportasi,
                        'telp_rumah' => $mahasiswa->mahasiswaDetail->telp_rumah,
                        'hp' => $mahasiswa->mahasiswaDetail->hp,
                        'email' => $mahasiswa->email,
                        'terima_kps' => $mahasiswa->terima_kps,
                        'no_kps' => $mahasiswa->no_kps == null ? 'Tidak ada' : $mahasiswa->no_kps,

                        // Ayah
                        'nik_wali1' => " " . ($mahasiswaWali1->ktp->nik ?? ''),
                        'nama_kontak_darurat1' => $mahasiswaWali1->nama ?? '',
                        'tgl_lahir_kontak_darurat1' => $mahasiswaWali1->ktp->lahir_tgl ?? '',
                        'pendidikan_kontak_darurat1' => $wali1Detail->pendidikan ?? '',
                        'pekerjaan_kontak_darurat1' => $wali1Detail->pekerjaan ?? '',
                        'penghasilan_kontak_darurat1' => $wali1Detail->penghasilan ?? '',
                        'kebutuhan_khusus_ayah' => $mahasiswaWali1->kebutuhan_khusus ?? '',

                        // Ibu
                        'nik_wali2' => " " . ($mahasiswaWali2->ktp->nik ?? ''),
                        'nama_kontak_darurat2' => $mahasiswaWali2->nama ?? '',
                        'tgl_lahir_kontak_darurat2' => $mahasiswaWali2->ktp->lahir_tgl ?? '',
                        'pendidikan_kontak_darurat2' => $wali2Detail->pendidikan ?? '',
                        'pekerjaan_kontak_darurat2' => $wali2Detail->pekerjaan ?? '',
                        'penghasilan_kontak_darurat2' => $wali2Detail->penghasilan ?? '',
                        'kebutuhan_khusus_ibu' => $mahasiswaWali2->kebutuhan_khusus ?? '',

                        //Wali
                        'nama_kontak_darurat' => $mahasiswa->nama_kontak_darurat ?? '',
                        'tgl_lahir_kontak_darurat' => $mahasiswa->tgl_lahir_kontak_darurat ?? '',
                        'pendidikan_kontak_darurat' => $mahasiswa->pendidikan_kontak_darurat ?? '',
                        'pekerjaan_kontak_darurat' => $mahasiswa->pekerjaan_kontak_darurat ?? '',
                        'penghasilan_kontak_darurat' => $mahasiswa->penghasilan_kontak_darurat ?? '',

                        'kebutuhan_khusus' => $mahasiswa->kebutuhan_khusus,
                    ];
                });
        } else {
            return Mahasiswa::with('mahasiswaDetail', 'programStudi', 'jurusan', 'ktp')
                ->get()
                ->map(function ($mahasiswa) {
                    return [
                        'nama' => $mahasiswa->nama,
                        'email' => $mahasiswa->email,
                        'jurusan_id' => $mahasiswa->jurusan_id == 1 ? 'DEFAULT' : $mahasiswa->jurusan_id,
                        'program_studi_id' => $mahasiswa->programStudi->nama_program_studi ?? '',
                        'registrasi_tanggal' => $mahasiswa->registrasi_tanggal,
                        'telp_rumah' => $mahasiswa->mahasiswaDetail->telp_rumah,
                        'hp' => $mahasiswa->mahasiswaDetail->hp,
                        'alamat_domisili' => $mahasiswa->mahasiswaDetail->alamat_domisili,
                        'kode_pos' => $mahasiswa->mahasiswaDetail->kode_pos,
                    ];
                });
        }
    }

    public function headings(): array
    {
        if ($this->dataLengkap) {
            return [
                'NIM',
                'Kode Prodi',
                'Nama Prodi',
                'Nama',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Jenis Kelamin',
                'NIK',
                'Agama',
                'NISN',
                'NPWP',
                'Kewarganegaraan',
                'Alamat Jalan',
                'RT',
                'RW',
                'Kelurahan',
                'Kecamatan',
                'Kode Pos',
                'Jenis Tinggal',
                'Alat Transportasi',
                'Telepon Rumah',
                'No HP',
                'Email',
                'Terima KPS',
                'No KPS',
                'NIK Ayah',
                'Nama Ayah',
                'Tanggal Lahir Ayah',
                'Pendidikan Ayah',
                'Pekerjaan Ayah',
                'Penghasilan Ayah',
                'Id Kebutuhan Ayah',
                'NIK Ibu',
                'Nama Ibu',
                'Tanggal Lahir Ibu',
                'Pendidikan Ibu',
                'Pekerjaan Ibu',
                'Penghasilan Ibu',
                'Id Kebutuhan Ibu',
                'Nama Wali',
                'Tanggal Lahir wali',
                'Pendidikan Wali',
                'Pekerjaan Wali',
                'Penghasilan Wali',
                'Id Kebutuhan Mahasiswa',
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

    public function columnWidths(): array
    {
        if ($this->dataLengkap) {
            return [
                'A' => 23,
                'B' => 23,
                'C' => 30,
                'D' => 30,
                'E' => 23,
                'F' => 23,
                'G' => 23,
                'H' => 23,
                'I' => 23,
                'J' => 23,
                'K' => 23,
                'L' => 23,
                'M' => 60,
                'N' => 23,
                'O' => 23,
                'P' => 23,
                'Q' => 23,
                'R' => 23,
                'S' => 23,
                'T' => 23,
                'U' => 23,
                'V' => 23,
                'W' => 23,
                'X' => 23,
                'Y' => 23,
                'Z' => 23,
                'AA' => 23,
                'AB' => 23,
                'AC' => 23,
                'AD' => 23,
                'AE' => 23,
                'AF' => 23,
                'AG' => 23,
                'AH' => 23,
                'AI' => 23,
                'AJ' => 23,
                'AK' => 23,
                'AL' => 23,
                'AM' => 23,
                'AN' => 23,
                'AO' => 30,
                'AP' => 23,
                'AQ' => 50,
                'AR' => 23,
                'AS' => 30,
                'AT' => 30,
            ];
        } else {
            return [
                'A' => 30,
                'B' => 30,
                'C' => 23,
                'D' => 30,
                'E' => 23,
                'F' => 23,
                'G' => 23,
                'H' => 49,
                'I' => 23,
            ];
        }
    }

    public function columnFormats(): array
    {
        if ($this->dataLengkap) {
            return [
                'A' => NumberFormat::FORMAT_TEXT,
                'B' => NumberFormat::FORMAT_TEXT,
                'C' => NumberFormat::FORMAT_TEXT,
                'D' => NumberFormat::FORMAT_TEXT,
                'E' => NumberFormat::FORMAT_TEXT,
                'F' => NumberFormat::FORMAT_DATE_YYYYMMDD,
                'G' => NumberFormat::FORMAT_TEXT,
                'H' => NumberFormat::FORMAT_TEXT,
                'I' => NumberFormat::FORMAT_NUMBER,
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
                'AA' => NumberFormat::FORMAT_TEXT,
                'AB' => NumberFormat::FORMAT_DATE_YYYYMMDD,
                'AC' => NumberFormat::FORMAT_TEXT,
                'AD' => NumberFormat::FORMAT_TEXT,
                'AE' => NumberFormat::FORMAT_TEXT,
                'AF' => NumberFormat::FORMAT_TEXT,
                'AG' => NumberFormat::FORMAT_DATE_YYYYMMDD,
                'AH' => NumberFormat::FORMAT_TEXT,
                'AI' => NumberFormat::FORMAT_TEXT,
                'AJ' => NumberFormat::FORMAT_TEXT,
                'AK' => NumberFormat::FORMAT_TEXT,
                'AL' => NumberFormat::FORMAT_TEXT,
                'AM' => NumberFormat::FORMAT_TEXT,
                'AN' => NumberFormat::FORMAT_TEXT,
                'AO' => NumberFormat::FORMAT_TEXT,
                'AP' => NumberFormat::FORMAT_TEXT,
                'AQ' => NumberFormat::FORMAT_TEXT,
                'AR' => NumberFormat::FORMAT_TEXT,
                'AS' => NumberFormat::FORMAT_TEXT,
                'AT' => NumberFormat::FORMAT_TEXT,
                'AU' => NumberFormat::FORMAT_TEXT,
                'AV' => NumberFormat::FORMAT_TEXT,
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


    public function registerEvents(): array
    {
        if ($this->dataLengkap) {
            return [
                AfterSheet::class => function (AfterSheet $event) {
                    $sheet = $event->sheet->getDelegate();

                    // Tambahkan komentar pada heading
                    $comment = $sheet->getComment('I1')->setWidth('200pt')->setHeight('100pt')->getText();
                    $comment->createTextRun('1 : Islam' . "\n");
                    $comment->createTextRun('2 : Kristen' . "\n");
                    $comment->createTextRun('3 : Katholik' . "\n");
                    $comment->createTextRun('4 : Hindu' . "\n");
                    $comment->createTextRun('5 : Budha' . "\n");
                    $comment->createTextRun('6 : Konghuchu' . "\n");
                    $comment->createTextRun('99 Lainnya');

                    $comment = $sheet->getComment('S1')->setWidth('200pt')->setHeight('100pt')->getText();
                    $comment->createTextRun('1 Bersama Orang Tua' . "\n");
                    $comment->createTextRun('2 Wali' . "\n");
                    $comment->createTextRun('3 Kost' . "\n");
                    $comment->createTextRun('4 Panti Asuhan' . "\n");
                    $comment->createTextRun('5 Rumah Sendiri' . "\n");
                    $comment->createTextRun('99 Lainnya');

                    $comment = $sheet->getComment('T1')->setWidth('200pt')->setHeight('190pt')->getText();
                    $comment->createTextRun('1 Jalan kaki' . "\n");
                    $comment->createTextRun('3 Angkutan umum/bus/pete-pete' . "\n");
                    $comment->createTextRun('4 Mobil/bus antar jemput' . "\n");
                    $comment->createTextRun('5 Kereta api' . "\n");
                    $comment->createTextRun('6 Ojek' . "\n");
                    $comment->createTextRun('7 Andong/bendi/sado/dokar/delman/becak' . "\n");
                    $comment->createTextRun('8 Perahu penyeberangan/rakit/getek' . "\n");
                    $comment->createTextRun('11 Kuda' . "\n");
                    $comment->createTextRun('12 Sepeda' . "\n");
                    $comment->createTextRun('13 Sepeda motor' . "\n");
                    $comment->createTextRun('14 Mobil pribadi' . "\n");
                    $comment->createTextRun('99 Lainnya');

                    $comment = $sheet->getComment('AC1')->setWidth('200pt')->setHeight('370pt')->getText();
                    $comment->createTextRun('0 Tidak sekolah' . "\n");
                    $comment->createTextRun('1 PAUD' . "\n");
                    $comment->createTextRun('2 TK / sederajat' . "\n");
                    $comment->createTextRun('3 Putus SD' . "\n");
                    $comment->createTextRun('4 SD / sederajat' . "\n");
                    $comment->createTextRun('5 SMP / sederajat' . "\n");
                    $comment->createTextRun('6 SMA / sederajat' . "\n");
                    $comment->createTextRun('7 Paket A' . "\n");
                    $comment->createTextRun('8 Paket B' . "\n");
                    $comment->createTextRun('9 Paket C' . "\n");
                    $comment->createTextRun('20 D1' . "\n");
                    $comment->createTextRun('21 D2' . "\n");
                    $comment->createTextRun('22 D3' . "\n");
                    $comment->createTextRun('23 D4' . "\n");
                    $comment->createTextRun('30 S1' . "\n");
                    $comment->createTextRun('31 Profesi' . "\n");
                    $comment->createTextRun('32 Sp-1' . "\n");
                    $comment->createTextRun('35 S2' . "\n");
                    $comment->createTextRun('36 S2 Terapan' . "\n");
                    $comment->createTextRun('37 Sp-2' . "\n");
                    $comment->createTextRun('40 S3' . "\n");
                    $comment->createTextRun('41 S3 Terapan' . "\n");
                    $comment->createTextRun('90 Non formal' . "\n");
                    $comment->createTextRun('91 Informal' . "\n");
                    $comment->createTextRun('99 Lainnya');

                    $comment = $sheet->getComment('AD1')->setWidth('200pt')->setHeight('290pt')->getText();
                    $comment->createTextRun('1 Tidak bekerja' . "\n");
                    $comment->createTextRun('2 Nelayan' . "\n");
                    $comment->createTextRun('3 Petani' . "\n");
                    $comment->createTextRun('4 Peternak' . "\n");
                    $comment->createTextRun('5 PNS/TNI/Polri' . "\n");
                    $comment->createTextRun('6 Karyawan Swasta' . "\n");
                    $comment->createTextRun('7 Pedagang Kecil' . "\n");
                    $comment->createTextRun('8 Pedagang Besar' . "\n");
                    $comment->createTextRun('9 Wiraswasta' . "\n");
                    $comment->createTextRun('10 Wirausaha' . "\n");
                    $comment->createTextRun('11 Buruh' . "\n");
                    $comment->createTextRun('12 Pensiunan' . "\n");
                    $comment->createTextRun('13 Peneliti' . "\n");
                    $comment->createTextRun('14 Tim Ahli / Konsultan' . "\n");
                    $comment->createTextRun('15 Magang' . "\n");
                    $comment->createTextRun('16 Tenaga Pengajar /Instruktur / Fasilitator' . "\n");
                    $comment->createTextRun('17 Pimpinan / Manajerial' . "\n");
                    $comment->createTextRun('90 Non formal' . "\n");
                    $comment->createTextRun('98 Sudah Meninggal' . "\n");
                    $comment->createTextRun('99 Lainnya');

                    $comment = $sheet->getComment('AE1')->setWidth('200pt')->setHeight('100pt')->getText();
                    $comment->createTextRun('11 Kurang dari Rp. 500,000' . "\n");
                    $comment->createTextRun('12 Rp. 500,000 - Rp. 999,999' . "\n");
                    $comment->createTextRun('13 Rp. 1,000,000 - Rp. 1,999,999' . "\n");
                    $comment->createTextRun('14 Rp. 2,000,000 - Rp. 4,999,999' . "\n");
                    $comment->createTextRun('15 Rp. 5,000,000 - Rp. 20,000,000' . "\n");
                    $comment->createTextRun('16 Lebih dari Rp. 20,000,000');

                    $comment = $sheet->getComment('AJ1')->setWidth('200pt')->setHeight('370pt')->getText();
                    $comment->createTextRun('0 Tidak sekolah' . "\n");
                    $comment->createTextRun('1 PAUD' . "\n");
                    $comment->createTextRun('2 TK / sederajat' . "\n");
                    $comment->createTextRun('3 Putus SD' . "\n");
                    $comment->createTextRun('4 SD / sederajat' . "\n");
                    $comment->createTextRun('5 SMP / sederajat' . "\n");
                    $comment->createTextRun('6 SMA / sederajat' . "\n");
                    $comment->createTextRun('7 Paket A' . "\n");
                    $comment->createTextRun('8 Paket B' . "\n");
                    $comment->createTextRun('9 Paket C' . "\n");
                    $comment->createTextRun('20 D1' . "\n");
                    $comment->createTextRun('21 D2' . "\n");
                    $comment->createTextRun('22 D3' . "\n");
                    $comment->createTextRun('23 D4' . "\n");
                    $comment->createTextRun('30 S1' . "\n");
                    $comment->createTextRun('31 Profesi' . "\n");
                    $comment->createTextRun('32 Sp-1' . "\n");
                    $comment->createTextRun('35 S2' . "\n");
                    $comment->createTextRun('36 S2 Terapan' . "\n");
                    $comment->createTextRun('37 Sp-2' . "\n");
                    $comment->createTextRun('40 S3' . "\n");
                    $comment->createTextRun('41 S3 Terapan' . "\n");
                    $comment->createTextRun('90 Non formal' . "\n");
                    $comment->createTextRun('91 Informal' . "\n");
                    $comment->createTextRun('99 Lainnya');

                    $comment = $sheet->getComment('AK1')->setWidth('200pt')->setHeight('290pt')->getText();
                    $comment->createTextRun('1 Tidak bekerja' . "\n");
                    $comment->createTextRun('2 Nelayan' . "\n");
                    $comment->createTextRun('3 Petani' . "\n");
                    $comment->createTextRun('4 Peternak' . "\n");
                    $comment->createTextRun('5 PNS/TNI/Polri' . "\n");
                    $comment->createTextRun('6 Karyawan Swasta' . "\n");
                    $comment->createTextRun('7 Pedagang Kecil' . "\n");
                    $comment->createTextRun('8 Pedagang Besar' . "\n");
                    $comment->createTextRun('9 Wiraswasta' . "\n");
                    $comment->createTextRun('10 Wirausaha' . "\n");
                    $comment->createTextRun('11 Buruh' . "\n");
                    $comment->createTextRun('12 Pensiunan' . "\n");
                    $comment->createTextRun('13 Peneliti' . "\n");
                    $comment->createTextRun('14 Tim Ahli / Konsultan' . "\n");
                    $comment->createTextRun('15 Magang' . "\n");
                    $comment->createTextRun('16 Tenaga Pengajar /Instruktur / Fasilitator' . "\n");
                    $comment->createTextRun('17 Pimpinan / Manajerial' . "\n");
                    $comment->createTextRun('90 Non formal' . "\n");
                    $comment->createTextRun('98 Sudah Meninggal' . "\n");
                    $comment->createTextRun('99 Lainnya');

                    $comment = $sheet->getComment('AL1')->setWidth('200pt')->setHeight('100pt')->getText();
                    $comment->createTextRun('11 Kurang dari Rp. 500,000' . "\n");
                    $comment->createTextRun('12 Rp. 500,000 - Rp. 999,999' . "\n");
                    $comment->createTextRun('13 Rp. 1,000,000 - Rp. 1,999,999' . "\n");
                    $comment->createTextRun('14 Rp. 2,000,000 - Rp. 4,999,999' . "\n");
                    $comment->createTextRun('15 Rp. 5,000,000 - Rp. 20,000,000' . "\n");
                    $comment->createTextRun('16 Lebih dari Rp. 20,000,000');

                    $comment = $sheet->getComment('AP1')->setWidth('200pt')->setHeight('370pt')->getText();
                    $comment->createTextRun('0 Tidak sekolah' . "\n");
                    $comment->createTextRun('1 PAUD' . "\n");
                    $comment->createTextRun('2 TK / sederajat' . "\n");
                    $comment->createTextRun('3 Putus SD' . "\n");
                    $comment->createTextRun('4 SD / sederajat' . "\n");
                    $comment->createTextRun('5 SMP / sederajat' . "\n");
                    $comment->createTextRun('6 SMA / sederajat' . "\n");
                    $comment->createTextRun('7 Paket A' . "\n");
                    $comment->createTextRun('8 Paket B' . "\n");
                    $comment->createTextRun('9 Paket C' . "\n");
                    $comment->createTextRun('20 D1' . "\n");
                    $comment->createTextRun('21 D2' . "\n");
                    $comment->createTextRun('22 D3' . "\n");
                    $comment->createTextRun('23 D4' . "\n");
                    $comment->createTextRun('30 S1' . "\n");
                    $comment->createTextRun('31 Profesi' . "\n");
                    $comment->createTextRun('32 Sp-1' . "\n");
                    $comment->createTextRun('35 S2' . "\n");
                    $comment->createTextRun('36 S2 Terapan' . "\n");
                    $comment->createTextRun('37 Sp-2' . "\n");
                    $comment->createTextRun('40 S3' . "\n");
                    $comment->createTextRun('41 S3 Terapan' . "\n");
                    $comment->createTextRun('90 Non formal' . "\n");
                    $comment->createTextRun('91 Informal' . "\n");
                    $comment->createTextRun('99 Lainnya');

                    $comment = $sheet->getComment('AQ1')->setWidth('200pt')->setHeight('290pt')->getText();
                    $comment->createTextRun('1 Tidak bekerja' . "\n");
                    $comment->createTextRun('2 Nelayan' . "\n");
                    $comment->createTextRun('3 Petani' . "\n");
                    $comment->createTextRun('4 Peternak' . "\n");
                    $comment->createTextRun('5 PNS/TNI/Polri' . "\n");
                    $comment->createTextRun('6 Karyawan Swasta' . "\n");
                    $comment->createTextRun('7 Pedagang Kecil' . "\n");
                    $comment->createTextRun('8 Pedagang Besar' . "\n");
                    $comment->createTextRun('9 Wiraswasta' . "\n");
                    $comment->createTextRun('10 Wirausaha' . "\n");
                    $comment->createTextRun('11 Buruh' . "\n");
                    $comment->createTextRun('12 Pensiunan' . "\n");
                    $comment->createTextRun('13 Peneliti' . "\n");
                    $comment->createTextRun('14 Tim Ahli / Konsultan' . "\n");
                    $comment->createTextRun('15 Magang' . "\n");
                    $comment->createTextRun('16 Tenaga Pengajar /Instruktur / Fasilitator' . "\n");
                    $comment->createTextRun('17 Pimpinan / Manajerial' . "\n");
                    $comment->createTextRun('90 Non formal' . "\n");
                    $comment->createTextRun('98 Sudah Meninggal' . "\n");
                    $comment->createTextRun('99 Lainnya');

                    $comment = $sheet->getComment('AR1')->setWidth('200pt')->setHeight('100pt')->getText();
                    $comment->createTextRun('11 Kurang dari Rp. 500,000' . "\n");
                    $comment->createTextRun('12 Rp. 500,000 - Rp. 999,999' . "\n");
                    $comment->createTextRun('13 Rp. 1,000,000 - Rp. 1,999,999' . "\n");
                    $comment->createTextRun('14 Rp. 2,000,000 - Rp. 4,999,999' . "\n");
                    $comment->createTextRun('15 Rp. 5,000,000 - Rp. 20,000,000' . "\n");
                    $comment->createTextRun('16 Lebih dari Rp. 20,000,000');

                    // Atur tinggi baris (row height)
                    $sheet->getRowDimension(1)->setRowHeight(23);

                    // Atur gaya huruf heading
                    $sheet->getStyle('A1:BB1')->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 12,
                        ],
                        'alignment' => [
                            'horizontal' => 'center',
                        ],
                    ]);

                    // Set the data font style
                    $sheet->getStyle('A2:BB' . $sheet->getHighestRow())->applyFromArray([
                        'alignment' => [
                            'horizontal' => 'left',
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

                    $sheet->getComment('E1')->setWidth('200pt')->getText()->createTextRun('Tanggal Registrasi Mahasiswa (Format : YYYY-MM-DD)');
                    $sheet->getComment('F1')->setWidth('200pt')->getText()->createTextRun('Telepon Rumah Mahasiswa');
                    $sheet->getComment('G1')->setWidth('200pt')->getText()->createTextRun('No HP Mahasiswa');
                    $sheet->getComment('H1')->setWidth('200pt')->getText()->createTextRun('Alamat Domisili Mahasiswa');
                    $sheet->getComment('I1')->setWidth('200pt')->getText()->createTextRun('Kode Pos Mahasiswa');

                    // Atur tinggi baris (row height)
                    $sheet->getRowDimension(1)->setRowHeight(23);

                    // Atur gaya huruf heading
                    $sheet->getStyle('A1:BB1')->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 12,
                        ],
                    ]);

                    // Set the data font style
                    $sheet->getStyle('A2:BB' . $sheet->getHighestRow())->applyFromArray([
                        'alignment' => [
                            'horizontal' => 'left',
                        ],
                    ]);
                }
            ];
        }
    }
}
