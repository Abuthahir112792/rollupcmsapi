<?php

namespace App\Exports;

use App\Orders;
use Maatwebsite\Excel\Concerns\FromArray;

class OrdersExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
    	$data= Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->leftjoin('branch', 'branch.id', '=', 'orders.branch_id')->where('order_status', '!=', '')->whereNotNull('order_status')->whereNotIn('order_status', ['Pending','Accepted'])->select('orders.*', 'users.mobile_number', 'users.room_number', 'users.house_number', 'users.zone_number', 'users.street_name', 'users.area_name', 'users.land_mark', 'users.building_villa_name', 'branch.branch_name')->orderBy('orders.id', 'desc')->get();
     $order_array[] = array('Order Date', 'Order Id', 'User Name', 'Price', 'Status', 'Phone', 'Self Pickup', 'Latitude', 'Longitude','Branch Name');
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
       'Longitude'   => $orderhistory->longitude,
       'Branch Name'   => $orderhistory->branch_name
      );
     }
        //return $order_array;
    return $order_array;
    }
}