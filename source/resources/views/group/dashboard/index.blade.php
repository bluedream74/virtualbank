@extends('group.layouts.app')
@section('title', 'Virtual Bank')

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2 style="float:none !important;">&nbsp;&nbsp;Virtual Bank</h2>
                </div>
            </div>
        </header>

        <!-- start page -->
        <section class="panel">
            <div class="panel-body"></div>
        </section>
        <!-- end page -->

    </section>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/select2/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/merchant/css/common.css') }}" />
@endsection

<!-- Custom JS -->
@section('page_js_vendor')
@endsection
