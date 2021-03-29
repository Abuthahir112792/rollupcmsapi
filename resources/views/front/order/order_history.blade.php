@extends('front.layouts.app')

@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.order_profile.order_history   ')}}
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
    <main  role="main" style="background: url('{{ asset('front/images/home-page-header.jpg') }}') no-repeat fixed center; position: absolute;width: 100%;height: 100%;display: table;background-size: cover;">
        <div 
        style="margin-bottom: 80px" 
        class="container" >
            <h4 
            class="mt-4" 
            style="color: white;font-weight: bold;"
            id="shop-detail-status" style="color: white"></h4>
            <div class="row" dir="ltr" id="main_order_history">
            </div>
        </div>
    </main>
    

    

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
    <script src="{{ asset('front/js/order.js') }}"></script>
@stop
