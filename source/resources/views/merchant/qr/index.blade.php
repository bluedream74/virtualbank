@extends('merchant.layouts.app')
@section('title', 'QR決済 | Virtual Bank')

@php($payment_url = $datas['payment_url'])

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2 style="float:none !important;"><i class="fa fa-qrcode"></i>&nbsp;&nbsp;QR決済</h2>
                </div>
            </div>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">

                <div id="qrcode_container" style="height: 500px; margin-top: 40px;" class="text-center">

                    <p class="title ">QRコード</p>
                    <div id="qrcode" style="margin: 70px auto 30px;; width: 200px;"></div>
                    <button onclick="showEdit()" class="btn btn-default btn-gold mt-xlg" style="padding: 20px !important; font-size: 20px !important;">ダウンロード</button>
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
    <link rel="stylesheet" href="{{ asset('public/merchant/css/common.css') }}" />
@endsection

<!-- Custom JS -->
@section('page_js_vendor')

    <script src="{{ asset('public/admin/js/qrcode.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-alpha1/html2canvas.js"></script>
    <script>

        function createQrcode()
        {
            $('#qrcode').html('');
            $('#qrcode').css('background-color', $('#back_color').val());

            var url = "{{ $payment_url }}";
            var qrcode = new QRCode('qrcode', {
                text: url,
                width: 200,
                height: 200,
                colorDark : '#000',
                colorLight : '#fff',
                correctLevel : QRCode.CorrectLevel.H
            });
        }

        createQrcode();

        function showEdit()
        {
            var url = "{{ url('merchant/qr-payment/edit') }}";
            window.location.href = url;
        }

    </script>
@endsection
