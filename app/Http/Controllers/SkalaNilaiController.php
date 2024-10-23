<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\SkalaNilai;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\SkalaNilaiDetail;

class SkalaNilaiController extends Controller
{
    public function index() {
        $skalaNilai = SkalaNilai::with(['semester', 'programStudi', 'skalaNilaiDetail'])->get();
        return view('perkuliahan.skala-nilai.index', compact('skalaNilai'));
    }


    public function create () {
        $semesters = Semester::all();
        $programStudis = ProgramStudi::all();
        return view('perkuliahan.skala-nilai.create', compact('semesters', 'programStudis'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'semester_id' => 'required',                      // Ensure semester_id is provided
            'program_studi_id' => 'required',                 // Ensure program_studi_id is provided
            'tgl_mulai_efektif' => 'required|date',           // Validate date for start
            'tgl_akhir_efektif' => 'required|date',           // Validate date for end
            'details' => 'nullable|array',                    // Ensure the details array is present
            'details.*.bobot_minimum' => 'required|numeric',   // Each detail's bobot_minimum must be a number
            'details.*.bobot_maksimum' => 'required|numeric',  // Each detail's bobot_maksimum must be a number
            'details.*.nilai_huruf' => 'required|alpha|size:1',// Each detail's nilai_huruf should be a single letter
            'details.*.nilai_indeks' => 'required|numeric',   // Each detail's nilai_indeks should be numeric
        ], [
            'nilai_huruf.size' => 'Nilai huruf harus berupa satu huruf.',
            'nilai_huruf.alpha' => 'Nilai huruf harus berupa huruf alfabet.',
        ]);

        try {
            // Create the main SkalaNilai record
            $skalaNilai = SkalaNilai::create([
                'semester_id' => $validatedData['semester_id'],
                'program_studi_id' => $validatedData['program_studi_id'],
                'tgl_mulai_efektif' => $validatedData['tgl_mulai_efektif'],
                'tgl_akhir_efektif' => $validatedData['tgl_akhir_efektif'],
            ]);

            // Iterate through each detail and create SkalaNilaiDetail records
            foreach ($validatedData['details'] as $detail) {
                SkalaNilaiDetail::create([
                    'skala_nilai_id' => $skalaNilai->id,          // Link to the created SkalaNilai
                    'bobot_minimum' => $detail['bobot_minimum'],  // Set bobot_minimum for this detail
                    'bobot_maksimum' => $detail['bobot_maksimum'],// Set bobot_maksimum for this detail
                    'nilai_huruf' => $detail['nilai_huruf'],      // Set nilai_huruf for this detail
                    'nilai_indeks' => $detail['nilai_indeks'],    // Set nilai_indeks for this detail
                ]);
            }

            // Redirect to the index route with success message
            return redirect()->route('skala-nilai.index')->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            // Handle any errors and redirect back with an error message
            return redirect()->back()->with('error', 'Data gagal disimpan: ' . $e->getMessage());
        }
    }





    public function show ($id) {
        $skalaNilai = SkalaNilai::with('semester', 'programStudi')->find($id);
        return view('perkuliahan.skala-nilai.show', compact('skalaNilai'));
    }

    public function edit ($id) {
        $semesters = Semester::all();
        $programStudis = ProgramStudi::all();
        $skalaNilai = SkalaNilai::find($id);
        return view('perkuliahan.skala-nilai.edit', compact('semesters', 'programStudis', 'skalaNilai'));
    }

    public function update(Request $request, $id)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'semester_id' => 'required',
        'program_studi_id' => 'required',
        'tgl_mulai_efektif' => 'required|date',
        'tgl_akhir_efektif' => 'required|date',
        'details' => 'nullable|array', // Make details nullable
        'details.*.id' => 'nullable|exists:t_skala_nilai_detail,id',
        'details.*.bobot_minimum' => 'required_with:details.*|numeric',
        'details.*.bobot_maksimum' => 'required_with:details.*|numeric',
        'details.*.nilai_huruf' => 'required_with:details.*|alpha|size:1',
        'details.*.nilai_indeks' => 'required_with:details.*|numeric',
    ], [
        'details.*.nilai_huruf.size' => 'Nilai huruf harus berupa satu huruf.',
        'details.*.nilai_huruf.alpha' => 'Nilai huruf harus berupa huruf alfabet.',
    ]);

    try {
        // Find the SkalaNilai record by its ID
        $skalaNilai = SkalaNilai::findOrFail($id);

        // Update SkalaNilai data
        $skalaNilai->update([
            'semester_id' => $validatedData['semester_id'],
            'program_studi_id' => $validatedData['program_studi_id'],
            'tgl_mulai_efektif' => $validatedData['tgl_mulai_efektif'],
            'tgl_akhir_efektif' => $validatedData['tgl_akhir_efektif'],
        ]);

        // Initialize details to an empty array if not set
        $details = $validatedData['details'] ?? [];

        // Loop through the details and update or create as necessary
        foreach ($details as $detail) {
            if (isset($detail['id'])) {
                // Update existing detail
                $skalaNilaiDetail = SkalaNilaiDetail::find($detail['id']);

                if ($skalaNilaiDetail) {
                    $skalaNilaiDetail->update([
                        'bobot_minimum' => $detail['bobot_minimum'],
                        'bobot_maksimum' => $detail['bobot_maksimum'],
                        'nilai_huruf' => $detail['nilai_huruf'],
                        'nilai_indeks' => $detail['nilai_indeks'],
                    ]);
                }
            } else {
                // Create a new detail record
                SkalaNilaiDetail::create([
                    'skala_nilai_id' => $skalaNilai->id,
                    'bobot_minimum' => $detail['bobot_minimum'],
                    'bobot_maksimum' => $detail['bobot_maksimum'],
                    'nilai_huruf' => $detail['nilai_huruf'],
                    'nilai_indeks' => $detail['nilai_indeks'],
                ]);
            }
        }

        return redirect()->route('skala-nilai.index')->with('success', 'Data berhasil diupdate');
    } catch (\Exception $e) {
        return redirect()->route('skala-nilai.index')->with('error', 'Data gagal diupdate: ' . $e->getMessage());
    }
}







    public function destroy ($id) {
        try {
            SkalaNilai::find($id)->delete();
            return redirect()->route('skala-nilai.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('skala-nilai.index')->with('error', 'Data gagal dihapus');
        }
    }


}
