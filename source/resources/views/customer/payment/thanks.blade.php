@extends('customer.layouts.app')
@section('title', '決済実行 | VirtualBank')

@php($data = $datas['data'])
@php($payment_method_id = $datas['payment_method_id'])

@section('content')
<div role="main" class="main">

    <div class="top-container">
        <h2 class="header-title" style="font-size: 28px;">クレジットカード決済</h2>

        @if($data->return_code == '0000')

            <p class="success-title">決済成功</p>
            <p class="success-help">(Successful Payment)</p>
            <div id="invoice-company">
                <p class="title">請求社名</p>
                <p class="help">VirtualB</p>
            </div>

            <div id="transaction-info">
                <p>決済日時: &nbsp;&nbsp;&nbsp;{{ date('Y-m-d H:i') }}</p>
                <p>決済額: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;￥{{ number_format(ceil($data->amount)) }}</p>
                <p>カード番号: **** **** **** {{ substr($data->card_number, -4) }}</p>
                <p>カード名義: {{ $data->card_holder }}</p>
                <p>携帯電話番号: {{ $data->phone }}</p>
            </div>

            <p class="comment">海外決済の請求名は、カード会社でなく、<br class="hidden-xs">海外からのご請求名となります。</p>
            <p class="pay_comment">円建ての決済となりますのでご安心下さい。<br>ご利用ありがとうございます。</p>
            <p class="comment"><span>※画面を閉じて下さい。</span>
        @else

            <p class="fail-title">決済失敗</p>
            <p class="success-help">(Settlement Failure)</p>

            @if($data->return_code == '9999')
                <p class="comment_token">※再決済をご希望の場合、<br class="visible-xs">一度画面を閉じて下さい。<br>再びカード情報入力画面を開いて、<br class="visible-xs">決済の操作を行って下さい。</p>
            @elseif($data->return_code == '9998')
                <p class="comment_token">カード情報入力に一定時間かかりますと、<br class="hidden-xs">セキュリティの関係上処理が行われません。</p>
            @else

                <div id="invoice-company">
                    <p class="title">失敗コード</p>
                    <p class="help">{{ $data->return_code }}</p>
                </div>

                <p class="comment"><span style="text-decoration: underline">入力情報に誤りがないかご確認下さい。</span><br class="hidden-xs">『オンライン海外決済』や『海外ショッピング』に制限がないかを<br class="hidden-xs">カード会社（特に、楽天カード）にご確認の上、ご決済下さい。</p>
                <p class="comment"><span style="text-decoration: underline">※再決済をご希望の場合、</span><br class="hidden-xs">一度画面を閉じて下さい。再びカード情報入力画面を開いて、決済の操作を行って下さい。</p>
            @endif
        @endif

        @if ($payment_method_id == "1")
            <div class="row">
                <div class="col-xs-12 text-center mt-md mb-lg">
                    <a class="btn btn-default btn-green" style="width: 300px;border-radius: 13px; padding: 20px 40px;" onclick="closeMe();" id="btnClose">画面を閉じる</a>
                </div>
            </div>
        @endif
    </div>

</div>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">
@endsection

<!-- Custom JS -->
@section('page_js')
    <script src="{{ asset('public/customer/js/views/top.js') }}" type="text/javascript"></script>
    <script>

        if (window.opener && window.opener !== window) {
            // you are in a popup
        }
        else{
            $('#btnClose').hide();
        }

        function closeMe(){
            open(location, '_self').close();
            return false;
        }

        $('#goto_top').on('click', function(){
            window.location.replace("{{ url('/') }}");
        });
    </script>
@endsection