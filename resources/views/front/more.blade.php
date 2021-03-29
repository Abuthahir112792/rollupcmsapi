@extends('front.layouts.app')

@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.more.more') }}
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


    <main class="main mt-4" role="main">
        <div class="container" >
            <h4 style="color:#416230;font-size:2.2rem;font-weight: 500;text-transform: capitalize;">{{ __('front/label.more.more') }}</h4>
            <div class="row">
                                     
                   <div class="col-md-4 col-sm-12 col-xs-12 order-card my-2">
                    <div class="form-group">
                    <label for="more_select_language">{{ __('front/label.more.languages') }}</label>
                    <select style="border:1px solid #416230;" class="form-control " id="more_select_language">
                        <option value="">{{ __('front/label.more.select_language') }}</option>
                        <option value="en">{{ __('front/label.home.english') }}</option>
                        <option value="ar">{{ __('front/label.home.arabic') }}</option>
                    </select>
                    </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 order-card my-2">
                    <div class="form-group">
                    <label for="other">{{__('front/label.more.others')}}</label>
                    <a href="{{ $is_login == 1 ? route('front.feedback') : route('front.login.show') }}" style='color: inherit;'><div style="border:1px solid #416230;" class="form-control" id="other">
                         {{__('front/label.home.feedback')}}
                    </div></a>
                    <a href="{{ $is_login == 1 ? route('front.referral') : route('front.login.show') }}" style='color: inherit;'><div style="border:1px solid #416230;" class="form-control" id="other">
                         {{__('front/label.home.refer_friends')}}
                    </div></a>
                    <a href="{{ route('front.privacy_policy') }}" style='color: inherit;'><div style="border:1px solid #416230;" class="form-control" id="other">
                         {{ __('front/label.home.privacy_policy') }}
                    </div></a>
                    <a href="{{ route('front.terms_condition') }}" style='color: inherit;'><div style="border:1px solid #416230;" class="form-control" id="other">
                         {{__('front/label.home.terms_conditions')}}
                    </div></a>
                    </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 order-card my-2">
                    <div class="form-group">
                    <label for="contact">{{__('front/label.more.contact_us')}}</label>
                    <a href="tel:+{{ $cms_data['Shopkeeperno'] }}" style='color: inherit;'><div style="border:1px solid #416230;" class="form-control" id="contact">
                         {{__('front/label.home.contact_us')}}
                    </div></a>
                    <a href="mailto: {{ $cms_data['Shopkeeperemail'] }}" style='color: inherit;'><div style="border:1px solid #416230;" class="form-control" id="contact">
                         {{__('front/label.home.send_email')}}
                    </div></a>
                    </div>
                    </div>
                    
                    <div class="col-md-12 text-center" >
                        @if($is_login == 1)
                        <button  class="btn btn btn-primary mb-4 mt-5" id="logout">{{__('front/label.more.logout')}}</button>
                        @else
                        <a href="{{ route('front.login.show') }}"><button  class="btn btn btn-primary mb-4 mt-5">{{__('front/label.more.login')}}</button> </a>
                        @endif
                    </div>
    
            
           
            <!-- The Modal -->
            <div id="myModal" class="modal" style="z-index: 2000">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div id="caption"></div>
            </div>

</div>
            </div>
        </div>
        
    </main>
    <footer style="postion:relative;bottom:70px;text-align: center;">
        <div class="container-fluid">
            <p class="copyright"><a style="color: #416230;text-decoration: none !important;" href="https://www.yougo.qa/easybuy" target="_blank">
            {{ __('front/label.footer') }}
            </a></p>
        </div>
    </footer>
    
<div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-body" id="notification_message">

                </div>
                <div class="modal-footer border-0 p-0">
                    <a href="" id="notification_action" class="btn btn-link text-dark text-decoration-none">{{ __('front/label.home.ok') }}</a>
                </div>
            </div>
        </div>
    </div>
    @include('front.layouts.nav',['is_login'=>$is_login])
@stop
@section('footer')
@stop

@section('javascript')
    <script src="{{ asset('front/js/home.js') }}"></script>
@stop
