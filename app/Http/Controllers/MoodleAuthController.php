<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoodleAuthController extends Controller
{
    // Fungsi untuk menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.moodle-login');
    }

    // Fungsi untuk login ke Moodle
    public function loginToMoodle(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Mengirim permintaan GET ke Moodle
        $response = Http::get('https://lms.poltekbatu.ac.id/login/token.php', [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'service' => 'my_API'
        ]);

        $responseData = $response->json();

        if (isset($responseData['token'])) {
            // Jika token ditemukan, maka simpan token ke session dan redirect ke url moodle
            $request->session()->put('token', $responseData['token']);
            return redirect('https://lms.poltekbatu.ac.id/login/index.php?auth=' . $responseData['token']);
        } else {
            return redirect()->back()->with('error', 'Username atau password salah');
        }
    }
}
