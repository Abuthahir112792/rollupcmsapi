<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\SiteMedia;
use App\SitePages;
use App\User;
use App\Orders;
use App\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Helpers\JwtDecoderHelper;

class HomeController extends Controller
{
    public function index(){
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        $token = null;
        $user_id =null;
        $user_name=null;
        if(isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            if(isset($_COOKIE['username'])&&isset($_COOKIE['userid'])){
                $user_id = $_COOKIE['userid'];
                $user_name = $_COOKIE['username'];
            }
        }
        $is_login = !empty($token) ? 1 : 0;
        $cms_data = [];
        $allMedia = SiteMedia::all();
        if(isset($allMedia) && !empty($allMedia)){
            foreach ($allMedia as $k => $v) {
                if($v->media_type == 'Image')
                    $cms_data['images'][] = $v->media_name;
                else
                    $cms_data['videos'][] = $v->media_name;
            }
        }

        $user_details = User::where('role','shop_keeper')->first();
        $order_allow = 0;
        if(!empty($user_details) && $is_login == 1){
            $order_allow = $user_details->order_allow;
        }

        $getkeeperno = SitePages::where('page_title','Shop Keeper Details')->first();
        $cms_data['Shopkeeperno'] = "";
        if(!empty($getkeeperno)){

            $cms_data['Shopkeeperno'] = $getkeeperno->page_content;
        }
        
        $getkeeperemail = SitePages::where('page_title','Shop Keeper Email')->first();
        $cms_data['Shopkeeperemail'] = "";
        if(!empty($getkeeperemail)){

            $cms_data['Shopkeeperemail'] = $getkeeperemail->page_content;
        }
       
 
        $getfeedbacklist = Feedback::leftjoin('users', 'users.id', '=', 'feedback.user_id')->where('feedback.feedback_rate','>=','4')->select('feedback.*', 'users.name')->orderBy('feedback.id', 'DESC')->skip(0)->take(5)->get();
        $cms_data['feedbacklist'] = "";
        if(!empty($getfeedbacklist)){

            $cms_data['feedbacklist'] = $getfeedbacklist;
        }

        

        if($is_login == "1"){
        $test = JwtDecoderHelper::decode($token);
        $str = $test["claims"]["sub"];
        $rest = explode(" ",$str); 
        $user_id =   $rest[0];
        $cms_data['user_id'] = $user_id;
        $cms_data['getpendingorders'] = Orders::where('user_id',$user_id)->where('order_status','Pending')->orderBy('id', 'desc')->get();     
        
        $cms_data['getusername'] = User::select('name')->where('id',$user_id)->first();     
        }

       
        
        return view('front.home',compact('is_login','cms_data','order_allow'));
    }

    public function profile(){
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        $token = null;
        if(isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
        }
        $is_login = !empty($token) ? 1 : 0;
        $logo = Helper::get_application_logo();
        //$name = User::select('name')->where('id',$user_id)->first();
        return view('front.profile.profile',compact('is_login','logo'));
    }

    public function privacy_policy(){
        $token = null;
        if(isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
        }
        $is_login = !empty($token) ? 1 : 0;

        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        $privacy = SitePages::where('page_title','Privacy Policy')->first();

        return view('front.privacy.privacy_policy',compact('privacy','is_login'));
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
        return view('front.terms_condition.terms_condition',compact('terms','is_login'));
    }

    public function feedback(){
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        $token = null;
        if(isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
        }
        $is_login = !empty($token) ? 1 : 0;
        return view('front.feedback.feedback',compact('is_login'));
    }

    //Referral Program front 
    public function referral(){
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        $token = null;
        if(isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
        }
        $is_login = !empty($token) ? 1 : 0;
        return view('front.referral.referral',compact('is_login'));
    }

    public function more(){
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        $token = null;
        if(isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            
        }
        $is_login = !empty($token) ? 1 : 0;


        $user_details = User::where('role','shop_keeper')->first();
        $order_allow = 0;
        if(!empty($user_details) && $is_login == 1){
            $order_allow = $user_details->order_allow;
        }

        $getkeeperno = SitePages::where('page_title','Shop Keeper Details')->first();
        $cms_data['Shopkeeperno'] = "";
        if(!empty($getkeeperno)){

            $cms_data['Shopkeeperno'] = $getkeeperno->page_content;
        }
        
        $getkeeperemail = SitePages::where('page_title','Shop Keeper Email')->first();
        $cms_data['Shopkeeperemail'] = "";
        if(!empty($getkeeperemail)){

            $cms_data['Shopkeeperemail'] = $getkeeperemail->page_content;
        }
            
        
        return view('front.more',compact('is_login','order_allow','cms_data'));
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
