<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    @yield('title')
    @include('front.includes.meta.default')
    @include('front.includes.js-and-css.css')
</head>

<body>
    <!-- Header Navigation-->
    @include('front.includes.header')
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
    @include('front.includes.footer')
    @include('front.includes.js-and-css.js')
</body>

</html>