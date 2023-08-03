@extends('customer.layouts.app')
@section('title', 'VirtualBank')

@php($user = $datas['user'])
@php($invoice_url = $datas['invoice_url'])

@section('content')
<div role="main" class="main">

    <div class="top-container pt-none">
        <div class="container mt-sm">
            <div class="row" id="menu-list">

                <div class="col-xs-6 col-sm-4 p-sm">
                    <a class="menu-item" href="{{ url('/sms-payment') }}">
                        <img src="{{ asset('public/customer/img/icon_sms.png') }}" width="60"/>
                        <p style="color: #6bb92d">SMS決済</p>
                    </a>
                </div>

                <div class="col-xs-6 col-sm-4 p-sm">
                    <a class="menu-item" data-toggle="modal" data-target="#qrDialog">
                        <img src="{{ asset('public/customer/img/icon_qr.png') }}" width="60"/>
                        <p style="color: #ff6c03;">QR決済</p>
                    </a>
                </div>

                <div class="col-xs-6 col-sm-4 p-sm">
                    <a class="menu-item" onclick="popupPayment('{{ $user->data->payment_url }}')">
                        <img src="{{ asset('public/customer/img/icon_card.png') }}" width="60"/>
                        <p style="color: #089ce4;">直接入力決済</p>
                    </a>
                </div>

                <div class="col-xs-6 col-sm-4 p-sm">
                    <a class="menu-item" href="{{ url('/transaction') }}">
                        <img src="{{ asset('public/customer/img/icon_pay.png') }}" width="60"/>
                        <p style="color: #ef8c0c">決済一覧</p>
                    </a>
                </div>

                <div class="col-xs-6 col-sm-4 p-sm">
                    <a class="menu-item" href="{{ url('/fee-setting') }}">
                        <img src="{{ asset('public/customer/img/icon_fee.png') }}" width="60"/>
                        <p style="color: #2d6f9f;">手数料設定</p>
                    </a>
                </div>

                <div class="col-xs-6 col-sm-4 p-sm">
                    <a class="menu-item" onclick="showPasswordModal()">
                        <p style="margin-top: -14px; color: #f52424">準備中</p>
                        <img src="{{ asset('public/customer/img/icon_invoice.png') }}" width="60"/>
                        <p style="color: #f52424">精算書</p>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- shop information -->
    @include('customer.layouts.info')

    <!-- ログアウト -->
    <div class="row">
        <div class="col-xs-12 text-center mb-md">
            <a href="{{ url('/logout') }}" class="btn btn-default btn-gold">ログアウト</a>
        </div>
    </div>

    <!-- QRCodeDialog -->
    <div class="modal fade" id="qrDialog" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title" id="modal-title" style="font-size: 24px;">QRコード</h5>
                </div>
                <div class="modal-body p-md">
                    <form>
                        <div class="form-group text-center">
                            <img src="{{ $user->data->qrcode }}" width="80%"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-default btn-white" data-dismiss="modal" style="width: 90%;">閉じる</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end dialog -->

    <!-- PasswordDialog -->
    <div class="modal fade" id="pwdDialog" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center" style="border-bottom: none">
                    <h5 class="modal-title" id="modal-title" style="font-size: 24px;">パスワード</h5>
                </div>

                <div class="modal-body p-md pt-none">
                    <div class="password_body">
                        {{--<input type="text" maxlength="1" id="p1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />--}}
                        <input type="text" maxlength="1" id="p1" />
                        <input type="text" maxlength="1" id="p2" />
                        <input type="text" maxlength="1" id="p3" />
                        <input type="text" maxlength="1" id="p4" />
                        <p id="wrong_password" class="mt-sm hidden">パスワードが不正です。</p>
                    </div>
                </div>

                <div class="modal-footer text-center"  style="border-top: none">
                    <button type="button" class="btn btn-danger" style="width: 120px; font-size: 18px;" onclick="checkPassword()">確認</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal" style="width: 120px; font-size: 18px;">キャンセル</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end dialog -->

</div>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">
@endsection

<!-- Custom JS -->
@section('page_js')
    <script>

        function showPasswordModal()
        {
            $('#pwdDialog').modal('show');
        }

        function checkPassword()
        {
            var p1 = $('#p1').val();
            var p2 = $('#p2').val();
            var p3 = $('#p3').val();
            var p4 = $('#p4').val();
            if((p1 == '') || (p2 == '') || (p3 == '') || (p4 == '')){
                $('#wrong_password').removeClass('hidden');
                return false;
            }

            if((p1 == '0') && (p2 == '5') && (p3 == '3') && (p4 == '0')){
                window.location.href = '{{ $invoice_url }}';
            }
            else {
                $('#wrong_password').removeClass('hidden');
                return false;
            }
        }

        function popupPayment(url){

            const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

            const w = 400;
            const h = 1000;

            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft
            const top = (height - h) / 2 / systemZoom + dualScreenTop

            window.open(url, '_blank', `scrollbars=yes,
            width=${w / systemZoom}, 
            height=${h / systemZoom}, 
            top=${top}, 
            left=${left}
            `);
        }

    </script>
@endsection