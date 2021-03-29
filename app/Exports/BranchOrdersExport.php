<?php

namespace App\Exports;

use App\Orders;
use Maatwebsite\Excel\Concerns\FromArray;
Use Auth;

class BranchOrdersExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
    	$data= Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->where('order_status', '!=', '')->where('orders.branch_id',Auth::user()->branch_id)->whereNotNull('order_status')->whereNotIn('order_status', ['Pending','Accepted'])->select('orders.*', 'users.mobile_number', 'users.room_number', 'users.house_number', 'users.zone_number', 'users.street_name', 'users.area_name', 'users.land_mark', 'users.building_villa_name')->orderBy('orders.id', 'desc')->get();
     $order_array[] = array('Order Date', 'Order Id', 'User Name', 'Price', 'Status', 'Phone', 'Self Pickup', 'Latitude', 'Longitude');
     foreach($data as $orderhistory)
     {
      $order_array[] = array(
       'Order Date'  => date('d-m-Y H:i', strtotime($orderhistory->created_at)),
       'Order Id'   => $orderhistory->order_id,
       'User Name'    => $orderhistory->user_name,
       'Price'  => $orderhistory->order_price,
       'Status'  => $orderhistory->order_status,
       'Phone'  => $orderhistory->mobile_number,
       'Self Pickup'   => $orderhistory->self_pickup,
       'Latitude'   => $orderhistory->latitude,
       'Longitude'   => $orderhistory->longitude
      );
     }
        //return $order_array;
    return $order_array;
    }
}