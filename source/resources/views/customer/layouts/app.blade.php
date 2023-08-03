<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('favicon.png')}}">
    <link rel="apple-touch-icon" href="{{asset('favicon.png')}}">

    <!-- CSRF Token -->
    <title>@yield('title', config('app.name', 'VirtualBank'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('public/customer/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/customer/vendor/font-awesome/css/font-awesome.min.css') }}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('public/customer/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('public/customer/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('public/customer/css/theme-elements.css') }}">
    <link rel="stylesheet" href="{{ asset('public/customer/css/theme-animate.css') }}">

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{ asset('public/customer/css/skins/default.css') }}">

    <!-- Custom CSS -->
    @yield('page_css')

   <!-- Vendor -->
    <script src="{{ asset('public/customer/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/customer/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/customer/js/common.js') }}"></script>

</head>

<body>
<div class="body">
    @include('customer.layouts.header')

    @yield('content')

    @include('customer.layouts.footer')
</div>


<!-- Theme Base, Components and Settings -->
<script src="{{ asset('public/customer/js/theme.js') }}"></script>
<script src="{{ asset('public/customer/js/theme.init.js') }}"></script>
<script src="{{ asset('public/customer/vendor/jquery.easing/jquery.easing.min.js') }}"></script>


<!-- Custom js -->
@yield('page_js')

</body>
</html>
