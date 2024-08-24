<?php

namespace App\Http\Controllers;

use App\Models\HrDetail;
use App\Models\ShortenerURL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        //proses Login
        $user = DB::table('t_hr_detail')->where('hp', $hp)->join('m_hr', 't_hr_detail.master_hr_id', '=', 'm_hr.id')->select('t_hr_detail.*', 'm_hr.nama')->first();

        //return
        return redirect()->route('/');

    }
}
