@extends('layouts.app')
@section('page_css')

@endsection
<style type="text/css">
    .header-sub-title {
        overflow: hidden;
    border-left: 10px solid #00AAFF !important;
    font-weight: 700;
    background: #252c35;
    border-top: 1px solid #ececec;
    border-bottom: 1px solid #ececec;
    display: inline-block;
    margin-bottom: 10px;
    padding: 12px 7px;
    width: 100%;
    font-size: 16px;
    color: #fff !important;
    border-right: 1px solid #ececec;
}

.statusorder {
  float: right;
}

@media screen and (max-width: 500px) {
  .header-sub-title label {
    float: none;
    display: block;
    text-align: left;
  }
  
  .statusorder {
    float: none;
  }
}
</style>
</script>
<!-- <style>
.statusorders {
 display: block;
}
</style> -->
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="header-sub-title ">
                <div class="pull-left">
            <h4 style="margin-top: 9px;">Orders</h4>
        </div>
           @foreach ($neworder as $neworder) 
           <div class="statusorder pull-right" id="statusorders">
            
                  <label >
            <input 
            style="display:none;background: #d63031;border: none;padding: 6px 12px;"
            type="hidden" class="neworder" value="New Pending Orders">
        </label>
        
            <input type="hidden" name="newstatus" id="newstatus" value="{{ $neworder->status }}"></div>

            @endforeach
            </div>

            <!-- <label class="switch">
          <input type="checkbox" class="ordercheck">
          <span class="slider round"></span>
        </label> -->

            <div class="row">
                <div class="col-md-12">
                    @if (Session::has('message'))
                       <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $message)
                                <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- BASIC TABLE -->
                    <div class="panel">
                        <div class="panel-body">
                            <div class="bs-example">
                                <ul id="myTab" class="nav nav-pills">
                                    <li class="nav-item active">
                                        <a href="#incomingorder" class="nav-link" data-toggle="tab">Incoming Order</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#outfordelivery" class="nav-link" data-toggle="tab">Out For Delivery</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#selfpickup" class="nav-link" data-toggle="tab">Self Pickup</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="incomingorder">
                                        <div class="table-responsive">
                                        <table id="incoming_order_table" class="display" width="100%">
                                            
                                        </table>     
                                    </div>
                                    </div>
                                    <div class="tab-pane fade" id="outfordelivery">
                                        <div class="table-responsive">
                                        <table id="out_for_delivery_tbl" class="display" width="100%">
                                            
                                        </table>
                                    </div>  
                                    </div>  
                                    <div class="tab-pane fade" id="selfpickup">
                                        <div class="table-responsive">
                                        <table id="self_pickup_tbl" class="display" width="100%">
                                            
                                        </table>
                                    </div>    
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END BASIC TABLE -->
                </div>
            </div>
        </div>
    </div>
    <div id="incoming-order-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Order Details ( <label class="inc_order_id"></label> )</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.incomingOrderUpdate') }}" method="post" id="incoming_order_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Order Description :</label>
                            <div class="col-md-8">
                              <label class="inc_order_desc"></label>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Order Price :</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control inc_order_price" name="inc_order_price" placeholder="Enter price"  autocomplete="off" require/>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Order Comment :</label>
                            <div class="col-md-8">
                                <textarea name="inc_order_comment" class="form-control inc_order_comment"></textarea>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Order Status :</label>
                            <div class="col-md-8">
                                <label class="radio-inline">
                                  <input type="radio" name="inc_order_status" value="Pending" checked="checked">Pending
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="inc_order_status"  value="Accepted">Accept
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="inc_order_status" value="Rejected">Reject
                                </label>
                            </div>
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                          </div>

                          <input type="hidden" name="inc_order_update_id" id="inc_order_update_id" >
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="out-for-delivery-order" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Order Details ( <label class="out_order_id"></label> )</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.outforOrderUpdate') }}" method="post" id="out_for_delivery_order_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Order Description :</label>
                            <div class="col-md-8">
                              <label class="out_order_desc"></label>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Order Price :</label>
                            <div class="col-md-8">
                                <label class="out_order_price"></label>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Order Comment :</label>
                            <div class="col-md-8">
                                <textarea name="out_order_comment" class="form-control out_order_comment"></textarea>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Order Status :</label>
                            <div class="col-md-8">
                                <label class="radio-inline">
                                  <input type="radio" name="out_order_status" value="Completed" checked="checked">Completed
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="out_order_status" value="Not Completed">Not Completed
                                </label>
                            </div>
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                          </div>

                          <input type="hidden" name="out_order_update_id" id="out_order_update_id" >
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="orderitems-modal" class="modal fade" role="dialog" >
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Order Details ( <label class="all_order_id"></label> )</h4>
                </div>
                <div class="modal-body">
                    <span  id="user_details"></span>
                    <h4 style="padding: 15px;">Product Details </h4>
                    <table id="Orderitem_details" class="display" width="100%"></table>
                    <span  style="padding: 35px;" id="allorder_details"></span>  
                    <span  style="padding: 15px;color: red;opacity: .5;" class="close" data-dismiss="modal">CLOSE</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="cancelnotification_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-body canceltheorder" id="canceltheorder">

                </div>
                <div class="modal-footer border-0 p-0">
                    <a href="{{route('admin.orders')}}"  class="btn btn-link text-dark text-decoration-none">OK</a>
                </div>
            </div>
        </div>
    </div>

    <div id="swift_order_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="swift_order_message"></h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.swiftOrderUpdate') }}" method="post" id="out_for_delivery_order_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                          <div class="input-ct group order-input">
                            
                              <select id="branch_id" class="branch_id" name="branch_id" style="display: block;width: 100%;border:none;border-bottom: 1px solid #1b88dba6;font-size: 13px;">
                                  <option value="">Select</option>
                              </select>
                            
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                          </div>

                          <input type="hidden" name="swift_order_orderid" id="swift_order_orderid" >
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page_js')
<script type="text/javascript" src="{{asset('custom_js/order_list.js')}}"></script>
<script>
    
</script>
@endsection