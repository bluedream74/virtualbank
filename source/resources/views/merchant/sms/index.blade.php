@extends('merchant.layouts.app')
@section('title', 'SMS決済 | Virtual Bank')

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

                <form action="{{ url('/merchant/sms-payment/thanks') }}" method="post" class="input-form">
                    {{csrf_field()}}

                    <div class="row mt-xlg mb-md">
                        <div class="col-xs-12 text-center">

                            <div class="form-group">
                                <h4 class="control-label text-center" style="color:white;">携帯電話番号</h4>
                                <input class="form-control input-lg text-center" style="font-size: 20px;" placeholder="半角数値入力ハイフンなし" name="phone" id="phone" required="" oninvalid="this.setCustomValidity('携帯電話番号入力してください')" oninput="this.setCustomValidity('')"/>
                                <p class="attention mt-xlg">必ず予約でご連絡頂いた携帯電話番号をご入力下さい。<br>固定電話番号のご入力はできません。<br>SMS（ショートメール）配信には、1通当たりコストが<br>かかりますのでご注意下さい。</p>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 text-center mt-xlg pb-xlg">
                            <button type="submit" class="btn btn-default btn-gold">SMS送信</button>
                        </div>
                    </div>

                </form>

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
