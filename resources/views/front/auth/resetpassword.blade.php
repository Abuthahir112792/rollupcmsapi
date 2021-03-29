@extends('front.layouts.app')

@section('title')
    {{ trans('front/label.title') }} - {{ trans('front/label.login.sign_in') }}
@stop
@section('css')
    <link href="{{ asset('front/css/login.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    {{--<link href="{{ asset('front/css/intlTelInput.css') }}" rel="stylesheet" type="text/css" />--}}
    <link href="{{ asset('front/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css" />
@stop

<style>
    
    .mobile-number .select2-container--default{
        top:15px;
    }
</style>

@section('loader')
    <div class="preloader" style="display: none">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
@stop

@section('content')
    <div class="contact-w3l">
        <div class="container">
            <!-- tittle heading -->
            <h3 class="tittle-w3l">Reset Password
                <span class="heading-style">
                    <i></i>
                    <i></i>
                    <i></i>
                </span>
            </h3>
            <!-- //tittle heading -->
            <!-- contact -->
            
                <div class="contact-agileinfo">
                    <div class="contact-form wthree">
                        <form>
                            <div class="input-group w3_w3layouts">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="password" class="form-control" name="password" id="password" placeholder="{{ __('front/label.register.password') }}">
                            <span class="input-group-addon"><a href="#" onclick="myFunctionpass()"><i class="fa fa-eye"></i></a></span>
                            </div>
                            <div class="input-group w3_w3layouts">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="{{ __('front/label.register.confirmpassword') }}">
                            <span class="input-group-addon"><a href="#" onclick="myFunctionconfirpass()"><i class="fa fa-eye"></i></a></span>
                            </div>
                            <input type="hidden" name="mobile" id="mobile" value="{{ $mobile }}">
                            <input type="hidden" name="userids" id="userids" value="{{ $userids }}" >
                            <div class="submit-data text-center">
                            <input class="btn-primary" type="button" id="btn_resetpassword" value="{{ trans('front/label.login.go') }}" style="display: none">
                        </div>
                        </form>
                    </div>
                </div>
            
            <!-- //contact -->
        </div>
    </div>

    <div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-body" id="notification_message">

                </div>
                <div class="modal-footer border-0 p-0">
                    <a href="" id="notification_action" class="btn btn-link text-dark text-decoration-none">{{ trans('front/label.login.ok') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
    <footer style="text-align: center;">
        <div class="container">
            <span 
            style="color:black"
            class="other-links">{{ trans('front/label.login.are_you_a_newbie') }} <a style="color: #416230;text-decoration: none !important;" href="{{ route('front.register') }}">{{ trans('front/label.login.sign_up') }}</a></span>
        </div>
    </footer>
@stop

@section('javascript')
    <script src="{{ asset('front/js/main.js') }}"></script>
    <script>
        $('#password').keyup(function () {
            var password = $('#password').val();
            if(password != ''){
                 
                     $('#btn_resetpassword').show();

                 }else{
                     $('#btn_resetpassword').hide();
                 }
            
        });
    </script>
    <script>
function myFunctionpass() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
function myFunctionconfirpass() {
  var x = document.getElementById("confirmpassword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
@stop

