@extends('merchant.layouts.app')
@section('title', '手数料設定 | Virtual Bank')

@php($visa_fee = $datas['visa_fee'])
@php($master_fee = $datas['master_fee'])
@php($jcb_fee = $datas['jcb_fee'])
@php($amex_fee = $datas['amex_fee'])

@php($s_visa_fee = $datas['s_visa_fee'])
@php($s_master_fee = $datas['s_master_fee'])
@php($s_jcb_fee = $datas['s_jcb_fee'])
@php($s_amex_fee = $datas['s_amex_fee'])

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2 style="float:none !important;"><i class="fa fa-yen"></i>&nbsp;&nbsp;手数料設定</h2>
                </div>
            </div>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">
                @if(session('status') == 'updated')
                    <p class="text-center mt-md mb-none" style="color: red; font-size: 20px;">手数料が変更されました</p>
                @endif

                <div id="fee_setting">

                    <div class="item item1 mb-sm" style="background-color: #99ffcc;">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-12 text-center" style="font-size: 20px; font-weight: bold; line-height: 1.6;">お客様の決済手数料</div>
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
                                <div class="col-xs-12 text-center" style="font-size: 20px; font-weight: bold; line-height: 1.6;">（固定）最低決済手数料</div>
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
                                <div class="col-xs-12 text-center" style="font-size: 20px; font-weight: bold; line-height: 1.6;">加算決済手数料</div>
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

                <div class="row p-sm">
                    <div class="col-xs-12 text-center">
                        <p style="font-size: 18px; line-height: 1.7;">加算決済手数料は、自由に変更できます。<br>最低決済手数料は、変更はできません。</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 text-center pb-xlg">
                        <button class="btn btn-default btn-gold" onclick="showEdit()">加算手数料を変更する</button>
                    </div>
                </div>

            </div>

        </section>
        <!-- end page -->

    </section>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/select2/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">
    <link rel="stylesheet" href="{{ asset('public/merchant/css/common.css') }}">
@endsection

<!-- Custom JS -->
@section('page_js_vendor')
    <script src="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/select2/js/select2.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/ios7-switch/ios7-switch.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/bootstrap-confirmation/bootstrap-confirmation.js') }}"></script>
    <script>

        function showEdit()
        {
            window.location.href ="{{ url('merchant/fee-setting/edit/') }}";
        }

    </script>
@endsection
