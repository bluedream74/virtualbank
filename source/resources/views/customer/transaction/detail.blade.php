@extends('customer.layouts.app')
@section('title', '決済詳細 | VirtualBank')

@php($transaction = $datas['transaction'])
@php($cards = $datas['card_type'])
@php($methods = $datas['payment_method'])

@section('content')
<div role="main" class="main">

    <div class="top-container">
        <h2 class="header-title">決済詳細</h2>

        <div class="transaction_detail">
            <table width="100%">
                <tbody>
                    <tr>
                        <td width="50%">決済ID</td>
                        <td width="50%">t_{{ $transaction->t_id }}</td>
                    </tr>
                    <tr>
                        <td width="50%">処理ステータス</td>
                        <td width="50%">
                            @if($transaction->status == '成功')
                                <p class="success status">{{ $transaction->status }}</p>
                            @else
                                <p class="fail status">{{ $transaction->status . $transaction->errorCode }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">決済日時</td>
                        <td width="50%">{{ $transaction->created_at }}</td>
                    </tr>
                    <tr>
                        <td width="50%">決済金額</td>
                        <td width="50%">¥{{ ceil($transaction->amount) }} </td>
                    </tr>
                    <tr>
                        <td width="50%">カード名義</td>
                        <td width="50%">{{ $transaction->card_holdername }}</td>
                    </tr>
                    <tr>
                        <td width="50%">カードロゴ</td>
                        <td width="50%">
                            @php($cardname = $cards[$transaction->cardtype_id-1]['name'])
                            <img src="{{ asset('public/customer/img/' . $cardname . '.png') }}" width="75"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">クレジットカード番号</td>
                        <td width="50%">**** **** **** {{ substr($transaction->card_number, -4) }}</td>
                    </tr>
                    <tr>
                        <td width="50%">携帯電話番号</td>
                        <td width="50%"><a href="tel:{{$transaction->phone}}">{{ $transaction->phone }}</a></td>
                    </tr>
                    <tr>
                        <td width="50%">決済種別</td>
                        <td width="50%">
                            @php($method = $methods[$transaction->payment_method_id-1]['name'])
                            {{ $method }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row mb-xs">
            <div class="col-xs-12 text-center">
                <button class="btn btn-default btn-gold" style="width: 300px; padding: 15px 40px;" onclick="window.history.back();">戻る</button>
            </div>
        </div>

    </div>

    <!-- shop information -->
    @include('customer.layouts.info')

</div>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">
@endsection
