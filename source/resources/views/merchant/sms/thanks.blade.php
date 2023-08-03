@extends('merchant.layouts.app')
@section('title', 'SMS決済 | Virtual Bank')

@php($data = $datas['data'])

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2 style="float:none !important;"><i class="fa fa-comments"></i>&nbsp;&nbsp;SMS決済</h2>
                </div>
            </div>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">

                <div class="input-form mt-xlg mb-md">

                    @if($data['result'] == 'success')
                        <p class="success-title">SMS送信しました</p>
                    @else
                        <p class="fail-title">SMS送信に失敗しました</p>
                    @endif

                    <div class="row">
                        <div class="col-xs-12 text-center mt-xlg pb-xlg">
                            <button class="btn btn-default btn-gold" onclick="window.history.back()">戻る</button>
                        </div>
                    </div>
                </div>

            </div>

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
    <link rel="stylesheet" href="{{ asset('public/customer/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('public/merchant/css/common.css') }}">
@endsection

<!-- Custom JS -->
@section('page_js_vendor')
    <script src="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/select2/js/select2.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/ios7-switch/ios7-switch.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/bootstrap-confirmation/bootstrap-confirmation.js') }}"></script>
@endsection
