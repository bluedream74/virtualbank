@extends('customer.layouts.app')
@section('title', '決済実行 | VirtualBank')

@section('content')
<div role="main" class="main">

    <div class="top-container" id="paymentForm">
        <div class="inner" id="resultContainer">
            <p class="comment p-none mb-xlg" style="font-size: 20px !important;">このURLは有効期間が切れました</p>
            <p class="text-thanks">※画面を閉じて下さい※</p>
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