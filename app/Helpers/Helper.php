<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Hash;
use App\Orders;
use App\SiteMedia;
use App\Category;
use App\Product;
use App\Statuslist;
use App\User;
class Helper
{

    // static $secretKey = 'VIPseckey@Marrakech';
    // static $secretIv = 'VIPiv@Marrakech';

    static $secretKey = 'yougoeasybuy@seckey';
    static $secretIv = 'yougoeasybuyiv';
    // Your PHP installation needs cUrl support, which not all PHP installations
    // include by default.
    // To run under docker:
    // docker run -v $PWD:/code php:7.3.2-alpine php /code/code_sample.php

    public static function sendSMS($body_message, $mobile){

        $username = config('app.sendsms_username');
        $password = config('app.sendsms_password');
        $sid = config('app.sendsms_sid');
        // $messages = array(
        //     array('to'=>$mobile, 'body'=>$body_message),
        // );
        //$result = self::messageSend(json_encode($messages), 'https://api.bulksms.com/v1/messages?auto-unicode=true&longMessageMaxParts=30', $username, $password );
        $msg = urlencode($body_message);
        $result = self::messageSend("http://www.smscountry.com/smscwebservice_bulk.aspx?User=$username&passwd=$password&mobilenumber=$mobile&DR=Y&mtype=N&DR=Y&sid=$sid&message=$msg");

        // $result = send_message( json_encode($messages), 'https://api.bulksms.com/v1/messages?auto-unicode=true&longMessageMaxParts=30', $username, $password );
        return $result;
        // if ($result['http_status'] != 201) {
        //     print "Error sending: " . ($result['error'] ? $result['error'] : "HTTP status ".$result['http_status']."; Response was " .$result['server_response']);
        // } else {
        //     print "Response " . $result['server_response'];
        // // Use json_decode($result['server_response']) to work with the response further
        // }
    }


    public static function messageSend($url){

        $ch = curl_init();
        $headers = array(
        'Content-Type:application/json',
        // 'Authorization:Basic '.config('app.sendsms_Authorization')
        );
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt ( $ch, CURLOPT_URL, $url );
        // curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        // curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_body );
        // Allow cUrl functions 20 seconds to execute
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 20 );
        // Wait 10 seconds while trying to connect
        curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
        $output = array();
        $output['server_response'] = curl_exec( $ch );
        $curl_info = curl_getinfo( $ch );
        $output['http_status'] = $curl_info[ 'http_code' ];
        $output['error'] = curl_error($ch);
        curl_close( $ch );
        return $output;
    }


    public static function encrypt($string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
        // hash
        $key = hash('sha256', self::$secretKey);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', self::$secretIv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);

        return $output;
    }

    /**
     * Returns decrypted original string
     *
     * @param  $string - Enctrypted string
     *
     * @return string
     */
    public static function decrypt($string) {

        $output = false;
        $encrypt_method = "AES-256-CBC";

        // hash
        $key = hash('sha256', self::$secretKey);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', self::$secretIv), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

        return $output;
    }

     /** get order details using encrypted id */
    public static function getOrderAllDetails($id){
        $data = Orders::where('id', Helper::decrypt($id))->first();
        if($data){
            return response()->json(['status' => 'Success!','status_code' => 200,'data' => $data]);
        }
        return response()->json(['status' => 'Error!','status_code' => 100]);
    }

    public static function getCategoryAllDetails($id){
        $data = Category::where('id', Helper::decrypt($id))->first();
        if($data){
            return response()->json(['status' => 'Success!','status_code' => 200,'data' => $data]);
        }
        return response()->json(['status' => 'Error!','status_code' => 100]);
    }

    public static function getBranchUserDetails($id){
        $data = User::where('id', Helper::decrypt($id))->first();
        
        if($data){
            return response()->json(['status' => 'Success!','status_code' => 200,'data' => $data,'pass' => md5($data->password)]);
        }
        return response()->json(['status' => 'Error!','status_code' => 100]);
    }

    public static function getProductAllDetails($id){
        $data = Product::where('id', Helper::decrypt($id))->first();
        $productcategory = Category::all();
        
        $productoutput = '<option value="">Select</option>';
        foreach($productcategory as $category)
        {
        $productoutput .= '<option value="'.$category->id.'">'.$category->name.'</option>';
        }
        if($data){
            return response()->json(['status' => 'Success!','status_code' => 200,'data' => $data,'productoutput' => $productoutput]);
        }
        return response()->json(['status' => 'Error!','status_code' => 100]);
    }

    public static function getStatuslistDetails($id){
        $data = Statuslist::where('id', Helper::decrypt($id))->first();
        if($data){
            return response()->json(['status' => 'Success!','status_code' => 200,'data' => $data]);
        }
        return response()->json(['status' => 'Error!','status_code' => 100]);
    }

    public static function getLogo($type){
        $data = SiteMedia::where('media_type', 'Logo')->first();
        if($data){
            return asset('cms_media/logo/'.$data->media_name);
        }else{
            if($type == 'login'){
                return asset('theme/assets/img/logo_two.png');
            }else{
                return asset('theme/assets/img/logo_two.png');
            }
        }
    }

    public static function get_application_logo(){
        $data = SiteMedia::where('media_type', 'Logo')->first();
        if($data){
            return asset('cms_media/logo/'.$data->media_name);
        }else{
            return asset('theme/assets/img/logo_two.png');
        }
    }
}


