@extends('customer.layouts.app')
@section('title', '決済確認画面 | VirtualBank')

@php($data = $datas['data'])

@section('content')
<div role="main" class="main">

    <div class="top-container confirm-container">

        <h2 class="header-title">クレジットカード決済</h2>
        <p class="text-center mt-md mb-none" style="color: red; font-size: 16px;">下記入力は、全て必須となります</p>

        <form action="{{ url('payment/thanks') }}" method="post" id="payForm">

            <input type="hidden" name="name" value="{{ $data['name'] }}" />
            <input type="hidden" name="payment_token" value="{{ $data['payment_token'] }}" />
            <input name="payment_method_id" type="hidden" value="{{ $data['payment_method_id'] }}" />

            <!-- ご利用店舗名（ShopName）-->
            <div id="shopname" class="mt-xs">
                <p class="title">ご利用店舗名（Shop Name）</p>
                <p class="name">{{ $data['m_name'] }}</p>
                <p class="amount">お申込金額＋決済手数料(Amount)</p>
                <input type="text" width="100%" value="¥{{ ceil($data['amount']) }}" readonly/>

                <input type="hidden" value="{{ $data['service_amount'] }}" name="service_amount"/>
                <input type="hidden" name="amount" id="amount" value="{{ ceil($data['amount']) }}" />

                <p class="help">お申込金額に下記決済手数料が加算<br class="visible-xs">されています。<br><span style="color: red; font-size: 15px;">「 {{ $data['cardtype_name'] }} : {{ $data['fee'] }}％ 」</span></p>

                <input type="hidden" name="email" value="{{ $data['email'] }}" />
                @if($data['email'] != '')
                    <p class="title">Eメールアドレス</p>
                    <p class="name">{{ $data['email'] }}</p>
                    <p class="help">決済完了後、Eメールアドレスに決済完了メールを送信致します</p>
                @endif

            </div>

            <!-- 携帯電話番号(cell-phone) -->
            <div id="card-info">

                <p class="title">携帯電話番号(cell-phone)</p>
                <input type="text" name="cellphone" id="cellphone" width="100%" value="{{ $data['phone'] }}" readonly/>

                <p class="title">カード番号(Credit Card Number)</p>
                <input type="text" name="card_number" id="card_number" value="{{ $data['card_number'] }}" readonly />

                <p class="title">カード有効期限(Expiration Date)</p>
                @if( intval($data['card_exp_month']) < 10)
                    <input type="text" value="{{ '0' . $data['card_exp_month'] . '/' . $data['card_exp_year'] }}" readonly />
                    <input name="expiry_month" id="expiry_month" value="{{ '0' . $data['card_exp_month'] }}" type="hidden" />
                @else
                    <input type="text" value="{{ $data['card_exp_month'] . '/' . $data['card_exp_year'] }}" readonly />
                    <input name="expiry_month" id="expiry_month" value="{{ $data['card_exp_month'] }}" type="hidden" />
                @endif

                <input name="expiry_year" id="expiry_year" value="{{ substr($data['card_exp_year'],2,4) }}" type="hidden" />
                <input name="card_exp_year" id="card_exp_year" value="{{ $data['card_exp_year'] }}" type="hidden" />

                <p class="title">カード名義(Your Name)</p>
                <input type="text" name="card_holder" id="card_holder" value="{{ $data['card_holdername'] }}" readonly />

                <p class="title">セキュリティーコード(CVV)</p>
                <input type="text" name="cvv" id="cvv" value="{{ $data['card_cvv'] }}" maxlength="4" readonly />
                <input type="hidden" name="cardtype_id" id="cardtype_id" value="{{ $data['cardtype_id'] }}" required />

                {{--<p class="help text-center" style="font-size: 17px; color: red; line-height: 1.2 !important;">決済実行後、SMS(ショートメール)が<br class="visible-xs">届きます。</p>--}}

            </div>

            <!-- links -->
            <div id="links">
                <div class="row form-group">
                    <div class="col-xs-12 text-center">
                        <button id="btnConfirm" class="btn btn-default btn-gold" style="width: 300px;border-radius: 13px;" onclick="requestPayment()">決済実行<br>(Purchase)</button>
                    </div>
                    <div class="col-xs-12 text-center mt-md">
                        <a class="btn btn-default btn-green" style="width: 300px;border-radius: 13px; padding: 20px 40px;" onclick="window.history.back();">戻る(back)</a>
                    </div>
                </div>
            </div>
        </form>

    </div>

</div>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">
@endsection

<!-- Custom JS -->
@section('page_js')
    <script>
        $('form').submit(function() {
            $(this).find("#btnConfirm").prop('disabled',true);
        });
    </script>
@endsection