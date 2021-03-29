<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\Helper;
use App\Orders;
use App\Orderitems;
use App\Orderstatus;
use App\Product;
use Session;

class EditorderController extends Controller
{   
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show Users List.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editOrderView($id)
    {   
        $productlist = Product::where('product_status','Active')->get();
        $orderstatus = Orders::where('id', Helper::decrypt($id))->first();
        return view('branch.user.editorders_list', ['productlist' => $productlist,'orderid'=>$id,'orderstatus'=>$orderstatus->order_status]);
    }

    public function getallOrderlist($editorderid){
        $data = [];
        $getallOrderlist = Orderitems::leftjoin('orders', 'orders.id', '=', 'orderitems.item_order_id')->leftjoin('product', 'product.id', '=', 'orderitems.product_id')->where('item_order_id', Helper::decrypt($editorderid))->select('orderitems.*', 'product.title', 'product.product_price')->get()->toArray();
        
        if(count($getallOrderlist) > 0){
            foreach ($getallOrderlist as $allOrderlist) {
                $data[] = [$allOrderlist['id'], $allOrderlist['title'], $allOrderlist['product_price'], $allOrderlist['orderitems_qty']."-".$allOrderlist['id'], $allOrderlist['orderitems_qty']*$allOrderlist['product_price']."-".$allOrderlist['id'], Helper::encrypt($allOrderlist['id'])];
            }
        }
        return response()->json($data);
    }

    public function getuserorderlist($editorderid){
        
        $getOrdersuser = Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->where('orders.id', Helper::decrypt($editorderid))->select('orders.*', 'users.mobile_number', 'users.mobile_number', 'users.address')->first();
        
        $getOrderuseritems = Orderitems::leftjoin('product', 'product.id', '=', 'orderitems.product_id')->where('orderitems.item_order_id', Helper::decrypt($editorderid))->select('orderitems.*', 'product.title', 'product.product_price')->get();
        
        
        return response()->json(['status' => 'Success!','status_code' => 200,'getOrdersuser' => $getOrdersuser,'getOrdersusercount' => count($getOrderuseritems)]);
    }

    public function getupdateallorderdetails($editorderid,$itemid,$qty){
        
            $getorderiteminfo = Orderitems::where('item_order_id', Helper::decrypt($editorderid))->where('id', $itemid)->first();
            $getorderprice = Orders::where('id', Helper::decrypt($editorderid))->first();
            $productqty = Product::where('id', $getorderiteminfo->product_id)->first();
        
                $productoprice=$getorderiteminfo->orderitems_price/$getorderiteminfo->orderitems_qty;
            $order_price=(($getorderprice->order_price)+($productoprice*$qty))-(($productoprice*$getorderiteminfo->orderitems_qty));
            
            Orderitems::where('item_order_id', Helper::decrypt($editorderid))->where('id', $itemid)->update(['orderitems_price'=>($productoprice*$qty),'orderitems_qty'=>($getorderiteminfo->orderitems_qty+$qty-$getorderiteminfo->orderitems_qty)]);
            
            Orders::where('id', Helper::decrypt($editorderid))->update(['order_price'=>$order_price]);
            
           
            $orderitemcounts = Orderitems::where('item_order_id', Helper::decrypt($editorderid))->get();
        return response()->json(['status' => 'Success!','status_code' => 200,'totalprice' => $order_price,'subtotal' => ($productoprice*$qty),'totalitem' => count($orderitemcounts)]);   
        
    }
    public function OrderdetailsUpdate(Request $request){
        $id = Helper::decrypt($request->order_list_update_id);
        if($id != ''){
            Orders::where('id',$id)->update(["order_status"=>$request->orders_status,"order_comment"=>$request->order_comment,"order_price"=>$request->total_amount,"order_description"=>$request->order_des]);

            $orderDetail = Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->select('mobile_number', 'user_id', 'order_comment', 'order_price', 'order_id', 'self_pickup', 'order_status','fcm_token')->where('orders.id',$id)->first();                
                        
            $userId = $orderDetail->user_id;
            $orderId = $orderDetail->order_id;
            $comment = $orderDetail->order_comment;
            $mobile = $orderDetail->mobile_number;
            $price = $orderDetail->order_price;
            $self_pickup = $orderDetail->self_pickup;
            $order_status = $orderDetail->order_status;
            $fcm_token = $orderDetail->fcm_token;

            if($order_status == 'Accepted' && $self_pickup == 'True'){
                $smsContent = "Your order has been accepted and is ready for self-pickup ,Your Order Id is $orderId with the amount of $price.$comment";
                $msg = 'Order accepted successfully.';
                $recipients = [$fcm_token];
                fcm()
                    ->to($recipients)
                    ->priority('high')
                    ->timeToLive(0)
                    ->data(['title' => 'BlueDiamond Supermarket','body' => $smsContent])
                    ->notification(['title' => 'BlueDiamond Supermarket','body' => $smsContent])
                    ->send();
            }else if($order_status == 'Accepted' && $self_pickup == 'False'){
                $smsContent = "Your Order Id is $orderId. Your order has been accepted with the amount $price and will be delivered soon. $comment";
                $msg = 'Order accepted successfully.';
                $recipients = [$fcm_token];
                fcm()
                    ->to($recipients)
                    ->priority('high')
                    ->timeToLive(0)
                    ->data(['title' => 'BlueDiamond Supermarket','body' => $smsContent])
                    ->notification(['title' => 'BlueDiamond Supermarket','body' => $smsContent])
                    ->send();
            }
            else if($order_status == 'Rejected'){
                $smsContent = "Your Order Id is $orderId. Your order has been rejected with reason - $comment";
                $recipients = [$fcm_token];
                fcm()
                    ->to($recipients)
                    ->priority('high')
                    ->timeToLive(0)
                    ->data(['title' => 'BlueDiamond Supermarket','body' => $smsContent])
                    ->notification(['title' => 'BlueDiamond Supermarket','body' => $smsContent])
                    ->send();
                $msg = 'Order rejected successfully.';
            }
            else if($order_status == 'Completed'){
                $smsContent = "Your Order Id is $orderId. Your order has been completed with reason - $comment";
                $recipients = [$fcm_token];
                fcm()
                    ->to($recipients)
                    ->priority('high')
                    ->timeToLive(0)
                    ->data(['title' => 'BlueDiamond Supermarket','body' => $smsContent])
                    ->notification(['title' => 'BlueDiamond Supermarket','body' => $smsContent])
                    ->send();
                $msg = 'Order completed successfully.';
            }
            else if($order_status == 'Not Completed'){
                $smsContent = "Your Order Id is $orderId. Your order has been not completed with reason - $comment";
                $recipients = [$fcm_token];
                fcm()
                    ->to($recipients)
                    ->priority('high')
                    ->timeToLive(0)
                    ->data(['title' => 'BlueDiamond Supermarket','body' => $smsContent])
                    ->notification(['title' => 'BlueDiamond Supermarket','body' => $smsContent])
                    ->send();
                $msg = 'Order not completed successfully.';
            }
            $msg = 'Order updated successfully.';
            return redirect('branch/orders')->with('message', $msg);
        }
        return redirect('branch/orders')->with('error','Something wrong to update order.');
    }
    
}
