<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>@if($setting) {{ $setting->site_name }} @endif</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:700%7CNunito:300,600" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{asset('app/css/bootstrap.min.css')}}" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{asset('app/css/font-awesome.min.css')}}">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{asset('app/css/style.css')}}" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="icon" href="{{asset('favicon-96x96.png') }}" sizes="96x96" type="image/png">
    
    @yield('stylesheet')
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
</head>

<body>

    <!-- Header Navigation-->
    @include('includes.header')
    <!-- /Header Navigation-->

    <!-- Page Description header -->
    @yield('header')
    <!-- Page Description header -->

    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                @yield('content')
                
                @yield('rightsidebar')
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- Footer -->
    @include('includes.footer')
    <!-- /Footer -->

    <!-- jQuery Plugins -->
    <script src="{{asset('app/js/jquery.min.js')}}"></script>
    <script src="{{asset('app/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('app/js/main.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    @yield('scripts')
    <!-- Ajax for header -->
    @include('includes.scripts.header')
    <!-- Ajax for header -->

    <!-- Ajax for footer -->
    @include('includes.scripts.footer')
    <!-- Ajax for footer -->
</body>

</html>