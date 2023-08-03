@extends('customer.layouts.app')
@section('title', 'SMS決済 | VirtualBank')

@php($data = $datas['data'])

@section('content')
<div role="main" class="main">

    <div class="top-container">
        <h2 class="header-title">SMS決済</h2>

        @if($data['result'] == 'success')
            <p class="success-title">SMS送信しました</p>
        @else
            <p class="fail-title">SMS送信に失敗しました</p>
        @endif

    </div>

    <!-- shop information -->
    @include('customer.layouts.info')

</div>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">
@endsection

<!-- Custom JS -->
@section('page_js')
    <script src="{{ asset('public/customer/js/views/top.js') }}" type="text/javascript"></script>
@endsection