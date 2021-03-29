<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!};
    </script>
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{ asset('theme/assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{asset('theme/assets/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('theme/assets/vendor/linearicons/style.css')}}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{asset('theme/assets/css/main.css')}}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{asset('theme/assets/img/logo_two.png')}}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{asset('theme/assets/img/logo_two.png')}}">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="{{asset('css/bootoast.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css">
    <!-- export -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/buttons.dataTables.min.css')}}">
    <!-- export -->
    <link rel="stylesheet" href="{{asset('custom_css/common_style.css')}}">
	@yield('page_css')
</head>

<body>
    <div class="loder_cla"> <img src="{{asset('theme/assets/img/loder.gif')}}" class="manu-img"> </div>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		@include('branch.layouts1.header')
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		@include('branch.layouts1.sidebar')
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			@yield('content')
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		@include('branch.layouts1.footer')
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('theme/assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('theme/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script src="{{asset('theme/assets/scripts/klorofil-common.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/bootoast.js')}}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/moment@2.24.0"></script> -->
    <!-- export excel -->
    <script type="text/javascript" src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jszip.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/buttons.html5.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/buttons.print.min.js')}}"></script>
    <!-- export excel -->
    <script type="text/javascript" src="{{asset('branch/custom_js/ajax_call.js')}}"></script>
	<script>

	</script>
    @yield('page_js')
</body>

</html>
