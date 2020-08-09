<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BlogApp</title>
    @include('admin.includes.css.main')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="app">
        <div>
            @if(Auth::guard('admin')->check())
            @include('admin.includes.topbar')
            @include('admin.includes.sidebar')
            @endif
            @yield('content')
        </div>
    </div>
    @include('admin.includes.js.main')
</body>

</html>