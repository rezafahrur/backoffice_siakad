<?php

namespace App\Http\Controllers;

use App\Exports\EvaluasiPlanExport;
use App\Models\Matakuliah;
use App\Models\EvaluasiPlan;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\EvaluasiPlanDetail;
use Maatwebsite\Excel\Facades\Excel;

class EvaluasiPlanController extends Controller
{
    public function index()
    {
        $evaluasiPlans = EvaluasiPlan::with('matakuliah', 'programStudi')->get();
        return view('master.evaluasi-plan.index', compact('evaluasiPlans'));
    }

    public function export()
    {
        return Excel::download(new EvaluasiPlanExport, 'evaluasi_plan.xlsx');
    }

    public function create()
    {
        $matakuliah = Matakuliah::all();
        $programStudi = ProgramStudi::all();
        return view('master.evaluasi-plan.create', compact('matakuliah', 'programStudi'));
    }

    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'matakuliah_id' => 'required',
                'program_studi_id' => 'required',
                'details.*.jenis_evaluasi' => 'required',
                'details.*.nama_evaluasi' => 'nullable',
                'details.*.desc_indo' => 'required',
                'details.*.desc_eng' => 'nullable',
                'details.*.bobot' => 'required|numeric',
                'details.*.no_urut' => 'nullable|numeric',
            ]);

            $evaluasiPlan = EvaluasiPlan::create($validateData);

            foreach ($request->details as $detail) {
                EvaluasiPlanDetail::create([
                    'evaluasi_plan_id' => $evaluasiPlan->id,
                    'jenis_evaluasi' => $detail['jenis_evaluasi'],
                    'nama_evaluasi' => $detail['nama_evaluasi'],
                    'desc_indo' => $detail['desc_indo'],
                    'desc_eng' => $detail['desc_eng'],
                    'bobot' => $detail['bobot'],
                    'no_urut' => $detail['no_urut'],
                ]);
            }

            return redirect()->route('evaluasi_plan.index')->with('success', 'Evaluasi Plan created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function edit(EvaluasiPlan $evaluasiPlan)
    {
        $matakuliah = Matakuliah::all();
        $programStudi = ProgramStudi::all();
        return view('master.evaluasi-plan.edit', compact('evaluasiPlan', 'matakuliah', 'programStudi'));
    }

    public function update(Request $request, EvaluasiPlan $evaluasiPlan)
    {
        try {
            $validateData = $request->validate([
                'matakuliah_id' => 'required',
                'program_studi_id' => 'required',
                'details.*.jenis_evaluasi' => 'required',
                'details.*.nama_evaluasi' => 'nullable',
                'details.*.desc_indo' => 'required',
                'details.*.desc_eng' => 'nullable',
                'details.*.bobot' => 'required|numeric',
                'details.*.no_urut' => 'nullable|numeric',
            ]);

            $evaluasiPlan->update($validateData);
            $evaluasiPlan->details()->delete();

            // Update or create new details
            foreach ($request->details as $detail) {
                EvaluasiPlanDetail::updateOrCreate([
                    'evaluasi_plan_id' => $evaluasiPlan->id,
                    'jenis_evaluasi' => $detail['jenis_evaluasi'],
                    'nama_evaluasi' => $detail['nama_evaluasi'],
                    'desc_indo' => $detail['desc_indo'],
                    'desc_eng' => $detail['desc_eng'],
                    'bobot' => $detail['bobot'],
                    'no_urut' => $detail['no_urut'],
                ]);
            }

            return redirect()->route('evaluasi_plan.index')->with('success', 'Evaluasi Plan updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function show($id)
    {
        $evaluasiPlan = EvaluasiPlan::with('matakuliah', 'programStudi', 'details')->find($id);
        return view('master.evaluasi-plan.detail', compact('evaluasiPlan'));
    }

    public function destroy(EvaluasiPlan $evaluasiPlan)
    {
        $evaluasiPlan->delete();
        return redirect()->route('evaluasi_plan.index')->with('success', 'Evaluasi Plan deleted successfully.');
    }

    public function getProgramStudi($matakuliahId)
    {
        $matakuliah = Matakuliah::find($matakuliahId);

        if ($matakuliah && $matakuliah->programStudi) {
            return response()->json([$matakuliah->programStudi]);
        }

        return response()->json([]);
    }
}
