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
            <h4 style="margin-top: 9px;">Product</h4>
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
                                    <button class="btn btn-success" id="add-product-modal"><i class="fa fa-plus" aria-hidden="true"></i> Add Product</button>   
                                    
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" >
                                        <table id="product_list_table" class="display" width="100%">
                                            
                                        </table>  
                                        <button class="btn btn-danger" id="delete-product-multi"><i class="fa fa-trash" aria-hidden="true"></i> Delete Product</button>   
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
    <div id="incoming-product-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Product Details</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.addProductUpdate') }}" method="post" id="incoming_croduct_form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        
                        <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Category Name :</label>
                            <div class="col-md-8">
                                <select id="category_id " class="form-control category_id " name="category_id" require>
                                  <option value="">Select</option>
                              </select>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Product Name :</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control title" name="title"
                                id="title" placeholder="Enter Name" require/>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Product Description :</label>
                            <div class="col-md-8">
                                <textarea name="product_description" id="product_description" class="form-control product_description" placeholder="Enter Description"></textarea>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Product Price :</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control product_price" name="product_price" placeholder="Enter price"  autocomplete="off" require/>
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Product Image :</label>
                            <div class="col-md-8">
                                <input type="hidden" name="image_url" id="image_url" value="" > 
                               <img id="img_product" style='width: 110px;' src="{{asset('theme/assets/img/logo_two.png')}}" alt="image" class="upload_imagetest"/>
                               <input type="file" class="form control form-control-sm" id="uploadFile" name="uploadFile" style="display:none;"/>
                               
                            </div>
                          </div>
                          <div class="row form-group d-flex">
                            <label class="control-label col-md-4">Product Status :</label>
                            <div class="col-md-8">
                                <label class="radio-inline">
                                  <input type="radio" name="product_status" value="Active" checked="checked">Active
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="product_status"  value="Inactive">Inactive
                                </label>
                            </div>
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                          </div>

                          <input type="hidden" name="product_update_id" id="product_update_id" >
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div id="delete-product-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_product_id" id="delete_product_id" >
                    <p>Are you sure want to delete this product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger delete-product-yes">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div id="muldelete-product-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="muldelete_product_id" id="muldelete_product_id" >
                    <p>Are you sure want to delete this product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger muldelete-product-yes">Delete</button>
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
                    <a href="{{route('admin.product')}}"  class="btn btn-link text-dark text-decoration-none">OK</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page_js')
<script type="text/javascript" src="{{asset('custom_js/product_list.js')}}"></script>
<script>
    
</script>
@endsection