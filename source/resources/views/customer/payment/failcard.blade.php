@extends('customer.layouts.app')
@section('title', 'カード決済連続失敗 | VirtualBank')

@php($fail_count = $datas['fail_count'])

@section('content')
<div role="main" class="main">

    <div class="top-container" id="paymentForm">
        <div class="inner" id="resultContainer">
            <h2 class="mb-sm">クレジットカード決済</h2>
            <p class="fail-title">決済失敗</p>
            <p class="success-help fail-help">(Settlement Failure)</p>
            <table class="flow-table mb-md">
                <tbody>
                    <tr>
                        <td class="text-center detail pt-md pb-md pl-sm pr-sm">
                            決済が連続で{{ $fail_count }}回失敗した為、<br>ご指定のクレジットカードによる決済に、<br>一定時間ご利用制限がかかっております。<br><br>別のクレジットカードによる決済又は、現金による支払いをお願いいたします。
                        </td>
                    </tr>
                </tbody>
            </table>
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