<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function register(){
        $logo = Helper::get_application_logo();
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        return view('front.auth.register',compact('logo'));
    }

    public function show_login(){
        $logo = Helper::get_application_logo();
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        return view('front.auth.login',compact('logo'));
    }

    public function login_otp(Request $request,$mobile,$is_login){
        $logo = Helper::get_application_logo();
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        return view('front.auth.otp',compact('mobile','is_login','logo'));
    }

    public function forgot(){
        $logo = Helper::get_application_logo();
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        return view('front.auth.forgot',compact('logo'));
    }

    public function reset_password(Request $request,$mobile,$userids){
        $logo = Helper::get_application_logo();
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        return view('front.auth.resetpassword',compact('mobile','userids','logo'));
    }
}
