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
use App\Product;
use App\Orderstatus;
use App\Orderitems;
use App\Branch;
use Google\Cloud\Translate\V2\TranslateClient;
class OrderController extends BaseController
{
    public function placeOrder(Request $request, $lang = 'en')
    {  
        App::setLocale($lang);
        $data = json_decode($request->getContent(),true);
        $self_pickup = $data["self_pickup"];
        $product_id = $data["product_id"];
        $orderitems_qty = $data["orderitems_qty"];
        $product_ids = $product_id;
        $branch_id = $data["branch_id"];
        $pids=Product::select('id')->get();
        foreach($pids as $pidss){
            $pid_array[] =$pidss['id'];
        }
        foreach($product_id as $pid){
            if (!(in_array($pid, $pid_array))){
                $response['status'] = 2;
                $response['message'] =  __('front/label.api.place_order.product_id_not_found');
                $response['lang']    = \app()->getLocale();
                array_walk_recursive($response,function(&$item){$item=strval($item);});
                return response()->json($response);
            }
        }
        if(empty($product_id)){
            $response['status'] = 2;
            $response['message'] =  __('front/label.api.place_order.product_check');
            $response['lang']    = \app()->getLocale();
        }
        
        else if($branch_id == ''){
            $response['status'] = 2;
            $response['message'] =  __('front/label.api.place_order.branch_check');
            $response['lang']    = \app()->getLocale();
        }
        else if($self_pickup === 'False' && ($data["latitude"] == '' || $data["longitude"] == '')){
            $response['status'] = 2;
            $response['message'] =  __('front/label.api.place_order.latitude_longitude_check');
            $response['lang']    = \app()->getLocale();
        }
        
        else{
            
                    $user_details = User::select('order_allow')->where('role','shop_keeper')->first();
                    if($user_details){
                        if($user_details->order_allow == 1){
                            $orderId = 'ORD'.'-'.mt_rand(100000, 999999);
                            $newOrder = new Orders();
                            $newOrder->user_id = Auth::user()->id;
                            $newOrder->user_name = Auth::user()->name;
                            $newOrder->order_id = $orderId;
                            $newOrder->self_pickup = $self_pickup;
                            $newOrder->order_status = 'Pending';
                            if($self_pickup === 'False'){
                                $newOrder->latitude = $data["latitude"];
                                $newOrder->longitude= $data["longitude"];
                            }
                            $newOrder->branch_id = $branch_id;
                            $newOrder->save();
                            foreach ($product_id as $key => $value) {
                                $productprice = Product::where('id',$product_id[$key])->first();
                                $newOrderitems = new Orderitems();
                                $newOrderitems->item_order_id = $newOrder->id;
                                $newOrderitems->product_id = $product_id[$key];
                                $newOrderitems->orderitems_qty = $orderitems_qty[$key];
                                $newOrderitems->orderitems_price = $productprice->product_price*$orderitems_qty[$key];
                                $newOrderitems->save();
                                $balanceproductqty = $productprice->product_qty - $orderitems_qty[$key];
                                //Product::where('id',$product_id[$key])->update(['product_qty'=>$balanceproductqty]);  
                            }
                            $totalamount = Orderitems::where('item_order_id',$newOrder->id)->sum('orderitems_price');
                            $updateamount = Orders::where('id',$newOrder->id)->update(['order_price'=>$totalamount]);

                            $status = 'True';
                            Orderstatus::where('branch_id','5')->orWhere('branch_id',$branch_id)->update(["status"=>$status]);
                            if($newOrder && $newOrderitems){
                                $response['status'] = 1;
                                $response['message'] = __('front/label.api.place_order.order_place_successfully');
                                $response['lang']    = \app()->getLocale();
                            }else{
                                $response['status'] = 0;
                                $response['message'] = __('front/label.api.place_order.something_wrong');
                                $response['lang']    = \app()->getLocale();
                            }
                        }else{
                                $response['status'] = 2;
                                $response['message'] = __('front/label.api.place_order.shop_close_now');
                                $response['lang']    = \app()->getLocale();
                            }
                        }else{
                            $response['status'] = 2;
                            $response['message'] = __('front/label.api.place_order.shop_did_not_found');
                            $response['lang']    = \app()->getLocale();
                        }
                    }
                    array_walk_recursive($response,function(&$item){$item=strval($item);});
                    return response()->json($response);
           
    
    }


    public function orderHistory($lang = 'en')
    {
        App::setLocale($lang);
        $user_id = Auth::user()->id;

        $orders = Orders::where('user_id',$user_id)->orderBy('id', 'desc')->get();
        $user_details = User::select('order_allow')->where('role','shop_keeper')->first();
        if($orders){
            $response['status'] = 1;
            $orders_list = $orders->toArray();
            array_walk_recursive($orders_list,function(&$item){$item=strval($item);});
            $response['data'] =  $orders_list;
            $response['shop_keeper'] =  $user_details->order_allow;
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

    public function orderDetails($orderidid,$lang = 'en')
    {
        App::setLocale($lang);
        $user_id = Auth::user()->id;

        $orders = Orders::where('id',$orderidid)->orderBy('id', 'desc')->get();
        $orderitems = Orderitems::leftjoin('product', 'product.id', '=', 'orderitems.product_id')->where('item_order_id',$orderidid)->select('orderitems.*', 'product.title')->get();
        $user_details = User::select('order_allow')->where('role','shop_keeper')->first();
        if($orders){
            $response['status'] = 1;
            $orders_list = $orders->toArray();
            $orderitems_list = $orderitems->toArray();
            array_walk_recursive($orders_list,function(&$item){$item=strval($item);});
            $response['data'] =  $orders_list;
            $response['orderitemsdata'] =  $orderitems_list;
            $response['shop_keeper'] =  $user_details->order_allow;
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

    public function cancelOrder(Request $request, $lang = 'en')
    {
        App::setLocale($lang);
        $order_id = $request->order_id;
        $order_status = 'Cancelled';
        $orderbranchid = Orders::where('id',$order_id)->first();
        $cancelOrder = Orders::where('id',$order_id)->update(["order_status"=>$order_status]);

        

                    $status = 'True';
                    Orderstatus::where('branch_id','5')->orWhere('branch_id',$orderbranchid->branch_id)->update(["status"=>$status]);
    
                    if($cancelOrder){
                        $response['status'] = 1;
                        $response['message'] = __('front/label.api.place_order.order_cancel_successfully');
                        $response['lang']    = \app()->getLocale();
                    }
               
        array_walk_recursive($response,function(&$item){$item=strval($item);});
        return response()->json($response);
    }
}







