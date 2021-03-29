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
            <h4 class="header-sub-title">Order Details( <label class="userorder_id"></label> )</h4>
            <input type="hidden" class="editorderid" name="editorderid" id="editorderid" value="{{ $orderid }}">
            <div class="row">
                <div class="col-md-12">
                    

                    @if (Session::has('message'))
                       <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                    <!-- BASIC TABLE -->
                    <!-- <div class="panel">
                        <div class="panel-body">
                            <select>
                            @foreach($productlist as $productlist)
                                <option value="{{ $productlist->id }}" >
                                    {{ $productlist->title }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                    </div> -->
                    <div class="panel">
                        <div class="panel-body">
                            <table id="allorderList" class="display" width="100%">
                                
                            </table>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="modal-content">
                <div class="modal-header">
                    
                    <h4 class="modal-title">User Details </h4>
                </div>
                <div class="modal-body">
                    
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Name :</label>
                            <div class="col-md-8">
                              <label class="name"></label>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Mobile No :</label>
                            <div class="col-md-8">
                                <label class="mobile_no"></label>
                            </div>
                          </div>
                          
                    
                </div>
            </div>
                        </div>
                    </div><div class="panel">
                        <div class="panel-body">
                            <div class="modal-content">
                <div class="modal-header">
                    
                    <h4 class="modal-title">Order Details ( <label class="userorder_id"></label> )</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.allOrderdetailsUpdate') }}" method="post" id="all_add_order_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Order Description :</label>
                            <div class="col-md-8">
                                <input type="text" name="order_des" class="form-control order_des" id="order_des" >
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Order Price :</label>
                            <div class="col-md-8">
                                <input type="text" name="total_amount" class="form-control total_amount" id="total_amount" min="0">
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Total Items :</label>
                            <div class="col-md-8">
                                <label class="total_items"></label>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Order Comment :</label>
                            <div class="col-md-8">
                                <textarea name="order_comment" class="form-control order_comment"  rows="5"></textarea>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Order Status :</label>
                            <div class="col-md-8">
                              @if($orderstatus == "Pending")
                              <label class="radio-inline">
                                  <input type="radio" name="orders_status" value="Pending" checked="checked">Pending
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="orders_status"  value="Accepted">Accept
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="orders_status" value="Rejected">Reject
                                </label>
                              @else
                                <label class="radio-inline">
                                  <input type="radio" name="orders_status"  value="Accepted">Accept
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="orders_status" value="Completed" checked="checked">Completed
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="orders_status" value="Not Completed">Not Completed
                                </label>
                                 @endif
                            </div>
                          </div>

                          <div class="modal-footer">
                            <a href="{{route('admin.orders')}}"><button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button></a>
                            <button type="submit" class="btn btn-warning">Update</button>
                          </div>

                          <input type="hidden" name="order_list_update_id" class="order_list_update_id" id="order_list_update_id" >
                    </form>
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

@endsection

@section('page_js')
<script type="text/javascript" src="{{asset('custom_js/editorder_list.js')}}"></script>
<script>
    
</script>
@endsection