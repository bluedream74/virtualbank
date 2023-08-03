@extends('customer.layouts.app')
@section('title', 'VirtualBank')

@php($m_name = $datas['m_name'])
@php($name = $datas['name'])
@php($payment_method_id = $datas['payment_method_id'])
@php($phone = $datas['phone'])

@php($visa_fee = $datas['visa_fee'])
@php($jcb_fee = $datas['jcb_fee'])
@php($master_fee = $datas['master_fee'])
@php($amex_fee = $datas['amex_fee'])

@php($status = $datas['status'])

@section('content')
<div role="main" class="main">

@if($status == '契約中')
    <div class="top-container" id="paymentForm">

        <form class="form-horizontal" action="{{ url('payment/confirm') }}" enctype="multipart/form-data" method="post">

            <h2 class="header-title" style="font-size: 28px !important;">クレジットカード決済</h2>
            <p class="text-center mt-md mb-none" style="color: red; font-size: 18px;">下記入力は、全て必須となります</p>

            <input type="hidden" name="visa_fee" value="{{ $visa_fee }}" />
            <input type="hidden" name="jcb_fee" value="{{ $jcb_fee }}" />
            <input type="hidden" name="payment_token" value="{{ $datas['payment_token'] }}" />

            <!-- ご利用店舗名（ShopName）-->
            <div id="shopname" class="mt-xs form-group">

                <p class="title">ご利用店舗名（Shop Name）</p>
                <p class="name">{{ $m_name }}</p>

                <input type="hidden" name="m_name" value="{{ $m_name }}" />
                <input type="hidden" name="name" value="{{ $name }}" />
                <input type="hidden" name="payment_method_id" value="{{ $payment_method_id }}" />

                <p class="amount mb-sm">お申込金額(Amount)</p>
                <input class="form-control" type="number" name="amount" id="amount" width="100%" placeholder="半角数値入力" required />
                <input type="hidden" name="fee" id="fee" value="" />
            </div>

            <!-- 携帯電話番号(cell-phone) -->
            <div id="phonenum">
                <p class="title">携帯電話番号(cell-phone)</p>
                <input class="form-control" type="number" name="phone" id="phone" width="100%" placeholder="半角数値入力ハイフンなし" value="{{ $phone }}" required />

                <div class="row form-group">
                    <div class="col-xs-12">
                        <div class="checkbox-custom checkbox-default col-xs-12">
                            <input type="checkbox" id="agree_email" name="agree_email" onclick='checkEmailClick(this);'><label for="agree_email" style="line-height: 1.8">決済完了メールの受け取りを希望する</label>
                        </div>
                    </div>

                    <div class="col-xs-12 mt-sm hidden" id="email_box">
                        <input class="form-control" type="email" name="email" id="email" width="100%" placeholder="Eメールアドレス" />
                        <p>決済完了後、Eメールアドレスに決済完了メールを送信致します</p>
                    </div>
                </div>

            </div>

            <!-- ご利用可能カード -->
            <div id="card-list">
                <p class="card-title">▼&nbsp;&nbsp;ご利用可能カード&nbsp;&nbsp;▼</p>
                <ul>
                    <li><img src="{{ asset('public/customer/img/VISA.png') }}" width="76" /></li>
                    <li><img src="{{ asset('public/customer/img/MASTERCARD.png') }}" width="76" /></li>
                    <li><img src="{{ asset('public/customer/img/JCB.png') }}" width="76" /></li>
                    <li><img src="{{ asset('public/customer/img/AMEX.png') }}" width="76" /></li>
                </ul>
            </div>

            <!-- カード番号 -->
            <div id="card-info">
                <p class="title">カード番号(Credit Card Number)</p>
                <input class="form-control" type="text" name="card_number" id="card_number" placeholder="半角数値入力ハイフンなし" required autocomplete="cc-number" />
                <input type="hidden" name="cardtype_id" id="cardtype_id" required  />
                <input type="hidden" name="cardtype_name" id="cardtype_name" required  />

                <p class="title">カード有効期限(Expiration Date)</p>
                <div class="row">
                    <div class="col-xs-5 col-xs-offset-1">
                        <select class="form-control" name="card_exp_month" id="card_exp_month" required="" autocomplete="cc-exp-month">
                            <option value="">月</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="col-xs-5">
                        <select class="form-control" name="card_exp_year" id="card_exp_year" required="" autocomplete="cc-exp-year">
                            <option value="">年</option>
                            @for($year=2021;$year<2100;$year++)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <p class="title mt-md">カード名義(Your Name)</p>
                <input class="form-control" type="text" name="card_holdername" id="card_holdername" placeholder="半角ローマ字入力" required autocomplete="cc-name"/>
                <p class="title">セキュリティーコード(CVV)</p>
                <input class="form-control" type="text" name="card_cvv" id="card_cvv" placeholder="半角数値入力" maxlength="4" required autocomplete="cc-csc"/>

                <div class="row mb-md mt-md">
                    <div class="col-xs-6">
                        <img src="{{ asset('public/customer/img/cvv-visa.png') }}" width="100%" />
                        <div class="row mt-sm">
                            <div class="col-xs-4 pl-md pr-none">
                                <img src="{{ asset('public/customer/img/VISA.png') }}" width="100%" />
                            </div>
                            <div class="col-xs-4 pl-xs pr-none">
                                <img src="{{ asset('public/customer/img/MASTERCARD.png') }}" width="100%" />
                            </div>
                            <div class="col-xs-4 pl-xs">
                                <img src="{{ asset('public/customer/img/JCB.png') }}" width="100%" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 p-none">
                        <img src="{{ asset('public/customer/img/cvv-amex.png') }}" width="90%" />
                        <div class="row mt-sm">
                            <div class="col-xs-4 pl-sm pr-none">
                                <img src="{{ asset('public/customer/img/AMEX.png') }}" width="90%" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- links -->
            <div id="links">
                <a class="page-link" href="{{ url('terms') }}"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;利用規約</a>
                <a class="page-link" href="{{ url('privacy-policy') }}"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;個人情報保護規約</a>

                <div class="row form-group mt-md">
                    <div class="col-xs-12">
                        <div class="checkbox-custom checkbox-default col-xs-12">
                            <input type="checkbox" id="agree" name="agree" required /><label for="agree" id="label-agree">利用規約に同意する(Agreement)</label>
                        </div>
                    </div>
                    <div class="col-xs-12 text-center mt-md">
                        <a class="btn btn-default btn-gold" style="width: 290px;border-radius: 13px;" onclick="checkForm()">確認画面へ<br>(Confirmation)</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="confirmForm" class="top-container confirm-container" style="display: none;">

        <h2 class="header-title">クレジットカード決済</h2>
        <p class="text-center mt-md mb-none" style="color: red; font-size: 16px;">下記入力は、全て必須となります</p>

        <form action="{{ url('payment/thanks') }}" method="post" id="payForm">

            <input type="hidden" name="name" value="{{ $datas['name'] }}" />
            <input type="hidden" name="payment_token" value="{{ $datas['payment_token'] }}" />
            <input type="hidden" name="payment_method_id" value="{{ $datas['payment_method_id'] }}" />
            <input type="hidden" id="payment_direct" name="payment_direct" />

            <!-- ご利用店舗名（ShopName）-->
            <div id="shopname" class="mt-xs">
                <p class="title">ご利用店舗名（Shop Name）</p>
                <p class="name">{{ $m_name }}</p>
                <p class="amount">お申込金額＋決済手数料(Amount)</p>
                <input type="text" width="100%" id="amount_visible" readonly/>

                <input type="hidden" id="service_amount" name="service_amount"/>
                <input type="hidden" name="amount" id="amount_hidden" />

                <p class="help">お申込金額に下記決済手数料が加算<br class="visible-xs">されています。<br><span style="color: red; font-size: 15px;" id="cardtype_name_confirm"></span></p>

                <input type="hidden" name="email" id="email_hidden"/>
                <div id="email_panel" style="display: none;">
                    <p class="title">Eメールアドレス</p>
                    <p class="name" id="email_visible"></p>
                    <p class="help">決済完了後、Eメールアドレスに決済完了メールを送信致します</p>
                </div>
            </div>

            <!-- 携帯電話番号(cell-phone) -->
            <div id="card-info">

                <p class="title">携帯電話番号(cell-phone)</p>
                <input type="text" name="cellphone" id="cellphone" width="100%" readonly/>

                <p class="title">カード番号(Credit Card Number)</p>
                <input type="text" name="card_number" id="card_number_confirm" readonly />

                <p class="title">カード有効期限(Expiration Date)</p>

                <input type="text" id="expiry_month_visible" readonly />
                <input name="expiry_month" id="expiry_month" type="hidden" />

                <input name="expiry_year" id="expiry_year_visible" type="hidden" />
                <input name="card_exp_year" id="expiry_year" type="hidden" />

                <p class="title">カード名義(Your Name)</p>
                <input type="text" name="card_holder" id="card_holder" readonly />

                <p class="title">セキュリティーコード(CVV)</p>
                <input type="text" name="cvv" id="cvv" maxlength="4" readonly />
                <input type="hidden" name="cardtype_id" id="cardtype_id_confirm" required />

                {{--<p class="help text-center" style="font-size: 17px; color: red; line-height: 1.2 !important;">決済実行後、SMS(ショートメール)が<br class="visible-xs">届きます。</p>--}}

            </div>

            <!-- links -->
            <div id="links">
                <div class="row form-group">
                    <div class="col-xs-12 text-center">
                        <button id="btnConfirm" class="btn btn-default btn-gold" style="width: 300px;border-radius: 13px;" onclick="requestPayment()">決済実行<br>(Purchase)</button>
                    </div>
                    <div class="col-xs-12 text-center mt-md">
                        <a class="btn btn-default btn-green" style="width: 300px;border-radius: 13px; padding: 20px 40px;" onclick="showInput()">戻る(back)</a>
                    </div>
                </div>
            </div>
        </form>

    </div>

