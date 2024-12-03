<?php

namespace App\Http\Controllers;

use App\Models\Hr;
use App\Models\HrDetail;
use App\Models\Ktp;
use App\Models\ShortenerURL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    function index()
    {
        return view('login.index');
    }

    function generateLoginURL(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $wa = str_replace('@c.us', '', $data['hp']);
        $hp = '0' . substr($wa, 2);


        //get ho from t_hr_detail
        $user = HrDetail::where('hp', $hp)->join('m_hr', 't_hr_detail.master_hr_id', '=', 'm_hr.id')->select('t_hr_detail.*', 'm_hr.nama')->orderBy('t_hr_detail.created_at', 'desc')->first();

        if ($user) {
            //generate otp
            $otp = bin2hex(random_bytes(3));
            $user->otp = $otp;
            $user->save();

            //generate keyword
            $keyword = bin2hex(random_bytes(5));

            //save to so.poltekbatu.ac.id
            $url = 'https://backoffice.poltekbatu.ac.id/prosesLogin/' . $user->hp . '/' . $otp;
            $so = new ShortenerURL;
            $so->keyword = $keyword;
            $so->url = $url;
            $so->ip = $request->ip();
            $so->clicks = 0;
            $so->save();

            $urlNow = 'https://so.poltekbatu.ac.id/' . $keyword;
            $res = array(
                'url' => $urlNow,
                'nama' => $user->nama,
            );

            //response ke wa bot
            return response($res, 200);
        } else {
            return response('null', 404);
        }
    }

    function prosesLogin($hp, $otp)
    {
        // Mendapatkan user berdasarkan nomor HP
        $user = Hr::join('t_hr_detail', 't_hr_detail.master_hr_id', '=', 'm_hr.id')
            ->join('m_position', 'm_hr.position_id', '=', 'm_position.id')
            ->join('t_ktp', 't_ktp.id', '=', 'm_hr.ktp_id')
            ->where('t_hr_detail.hp', $hp)
            ->select('t_hr_detail.*', 'm_hr.nama', 'm_hr.gelar_belakang', 'm_hr.gelar_depan', 'm_position.posisi', 'm_position.id AS position_id', 'm_hr.photo_profile', 't_ktp.nik')
            ->orderBy('t_hr_detail.created_at', 'desc')
            ->first();

        // Tambahkan pengecekan jika user tidak ditemukan atau master_hr_id null
        if (!$user || is_null($user->master_hr_id)) {
            return redirect()->route('login')->with('error', 'Data user tidak ditemukan atau tidak valid.');
        }

        $hr_detail = HrDetail::where('master_hr_id', $user->master_hr_id)->orderBy('created_at', 'desc')->first();


        // if (!$user || $user->otp !== $otp) {
        //     // Jika OTP tidak valid, nullkan dan redirect dengan pesan kesalahan
        //     HrDetail::where('master_hr_id', $user->master_hr_id)->update(['otp' => null, 'session_id' => null]);
        //     return redirect()->route('login')->with('error', 'Ada kesalahan, silahkan coba lagi');
        // }

        if ($user->otp == $otp) {
            // Nullkan OTP setelah verifikasi berhasil
            $hr_detail->otp = null;
            $hr_detail->save();

            // nuulkan model has role
            $user->roles()->detach();

            // Generate dan simpan password LMS baru
            $passwordLMS = Str::random(8);
            $user->password_lms = bcrypt($passwordLMS);
            $user->save();

            // Simpan kredensial LMS dalam session untuk memperbarui password LMS
            session([
                'update_lms_password' => true,
                'lms_credentials' => [
                    'username' => $user->nik, // Menggunakan NIK dari t_ktp sebagai username
                    'password' => $passwordLMS,
                ]
            ]);

            // Kirim password baru ke LMS
            Http::post('https://lms.poltekbatu.ac.id/user/interpreterUpdatePasswordDARe5.php', [
                'username' => $user->nik,
                'password' => $passwordLMS,
            ]);

            // Kelola sesi, logout dari sesi sebelumnya jika ada
            $new_session_id = Session::getId();
            $last_session = Session::getHandler()->read($user->session_id);
            if ($last_session) {
                Session::getHandler()->destroy($user->session_id);
                Auth::guard('hr')->logout();
            }

            //loginkan
            $hr_detail->session_id = $new_session_id;
            $hr_detail->save();

            Session::put([
                'hr_id' => $user->master_hr_id,
                'nama' => explode(" ", $user->nama)[0],
                'nama_lengkap' => $user->gelar_depan . ' ' . $user->nama . ' ' . $user->gelar_belakang,
                'posisi_id' => $user->position_id,
                'posisi' => $user->posisi,
                'photo_profile' => $user->photo_profile,
            ]);

            // Loginkan user di sistem
            Auth::guard('hr')->loginUsingId($user->master_hr_id);

            $user = Auth::guard('hr')->user();

            // Assign role berdasarkan posisi
            $roleName = $user->position->posisi;
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $user->assignRole($role->name);
            } else {
                return redirect()->route('login')->with('error', 'Role tidak ditemukan.');
            }

            // Redirect ke halaman utama setelah login berhasil
            return redirect()->route('/');
        } else {
            $hr_detail->otp = null;
            $hr_detail->session_id = null;
            $hr_detail->save();

            return redirect()->route('login')->with('error', 'Ada Yang Salah Dalam Link Anda');
        }
    }

    public function clearLmsPasswordSession()
    {
        session()->forget('update_lms_password');
        return response()->json(['status' => 'session cleared']);
    }

    public function proxyUpdatePassword(Request $request)
    {
        try {
            // Send POST request to LMS API
            $response = Http::post('https://lms.poltekbatu.ac.id/user/interpreterUpdatePasswordDARe5.php', [
                'username' => $request->username,
                'password' => $request->password,
            ]);

            // Check if the response is successful
            if ($response->successful()) {
                return response()->json(['message' => 'LMS password updated successfully.'], 200);
            } else {
                return response()->json(['error' => 'Failed to update LMS password.'], 500);
            }
        } catch (\Exception $e) {
            // Catch and return any exceptions
            return response()->json(['error' => 'An error occurred while updating LMS password.'], 500);
        }
    }

    function logout()
    {
        $user = HrDetail::where('t_hr_detail.master_hr_id', Session::get('hr_id'))->join('m_hr', 't_hr_detail.master_hr_id', '=', 'm_hr.id')->select('t_hr_detail.*', 'm_hr.nama', 'm_hr.gelar_belakang', 'm_hr.gelar_depan', 'm_hr.id AS hr_id')->orderBy('t_hr_detail.created_at', 'desc')->first();
        Session::getHandler()->destroy($user->session_id);
        $user->session_id = null;
        $user->save();
        $userlog = Auth::guard('hr')->user();
        $userlog->roles()->detach();
        Auth::guard('hr')->logout();

        return redirect()->route('login');
    }
}
