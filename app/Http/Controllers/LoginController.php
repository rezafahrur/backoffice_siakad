<?php

namespace App\Http\Controllers;

use App\Models\Hr;
use App\Models\HrDetail;
use App\Models\ShortenerURL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        $hp = '0' . substr($wa,2);


        //get ho from t_hr_detail
        $user = HrDetail::where('hp', $hp)->join('m_hr', 't_hr_detail.master_hr_id', '=', 'm_hr.id')->select('t_hr_detail.*', 'm_hr.nama')->orderBy('t_hr_detail.created_at', 'desc')->first();

        if($user)
        {
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

        }
        else
        {
            return response('null', 404);
        }


    }

    function prosesLogin(Request $request, $hp, $otp)
    {
        //get user
        $user = Hr::join('t_hr_detail', 't_hr_detail.master_hr_id', '=', 'm_hr.id')->join('m_position', 'm_hr.position_id', '=', 'm_position.id')->where('t_hr_detail.hp', $hp)->select('t_hr_detail.*', 'm_hr.nama', 'm_hr.gelar_belakang', 'm_hr.gelar_depan', 'm_position.posisi', 'm_position.id AS position_id')->orderBy('t_hr_detail.created_at', 'desc')->first();

        $hr_detail = HrDetail::where('master_hr_id', $user->master_hr_id)->orderBy('created_at', 'desc')->first();

        if($user->otp == $otp)
        {
            //nullkan otp t_hr_detail
            $hr_detail->otp = null;
            $hr_detail->save();

            //logout session lama
            $new_session_id = Session::getId();
            $last_session = Session::getHandler()->read($user->session_id);

            if ($last_session)
            {
                Session::getHandler()->destroy($user->session_id);
                Auth::guard('hr')->logout();
            }

            //loginkan
            $hr_detail->session_id = $new_session_id;
            $hr_detail->save();

            Session::put('hr_id', $user->master_hr_id);
            Session::put('nama', explode(" ",$user->nama)[0]);
            Session::put('nama_lengkap', $user->gelar_depan . ' ' . $user->nama . ' ' . $user->gelar_belakang);
            Session::put('posisi_id',$user->m_position_id);
            Session::put('posisi', $user->posisi);
            Auth::guard('hr')->loginUsingId($user->master_hr_id);

            return redirect()->route('/');

        }
        else
        {
            $hr_detail->otp = null;
            $hr_detail->session_id = null;
            $hr_detail->save();

            return redirect()->route('login')->with('error', 'Ada Yang Salah Dalam Link Anda');
        }
    }

    function logout()
    {
        $user = HrDetail::where('t_hr_detail.master_hr_id', Session::get('hr_id'))->join('m_hr', 't_hr_detail.master_hr_id', '=', 'm_hr.id')->select('t_hr_detail.*', 'm_hr.nama', 'm_hr.gelar_belakang', 'm_hr.gelar_depan', 'm_hr.id AS hr_id')->orderBy('t_hr_detail.created_at', 'desc')->first();
        Session::getHandler()->destroy($user->session_id);
        $user->session_id = null;
        $user->save();
        Auth::guard('hr')->logout();

        return redirect()->route('login');
    }
}
