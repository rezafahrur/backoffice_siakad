<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Semester;

class ConfigController extends Controller
{
    // Show the form with configurations
    public function index()
    {
        // Fetch all configs
        $configs = Config::all();

        // Get all active semesters
        $semesters = Semester::pluck('nama_semester', 'kode_semester');

        return view('feature.config.index', compact('configs', 'semesters'));
    }

    // Update configurations
    public function update(Request $request)
    {
        // Loop through the configuration keys
        foreach ($request->except('_token') as $key => $value) {
            Config::where('key', $key)->update(['value' => $value]);
        }

        return redirect()->back()->with('success', 'Configuration updated successfully.');
    }
}
