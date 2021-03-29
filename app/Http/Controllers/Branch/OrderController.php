<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\Helper;
use App\Orders;
use App\Orderstatus;
use App\Orderitems;
use App\Branch;
use App\Product;
use App\User;
use Auth;
use Session;

class OrderController extends Controller
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
    public function ordersListView()
    {   
        $neworder = Orderstatus::select('status')->get();

        return view('branch.user.orders_list', ['neworder' => $neworder]);
    }

    public function incomingOrders(){
        $data = [];
        $getOrders = Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->where('orders.branch_id',Auth::user()->branch_id)->where('order_status', 'Pending')->orWhereNull('order_status')->orwhere('order_status', '')->select('orders.*', 'users.mobile_number', 'users.address')->get()->toArray();
        
        if(count($getOrders) > 0){
            foreach ($getOrders as $order) {
                $date_time = date('d-m-Y H:i', strtotime($order['created_at']));
                $data[] = [$order['id'],$date_time, $order['order_id'], $order['user_name'], $order['order_description'], $order['order_price'], $order['order_status']."-".$order['id'], $order['mobile_number'], $order['address'], $order['self_pickup'], $order['latitude'], $order['longitude'], Helper::encrypt($order['id'])];
            }
        }
        return response()->json($data);
    }
    public function outForDeliveryOrders(){
        $data = [];
        $getOrders = Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->where('order_status', 'Accepted')->where('orders.branch_id',Auth::user()->branch_id)->where('self_pickup', 'False')->select('orders.*', 'users.mobile_number', 'users.address')->get()->toArray();
        
        if(count($getOrders) > 0){
            foreach ($getOrders as $order) {
                $date_time = date('d-m-Y H:i', strtotime($order['created_at']));
                $data[] = [$order['id'],$date_time, $order['order_id'], $order['user_name'], $order['order_description'], $order['order_price'], $order['order_status']."-".$order['id'], $order['mobile_number'], $order['address'], $order['latitude'], $order['longitude'], Helper::encrypt($order['id'])];
            }
        }

        return response()->json($data);
    }

    public function selfPickupOrders(){
        $data = [];
        $getOrders = Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->where('order_status', '=' ,'Accepted')->where('orders.branch_id',Auth::user()->branch_id)->where('self_pickup', '=' ,'True')->select('orders.*', 'users.mobile_number', 'users.address')->get()->toArray();
        
        if(count($getOrders) > 0){
            foreach ($getOrders as $order) {
                $date_time = date('d-m-Y H:i', strtotime($order['created_at']));
                $data[] = [$order['id'],$date_time, $order['order_id'], $order['user_name'], $order['order_description'], $order['order_price'], $order['order_status']."-".$order['id'], $order['mobile_number'], $order['address'], $order['latitude'], $order['longitude'], Helper::encrypt($order['id'])];
            }
        }

        return response()->json($data);
    }

    public function getOrderitemDetails($id){
        $data = [];
        //$getOrdersdata = [];
        $getOrders = Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->where('orders.id', Helper::decrypt($id))->select('orders.*', 'users.mobile_number', 'users.address')->first();
        
        $getOrderitems = Orderitems::leftjoin('product', 'product.id', '=', 'orderitems.product_id')->where('orderitems.item_order_id', Helper::decrypt($id))->select('orderitems.*', 'product.title', 'product.product_price')->get()->toArray();
        
        if(count($getOrderitems) > 0){
            foreach ($getOrderitems as $orderitem) {
                $data[] = [$orderitem['id'], $orderitem['title'], $orderitem['product_price'], $orderitem['orderitems_qty'], $orderitem['orderitems_qty']*$orderitem['product_price']];
            }
        }
        return response()->json(['status' => 'Success!','status_code' => 200,'getOrders' => $getOrders,'getOrderscount' => count($getOrderitems),'data' => $data]);
    }

    public function incomingOrderUpdate(Request $request){
        $id = Helper::decrypt($request->inc_order_update_id);
        if($id != ''){
            Orders::where('id',$id)->update(["order_price"=>$request->inc_order_price,"order_status"=>$request->inc_order_status,"order_comment"=>$request->inc_order_comment]);

            $msg = 'Order updated successfully.';
            $orderDetail = Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->select('mobile_number', 'user_id', 'order_comment', 'order_price', 'order_id', 'self_pickup')->where('orders.id',$id)->first();                
                        
            $userId = $orderDetail->user_id;
            $orderId = $orderDetail->order_id;
            $comment = $orderDetail->order_comment;
            $mobile = $orderDetail->mobile_number;
            $price = $orderDetail->order_price;
            $self_pickup = $orderDetail->self_pickup;

            if($request->inc_order_status == 'Accepted' && $self_pickup == 'True'){
                $smsContent = "Your order has been accepted and is ready for self-pickup ,Your Order Id is $orderId with the amount of $price.$comment";
                $msg = 'Order accepted successfully.';
                $res = Helper::sendSMS($smsContent, $mobile);
            }else if($request->inc_order_status == 'Accepted' && $self_pickup == 'False'){
                $smsContent = "Your Order Id is $orderId. Your order has been accepted with the amount $price and will be delivered soon. $comment";
                $msg = 'Order accepted successfully.';
                $res = Helper::sendSMS($smsContent, $mobile);
            }
            else if($request->inc_order_status == 'Rejected'){
                $smsContent = "Your Order Id is $orderId. Your order has been rejected with reason - $comment";
                $res = Helper::sendSMS($smsContent, $mobile);
                $msg = 'Order rejected successfully.';
            }
            return Redirect::back()->with('message',$msg);
        }
        return Redirect::back()->with('error','Something wrong to update order.');
    }

    public function outForOrderUpdate(Request $request){
        $id = Helper::decrypt($request->out_order_update_id);
        if($id != ''){
            Orders::where('id',$id)->update(["order_status"=>$request->out_order_status,"order_comment"=>$request->out_order_comment]);
            $msg = 'Order updated successfully.';
            if($request->out_order_status == 'Completed'){
                $msg = 'Order completed successfully.';
            }
            return redirect('branch/orders#outfordelivery')->with('message', $msg);
        }
        return redirect('branch/orders#outfordelivery')->with('error','Something wrong to update order.');
    }

    public function getBranchDetail(){
        $branchdata = Branch::leftjoin('users', 'users.branch_id', '=', 'branch.id')->
        where('branch.id','!=',Auth::user()->branch_id)->select('branch.*')->get();
        $output = '<option value="">Select</option>';
     foreach($branchdata as $row)
     {
      $output .= '<option value="'.$row->id.'">'.$row->branch_name.'</option>';
     }
     echo $output;
    }

    public function swiftOrderUpdate(Request $request){
        $id = Helper::decrypt($request->swift_order_orderid);
        $status = "True";
        if($id != ''){
            if($request->branch_id == ''){
                $msg = 'Please select any one branch.';
            }
            else{
            Orders::where('id',$id)->update(["branch_id"=>$request->branch_id]);
            Orderstatus::select('status')->Where('branch_id',$request->branch_id)->orWhere('branch_id','5')->update(["status"=>$status]);
            $msg = 'Order Shifted Successfully';
            }
            return redirect('branch/orders#incomingorder')->with('message', $msg);
        }
        return redirect('branch/orders#incomingorder')->with('error','Something wrong to update order.');
    }

    public function neworderAllow($status){
        $currentbranchid = Auth::User()->branch_id;
        Orderstatus::select('status')->Where('branch_id',$currentbranchid)->orWhere('branch_id','5')->update(["status"=>$status]);
        $msg = 'Pending Order Closed Successfully.';
        if($status == 'True'){
            $msg = 'New Pending Order.';
        }
        return response()->json(['status' => 'Success!','status_code' => 200,'msg' => $msg]);
    }

    public function neworderChecking(){
        $status = "True";
        $currentbranchid = Auth::User()->branch_id;
        $from = date("Y-m-d H:i");
        $to1 = date('Y-m-d H:i',strtotime('-2 minutes',strtotime($from)));
        $to2 = date('Y-m-d H:i',strtotime('-1 minutes',strtotime($from)));
       // $to3 = date('Y-m-d H:i',strtotime('-3 minutes',strtotime($from)));
        $ordercheckingsss = Orders::select('created_at')->orderBy('id', 'desc')->take(1)->first();
        $pendingOrders = Orders::where('order_status','Pending')->count();
        $orderchecking123 = $ordercheckingsss->created_at;
        $orderchecking = $orderchecking123->format('Y-m-d H:i');
        
        $neworderstatus123 = Orderstatus::select('status')->Where('branch_id',$currentbranchid)->first();
        $neworderstatus = $neworderstatus123->status;
        //Code::where('to_be_used_by_user_id', '!=' , 2)->orWhereNull('to_be_used_by_user_id')->get()
        //where('created_at', 'like', '%' . $from . '%')->get();
       // $date = DateTime::createFromFormat($format, '2009-02-15');

//echo "Format: $format; " . $date->format('Y/m/d H:i:s') . "\n";
        //$orderchecking = Orders::where('created_at', 'like', '%' . $from . '%')->first();
        $msg = 'No.';
        //if(($orderchecking == $from || $orderchecking == $to1 || $orderchecking == $to2) && $neworderstatus == $status){
        if($neworderstatus == $status){
        //Orderstatus::select('status')->update(["status"=>$status]);
        $msg = 'New Pending Order.';
        }
        return response()->json(['status' => 'Success!','status_code' => 200,'msg' => $msg,'pending_orders'=>$pendingOrders]);
    }
    
        public function orderStatuschange($id,$status){
        if($id != ''){
            $orderstatus = Orders::where('id', $id)->update(["order_status"=>$status]);

            $msg = 'Order updated successfully.';
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
            return response()->json(['status' => 'Success!','status_code' => 200,'msg' => $msg]);
        }
        return Redirect::back()->with('error','Something wrong to update order.');
        
    }
    
    public function getOrderDetails($id){
        return Helper::getOrderAllDetails($id);
    }
}
