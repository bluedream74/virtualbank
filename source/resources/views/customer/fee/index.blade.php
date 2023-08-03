@extends('customer.layouts.app')
@section('title', '手数料設定 | VirtualBank')

@php($visa_fee = $datas['visa_fee'])
@php($master_fee = $datas['master_fee'])
@php($jcb_fee = $datas['jcb_fee'])
@php($amex_fee = $datas['amex_fee'])

@php($s_visa_fee = $datas['s_visa_fee'])
@php($s_master_fee = $datas['s_master_fee'])
@php($s_jcb_fee = $datas['s_jcb_fee'])
@php($s_amex_fee = $datas['s_amex_fee'])

@section('content')
<div role="main" class="main">

    <div class="top-container">
        <h2 class="header-title">手数料設定</h2>

        @if(session('status') == 'updated')
            <p class="text-center mt-md mb-none" style="color: red; font-size: 20px;">手数料が変更されました</p>
        @endif

        <div id="fee_setting">

            <div class="item item1 mb-sm" style="background-color: #99ffcc;">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-12 text-center" style="font-size: 20px; font-weight: bold">お客様の決済手数料</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 text-center b-right">VISA</div>
                        <div class="col-xs-6 text-center">{{ $s_visa_fee +  $visa_fee }}%</div>
                    </div>
                    <div class="row mt-xs">
                        <div class="col-xs-6 text-center b-right">MASTER</div>
                        <div class="col-xs-6 text-center">{{ $s_master_fee + $master_fee }}%</div>
                    </div>
                    <div class="row mt-xs">
                        <div class="col-xs-6 text-center b-right">JCB</div>
                        <div class="col-xs-6 text-center">{{ $s_jcb_fee + $jcb_fee }}%</div>
                    </div>
                    <div class="row mt-xs b-none">
                        <div class="col-xs-6 text-center b-right">AMEX</div>
                        <div class="col-xs-6 text-center">{{ $s_amex_fee + $amex_fee }}%</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 text-center">
                    <img src="{{ asset('public/customer/img/icon_same.png') }}" />
                </div>
            </div>

            <div class="item item2 mt-sm mb-sm">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-12 text-center" style="font-size: 20px; font-weight: bold">（固定）最低決済手数料</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 text-center b-right">VISA</div>
                        <div class="col-xs-6 text-center">{{ $s_visa_fee  }}%</div>
                    </div>
                    <div class="row mt-xs">
                        <div class="col-xs-6 text-center b-right">MASTER</div>
                        <div class="col-xs-6 text-center">{{ $s_master_fee }}%</div>
                    </div>
                    <div class="row mt-xs">
                        <div class="col-xs-6 text-center b-right">JCB</div>
                        <div class="col-xs-6 text-center">{{ $s_jcb_fee }}%</div>
                    </div>
                    <div class="row mt-xs b-none">
                        <div class="col-xs-6 text-center b-right">AMEX</div>
                        <div class="col-xs-6 text-center">{{ $s_amex_fee }}%</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 text-center">
                    <img src="{{ asset('public/customer/img/icon_plus.png') }}" class="plus"/>
                </div>
            </div>

            <div class="item item3 mt-sm" style="background-color: #ccffff;">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-12 text-center" style="font-size: 20px; font-weight: bold">加算決済手数料</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 text-center b-right">VISA</div>
                        <div class="col-xs-6 text-center">{{ $visa_fee }}%</div>
                    </div>
                    <div class="row mt-xs">
                        <div class="col-xs-6 text-center b-right">MASTER</div>
                        <div class="col-xs-6 text-center">{{ $master_fee }}%</div>
                    </div>
                    <div class="row mt-xs">
                        <div class="col-xs-6 text-center b-right">JCB</div>
                        <div class="col-xs-6 text-center">{{ $jcb_fee }}%</div>
                    </div>
                    <div class="row mt-xs b-none">
                        <div class="col-xs-6 text-center b-right">AMEX</div>
                        <div class="col-xs-6 text-center">{{ $amex_fee }}%</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row p-sm" id="fee_help">
            <div class="col-xs-12 text-center">
                <p style="font-size: 16px;" class="mb-xs">加算決済手数料は、自由に変更できます。<br>最低決済手数料は、変更はできません。</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 text-center">
                <a type="submit" class="btn btn-default btn-gold" href="{{ url('fee-setting/edit/') }}" style="width: 300px; padding: 14px 40px;">変更</a>
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

<!-- Custom JS -->
@section('page_js')
@endsection