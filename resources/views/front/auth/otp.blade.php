@extends('front.layouts.app')
@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.otp_verification.otp_verification') }}
@stop
@section('css')
    <link href="{{ asset('front/css/login.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .otpinput {
    height: 60px;
  width: 60px;
  text-align:center;
  background-color: white;
  border-radius: 50%;
  border:3px solid #416230;
  display: inline-block;        
    color: black;
    
        }
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
        }
    </style>
@stop

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
            <h3 class="tittle-w3l">{{ __('front/label.otp_verification.you_have_received_otp_on_this_mobile') }}{{$mobile}}
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
                        <div  style="align-content: center">
                            <div class="text-center mt-3 mb-5">
                            <input type="number" class="otpinput" id="otp1" type="text" maxlength="1"/>
                            <input type="number" class="otpinput" id="otp2" type="text" maxlength="1"/> 
                            <input type="number" class="otpinput" id="otp3" type="text" maxlength="1"/>
                            <input type="number" class="otpinput" id="otp4" type="text" maxlength="1"/>
                                <input type="hidden" name="mobile" id="mobile" value="{{ $mobile }}">
                                <input type="hidden" name="is_from_login" id="is_from_login" value="{{ $is_login }}" >
                            </div>
                        </div>
                        <div class="submit-data text-center">
                        <input class="btn-primary" id="btn_valid_otp"  type="button" value="{{ __('front/label.otp_verification.go') }}">
                    </div>
                    <div class="back-link mt-5 text-center">
                        <a style="color: #416230;text-decoration: none !important;" href="{{ route('front.home') }}"><< {{ __('front/label.otp_verification.back') }}</a>
                    </div>
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
                    <a href="" id="notification_action" class="btn btn-link text-dark text-decoration-none">{{ __('front/label.otp_verification.ok') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
    <footer style="text-align: center;" >
        <div class="container">
            <span 
            style="color:black"
            class="other-links">{{ __('front/label.otp_verification.i_am_already_a_member') }} <a style="color: #416230;text-decoration: none !important;" href="{{ route('front.login.show') }}">{{ __('front/label.otp_verification.sign_in') }}</a></span>
        </div>
    </footer>
@stop

@section('javascript')
    <script src="{{ asset('front/js/main.js') }}"></script>
    <script type="text/javascript">
        $(".otpinput").keyup(function () {
    if (this.value.length == this.maxLength) {
      $(this).next('.otpinput').focus();
    }
});
    </script>
@stop


