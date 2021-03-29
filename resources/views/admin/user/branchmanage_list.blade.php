@extends('layouts.app')
@section('page_css')

@endsection
<style type="text/css">
    .header-sub-title {
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
</style>
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <h4 class="header-sub-title">BranchManage</h4>
            <div class="row">
                <div class="col-md-12">
                    @if (Session::has('message'))
                       <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                    <!-- BASIC TABLE -->
                    <div class="panel">
                        <div class="panel-body">
                            <div class="bs-example">
                                <ul id="myTab" class="nav nav-pills">
                               
                                      
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" >
                                        <table id="branchmanageList" class="display" width="100%">
                                            
                                        </table>  
                                             
                                       
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
    
   

    <div id="incoming-branchmanage-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reset Password</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.addUserUpdate') }}" method="post" id="incoming_branchmanage_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">User Name :</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control name" name="user-name"
                                id="user-name" placeholder="Enter Name" require readonly />
                            </div>
                          </div>
                           <div class="row form-group d-flex">
                            <label class="control-label col-md-4">User email :</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control user_email" name="user_email" placeholder="Enter email"  autocomplete="off" require readonly/>
                            </div>
                          </div>
                           <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Password :</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control user_password" name="user_password" placeholder="Enter userpassword" require/>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Confirm Password :</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control user__confirm_password" name="user__confirm_password" placeholder="Enter userpassword" require/>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Submit</button>
                          </div>

                          <input type="hidden" name="branch_user_id" id="branch_user_id" >
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div id="delete-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_user_id" id="delete_user_id" >
                    <p>Are you sure want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger delete-confirm">Delete</button>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('page_js')
<script type="text/javascript" src="{{asset('custom_js/branchmanager_list.js')}}"></script>
<script>
    
</script>
@endsection