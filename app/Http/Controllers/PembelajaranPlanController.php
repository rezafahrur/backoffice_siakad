<?php

namespace App\Http\Controllers;

use App\Models\PembelajaranPlan;
use App\Models\PembelajaranPlanDetail;
use App\Models\Matakuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class PembelajaranPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = PembelajaranPlan::with('matakuliah', 'programStudi')->get();
        return view('master.learn-plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $matakuliah = Matakuliah::all();
        $programStudi = ProgramStudi::all();
        return view('master.learn-plan.create', compact('matakuliah', 'programStudi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'matakuliah_id' => 'required',
                'program_studi_id' => 'required',
                'details.*.pertemuan' => 'required',
                'details.*.materi_indo' => 'nullable',
                'details.*.materi_eng' => 'nullable',
            ]);

            $pembelajaranPlan = PembelajaranPlan::create($validatedData);

            foreach ($request->details as $detail) {
                PembelajaranPlanDetail::create([
                    'pembelajaran_plan_id' => $pembelajaranPlan->id,
                    'pertemuan' => $detail['pertemuan'],
                    'materi_indo' => $detail['materi_indo'],
                    'materi_eng' => $detail['materi_eng'],
                ]);
            }

            return redirect()->route('pembelajaran_plans.index')->with('success', 'Rencana Pembelajaran berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PembelajaranPlan $pembelajaranPlan)
    {
        $matakuliah = Matakuliah::all();
        $programStudi = ProgramStudi::all();
        return view('master.learn-plan.edit', compact('pembelajaranPlan', 'matakuliah', 'programStudi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PembelajaranPlan $pembelajaranPlan)
    {
        try {
            $validatedData = $request->validate([
                'matakuliah_id' => 'required',
                'program_studi_id' => 'required',
                'details.*.pertemuan' => 'required',
                'details.*.materi_indo' => 'nullable',
                'details.*.materi_eng' => 'nullable',
            ]);

            $pembelajaranPlan->update($validatedData);
            $pembelajaranPlan->details()->delete();

            foreach ($request->details as $detail) {
                PembelajaranPlanDetail::create([
                    'pembelajaran_plan_id' => $pembelajaranPlan->id,
                    'pertemuan' => $detail['pertemuan'],
                    'materi_indo' => $detail['materi_indo'],
                    'materi_eng' => $detail['materi_eng'],
                ]);
            }

            return redirect()->route('pembelajaran_plans.index')->with('success', 'Rencana Pembelajaran berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // show
    public function show($id)
    {
        $pembelajaranPlan = PembelajaranPlan::with('matakuliah', 'programStudi', 'details')->findOrFail($id);
        return view('master.learn-plan.detail', compact('pembelajaranPlan'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PembelajaranPlan $pembelajaranPlan)
    {
        $pembelajaranPlan->delete();
        return redirect()->route('pembelajaran_plans.index');
    }

    public function getProgramStudi($matakuliahId)
    {
        $matakuliah = MataKuliah::find($matakuliahId);

        // Check if the Matakuliah exists and has a related Program Studi
        if ($matakuliah && $matakuliah->programStudi) {
            return response()->json([$matakuliah->programStudi]);
        }

        // Return an empty array if no Program Studi is found
        return response()->json([]);
    }
}
