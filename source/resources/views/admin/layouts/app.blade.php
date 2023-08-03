<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">

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
        <link rel="stylesheet" href="{{ asset('public/admin/vendor/bootstrap/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('public/admin/vendor/font-awesome/css/font-awesome.css') }}">
        <link rel="stylesheet" href="{{ asset('public/admin/vendor/simple-line-icons/css/simple-line-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('public/admin/vendor/owl.carousel/assets/owl.carousel.css') }}">
        <link rel="stylesheet" href="{{ asset('public/admin/vendor/owl.carousel/assets/owl.theme.default.css') }}">
        <link rel="stylesheet" href="{{ asset('public/admin/vendor/magnific-popup/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('public/admin/vendor/pnotify/pnotify.custom.css') }}">

        <!-- Theme CSS -->
        <link rel="stylesheet" href="{{ asset('public/admin/css/theme.css') }}">
        <link rel="stylesheet" href="{{ asset('public/admin/css/theme-custom.css') }}">


        <!-- Skin CSS -->
        <link rel="stylesheet" href="{{ asset('public/admin/css/skins/default.css') }}">

        <!-- Custom CSS -->
        @yield('page_css')

        <!-- Head Libs -->
        <script src="{{ asset('public/admin/vendor/modernizr/modernizr.js') }}"></script>


    </head>

    <body>
        
        @if(Auth::guard('admin')->check())

            <section class="body">

                @include('admin.layouts.header')

                <div class="inner-wrapper">

                    @include('admin.layouts.sidebar-left')

                    @yield('content')

                </div>

                @include('admin.layouts.sidebar-right')

            </section>

        @else

            @yield('content')

        @endif

        <!-- Vendor -->
        <script src="{{ asset('public/admin/vendor/jquery/jquery.js') }}"></script>
        <script src="{{ asset('public/admin/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
        <script src="{{ asset('public/admin/vendor/bootstrap/js/bootstrap.js') }}"></script>
        <script src="{{ asset('public/admin/vendor/nanoscroller/nanoscroller.js') }}"></script>
        <script src="{{ asset('public/admin/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('public/admin/vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
        <script src="{{ asset('public/admin/vendor/jquery-placeholder/jquery-placeholder.js') }}"></script>
        <script src="{{ asset('public/admin/vendor/pnotify/pnotify.custom.js')}}"></script>

        <!-- Custom vendor js -->
        @yield('page_js_vendor')

        <!-- Theme Base, Components and Settings -->
        <script src="{{ asset('public/admin/js/theme.js') }}"></script>

        <!-- Theme Initialization Files -->
        <script src="{{ asset('public/admin/js/theme.init.js') }}"></script>

        <!-- Theme Initialization Files -->
        <script src="{{ asset('public/admin/js/theme.custom.js') }}"></script>

        <!-- Custom page js -->
        @yield('page_js_page')
    </body>
</html>

