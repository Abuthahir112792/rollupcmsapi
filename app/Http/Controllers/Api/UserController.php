<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\SiteMedia;
use App\SitePages;
use App\Feedback;
use App\Orders;
use App\Category;
use App\Product;
use App\Branch;

class UserController extends BaseController
{

    public function getHomePage($lang = 'en')
    {
        App::setLocale($lang);
        $response = array();
        $cms_data['images'] = array();
        $cms_data['videos'] = array();

        $allMedia = SiteMedia::all();
        if(isset($allMedia) && !empty($allMedia)){
            foreach ($allMedia as $k => $v) {
                if($v->media_type == 'Image')
                    $cms_data['images'][] = $v->media_name;
                else
                    $cms_data['videos'][] = $v->media_name;
            }
        }

        $allPages = SitePages::all();
        if(isset($allPages) && !empty($allPages)){
            foreach ($allPages as $k => $v) {
                if($v->page_title == 'Privacy Policy')
                    $cms_data['Policy'] = $v->page_content;
                else
                    $cms_data['Term'] = $v->page_content;
            }
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

       $getcategorylist = Category::where('category_status','Active')->get()->toArray();
       $cms_data['categorylist'] = "";
        if(!empty($getcategorylist)){

            $cms_data['categorylist'] = $getcategorylist;
        }

        $categoryorder = Category::select('id')->where('category_status','Active')->orderBy('id', 'ASC')->skip(0)->take(1)->first();
        $getcategoryviaproductList = Product::leftjoin('category', 'category.id', '=', 'product.category_id')->where('category.category_status', 'Active')->where('category_id',$categoryorder->id)->where('product_status','Active')->select('product.*', 'category.name', 'category.category_status')->skip(0)->take(10)->get()->toArray();
        $cms_data['categoryviaproductList'] = array();
        if(!empty($getcategoryviaproductList)){

            $cms_data['categoryviaproductList'] = $getcategoryviaproductList;
        }

        $getbranchList = Branch::leftjoin('users', 'users.branch_id', '=', 'branch.id')->where('users.branch_user_status', 'Active')->where('users.order_allow','!=','0')->select('branch.*', 'users.branch_user_status', 'users.order_allow')->get()->toArray();
        $cms_data['branchList'] = array();
        if(!empty($getbranchList)){

            $cms_data['branchList'] = $getbranchList;
        }

        $user_details = User::where('role','shop_keeper')->first();
        $order_allow = 0;
        if($user_details){
            $order_allow = $user_details->order_allow;
        }
        $logo = Helper::get_application_logo();
        $cms_data['order_allow'] = $order_allow;

        $response['status'] = 1;
        $response['message'] = __('front/label.api.home.fetch_successfully');
        $response['data'] =  $cms_data;
        $response['lang']    = \app()->getLocale();
        $response['logo']    = $logo;
        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }

    /**
     * Gets the Products by the category by pagination
     */
    public function getProductsByCategory($categoryId,$lang = 'en'){
        App::setLocale($lang);
        $response =  array();
        $data =array();
        $checkIfCategoryExist = Category::select('id')->where('id',$categoryId)->first();
        if(!empty($checkIfCategoryExist)){
            $data= Product::leftjoin('category', 'category.id', '=', 'product.category_id')->where('category.category_status', 'Active')->where('category_id',$checkIfCategoryExist->id)->where('product_status','Active')->select('product.*', 'category.name', 'category.category_status')->paginate(10);
        }
        $response['status'] = 1;
        $response['message'] = __('front/label.api.home.fetch_successfully');
        $response['data'] =  $data;
        $response['lang']    = \app()->getLocale();
        return response()->json($response);
    }

    public function getPendingPage($lang = 'en')
    {
        App::setLocale($lang);
        $user_id = Auth::User()->id;
        
        
        $getorders = Orders::where('user_id',$user_id)->where('order_status','Pending')->orderBy('id', 'desc')->get();     
        
        $usersnames = User::select('name')->where('id',$user_id)->first();      
        $users_names = $usersnames->name;
        $user_details = User::where('role','shop_keeper')->first();
        $order_allow = 0;
        if($user_details){
            $order_allow = $user_details->order_allow;
        }
        
        
        if($getorders){
            $response['status'] = 1;
            $pending_list = $getorders->toArray();
            array_walk_recursive($pending_list,function(&$item){$item=strval($item);});
            $response['data'] =  $pending_list;
            $response['shop_keeper'] =  $order_allow;
            $response['name'] =  $users_names;
            $response['message'] = __('front/label.api.order_history.order_fetch_successfully');
            $response['lang']    = \app()->getLocale();
        }else{
            $response['status'] = 3;
            $response['message'] = __('front/label.api.order_history.something_wrong');
            $response['lang']    = \app()->getLocale();
        }
         array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }

    public function getUserDetail($lang = 'en')
    {
        App::setLocale($lang);
        $user = Auth::user();
        if(!empty($user)){
            $response['status'] = 1;
            $guest = $user->toArray();
            array_walk_recursive($guest,function(&$item){$item=strval($item);});
            $response['data'] =  $guest;
            $response['password'] =  Helper::decrypt($user->password);
            $response['message'] = __('front/label.api.get_user.fetch_successfully');
            $response['lang']    = \app()->getLocale();
        }else{
            $response['status'] = 3;
            $response['message'] = __('front/label.api.get_user.user_does_not_exist');
            $response['lang']    = \app()->getLocale();
        }

        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }

    public function userDetailUpdate(Request $request, $lang = 'en')
    {
        App::setLocale($lang);
        $user_name = $request->user_name;
        $address = $request->address;
        $fcm_token = $request->fcm_token;

        if($user_name == ''){
            $response['status'] = 2;
            $response['message'] = __('front/label.api.update_user.name_field_required');
            $response['lang']    = \app()->getLocale();
        }
        else if($fcm_token == ''){
            $response['status'] = 5;
            $response['message'] = __('front/label.api.register.fcm_required');
            $response['lang']    = \app()->getLocale(); 
        }
        
        else{

            $user = Auth::user();
            $encryptedId =  Helper::encrypt($user->id);
            $token =  $user->createToken('MyApp')->accessToken;
            if(!empty($user)){
                $user->name = $user_name;
                $user->fcm_token = $fcm_token;
                $user->save();
                
                $response['status'] = 1;
                $user->encryptedId =  Helper::encrypt($user->id);
                $user->token =  $user->createToken('MyApp')->accessToken;
                $guest = $user->toArray();
                array_walk_recursive($guest,function(&$item){$item=strval($item);});
                $response['data'] =  $guest;
                $response['message'] = __('front/label.api.update_user.updated_successfully');
                $response['lang']    = \app()->getLocale();
            }else{
                $response['status'] = 5;
                $response['message'] = __('front/label.api.update_user.user_does_not_exist');
                $response['lang']    = \app()->getLocale();
            }
        }
        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }

    public function feedbackCreate(Request $request, $lang = 'en')
    {
        App::setLocale($lang);
        $feedback_rate = $request->feedback_rate;
        $feedback_description = $request->feedback_description;
        if($feedback_rate == ''){
            $response['status'] = 2;
            $response['message'] = __('front/label.api.feedback.rate_field_required');
            $response['lang']    = \app()->getLocale();
        }
         else{           
                    $userfeedbackuser_id = Auth::user()->id;
                    $userfeedbackrate = Feedback::firstOrCreate(['user_id' => $userfeedbackuser_id]);
                    $userfeedbackrate->feedback_rate = $feedback_rate;
                    $userfeedbackrate->feedback_description = $feedback_description;
                    $userfeedbackrate->save();

                    if($userfeedbackrate){
                        $response['status'] = 1;
                        $response['message'] = __('front/label.api.feedback.feedback_success');
                        $response['lang']    = \app()->getLocale();
                    }else{
                        $response['status'] = 0;
                        $response['message'] = __('front/label.api.place_order.something_wrong');
                        $response['lang']    = \app()->getLocale();
                    }
                    }       
        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }

    public function getfeedbackDetail($lang = 'en')
    {
        App::setLocale($lang);
        $userfeedbackuserid = Auth::user()->id;
        $feedbackdetails = Feedback::where('user_id',$userfeedbackuserid)->first();
        if(!empty($feedbackdetails)){
            $response['status'] = 1;
            $feedbackdetailsguest = $feedbackdetails->toArray();
            array_walk_recursive($feedbackdetailsguest,function(&$item){$item=strval($item);});
            $response['data'] =  $feedbackdetailsguest;
            $response['message'] = __('front/label.api.get_user.fetch_successfully');
            $response['lang']    = \app()->getLocale();
        }

        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }

    public function getfeedbackList($lang = 'en')
    {
        App::setLocale($lang);
        $getfeedbacklist = Feedback::leftjoin('users', 'users.id', '=', 'feedback.user_id')->where('feedback.feedback_rate','>=','4')->select('feedback.*', 'users.name')->orderBy('feedback.id', 'DESC')->skip(0)->take(5)->get();
        if(!empty($getfeedbacklist)){
            $response['status'] = 1;
            $getfeedbacklistguest = $getfeedbacklist->toArray();
            array_walk_recursive($getfeedbacklistguest,function(&$item){$item=strval($item);});
            $response['data'] =  $getfeedbacklistguest;
            $response['message'] = __('front/label.api.get_user.fetch_successfully');
            $response['lang']    = \app()->getLocale();
        }

        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }
}







