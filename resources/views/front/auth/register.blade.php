@extends('front.layouts.app')
@section('title')
    {{ __('front/label.title') }} - {{__('front/label.login.sign_up')}}
@stop
@section('css')
    <link href="{{ asset('front/css/login.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    {{--<link href="{{ asset('front/css/intlTelInput.css') }}" rel="stylesheet" type="text/css" />--}}
    <link href="{{ asset('front/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css" />
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
            <h3 class="tittle-w3l">Register
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
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('front/label.register.name') }}" required>
                        </div>
                        {{--<div class="input-ct group mobile-number">
                            <input type="hidden" name="mobile_code" id="mobile_code">
                            <input type="tel" class="country-code" name="mobile" id="mobile">
                        </div>--}}
                        <div class="input-group w3_w3layouts">
                            <span class="input-group-addon"><span class="flag-icon flag-icon-qa flag-icon-squared" id="selected_code"></span>
                            <select name="mobile_code" id="mobile_code" class="country-code"></select>
                            </span>
                            <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="{{ __('front/label.register.mobile') }}">
                        </div>
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
                        <div class="input-group w3_w3layouts">
                            <span class="input-group-addon"><i class="fa fa-address-book-o"></i></span>
                            <input type="text" class="form-control" name="room_number" id="room_number" placeholder="{{ __('front/label.register.room_number_label') }}" required>
                        </div>
                        <div class="input-group w3_w3layouts">
                            <span class="input-group-addon"><i class="fa fa-home"></i></span>
                            <input type="text" class="form-control" name="house_number" id="house_number" placeholder="{{ __('front/label.register.house_number_label') }}" required>
                        </div>
                        <div class="input-group w3_w3layouts">
                            <span class="input-group-addon"><i class="fa  fa-flag-o"></i></span>
                            <input type="text" class="form-control" name="zone_number" id="zone_number" placeholder="{{ __('front/label.register.zone_number_label') }}" required>
                        </div>
                        <div class="input-group w3_w3layouts">
                            <span class="input-group-addon"><i class="fa fa-building"></i></span>
                            <input type="text" class="form-control" name="building_villa_name" id="building_villa_name" placeholder="{{ __('front/label.register.building_villa_name_label') }}" required>
                        </div>
                        <div class="input-group w3_w3layouts">
                            <span class="input-group-addon"><i class="fa fa-road"></i></span>
                            <input type="text" class="form-control" name="street_name" id="street_name" placeholder="{{ __('front/label.register.street_name_label') }}" required>
                        </div>
                        <div class="input-group w3_w3layouts">
                            <span class="input-group-addon"><i class="fa  fa-home"></i></span>
                            <input type="text" class="form-control" name="area_name" id="area_name" placeholder="{{ __('front/label.register.area_name_label') }}" required>
                        </div>
                        <div class="input-group w3_w3layouts">
                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                            <input type="text" class="form-control" name="land_mark" id="land_mark" placeholder="{{ __('front/label.register.land_mark_label') }}" required>
                        </div>
                        <div class="input-group w3_w3layouts">
                            <span class="input-group-addon"><i class="fa fa-share-square"></i></span>
                            <input type="text" class="form-control" name="member_referral" id="member_referral" placeholder="{{ __('front/label.register.referral_label') }}" required>
                        </div>
                        <div class="submit-data text-center">
                            <input class="btn-primary" id="btn_register" type="submit" value="{{ __('front/label.register.go') }}">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-body" id="notification_message">

                </div>
                <div class="modal-footer border-0 p-0">
                    <a href="" id="notification_action" class="btn btn-link text-dark text-decoration-none">{{ __('front/label.register.ok') }}</a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
    <footer style="text-align: center;" >
        <div class="container">
        <span style="color:black" class="other-links">{{ __('front/label.login.are_you_a_newbie') }} <a style="color: #416230;text-decoration: none !important;" href="{{ route('front.login.show') }}">{{ __('front/label.login.sign_in') }}</a></span>
        </div>
    </footer>
@stop

@section('javascript')
    <script src="{{ asset('front/js/main.js') }}"></script>
    <script src="{{ asset('front/js/select2.min.js') }}"></script>
    {{--<script src="{{ asset('front/js/intlTelInput.js') }}"></script>--}}
    {{--<script>
        var utilsScript = '{{ asset('front/js/utils.js') }}';

        $(document).ready(function () {
            var input = document.querySelector("#mobile");
            var iti = window.intlTelInput(input, {
                utilsScript: utilsScript,
                initialCountry:"QA",
                separateDialCode : true,
            });
        })
    </script>--}}
    <script>
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
