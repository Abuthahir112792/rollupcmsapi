@extends('front.layouts.app')

@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.profile.profile') }}
@stop
@section('css')
    <link href="{{ asset('front/css/login.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@stop
@section('loader')
    <div class="preloader" style="display: none">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
@stop
@section('content')
        @include('front.layouts.top_nav',['is_login' => $is_login])

    <main class="main " role="main">
        <div class="container" style="margin-top: 20px;padding: 20px;">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="logo">

                        <img src="{{ $logo }}">
                        <!-- <span class="title_logo">{{ __('front/label.logo_title') }}</span> -->
                    </div>
                    <form class="profile-container">
                        <div class="input-ct group">
                            <i class="far fa-user"></i>
                            <input type="text" id="name" name="name" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('front/label.profile.name') }}</label>
                        </div>
                        <div class="input-ct group">
                            <i class="far fa-envelope"></i>
                            <input type="text" name="email" id="email" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('front/label.register.email') }}</label>
                        </div>
                        <div class="input-ct group pass-input">
                            <i class="fa fa-key"></i>
                            <input type="password" name="password" id="password" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('front/label.register.password') }}</label>
                            <a href="#" onclick="myFunctionpass()" id="eye" class="eye pass-cmd"><i class="fas fa-eye"></i></a>
                        </div>
                        <div class="input-ct group input-disabled">
                            <i class="fas fa-mobile-alt"></i>
                            <input type="text" name="mobile" id="mobile" disabled required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('front/label.profile.mobile') }}</label>
                        </div>
                        <div class="input-ct group">
                            <i class="fas fa-door-open"></i>
                            <input type="text" name="room_number" id="room_number" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('front/label.profile.room_number_label') }}</label>
                        </div>
                        <div class="input-ct group">
                            <i class="fas fa-home"></i>
                            <input type="text" name="house_number" id="house_number" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('front/label.profile.house_number_label') }}</label>
                        </div>
                        <div class="input-ct group">
                            <i class="fas fa-border-none"></i>
                            <input type="text" name="zone_number" id="zone_number" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('front/label.profile.zone_number_label') }}</label>
                        </div>
                        <div class="input-ct group">
                            <i class="fas fa-building"></i>
                            <input type="text" name="building_villa_name" id="building_villa_name" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('front/label.profile.building_villa_name_label') }}</label>
                         </div>
                        <div class="input-ct group">
                            <i class="fas fa-road"></i>
                            <input type="text" name="street_name" id="street_name" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('front/label.profile.street_name_label') }}</label>
                        </div>
                        <div class="input-ct group">
                            <i class="fas fa-map-marked-alt"></i>
                            <input type="text" name="area_name" id="area_name" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('front/label.profile.area_name_label') }}</label>
                        </div>
                        <div class="input-ct group">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" name="land_mark" id="land_mark" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('front/label.profile.land_mark_label') }}</label>
                        </div>
                        <div class="submit-data text-center">
                            <input class="btn-primary" id="btn_profile" type="button" value="{{ __('front/label.profile.update') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-body" id="notification_message">

                </div>
                <div class="modal-footer border-0 p-0">
                    <a href="" id="notification_action" class="btn btn-link text-dark text-decoration-none">{{ __('front/label.profile.ok') }}</a>
                </div>
            </div>
        </div>
    </div>

    @include('front.layouts.nav',['is_login'=>$is_login])

@stop
@section('footer')
@stop

@section('javascript')
    <script src="{{ asset('front/js/profile.js') }}"></script>
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
