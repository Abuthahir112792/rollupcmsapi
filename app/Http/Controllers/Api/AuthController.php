<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\User;
use App\UserLoginOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(Request $request,$lang = 'en')
    {
        App::setLocale($lang);
        $input = $request->all();
        $member_referral = $input['member_referral'];
        $member_id = trim($member_referral,"RCBDS");
        $referralcode = trim($member_referral,$member_id);
        $memberidexist = User::where('id', $member_id)->first();
        $email = $input['email'];
        $emailexist = User::where('email',$email)->first();
        if($input['name'] == ''){
            $response['status'] = 2;
            $response['message'] = __('front/label.api.register.name_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if((empty($memberidexist)) && ($member_referral != '')){
            $response['status'] = 5;
            $response['message'] = __('front/label.api.register.referralcode_required');
            $response['lang']    = \app()->getLocale();
        } 
        else if($input['calling_code'] == ''){
            $response['status'] = 4;
            $response['message'] = __('front/label.api.register.calling_code_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['mobile_number'] == ''){
            $response['status'] = 3;
            $response['message'] = __('front/label.api.register.number_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['password'] == ''){
            $response['status'] = 3;
            $response['message'] = __('front/label.api.register.password_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['confirmpassword'] == ''){
            $response['status'] = 3;
            $response['message'] = __('front/label.api.register.confirmpassword_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['password'] != $input['confirmpassword']){
            $response['status'] = 3;
            $response['message'] = __('front/label.api.register.password_check');
            $response['lang']    = \app()->getLocale();
        }
        else if(($input['calling_code'] == '+91' || $input['calling_code'] == '+92' || $input['calling_code'] == '+90' || $input['calling_code'] == '+20' || $input['calling_code'] == '+63' || $input['calling_code'] == '+880') && (strlen($input['mobile_number']) != 10)){
                $response['status'] = 5;
                $response['message'] = __('front/label.api.register.mobileno_ten_digit_required');
                $response['lang']    = \app()->getLocale(); 
        }
        else if(($input['calling_code'] == '+974') && (strlen($input['mobile_number']) != 8)){
                $response['status'] = 5;
                $response['message'] = __('front/label.api.register.mobileno_eight_digit_required');
                $response['lang']    = \app()->getLocale(); 
        }
        else if(($input['calling_code'] == '+94' || $input['calling_code'] == '+218') && (strlen($input['mobile_number']) != 9)){
                $response['status'] = 5;
                $response['message'] = __('front/label.api.register.mobileno_nine_digit_required');
                $response['lang']    = \app()->getLocale(); 
        }
        else if($input['email'] == ''){
            $response['status'] = 5;
            $response['message'] = __('front/label.api.register.email_field_required');
            $response['lang']    = \app()->getLocale(); 
        }
        else if($input['fcm_token'] == ''){
            $response['status'] = 5;
            $response['message'] = __('front/label.api.register.fcm_required');
            $response['lang']    = \app()->getLocale(); 
        }
        else if($emailexist){
                    $response['status'] = 5;
                    $response['message'] = __('front/label.api.register.email_already_registered');
                    $response['lang']    = \app()->getLocale();
                }
        else{
            $userExist = User::where('mobile_number', $input['calling_code'].$input['mobile_number'])->first();
            if($userExist){
                if($userExist->status == 1){
                    $response['status'] = 6;
                    $response['message'] = __('front/label.api.register.user_already_register');
                    $response['lang']    = \app()->getLocale();
                }
                
                else{
                    $otp = $this->genrateOTP();
                    User::where('mobile_number', $input['calling_code'].$input['mobile_number'])->update(array('otp' => $otp));
                    if(!empty($userExist)) {
                        $body_message = $otp;
                        $res = Helper::sendSMS($body_message, $userExist->mobile_number);
                    }
                    if(isset($res) && $res['http_status'] == 200){
                        // $response['otp'] =  $otp;
                        $response['status'] = 1;
                        $response['message'] = __('front/label.api.register.otp_sent_successfully');
                        $response['lang']    = \app()->getLocale();
                    }
                    else{
                        $response['status'] = 0;
                        $response['message'] = __('front/label.api.register.something_wrong');
                        $response['lang']    = \app()->getLocale();
                    }
                }
            }else{
                $otp = $this->genrateOTP();
                $user = User::create([
                    'mobile_number' => $input['calling_code'].$input['mobile_number'],
                    'name' => $input['name'],
                    'password' => Helper::encrypt($input['password']),
                    'email' =>$input['email'],
                    'status' => 0,
                    'otp' => $otp,
                    'fcm_token' => $input['fcm_token'],
                ]);
                if($input['member_referral'] != ''){
                    $member_referral = $input['member_referral'];
                    $member_id = trim($member_referral,"RCBDS");
                    $referralcode = trim($member_referral,$member_id);
                    $memberreferralcheck = User::select('member_referral')->where('id', $member_id)->first();
                    if(!empty($memberreferralcheck)){
                        $memberreferraladd = $memberreferralcheck->member_referral;
                        User::where('id', $member_id)->update(["member_referral"=>$memberreferraladd+1]);
                    }
                }
                if(!empty($user)) {
                    $body_message = $otp;
                    $res = Helper::sendSMS($body_message, $user->mobile_number);
                }
                if(isset($res) && $res['http_status'] == 200){
                    // $response['otp'] =  $otp;
                    $response['status'] = 1;
                    $response['message'] = __('front/label.api.register.otp_sent_successfully');
                    $response['lang']    = \app()->getLocale();
                }else{
                    $response['status'] = 0;
                    $response['message'] = __('front/label.api.register.something_wrong');
                    $response['lang']    = \app()->getLocale();
                }

            }
        }
        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }


    public function login(Request $request,$lang = 'en')
    {
        App::setLocale($lang);
        $input = $request->all();
        if($input['mobile_number'] == '')
        {
            $response['status']  = 2;
            $response['message'] = __('front/label.api.login.number_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['calling_code'] == '')
        {
            $response['status'] = 3;
            $response['message'] = __('front/label.api.login.calling_code_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['password'] == ''){
            $response['status'] = 3;
            $response['message'] = __('front/label.api.register.password_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['fcm_token'] == ''){
            $response['status'] = 5;
            $response['message'] = __('front/label.api.register.fcm_required');
            $response['lang']    = \app()->getLocale(); 
        }else{
            $mobile_number = trim($request->mobile_number);
            $code = trim($request->calling_code);
            $fcm_token = $request->fcm_token;
            $mobile = trim($code.$mobile_number);
            $user = User::where('mobile_number',$mobile)->where('status', 1)->where('role','user')->first();
            if(!$user){
                $response['status'] = 5;
                $response['message'] = __('front/label.api.login.user_not_actives_or_exists');
                $response['lang']    = \app()->getLocale();
            }else{
                $password = Helper::decrypt($user->password);
                if($input['password'] !==$password ){
                    $response['status'] = 3;
                    $response['message'] = __('front/label.api.register.incorrect_password');
                    $response['lang']    = \app()->getLocale();
                }
                else{
                    User::where('mobile_number', $mobile)->update(array('fcm_token' => $fcm_token));
                    $response['status'] = 1;
                    $response['message'] = __('front/label.api.login.login_successfully');
                    $user->encryptedId =  Helper::encrypt($user->id);
                    $user->token =  $user->createToken('MyApp')->accessToken;
                    $guest = $user->toArray();
                    array_walk_recursive($guest,function(&$item){$item=strval($item);});
                    $response['data'] =  $guest;
                    $response['token'] =  $user->createToken('MyApp')->accessToken;
                    $response['username'] =  $user->name;
                    $response['userid'] =  $user->id;
                    $response['useremail'] =  $user->mobile_number.'@user.bd';
                    $response['lang']    = \app()->getLocale();
                }
                
            }

        }
        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }

    public function forgot(Request $request,$lang = 'en')
    {
        App::setLocale($lang);
        $input = $request->all();
        if($input['mobile_number'] == '')
        {
            $response['status']  = 2;
            $response['message'] = __('front/label.api.login.number_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['calling_code'] == '')
        {
            $response['status'] = 3;
            $response['message'] = __('front/label.api.login.calling_code_field_required');
            $response['lang']    = \app()->getLocale();
        }else{
            $mobile_number = trim($request->mobile_number);
            $code = trim($request->calling_code);
            $mobile = trim($code.$mobile_number);

            $user = User::where('mobile_number',$mobile)->where('status', 1)->where('role','user')->first();
            if(!empty($user)){
                $otp = $this->genrateOTP();
                $body_message = $otp;
                $res = Helper::sendSMS($body_message, $user->mobile_number);

                if(isset($res) && $res['http_status'] == 200){
                    // $response['otp'] =  $otp;
                    $userloginotp = UserLoginOtp::firstOrCreate(['user_id' => $user->id]);
                    $userloginotp->otp = $otp;
                    $userloginotp->save();

                    $response['status'] = 1;
                    $response['message'] = __('front/label.api.login.otp_sent_successfully');
                    $response['lang']    = \app()->getLocale();
                }else{
                    $response['status'] = 0;
                    $response['message'] = __('front/label.api.login.something_wrong');
                    $response['lang']    = \app()->getLocale();
                }

            }else{
                $response['status'] = 4;
                $response['message'] = __('front/label.api.login.user_not_active_or_exist');
                $response['lang']    = \app()->getLocale();
            }
        }
        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }

    public function validateOTP(Request $request,$lang = 'en'){
        App::setLocale($lang);
        $input = $request->all();
        if($input['mobile_number'] == '')
        {
            $response['status'] = 2;
            $response['message'] = __('front/label.api.validate_otp.number_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['otp'] == ''){
            $response['status'] = 3;
            $response['message'] = __('front/label.api.validate_otp.otp_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['is_login_register'] == ''){   // 1 - Register 2 - Login
            $response['status'] = 4;
            $response['message'] = __('front/label.api.validate_otp.please_specify');
            $response['lang']    = \app()->getLocale();
        }
       else{

            if($request->is_login_register == 1){ // IF REGISTER
                 $mobile_number = $request->mobile_number;
                $otp = $request->otp;
                $user = User::where('mobile_number', $mobile_number)->first();
                if(!$user){
                    $response['status'] = 6;
                    $response['message'] = __('front/label.api.validate_otp.user_not_available');
                    $response['lang']    = \app()->getLocale();
                }else{
                    if($otp == $user->otp) {
                        User::where('mobile_number', $mobile_number)->update(array('status' => 1, 'otp' => 0));
                        $response['status'] = 1;
                        $response['message'] = __('front/label.api.validate_otp.verified_sent_successfully');
                        $user->encryptedId =  Helper::encrypt($user->id);
                        $user->token =  $user->createToken('MyApp')->accessToken;
                        $guest = $user->toArray();
                        array_walk_recursive($guest,function(&$item){$item=strval($item);});
                        $response['data'] =  $guest;
                        $response['token'] =  $user->createToken('MyApp')->accessToken;
                        $response['username'] =  $user->name;
                        $response['userid'] =  $user->id;
                        $response['useremail'] =  $user->mobile_number.'@user.bd';
                        $response['lang']    = \app()->getLocale();
                    }else{
                        $response['status'] = 6;
                        $response['message'] = __('front/label.api.validate_otp.otp_invalid');
                        $response['lang']    = \app()->getLocale();
                    }
                }
            }else{ // IF LOGIN
                if($input['password'] == '')
        {
            $response['status'] = 2;
            $response['message'] = __('front/label.api.register.password_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['confirmpassword'] == ''){
            $response['status'] = 3;
            $response['message'] = __('front/label.api.register.confirmpassword_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['password'] != $input['confirmpassword']){
            $response['status'] = 3;
            $response['message'] = __('front/label.api.register.password_check');
            $response['lang']    = \app()->getLocale();
        }
else{
                $mobile_number = trim($request->mobile_number);
                $otp = trim($request->otp);
                $password = $request->password;
                $confirmpassword = $request->confirmpassword;
                $user = User::where('mobile_number', $mobile_number)->where('status', 1)->where('role','user')->first();
                if(!$user){
                    $response['status'] = 5;
                    $response['message'] = __('front/label.api.validate_otp.user_not_available');
                    $response['lang']    = \app()->getLocale();
                }else{
                    $getOTP = UserLoginOtp::where('user_id', $user->id)->first();
                    if($otp == $getOTP->otp) {
                        $getresetPassword = User::where('mobile_number', $user->mobile_number)->where('id', $user->id)->update(['password'=>Helper::encrypt($password)]);
                        $response['status'] = 1;
                        $response['message'] = __('front/label.api.validate_otp.password_reset');
                        $response['lang']    = \app()->getLocale();
                    }else{
                        $response['status'] = 6;
                        $response['message'] = __('front/label.api.validate_otp.otp_invalid');
                        $response['lang']    = \app()->getLocale();
                    }
                }
            }
            }
        }
        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }

    public function resetPassword(Request $request,$lang = 'en'){
        App::setLocale($lang);
        $input = $request->all();
        if($input['password'] == '')
        {
            $response['status'] = 2;
            $response['message'] = __('front/label.api.register.password_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['confirmpassword'] == ''){
            $response['status'] = 3;
            $response['message'] = __('front/label.api.register.confirmpassword_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($input['password'] != $input['confirmpassword']){
            $response['status'] = 3;
            $response['message'] = __('front/label.api.register.password_check');
            $response['lang']    = \app()->getLocale();
        }
        else{

               $mobile_number = trim($request->mobile);
                $userids = Helper::decrypt($request->userids);
                $user = User::where('mobile_number', $mobile_number)->where('id', $userids)->where('status', 1)->where('role','user')->first();
                if(!$user){
                    $response['status'] = 5;
                    $response['message'] = __('front/label.api.validate_otp.user_not_available');
                    $response['lang']    = \app()->getLocale();
                }else{
                    $getresetPassword = User::where('mobile_number', $user->mobile_number)->where('id', $user->id)->update(['password'=>Helper::encrypt($request->password)]);
                    if($getresetPassword) {
                        $response['status'] = 1;
                        $response['message'] = __('front/label.api.validate_otp.password_reset');
                        $response['lang']    = \app()->getLocale();
                    }else{
                        $response['status'] = 6;
                        $response['message'] = __('front/label.api.logout.something_wrong');
                        $response['lang']    = \app()->getLocale();
                    }
                }
            
        }
        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }

    public function logout(Request $request,$lang = 'en')
    {
        App::setLocale($lang);
        if(!Auth::check()) {
            $response['message'] = __('front/label.api.logout.something_wrong');
            $response['status'] = 2;
            $response['lang']    = \app()->getLocale();
        }else{
            Auth::user()->token()->revoke();
//            User::where('id', Auth::user()->id)->update(array('user_token' => ''));
            $response['message'] =  __('front/label.api.logout.logout_successfully');
            $response['status'] =  1;
            $response['lang']    = \app()->getLocale();
        }
        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }

    public static function genrateOTP() {
        $otp = mt_rand(1000,9999);
        return  $otp;
    }

    
}







