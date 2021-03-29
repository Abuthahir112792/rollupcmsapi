<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function order_history(){
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        $token = null;
        if(isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
        }
        $is_login = !empty($token) ? 1 : 0;
        return view('front.order.order_history',compact('is_login'));
    }

    public function add_order(){
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        return view('front.order.add_order');
    }

    public function order_details($orderid){
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        $token = null;
        if(isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
        }
        $is_login = !empty($token) ? 1 : 0;
        return view('front.order.order_details',compact('is_login','orderid'));
    }
}
