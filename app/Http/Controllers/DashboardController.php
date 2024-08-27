<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Hr;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total mahasiswa
        $total_mahasiswa = Mahasiswa::count();

        // Menghitung total dosen (hr yang position-nya dosen)
        $total_dosen = Hr::whereHas('position', function($query) {
            $query->where('posisi', 'dosen');
        })->count();

        // Menghitung total HR
        $total_hr = Hr::count();

        return view('home', [
            'total_mahasiswa' => $total_mahasiswa,
            'total_hr' => $total_hr,
            'total_dosen' => $total_dosen,
        ]);
    }

    public function profile()
    {

    }

}
