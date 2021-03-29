<!doctype html>
<html lang="en" class="fullscreen-bg">
<head>
    <title>Login | Rollup</title>
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
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="{{asset('theme/assets/css/demo.css')}}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('theme/assets/img/logo_two.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('theme/assets/img/logo_two.png')}}">
    <link rel="stylesheet" href="{{asset('custom_css/common_style.css')}}">
    <script src="{{asset('theme/assets/vendor/jquery/jquery.min.js')}}"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="{{asset('css/bootoast.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('js/bootoast.js')}}"></script>
    <script src="{{asset('custom_js/ajax_call.js')}}"></script>
</head>
<body>
<!-- WRAPPER -->
<div id="wrapper">
    <div class="vertical-align-wrap bg-wrap">
        <div class="vertical-align-middle">
            <div class="auth-box ">
                <div class="left">
                    <div class="content">
                        <div class="header">
                            <div class="logo text-center"><img src="{{ \App\Helpers\Helper::getLogo('login') }}" alt="YouGo Logo" height="154" width="172"></div>
                            <p class="lead">Login to your branch account</p>
                        </div>
                        @if (count($errors) > 0)
                           <div class = "alert alert-danger">
                              <ul>
                                 @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                 @endforeach
                              </ul>
                           </div>
                        @endif
                        <form class="form-auth-small" method="POST" action="{{ route('branch.login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="signin-email" class="control-label sr-only">Email</label>
                                <input type="email" class="form-control email_or_username" id="email_or_username" name="email" value="" placeholder="hello@example.com">
                            </div>
                            <div class="form-group">
                                <label for="signin-password" class="control-label sr-only">Password</label>
                                <input type="password" name="password" class="form-control password" id="signin-password" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block submit_data">LOGIN</button>
                        </form>
                    </div>
                </div>
                <!-- <div class="right">
                    <div class="overlay"></div>
                    <div class="content text">
                        <h1 class="heading">YouGo</h1>
                    </div>
                </div> -->
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<!-- END WRAPPER -->
<script>

</script>
</body>

</html>
