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
            <h4 style="margin-top: 9px;">Statuslist</h4>
        </div>
            </div>

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
                                    <button class="btn btn-succes" id="add-statuslist-modal"><i class="fa fa-plug" aria-hidden="true"></i>Add Statuslist</button>   
                                    
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" >
                                        <table id="statuslist_list_table" class="display" width="100%">
                                            
                                        </table>  
                                        <button class="btn btn-succes" id="delete-statuslist-multi"><i class="fa fa-plug" aria-hidden="true"></i>Delete Product</button>    
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
    <div id="statuslist-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Statuslist Details</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.addStatuslistUpdate') }}" method="post" id="incoming_statuslist_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        
                        <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Statuslist Name :</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control status_name" name="status_name" placeholder="Enter Name"  id="status_name" autocomplete="off" require/>
                            </div>
                          </div>
                         <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Statuslist Status :</label>
                            <div class="col-md-8">
                                <label class="radio-inline">
                                  <input type="radio" name="status_status" value="Active" checked="checked">Active
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="status_status"  value="Inactive">Inactive
                                </label>
                            </div>
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                          </div>

                          <input type="hidden" name="statuslist_update_id" id="statuslist_update_id" >
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div id="delete-statuslist-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_statuslist_id" id="delete_statuslist_id" >
                    <p>Are you sure want to delete this statuslist?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger delete-statuslist-yes">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div id="muldelete-statuslist-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="muldelete_statuslist_id" id="muldelete_statuslist_id" >
                    <p>Are you sure want to delete this statuslist?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger muldelete-statuslist-yes">Delete</button>
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
                    <a href="{{route('admin.statuslist')}}"  class="btn btn-link text-dark text-decoration-none">OK</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page_js')
<script type="text/javascript" src="{{asset('custom_js/statuslist_list.js')}}"></script>
<script>
    
</script>
@endsection