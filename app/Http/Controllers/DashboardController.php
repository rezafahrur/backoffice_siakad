<?php

namespace App\Http\Controllers;

use App\Models\Hr;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        // Get the logged-in user's HR model
        $user = Auth::guard('hr')->user();

        return view('master.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Get the logged-in user's HR model
        $user = Hr::where('id', Session::get('hr_id'))->first();
        // dd($user);

        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:m_hr,email,' . $user->id,
            'phone' => 'required|string|max:15',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update the user's data
        $user->nama = $request->input('name');
        $user->email = $request->input('email');

        // Update phone number in HrDetail
        $user->hrDetail->hp = $request->input('phone');
        $user->hrDetail->save();

        // Handle photo profile upload
        if ($request->hasFile('photo_profile')) {
            $path = $request->file('photo_profile')->store('photo_profiles', 'public');
            $user->photo_profile = $path;
        }

        // Save the updated user data
        $user->save();

        //update session
        Session::put('photo_profile', $user->photo_profile);

        // Flash a success message to the session
        Session::flash('success', 'Profile updated successfully.');

        return redirect()->route('profile');
    }



}
