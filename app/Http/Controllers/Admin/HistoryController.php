<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\Helper;
use App\Orders;
use App\Orderitems;
use App\Product;
use Session;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class HistoryController extends Controller
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
     * Show History List.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function historyListView()
    {   
        $data= Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->leftjoin('branch', 'branch.id', '=', 'orders.branch_id')->where('order_status', '!=', '')->whereNotNull('order_status')->whereNotIn('order_status', ['Pending','Accepted'])->select('orders.*', 'users.mobile_number', 'users.address', 'branch.branch_name')->orderBy('orders.id', 'desc')->paginate(10);
         return view('admin.user.history_list', compact('data'));
    }

   

    public function getHistoryorderitemDetails($id){
        $data = [];
        //$getOrdersdata = [];
        $getOrders = Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->where('orders.id', $id)->select('orders.*', 'users.mobile_number', 'users.address')->first();
        
        $getOrderitems = Orderitems::leftjoin('product', 'product.id', '=', 'orderitems.product_id')->where('orderitems.item_order_id', $id)->select('orderitems.*', 'product.title', 'product.product_price')->get()->toArray();
        
        if(count($getOrderitems) > 0){
            foreach ($getOrderitems as $orderitem) {
                $data[] = [$orderitem['id'], $orderitem['title'], $orderitem['product_price'], $orderitem['orderitems_qty'], $orderitem['orderitems_qty']*$orderitem['product_price']];
            }
        }
        return response()->json(['status' => 'Success!','status_code' => 200,'getOrders' => $getOrders,'getOrderscount' => count($getOrderitems),'data' => $data]);
    }

    public  function fetch_data(Request $request)
    {
     if($request->ajax())
     {
      $page = $request->get('page');
      $sort_by = $request->get('sortby');
      $sort_type = $request->get('sorttype');
            $query = $request->get('query');
           $query = str_replace(" ", "%", $query);
           if($query != '')
           {

               $data = Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->leftjoin('branch', 'branch.id', '=', 'orders.branch_id')->where('orders.order_status', '!=', '')->whereNotNull('orders.order_status')->whereNotIn('orders.order_status', ['Pending','Accepted'])->where('orders.user_name', 'like', '%'.$query.'%')->orWhere('orders.order_id', 'like', '%'.$query.'%')->orWhere('orders.order_description', 'like', '%'.$query.'%')->orWhere('orders.order_price', 'like', '%'.$query.'%')->orWhere('orders.self_pickup', 'like', '%'.$query.'%')->orWhere('orders.id', 'like', '%'.$query.'%')->orWhere('orders.latitude', 'like', '%'.$query.'%')->orWhere('orders.longitude', 'like', '%'.$query.'%')->select('orders.*', 'users.mobile_number', 'users.address', 'branch.branch_name')->orderBy('orders.id', 'desc')->paginate(10)->setpath($page);

                //$data->appends(array('q'=>$request->get('query')));

           }

        else{

             $data= Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->leftjoin('branch', 'branch.id', '=', 'orders.branch_id')->where('order_status', '!=', '')->whereNotNull('order_status')->whereNotIn('order_status', ['Pending','Accepted'])->select('orders.*', 'users.mobile_number', 'users.address', 'branch.branch_name')->orderBy('orders.id', 'desc')->paginate(10);          
             }

           

             return view('admin.user.historypagination_list', compact('data'))->render();

      }

     }

    public function getHistoryDetails($id){
        return Helper::getOrderAllDetails($id);
    }
    public  function orderexcel()
    {
      return Excel::download(new OrdersExport, 'Adminrollup.xlsx');
    }
}



   