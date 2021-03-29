<!DOCTYPE html>
<html class=" js flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths" lang="zxx" style=""><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="meta description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">var APP_URL = {!! json_encode(url('/')) !!};</script>
    <script type="text/javascript">var LANGUAGE = '{{ \Illuminate\Support\Facades\Session::has('lang') ? \Illuminate\Support\Facades\Session::get('lang') : 'en' }}'</script>

    @yield('css')
    <!--=== Favicon ===-->
    <link rel="shortcut icon" href="{{asset('front/grocery/images/favicon.png')}}" type="image/x-icon">

    <link href="{{ asset('front/grocery/css/plugins.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('front/grocery/css/style.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('front/grocery/css/vendor.css')}}" rel="stylesheet">

    <!-- Modernizer JS -->
    <script src="{{ asset('front/grocery/js/modernizr-2.8.3.min.js.download') }}"></script>
    <script src="https://kit.fontawesome.com/3e23a000a8.js" crossorigin="anonymous"></script>
     <link rel="apple-touch-icon" href="https://iconifier.net/images/ghosted/apple-touch-icon-152x152.png">
</head>
<body>

@yield('loader')

@yield('header')

@yield('content')


@yield('footer')

<!-- javascript -->
@yield('slider')

<script src="{{ asset('front/grocery/js/vendor.js.download') }}"></script>
<script src="{{ asset('front/grocery/js/plugins.js.download') }}"></script>
<script src="{{ asset('front/grocery/js/active.js.download') }}"></script>
@yield('javascript')
</body>
</html>
