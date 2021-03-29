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
            <h3 class="tittle-w3l">Login
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
                            {{--<div class="input-ct group mobile-number">
                            <input type="hidden" name="mobile_code" id="mobile_code">
                            <input type="tel" class="country-code" name="mobile" id="mobile">
                            </div>--}}
                            <div class="input-group w3_w3layouts">
                            <span class="input-group-addon"><span class="flag-icon flag-icon-qa flag-icon-squared" id="selected_code"></span>
                            <select name="mobile_code" id="mobile_code" class="country-code"></select>
                            <i class="fas fa-mobile-alt"></i></span>
                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="{{ __('front/label.forgot.mobile') }}">
                            </div>
                            <div class="input-group w3_w3layouts">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="password" class="form-control" name="password" id="password" placeholder="{{ __('front/label.register.password') }}">
                            <span class="input-group-addon"><a href="#" onclick="myFunctionpass()"><i class="fa fa-eye"></i></a></span>
                            </div>
                            <div class="submit-data text-center">
                            <input class="btn-primary" type="button" id="btn_login" value="{{ trans('front/label.login.go') }}" style="display: none">
                        </div>
                        </form>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <span class="other-links"><a href="{{ route('front.forgot') }}">
                                        {{ trans('front/label.forgot.title') }}
                                </a></span>
                                
                            </div>
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
    {{--<script src="{{ asset('front/js/intlTelInput.js') }}"></script>--}}
    <script src="{{ asset('front/js/select2.min.js') }}"></script>

    <script>
        /*var utilsScript = '{{ asset('front/js/utils.js') }}';

        $(document).ready(function () {
            var input = document.querySelector("#mobile");
            var iti = window.intlTelInput(input, {
                utilsScript: utilsScript,
                initialCountry:"QA",
                separateDialCode : true,
            });

            $('#mobile').keyup(function () {
                console.log('number is validate :'+iti.isValidNumber());
                if (iti.isValidNumber()) {
                    $('#btn_login').show();
                } else {
                    $('#btn_login').hide();
                }
            })
        })*/

        (function($) {
            $(function() {
                var isoCountries = [
                    { id: '+974', sort:'QA', text: 'QA +974'},
                    { id: '+91', sort:'IN', text: 'IN +91'},
                    { id: '+92', sort:'PK', text: 'PK +92'},
                    { id: '+90', sort:'TR', text: 'TR +90'},
                    { id: '+20', sort:'EG', text: 'EG +20'},
                    { id: '+63', sort:'PH', text: 'PH +63'},
                    { id: '+880', sort:'BD', text: 'BD +880'},
                    { id: '+94', sort:'LK', text: 'LK +94'},
                    { id: '+961', sort:'LB', text: 'LB +961'},
                ];

                function formatCountry (country) {
                    if (!country.id) { return country.code; }
                    var $country = $(
                        '<span class="flag-icon flag-icon-'+ country.sort.toLowerCase() +' flag-icon-squared"></span>' +
                        '<span class="flag-text">'+ country.text+"</span>"
                    );
                    return $country;
                };

                //Assuming you have a select element with name country
                // e.g. <select name="name"></select>

                $("#mobile_code").select2({
                    placeholder: "Select a country",
                    templateResult: formatCountry,
                    data: isoCountries
                });

                $('#mobile_code').change(function () {
                    var code = $(this).val();
                    $("#selected_code").removeAttr('class');
                    var class_name = '';
                    if(code == '+974'){
                        class_name = 'flag-icon flag-icon-qa flag-icon-squared';
                    }
                    else if(code == '+91'){
                        class_name = 'flag-icon flag-icon-in flag-icon-squared';
                    }
                    else if(code == '+92'){
                        class_name = 'flag-icon flag-icon-pk flag-icon-squared';
                    }
                    else if(code == '+90'){
                        class_name = 'flag-icon flag-icon-tr flag-icon-squared';
                    }
                    else if(code == '+20'){
                        class_name = 'flag-icon flag-icon-eg flag-icon-squared';
                    }else if(code == '+63'){
                        class_name = 'flag-icon flag-icon-ph flag-icon-squared';
                    }else if(code == '+880'){
                        class_name = 'flag-icon flag-icon-bd flag-icon-squared';
                    }else if(code == '+94'){
                        class_name = 'flag-icon flag-icon-lk flag-icon-squared';
                    }else if(code == '+961'){
                        class_name = 'flag-icon flag-icon-lb flag-icon-squared';
                    }
                    $('#selected_code').addClass(class_name)
                })
            });
        })(jQuery);

        $('#mobile').keyup(function () {
            var country_code = $('#mobile_code').val();
            var mobile = $('#mobile').val().trim().length;
            if(country_code == '+91' || country_code == '+92' || country_code == '+90' || country_code == '+20' || country_code == '+63' || country_code == '+880'){
                 if(mobile == 10){
                     $('#btn_login').show();

                 }else{
                     $('#btn_login').hide();
                 }
            }
            if(country_code == '+974'){
                if(mobile == 8){
                    $('#btn_login').show();

                }else{
                    $('#btn_login').hide();
                }
            }
            if(country_code == '+94' || country_code == '+218'){
                if(mobile == 9){
                    $('#btn_login').show();
                }else{
                    $('#btn_login').hide();
                }
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
</script>
@stop

