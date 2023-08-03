@extends('customer.layouts.app')
@section('title', 'SMS決済 | VirtualBank')

@section('content')

<div role="main" class="main">

        <div class="top-container">

            <h2 class="header-title">SMS決済</h2>

            <form action="{{ url('/sms-payment/thanks') }}" method="post" class="input-form">
                {{csrf_field()}}

                <div class="row mt-sm mb-sm">
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <h4 class="control-label text-center" style="color:white; font-size: 25px !important;">携帯電話番号</h4>
                            <input type="number" class="form-control input-lg text-center" placeholder="半角数値入力ハイフンなし" name="phone" id="phone" required="" style="font-size: 20px;" oninvalid="this.setCustomValidity('携帯電話番号入力してください')" oninput="this.setCustomValidity('')"/>
                        </div>
                        <div class="col-xs-12 p-none mt-sm">
                            <p class="attention">必ず予約の携帯電話番号をご入力下さい。<br class="hidden-xs">固定電話番号のご入力はできません。</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button type="submit" class="btn btn-default btn-gold">SMS送信</button>
                    </div>
                </div>

            </form>
        </div>

        <!-- shop information -->
        @include('customer.layouts.info')

</div>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/register.css') }}">
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">
@endsection

<!-- Custom JS -->
@section('page_js')

    <script>

        // 携帯電話番号
        $('#phone').on('keyup', function(e){

            var val = $(this).val();
            if(val.length > 11) {
                $(this).val(val.substring(0,11));
                return false;
            }
        });

    </script>
@endsection