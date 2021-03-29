@extends('front.layouts.app')

@section('title')
    YouGo - Add Order
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
    @include('front.layouts.nav')
@stop
@section('footer')
@stop

@section('javascript')
    <script src="{{ asset('front/js/order.js') }}"></script>
@stop
