<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BlogApp</title>
    <!-- Tell the browser to be responsive to screen width -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    @yield('stylesheet')
    <link rel="icon" href="{{asset('favicon-96x96.png') }}" sizes="96x96" type="image/png">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- ./wrapper -->
    <div id="app">
        <div>
            @if(Auth::check())
            @include('admin.includes.topbar')
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->
            @include('admin.includes.sidebar')
            @endif
            @yield('content')
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Summernote -->
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js')}}"></script>

    @yield('script')

</body>

</html>