@elseif(($status == '審査中') || ($status == '休止'))
    <p class="comment" style="margin: 70px 0;">この店舗のクレジットカード決済は只今休止中です。<br>詳細は店舗にご確認ください。</p>
@elseif($status == '解約')
    <p class="comment" style="margin: 70px 0;">この店舗のクレジットカード決済はご利用頂けません。<br>詳細は店舗にご確認ください。</p>
@endif

</div>

@endsection


<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">
@endsection

<!-- Custom JS -->
@section('page_js')
    <script>

        function GetCardType(number)
        {
            var cardtype_name = '';
            var cardtype_id = 0;

            // visa
            var re = new RegExp("^4");
            if (number.match(re) != null){
                cardtype_id = 1; //  "Visa";
                cardtype_name = 'VISA';
            }

            // Mastercard
            // Updated for Mastercard 2017 BINs expansion
            /*if (/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/.test(number)) {
                cardtype_id = 2; // "Mastercard";
                cardtype_name = 'MASTERCARD';
            }*/

            re = new RegExp("^5[1-5][0-9]");
            if (number.match(re) != null){
                cardtype_id = 2; // "Mastercard";
                cardtype_name = 'MASTERCARD';
            }

            // AMEX
            re = new RegExp("^3[47]");
            if (number.match(re) != null){
                cardtype_id = 4;
                cardtype_name = 'AMEX';
            }

            // JCB
            re = new RegExp("^35(2[89]|[3-8][0-9])");
            if (number.match(re) != null){
                cardtype_id = 3; // "JCB";
                cardtype_name = 'JCB';
            }

            // card type
            if(cardtype_id != 0){

                $('#cardtype_id').val(cardtype_id);
                $('#cardtype_name').val(cardtype_name);

                switch(cardtype_id)
                {
                    case 1:
                        $('#fee').val('{{ $visa_fee  }}');
                        $('#feeVal').html('{{ $visa_fee  }}%');
                        break;
                    case 2:
                        $('#fee').val('{{ $master_fee  }}');
                        $('#feeVal').html('{{ $master_fee  }}%');
                        break;
                    case 3:
                        $('#fee').val('{{ $jcb_fee  }}');
                        $('#feeVal').html('{{ $jcb_fee  }}%');
                        break;
                    case 4:
                        $('#fee').val('{{ $amex_fee  }}');
                        $('#feeVal').html('{{ $amex_fee  }}%');
                        break;
                }
            }
        }

        // 携帯電話番号
        $('#phone').on('keyup', function(e){

            var val = $(this).val();
            if(val.length > 11) {
                $(this).val(val.substring(0,11));
                return false;
            }
        });

        // カード番号
        $('#card_number').on('keyup', function(e){
            var val = $(this).val();
            var newval = '';
            val = val.replace(/\s/g, '');
            var isOverflow = false;
            if (val.length > 16){
                isOverflow = true;
                val = val.substring(0, 16);
            }
            for(var i=0; i < val.length; i++) {
                if(i%4 == 0 && i > 0) newval = newval.concat(' ');
                newval = newval.concat(val[i]);
            }
            $(this).val(newval);
			return isOverflow;
        });

        function checkForm()
        {
            $('.error').removeClass('error');

            // 申込金額
            var amount = $('#amount').val();
            if((amount == '')){
                $('#amount').addClass('error');
                $('#amount').focus();
                setTimeout(function() { alert('申込金額を入力してください。'); }, 700);
                return false;
            }

            if((amount > 500000) || (amount < 0)){
                $('#amount').addClass('error');
                $('#amount').focus();
                setTimeout(function() { alert('申込金額は50万円までを上限とする。'); }, 700);
                return false;
            }

            // cell-phone
            var phonenum = $('#phone').val();
            if(phonenum == ''){
                $('#phone').addClass('error');
                $('#phone').focus();
                setTimeout(function() { alert('携帯電話番号を入力してください。'); }, 700);
                return false;
            }

            // email
            var agree_email = document.getElementById('agree_email');
            if(agree_email.checked){
                var email = $('#email').val();
                if(email == ''){
                    $('#email').addClass('error');
                    $('#email').focus();
                    setTimeout(function() { alert('Eメールアドレスを入力してください。'); }, 700);
                    return false;
                }
                else {
                    if(!validateEmail(email)) {
                        $('#email').addClass('error');
                        $('#email').focus();
                        setTimeout(function() { alert('Eメールアドレスが不正です。'); }, 700);
                        return false;
                    }
                }
            }

            // card_number
            var card_number = $('#card_number').val();
            if(card_number == ''){
                $('#card_number').addClass('error');
                $('#card_number').focus();
                setTimeout(function() { alert('カード番号を入力してください。'); }, 700);
                return false;
            }

            GetCardType(card_number);
            var cardtype_id = $('#cardtype_id').val();
            if(cardtype_id == ''){
                $('#card_number').addClass('error');
                $('#card_number').focus();
                setTimeout(function() { alert('カード番号が不正です。'); }, 700);
                return false;
            }

            // カード有効期限
            var card_exp_month = $('#card_exp_month').val();
            if(card_exp_month == ''){
                $('#card_exp_month').addClass('error');
                $('#card_exp_month').focus();
                setTimeout(function() { alert('カード有効期限を選択してください。'); }, 700);
                return false;
            }

            var card_exp_year = $('#card_exp_year').val();
            if(card_exp_year == ''){
                $('#card_exp_year').addClass('error');
                $('#card_exp_year').focus();
                setTimeout(function() { alert('カード有効期限を選択してください。'); }, 700);
                return false;
            }

            // カード名義
            var card_holdername = $('#card_holdername').val();
            if(card_holdername == ''){
                $('#card_holdername').addClass('error');
                $('#card_holdername').focus();
                setTimeout(function() { alert('カード名義を入力してください。'); }, 700);
                return false;
            }

            // セキュリティーコード
            var card_cvv = $('#card_cvv').val();
            if(card_cvv == ''){
                $('#card_cvv').addClass('error');
                $('#card_cvv').focus();
                setTimeout(function() { alert('セキュリティーコードを入力してください。'); }, 700);
                return false;
            }

            // agreement
            if(!$('#agree').prop('checked')){
                alert('利用規約に同意？');
                return false;
            }

            // show confirm
            showConfirm();
        }

        function showInput(){
            $('#paymentForm').css('display', 'block');
            $('#confirmForm').css('display', 'none');
        }

        function showConfirm(){
            var amount = $('#amount').val();
            $('#service_amount').val(amount);
            amount = parseFloat(amount);
            amount += (amount * parseFloat($('#fee').val())) / 100;
            amount = Math.ceil(amount);
            $('#amount_hidden').val(amount);
            $('#amount_visible').val(amount);

            var email = $('#email').val();
            $('#email_hidden').val(email);
            if (email != ''){
                $('#email_visible').text(email);
                $('#email_panel').css('display', 'block');
            }

            $('#cellphone').val($('#phone').val());

            $('#card_number_confirm').val($('#card_number').val());
            var exp_month_pad = $('#card_exp_month').val().padStart(2, '0');
            var exp_year = $('#card_exp_year').val();
            $('#expiry_month').val(exp_month_pad);
            $('#expiry_month_visible').val(exp_month_pad + '/' + exp_year);
            $('#expiry_year').val(exp_year);
            $('#expiry_year_visible').val(exp_year.substring(2, 4));
            $('#card_holder').val($('#card_holdername').val());
            $('#cvv').val($('#card_cvv').val());

            var cardtype = $('#cardtype_id').val();
            if (cardtype == '') cardtype = 1;
            $('#cardtype_id_confirm').val(cardtype);
            $('#cardtype_name_confirm').val($('#cardtype_name').val() + " : " + $('#fee').val() + '％');

            $('#paymentForm').css('display', 'none');
            $('#confirmForm').css('display', 'block');

            $('html, body').animate({ scrollTop: 0 }, 'fast');
        }

        function checkEmailClick(obj)
        {
            if(obj.checked){
                $('#email_box').removeClass('hidden');
            }
            else{
                $('#email_box').addClass('hidden');
                $('#email').val('');
            }
        }

        function validateEmail(email) {
            const re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return re.test(String(email).toLowerCase());
        }

        $('form').submit(function() {
            $(this).find("#btnConfirm").prop('disabled',true);
        });
        
        $('#goto_top').on('click', function(){
            window.close();
        });

        // check if popup or direct
        if (window.opener && window.opener !== window) {
            $('#payment_direct').val(0);
        }
        else{
            $('#payment_direct').val(1);
        }

    </script>
@endsection