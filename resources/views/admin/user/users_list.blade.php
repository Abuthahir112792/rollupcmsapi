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
            <h4 class="header-sub-title">Users</h4>
            <div class="row">
                <div class="col-md-12">
                    @if (Session::has('message'))
                       <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                    <!-- BASIC TABLE -->
                    <div class="panel">
                        <div class="panel-body">
                            <table id="usersList" class="display" width="100%">
                                
                            </table>
                        </div>
                    </div>
                    <!-- END BASIC TABLE -->
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
<script type="text/javascript" src="{{asset('custom_js/user_list.js')}}"></script>
<script>
    
</script>
@endsection