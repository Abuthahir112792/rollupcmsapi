@extends('layouts.app')
@section('page_css')
@endsection
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <h4 class="header-sub-title">CMS</h4>
            <div class="row">
                <div class="col-md-12">
                    @if (Session::has('message'))
                       <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                    @if (Session::has('error'))
                       <div class="alert alert-danger">{{ Session::get('error') }}</div>
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
                                        <a href="#images" class="nav-link" data-toggle="tab">Images</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#video" class="nav-link" data-toggle="tab">Videos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#logo" class="nav-link" data-toggle="tab">Logo</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#policy" class="nav-link" data-toggle="tab">Privacy Policy</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#condition" class="nav-link" data-toggle="tab">Terms & Conditions</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#shopkeeper" class="nav-link" data-toggle="tab">Shop Keeper Details</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="images">
                                        <form id="imageUpload" action="{{ route('admin.images.upload') }}" method="post" enctype="multipart/form-data">
                                          {{ csrf_field() }}
                                            <input type="file" class="form control form-control-sm" id="uploadFile" name="uploadFile[]" multiple/>
                                            <input type="submit" class="btn btn-success" name='submitImage' value="Upload Images"/>
                                        </form>
                                        <br/>
                                        <div id="image_preview"></div>
                                        @if(isset($cms_data['images']) && count($cms_data['images']) > 0)
                                        <div id="image_preview1">
                                                @foreach ($cms_data['images'] as $k => $v)
                                                    <div class="uploaded_image"><img src="{{asset('cms_media/images/'.$v['media_name'])}}">
                                                    <a href="javascript:;" class="btn btn-danger btn-widhigh delete-image" title="Delete" data-type="image" data-id="{{$v['id']}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </div>
                                                @endforeach
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="video">
                                        <form id="videoUpload" action="{{ route('admin.video.upload') }}" method="post" enctype="multipart/form-data">
                                          {{ csrf_field() }}
                                            <input type="file" id="uploadVideo1" name="uploadVideo1"/>
                                            <input type="file" id="uploadVideo2" name="uploadVideo2"/>
                                            <input type="submit" class="btn btn-success" name='submitImage' value="Upload Videos"/>
                                        </form>
                                        <div class="video_uploaded">
                                         @if(isset($cms_data['videos']) && count($cms_data['videos']) > 0)
                                         @foreach ($cms_data['videos'] as $k => $v)
                                            <div class="video_preview">
                                                <video controls>
                                                  <source src="{{asset('cms_media/videos/'.$v['media_name'])}}" type="video/mp4">
                                                  <!-- <source src="movie.ogg" type="video/ogg"> -->
                                                  Your browser does not support the video tag.
                                                </video>
                                                <a href="javascript:;" class="btn btn-danger btn-widhigh delete-image" title="Delete" data-type="video" data-id="{{$v['id']}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </div>
                                            @endforeach
                                            @endif
                                            
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="logo">
                                        <form id="logoUpload" class="logoUpload" action="{{ route('admin.logo.upload') }}" method="post" enctype="multipart/form-data">
                                          {{ csrf_field() }}
                                            <input type="file" class="form control form-control-sm uploadLogo" id="uploadLogo" name="logo" accept="image/*" />
                                            <input type="submit" class="btn btn-success submit_logo" name='submitLogo' value="Upload Logo"/>
                                        </form>
                                        <br/>
                                        <div id="logo_upload_preview" class="cus_preview"></div>
                                        @if(isset($cms_data['logo']) && count($cms_data['logo']) > 0)
                                        <div id="logo_preview" class="pre_defined_block">
                                                @foreach ($cms_data['logo'] as $k => $v)
                                                    <div class="uploaded_logo cus_block"><img src="{{asset('cms_media/logo/'.$v['media_name'])}}">
                                                    <a href="javascript:;" class="btn btn-danger btn-widhigh delete-image" title="Delete" data-type="logo" data-id="{{$v['id']}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </div>
                                                @endforeach
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="policy">
                                        <form id="privacydetail" action="{{ route('admin.privacy.update') }}" method="post">
                                            {{ csrf_field() }} 
                                            <!-- <textarea name="editor1"></textarea> -->
                                            <textarea name="privacy_content" id="privacy_editor1">
                                                @if(isset($cms_data['Policy']))
                                                    {{ $cms_data['Policy']['page_content'] }}
                                                @endif
                                            </textarea>
                                            <div class="form-group col-xs-11 col-sm-12 col-md-12 col-lg-12">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="condition">
                                        <form id="termdetail" action="{{ route('admin.term.update') }}" method="post">
                                            {{ csrf_field() }} 
                                            <textarea name="term_content" id="term_editor1">
                                                @if(isset($cms_data['Term']))
                                                    {{ $cms_data['Term']['page_content'] }}
                                                @endif
                                            </textarea>
                                            <div class="form-group col-xs-11 col-sm-12 col-md-12 col-lg-12">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="shopkeeper">
                                        <form id="termdetail" action="{{ route('admin.shopkeeper.update') }}" method="post">
                                            {{ csrf_field() }} 
                                            <div class="form-group">
                                            <label for="shopkeeper_number">Phone Number:</label>
                                            <input type="number" class="form-control" placeholder="Enter Phone Number" id="shopkeeper_number" name="shopkeeper_number" value="{{ $cms_data['Shopkeeperno']['page_content'] }}">
                                            </div>
                                            <div class="form-group">
                                            <label for="shopkeeper_email">Email:</label>
                                            <input type="email" class="form-control" placeholder="Enter Email" id="shopkeeper_email" name="shopkeeper_email" value="{{ $cms_data['Shopkeeperemail']['page_content'] }}">
                                            </div>
                                            <div class="form-group col-xs-11 col-sm-12 col-md-12 col-lg-12">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </form>
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
    <div id="delete-image-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_image_id" id="delete_image_id" >
                    <input type="hidden" name="delete_type" id="delete_type" >
                    <p>Are you sure want to delete this media?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger delete-confirm-yes">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_js')
<script src="{{asset('js/ckeditor.js')}}"></script>
<script type="text/javascript" src="{{asset('custom_js/cms_detail.js')}}"></script>
@endsection