<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Requests\NilaiRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nilais = Nilai::with(['programStudi', 'kelas', 'matakuliah'])->get();

        return view('master.nilai.index', compact('nilais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programStudi = ProgramStudi::all();
        // $kelas = Kelas::all();
        // $matakuliah = collect();
        return view('master.nilai.create', compact('programStudi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NilaiRequest $request)
{
    try {
        // Buat record nilai utama
        $nilai = Nilai::create($request->validated());

        // Loop melalui setiap detail nilai yang diinputkan
        foreach ($request->details as $detail) {
            // Hitung rata-rata dari hasil_proyek, quiz, tugas, uts, uas, dan aktivitas_partisipatif
            $average = (
                $detail['hasil_proyek'] +
                $detail['quiz'] +
                $detail['tugas'] +
                $detail['uts'] +
                $detail['uas'] +
                $detail['aktivitas_partisipatif']
            ) / 6;

            // Tentukan nilai huruf dan nilai indeks berdasarkan rata-rata
            if ($average >= 85 && $average <= 100) {
                $detail['nilai_huruf'] = 'A';
                $detail['nilai_indeks'] = 4.00;
            } elseif ($average >= 80 && $average < 85) {
                $detail['nilai_huruf'] = 'A-';
                $detail['nilai_indeks'] = 3.70;
            } elseif ($average >= 75 && $average < 80) {
                $detail['nilai_huruf'] = 'B+';
                $detail['nilai_indeks'] = 3.30;
            } elseif ($average >= 70 && $average < 75) {
                $detail['nilai_huruf'] = 'B';
                $detail['nilai_indeks'] = 3.00;
            } elseif ($average >= 65 && $average < 70) {
                $detail['nilai_huruf'] = 'B-';
                $detail['nilai_indeks'] = 2.70;
            } elseif ($average >= 60 && $average < 65) {
                $detail['nilai_huruf'] = 'C+';
                $detail['nilai_indeks'] = 2.30;
            } elseif ($average >= 55 && $average < 60) {
                $detail['nilai_huruf'] = 'C';
                $detail['nilai_indeks'] = 2.00;
            } elseif ($average >= 50 && $average < 55) {
                $detail['nilai_huruf'] = 'D';
                $detail['nilai_indeks'] = 1.00;
            } else {
                $detail['nilai_huruf'] = 'E';
                $detail['nilai_indeks'] = 0.00;
            }

            // Simpan rata-rata sebagai nilai angka
            // $detail['nilai_angka'] = $average;

            // Simpan detail nilai ke database
            $nilai->details()->create($detail);
        }

        // Redirect ke halaman index nilai dengan pesan sukses
        return redirect()->route('nilai.index')->with('success', 'Data berhasil disimpan');
    } catch (\Exception $e) {
        // Jika terjadi error, redirect kembali dengan input dan pesan error
        return redirect()->back()->withInput()->with([
            'error' => $e->getMessage(),
            'toast_message' => 'Data Gagal Disimpan',
        ]);
    }
}

    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $nilai = Nilai::with(['programStudi', 'kelas', 'matakuliah', 'details'])->findOrFail($id);

        return view('master.nilai.detail', compact('nilai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $nilai = Nilai::with(['programStudi', 'kelas', 'matakuliah', 'details'])->findOrFail($id);

        return view('master.nilai.edit', compact('nilai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NilaiRequest $request, Nilai $nilai)
    {
        try {
            // Update data utama
            $nilai->update($request->validated());
    
            // Loop setiap detail nilai yang diinputkan
            foreach ($request->details as $detail) {
                // Hitung rata-rata dari hasil_proyek, quiz, tugas, uts, uas, dan aktivitas_partisipatif
                $average = (
                    $detail['hasil_proyek'] +
                    $detail['quiz'] +
                    $detail['tugas'] +
                    $detail['uts'] +
                    $detail['uas'] +
                    $detail['aktivitas_partisipatif']
                ) / 6;
    
                // Tentukan nilai huruf dan nilai indeks berdasarkan rata-rata
                if ($average >= 85 && $average <= 100) {
                    $detail['nilai_huruf'] = 'A';
                    $detail['nilai_indeks'] = 4.00;
                } elseif ($average >= 80 && $average < 85) {
                    $detail['nilai_huruf'] = 'A-';
                    $detail['nilai_indeks'] = 3.70;
                } elseif ($average >= 75 && $average < 80) {
                    $detail['nilai_huruf'] = 'B+';
                    $detail['nilai_indeks'] = 3.30;
                } elseif ($average >= 70 && $average < 75) {
                    $detail['nilai_huruf'] = 'B';
                    $detail['nilai_indeks'] = 3.00;
                } elseif ($average >= 65 && $average < 70) {
                    $detail['nilai_huruf'] = 'B-';
                    $detail['nilai_indeks'] = 2.70;
                } elseif ($average >= 60 && $average < 65) {
                    $detail['nilai_huruf'] = 'C+';
                    $detail['nilai_indeks'] = 2.30;
                } elseif ($average >= 55 && $average < 60) {
                    $detail['nilai_huruf'] = 'C';
                    $detail['nilai_indeks'] = 2.00;
                } elseif ($average >= 50 && $average < 55) {
                    $detail['nilai_huruf'] = 'D';
                    $detail['nilai_indeks'] = 1.00;
                } else {
                    $detail['nilai_huruf'] = 'E';
                    $detail['nilai_indeks'] = 0.00;
                }
    
                // Simpan rata-rata sebagai nilai angka
                // $detail['nilai_angka'] = $average;
    
                // Update atau buat detail nilai berdasarkan mahasiswa_id
                $nilai->details()->updateOrCreate(
                    ['mahasiswa_id' => $detail['mahasiswa_id']], // Kondisi untuk update
                    $detail // Data yang akan disimpan
                );
            }
    
            // Redirect ke halaman index nilai dengan pesan sukses
            return redirect()->route('nilai.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            // Jika terjadi error, redirect kembali dengan input dan pesan error
            return redirect()->back()->withInput()->with([
                'error' => $e->getMessage(),
                'toast_message' => 'Data Gagal Diperbarui',
            ]);
        }
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nilai $nilai)
    {
        try {
            if ($nilai->details) {
                foreach ($nilai->details as $detail) {
                    $detail->delete();
                }
            }

            $nilai->delete();

            return redirect()->route('nilai.index')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error', $e->getMessage(),
                'toast_message' => 'Data Gagal Dihapus',
            ]);
        }
    }

    public function getKelasMataKuliah($programStudiId)
    {
        $kelas = Kelas::where('program_studi_id', $programStudiId)->get();

        // get matakuliah from kelas details to kurikulum details to matakuliah
        $matakuliah = collect();
        foreach ($kelas as $k) {
            $matakuliah = $matakuliah->merge($k->details->pluck('kurikulumDetail.matakuliah'));
        }

        // remove duplicate matakuliah
        $matakuliah = $matakuliah->unique('id');

        return response()->json([
            'kelas' => $kelas,
            'matakuliah' => $matakuliah
        ]);
    }

    public function getMahasiswaByKelas($kelasId)
    {
        $mahasiswas = Krs::with('mahasiswa')->where('kelas_id', $kelasId)->get()->pluck('mahasiswa');
        return response()->json($mahasiswas);
    }

    public function cetakPdf($id)
{
    $nilai = Nilai::with(['programStudi', 'kelas', 'matakuliah', 'details'])->findOrFail($id);

    // Buat PDF menggunakan view yang sama atau view khusus untuk PDF
    $pdf = PDF::loadView('master.nilai.pdf', compact('nilai'));

    // Kembalikan response untuk download PDF
    return $pdf->download('nilai-mahasiswa' . $nilai->id . '.pdf');
}

}
