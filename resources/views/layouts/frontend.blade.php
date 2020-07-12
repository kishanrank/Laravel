<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    @yield('title')
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Pragma" content="cache">
    <meta name="revisit-after" content="2 days">
    <meta name="copyright" content="shubham infotech">
    <meta name="author" content="kishanrank, kmrank111@gmail.com">
    <meta name="identifier-URL" content="http://127.0.0.1:8000/">
    <meta name="allow-search" content="yes">
    <meta name="coverage" content="Worldwide">
    <meta name="audience" content="all">
    <meta name="distribution" content="Global">
    <meta name="rating" content="General">
    <link rel="canonical" href="{{ route('front.home') }}" />
    <meta name="keywords" content="Laravel, HTML, CSS, Javascript, Ajax, jQuery, Angular, Node js, Vue, SQL, PHP, XML, learning, tutorial, how, to, blog, article, create, programming, code, Magento"/>
    @yield('meta')

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:700%7CNunito:300,600" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{asset('app/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('app/css/font-awesome.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('app/css/style.css')}}" />
    <link rel="icon" href="{{asset('favicon-96x96.png') }}" sizes="96x96" type="image/png">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    @yield('stylesheet')
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