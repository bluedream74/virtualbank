@extends('customer.layouts.app')
@section('title', 'VirtualBank')

@php($phone = $datas['phone'])

@section('content')
<div role="main" class="main">

    <div class="top-container" id="paymentForm">
        <div id="phoneContainer">
            <p class="large text-center mb-none"><strong>携帯電話番号(Cell-Phone)</strong><br>{{ $phone }}</p>
        </div>

        <div id="textContainer">
            <p class="medium text-thanks">上記電話番号宛にショートメール(SMS)を<br>送信しました</p>
            <p class="command">届いたメッセージのURLをクリックして<br>決済を実行して下さい</p>
            <p class="medium text-thanks">URL有効期限は15分となります<br>※画面を閉じて下さい※</p>
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
 @endsection