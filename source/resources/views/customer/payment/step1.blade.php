@extends('customer.layouts.app')
@section('title', 'VirtualBank')

@php($path = $datas['path'])

@section('content')
<div role="main" class="main">

    <div class="top-container">
        <div class="inner">
            <h2>ご利用クレジットカードの、<br>カードブランドを選択してください</h2>
            <table class="flow-table">
                <tbody>
                    <tr>
                        <td width="15%">
                            <input type="radio" id="card_visa" name="card" class="ml-xs" />
                        </td>
                        <td width="85%">
                            <div class="row">
                                <div class="col-xs-5 pt-xs">
                                    <img src="{{ asset('public/customer/img/VISA.png') }}" width="100%" />
                                </div>
                                <p class="col-xs-7 mt-sm card"><strong>VISA</strong><br>ビザカード</p>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td width="15%">
                            <input type="radio" id="card_master" name="card" class="ml-xs" />
                        </td>
                        <td width="85%">
                            <div class="row">
                                <div class="col-xs-5 pt-sm">
                                    <img src="{{ asset('public/customer/img/MASTERCARD.png') }}" width="100%" />
                                </div>
                                <p class="col-xs-7 mt-sm card pt-sm"><strong>MASTER</strong><br>マスターカード</p>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td width="15%">
                            <input type="radio" id="card_jcb" name="card" class="ml-xs" />
                        </td>
                        <td width="85%">
                            <div class="row">
                                <div class="col-xs-5 pt-xs">
                                    <img src="{{ asset('public/customer/img/JCB.png') }}" width="100%" />
                                </div>
                                <p class="col-xs-7 mt-sm card"><strong>JCB</strong><br>ジェイシービーカード</p>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td width="15%">
                            <input type="radio" id="card_amex" name="card" class="ml-xs" />
                        </td>
                        <td width="85%">
                            <div class="row">
                                <div class="col-xs-5 pt-sm">
                                    <img src="{{ asset('public/customer/img/AMEX.png') }}" width="100%" />
                                </div>
                                <p class="col-xs-7 mt-sm card pt-sm"><strong>AMEX</strong><br>アメリカンエキスプレス</p>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
            <div class="text-center mt-xlg">
                <a data-url="{{ url('/payment/step2/' . $path) }}" class="btn btn-default btn-gold btn-next disabled" onclick="goStep2(this)" id="btnNext">次へ</a>             
            </div>
                      
        </div>
        
    </div>

</div>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/payment.css') }}">
@endsection

<!-- Custom JS -->
@section('page_js')

    <script>

        function goStep2(obj)
        {
            var next_url = $(obj).data('url');
            location.href = next_url + '&cardtype_id=' + getCardtype();
        }

        $('input[type="radio"]').change(function() {

            if($(this).is(":checked"))
                $('#btnNext').removeClass('disabled');
            else
                $('#btnNext').addClass('disabled');
        });

        $(function() {
            setTimeout(() => {
                checkCards();
            }, 500);
        });

        // check if card selected
        function checkCards()
        {
            if(getCardtype() != 0)
                $('#btnNext').removeClass('disabled');
            else
                $('#btnNext').addClass('disabled');
        }

        function getCardtype()
        {
            if($('#card_visa').is(":checked"))
                return 1;
            if($('#card_master').is(":checked"))
                return 2;
            if($('#card_jcb').is(":checked"))
                return 3;
            if($('#card_amex').is(":checked"))
                return 4;

            return 0;
        }

    </script>

@endsection