<?php

namespace App\Imports;

use App\Models\NilaiDetail;
use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\Krs;
use App\Models\Kelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;

class NilaiImport implements ToCollection
{
    protected $programStudiId;
    protected $kelasId;
    protected $matakuliahId;

    public function __construct($programStudiId, $kelasId, $matakuliahId)
    {
        $this->programStudiId = $programStudiId;
        $this->kelasId = $kelasId;
        $this->matakuliahId = $matakuliahId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // Lewati header

            // Cari mahasiswa berdasarkan NIM
            $mahasiswa = Mahasiswa::where('nim', $row[0])->first();

            if ($mahasiswa) {
                // Validasi apakah mahasiswa terdaftar di KRS dengan kurikulum yang sama dengan kelas yang dipilih
                $isValid = Krs::where('mahasiswa_id', $mahasiswa->id)
                    ->whereHas('kurikulum', function ($query) {
                        $query->whereHas('kelas', function ($subQuery) {
                            $subQuery->where('id', $this->kelasId)
                                ->where('program_studi_id', $this->programStudiId);
                        });
                    })
                    ->exists();

                if ($isValid) {
                    // Jika valid, tambahkan data nilai
                    NilaiDetail::create([
                        'nilai_id' => $this->getNilaiId(),
                        'mahasiswa_id' => $mahasiswa->id,
                        'hasil_proyek' => $row[2],
                        'quiz' => $row[3],
                        'tugas' => $row[4],
                        'uts' => $row[5],
                        'uas' => $row[6],
                        'aktivitas_partisipatif' => $row[7],
                        'nilai_angka' => $row[8],
                        'nilai_huruf' => $this->calculateGrade($row[8]),
                        'nilai_indeks' => $this->calculateIndex($row[8]),
                    ]);
                } else {
                    Log::warning("Mahasiswa dengan NIM {$row[0]} tidak terdaftar di kelas atau kurikulum yang sesuai.");
                }
            } else {
                Log::warning("Mahasiswa dengan NIM {$row[0]} tidak ditemukan di database.");
            }
        }
    }

    private function getNilaiId()
    {
        return Nilai::firstOrCreate([
            'program_studi_id' => $this->programStudiId,
            'kelas_id' => $this->kelasId,
            'matakuliah_id' => $this->matakuliahId,
        ])->id;
    }

    private function calculateGrade($nilaiAngka)
    {
        if ($nilaiAngka >= 85) return 'A';
        if ($nilaiAngka >= 80) return 'A-';
        if ($nilaiAngka >= 75) return 'B+';
        if ($nilaiAngka >= 70) return 'B';
        if ($nilaiAngka >= 65) return 'B-';
        if ($nilaiAngka >= 60) return 'C+';
        if ($nilaiAngka >= 55) return 'C';
        if ($nilaiAngka >= 50) return 'D';
        return 'E';
    }

    private function calculateIndex($nilaiAngka)
    {
        if ($nilaiAngka >= 85) return 4.00;
        if ($nilaiAngka >= 80) return 3.70;
        if ($nilaiAngka >= 75) return 3.30;
        if ($nilaiAngka >= 70) return 3.00;
        if ($nilaiAngka >= 65) return 2.70;
        if ($nilaiAngka >= 60) return 2.30;
        if ($nilaiAngka >= 55) return 2.00;
        if ($nilaiAngka >= 50) return 1.00;
        return 0.00;
    }
}


