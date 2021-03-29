@extends('branch.layouts1.app')
@section('page_css')

@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <h4 class="header-sub-title">History</h4>
            <div class="row">
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
                <div class="col-md-12">
                    <!-- BASIC TABLE -->
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                 <div class="col-md-9">
                                        <a href="{{ route('branch.bexport_excel.bexcel') }}" class="btn btn-primary">Excel</a>
                                </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                <input type="text" name="serach" id="serach" class="form-control" />
                                 </div>
                                </div>
                                </div>
                            <div class="table-responsive">
                             <table class="table table-striped table-bordered">
                             <thead>
                                <tr>
                                <th>Order Date</th>
                                <th>Order Id</th>
                                <th>User Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Self Pickup</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Action</th>
                                </tr>
                             </thead>
                            <tbody>
                                @include('branch.user.historypagination_list')
                            </tbody>
                            </table>
                            <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                            <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="orders.id" />
                            <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
                        </div>
                    </div>
                    </div>
                    <!-- END BASIC TABLE -->
                </div>
            </div>
        </div>
    </div>

    <div id="history-list-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Order Details ( <label class="his_order_id"></label> )</h4>
                </div>
                <div class="modal-body">
                          <div class="row d-flex">
                            <label class="control-label col-md-4">Order Description :</label>
                            <div class="col-md-8">
                              <label class="his_order_desc"></label>
                            </div>
                          </div>
                          <div class="row d-flex">
                            <label class="control-label col-md-4">Order Price :</label>
                            <div class="col-md-8">
                                <label class="his_order_price"></label>
                            </div>
                          </div>
                          <div class="row d-flex">
                            <label class="control-label col-md-4">Order Comment :</label>
                            <div class="col-md-8">
                                <label class="his_order_comment"></label>
                            </div>
                          </div>
                          <div class="row d-flex">
                            <label class="control-label col-md-4">Order Status :</label>
                            <div class="col-md-8">
                                <label class="his_order_status"></label>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="historyorderitems-modal" class="modal fade" role="dialog" >
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Order Details ( <label class="historyall_order_id"></label> )</h4>
                </div>
                <div class="modal-body">
                    <span  id="historyuser_details"></span>
                    <h4 style="padding: 15px;">Product Details </h4>
                    <table id="historyOrderitem_details" class="display" width="100%"></table>
                    <span  style="padding: 35px;" id="historyallorder_details"></span>  
                    <span  style="padding: 15px;color: red;opacity: .5;" class="close" data-dismiss="modal">CLOSE</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
<script type="text/javascript" src="{{asset('branch/custom_js/history_list.js')}}"></script>
<script>
    
</script>
@endsection