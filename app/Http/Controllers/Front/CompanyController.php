<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\SitePages;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    public function privacy_policy(){
        $token = null;
        if(isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
        }
        $is_login = !empty($token) ? 1 : 0;

        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        $privacy = SitePages::where('page_title','Privacy Policy')->first();

        return view('front.privacy.mobile_privacy_policy',compact('privacy','is_login'));
    }

    public function terms_condition(){
        $token = null;
        if(isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
        }
        $is_login = !empty($token) ? 1 : 0;

        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        $terms = SitePages::where('page_title','Terms & Condition')->first();
        return view('front.terms_condition.mobile_terms_condition',compact('terms','is_login'));
    }

    public function language_change($lang){
        App::setLocale($lang);
        Session::put('lang',$lang);
        if(Session::has('lang')){
            return 'true';
        }
        return 'false';
    }
}
