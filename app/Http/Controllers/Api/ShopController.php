<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Orders;
use App\Category;
use App\Product;
use App\Orderstatus;
use App\Branch;

use Google\Cloud\Translate\V2\TranslateClient;


class ShopController extends BaseController
{

    public function categoryList($lang = 'en')
    {
        App::setLocale($lang);
        $categorylist = Category::where('category_status','Active')->get();
        
        if($categorylist){
            $response['status'] = 1;
            $category_list = $categorylist->toArray();
            array_walk_recursive($category_list,function(&$item){$item=strval($item);});
            $response['data'] =  $category_list;
            
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

    public function productList($lang = 'en')
    {
        App::setLocale($lang);
        $productlist = Product::where('product_status','Active')->get();
        
        if($productlist){
            $response['status'] = 1;
            $product_list = $productlist->toArray();
            array_walk_recursive($product_list,function(&$item){$item=strval($item);});
            $response['data'] =  $product_list;
            
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

    public function categoryproductList($lang = 'en')
    {
        App::setLocale($lang);
        $categoryorder = Category::select('id')->where('category_status','Active')->orderBy('id', 'ASC')->skip(0)->take(1)->first();
        $categoryviaproductList = Product::leftjoin('category', 'category.id', '=', 'product.category_id')->where('category.category_status', 'Active')->where('category_id',$categoryorder->id)->where('product_status','Active')->select('product.*', 'category.name', 'category.category_status')->get();

        
        if($categoryviaproductList){
            $response['status'] = 1;
            $categoryviaproduct_list = $categoryviaproductList->toArray();
            array_walk_recursive($categoryviaproduct_list,function(&$item){$item=strval($item);});
            $response['data'] =  $categoryviaproduct_list;
            
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

    public function categoryviaproductList($categoryid,$lang = 'en')
    {
        App::setLocale($lang);
        $categoryviaproductList = Product::leftjoin('category', 'category.id', '=', 'product.category_id')->where('category.category_status', 'Active')->where('category_id',$categoryid)->where('product_status','Active')->select('product.*', 'category.name', 'category.category_status')->get();

        
        if($categoryviaproductList){
            $response['status'] = 1;
            $categoryviaproduct_list = $categoryviaproductList->toArray();
            array_walk_recursive($categoryviaproduct_list,function(&$item){$item=strval($item);});
            $response['data'] =  $categoryviaproduct_list;
            
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

    public function productdetailsList($productdetailsid,$lang = 'en')
    {
        App::setLocale($lang);
        //$user_id = Auth::user()->id;

        $productdetailsList = Product::leftjoin('category', 'category.id', '=', 'product.category_id')->where('category.category_status', 'Active')->where('product.id',$productdetailsid)->where('product_status','Active')->select('product.*', 'category.name', 'category.category_status')->get();
        
        if($productdetailsList){
            $response['status'] = 1;
            $productdetailsList_list = $productdetailsList->toArray();
            array_walk_recursive($productdetailsList_list,function(&$item){$item=strval($item);});
            $response['data'] =  $productdetailsList_list;
            
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

    public function productsearchList($productword,$lang = 'en')
    {
        App::setLocale($lang);
        //$user_id = Auth::user()->id;

        $productdetailsList = Product::leftjoin('category', 'category.id', '=', 'product.category_id')->where('category.category_status', 'Active')->where('product.title', 'LIKE', "%{$productword}%")->where('product_status','Active')->select('product.*', 'category.name', 'category.category_status')->get();
        
        if($productdetailsList){
            $response['status'] = 1;
            $productdetailsList_list = $productdetailsList->toArray();
            array_walk_recursive($productdetailsList_list,function(&$item){$item=strval($item);});
            $response['data'] =  $productdetailsList_list;
            
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

    public function branchDetails($lang = 'en'){
        App::setLocale($lang);
        $branch = Branch::leftjoin('users', 'users.branch_id', '=', 'branch.id')->where('users.branch_user_status', 'Active')->where('users.order_allow','!=','0')->select('branch.*', 'users.branch_user_status', 'users.order_allow')->get();
        if(empty($branch)){
            $response['status'] = 3;
            $response['message'] = __('front/label.api.branch.branchs_not_available');
            $response['lang']    = \app()->getLocale();
        }
        else{
            $response['status'] = 1;
            $branch = $branch->toArray();
            array_walk_recursive($branch,function(&$item){$item=strval($item);});
            $response['data'] =  $branch;
            $response['message'] = __('front/label.api.branch.branchs_fetched_success');
            $response['lang']    = \app()->getLocale();
        }
        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }

}







