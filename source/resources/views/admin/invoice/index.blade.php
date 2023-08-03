@extends('admin.layouts.app')
@section('title', '精算 | Virtual Bank')

@php($list = $datas['list'])

@php($start_date = $datas['start_date'])
@php($end_date = $datas['end_date'])
@php($start_output = $datas['start_output'])
@php($end_output = $datas['end_output'])
@php($invoice_id = $datas['invoice_id'])
@php($merchant_id = $datas['merchant_id'])
@php($shop_id = $datas['shop_id'])
@php($start_invoice = $datas['start_invoice'])
@php($end_invoice = $datas['end_invoice'])
@php($amount_min = $datas['amount_min'])
@php($amount_max = $datas['amount_max'])
@php($pay_cycle = $datas['pay_cycle'])
@php($shop_name = $datas['shop_name'])

@php($shop_count = $datas['shop_count'])
@php($pay_amount = $datas['pay_amount'])
@php($total_count = $datas['total_count'])
@php($total_amount = $datas['total_amount'])
@php($cc_count = $datas['cc_count'])
@php($cc_amount = $datas['cc_amount'])
@php($cb_count = $datas['cb_count'])
@php($cb_amount = $datas['cb_amount'])
@php($month_amount = $datas['month_amount'])
@php($transaction_fee = $datas['transaction_fee'])
@php($tf_fee = $datas['tf_fee'])
@php($sms_fee = $datas['sms_fee'])
@php($cc_fee = $datas['cc_fee'])
@php($cb_fee = $datas['cb_fee'])
@php($enter_fee = $datas['enter_fee'])
@php($rr_amount = $datas['rr_amount'])
@php($rr_fee = $datas['rr_fee'])

@php($list = $datas['list'])
@php($pagelen = json_decode($datas['pagelen']))

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h2><i class="fa fa-files-o"></i>&nbsp;&nbsp;精算</h2>
                    <a class="btn btn-danger pull-right text-right mr-xlg" style="margin-top: 7px;" onclick="downloadCSV();">CSVダウンロード</a>
                </div>
            </div>

        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">

                <div class="row pl-md">
                    <label class="col-sm-6" style="font-weight: bold; color: #000000; font-size: 18px;">検索条件</label>
                </div>

                <!-- filter -->
                <div class="filter mb-xlg" style="padding: 15px; border: 1px solid #444;">

                    <form class="form-horizontal" action="{{ url('admin/invoice/search/') }}" enctype="multipart/form-data" method="post" id="searchForm">

                        <div class="row">

                            <label class="col-sm-1 mt-xs text-right">決済期間</label>
                            <div class="col-sm-2">
                                <input id="start_date" name="start_date" type="date" class="form-control" value="{{ $start_date }}" />
                            </div>

                            <label class="col-sm-1 text-center" style="width: 90px">～</label>
                            <div class="col-sm-2">
                                <input id="end_date" name="end_date" type="date" class="form-control" value="{{ $end_date }}" />
                            </div>

                            <label class="col-sm-1 control-label" style="width: 120px;">ご入金予定日</label>
                            <div class="col-sm-2">
                                <input id="start_output" name="start_output" type="date" class="form-control" value="{{ $start_output }}" />
                            </div>

                            <label class="col-sm-1 text-center" style="width: 90px">～</label>
                            <div class="col-sm-2">
                                <input id="end_output" name="end_output" type="date" class="form-control" value="{{ $end_output }}" />
                            </div>

                        </div>

                        <div class="row mt-sm">

                            <label class="col-sm-1 control-label text-right">発行日</label>
                            <div class="col-sm-2">
                                <input id="start_invoice" name="start_invoice" type="date" class="form-control" value="{{ $start_invoice }}" />
                            </div>

                            <label class="col-sm-1 text-center" style="width: 90px">～</label>
                            <div class="col-sm-2">
                                <input id="end_invoice" name="end_invoice" type="date" class="form-control" value="{{ $end_invoice }}" />
                            </div>

                            <label class="col-sm-1 control-label text-right" style="width: 120px;">決済金額</label>
                            <div class="col-sm-2">
                                <input id="amount_min" name="amount_min" type="number" class="form-control" value="{{ $amount_min }}" />
                            </div>

                            <label class="col-sm-1 text-center" style="width: 90px">～</label>
                            <div class="col-sm-2">
                                <input id="amount_max" name="amount_max" type="number" class="form-control" value="{{ $amount_max }}" />
                            </div>

                        </div>

                        <div class="row mt-sm">
                            <label class="col-sm-1 mt-xs text-right">精算ID</label>
                            <div class="col-sm-2">
                                <input id="invoice_id" name="invoice_id" type="text" class="form-control" value="{{ $invoice_id }}" />
                            </div>

                            <label class="col-sm-1 mt-xs text-right" style="width: 90px;">加盟店ID</label>
                            <div class="col-sm-2">
                                <input id="merchant_id" name="merchant_id" type="text" class="form-control" value="{{ $merchant_id }}" />
                            </div>

                            <label class="mt-xs col-sm-1 text-right" style="width: 120px;">店舗ID</label>
                            <div class="col-sm-2">
                                <input id="shop_id" name="shop_id" type="text" class="form-control" value="{{ $shop_id }}" />
                            </div>

                            <label class="mt-xs col-sm-1 text-right" style="width: 90px;">店舗名</label>
                            <div class="col-sm-2">
                                <input id="shop_name" name="shop_name" type="text" class="form-control" value="{{ $shop_name }}" />
                            </div>

                        </div>

                        <div class="row mt-sm">
                            <input id="pagelen" name="pagelen" type="hidden" class="form-control" value="{{ $pagelen }}" />
                            <label class="mt-xs col-xs-1 text-right" style="width: 125px;">支払いサイクル</label>
                            <div class="col-xs-2">
                                <select class="form-control" id="pay_cycle" name="pay_cycle">
                                    <option value=""></option>
                                    <option value="1" @if($pay_cycle == 1) selected @endif>月１支払い</option>
                                    <option value="2" @if($pay_cycle == 2) selected @endif>月２支払い</option>
                                    <option value="3" @if($pay_cycle == 3) selected @endif>週１支払い</option>
                                    <option value="4" @if($pay_cycle == 4) selected @endif>毎日支払い</option>
                                </select>
                            </div>
                            <div class="col-xs-6"></div>
                            <div class="col-xs-3 text-right">
                                <button type="submit" class="btn btn-success" style="width: 100px;">検索</button>
                                <a class="btn btn-white ml-xs" style="width: 100px; border: 1px solid #ccc; color: #000000" onclick="reset()" >リセット</a>
                            </div>
                        </div>

                    </form>

                </div>

                <!-- 集計機能 -->
                <div id="report" class="mb-xlg">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="text-center">
                            <tr>
                                <th class="yellow"></th>
                                <th class="text-center yellow">店舗件数</th>
                                <th class="text-center yellow">お支払い金額</th>
                                <th class="text-center blue">決済件数</th>
                                <th class="text-center blue">決済金額</th>
                                <th class="text-center blue">取消し件数</th>
                                <th class="text-center blue">取消し金額</th>
                                <th class="text-center blue">CB件数</th>
                                <th class="text-center blue">CB金額</th>
                                <th class="text-center pink">月額管理費用</th>
                                <th class="text-center pink">決済手数料</th>
                                <th class="text-center pink">TF認証料</th>
                                <th class="text-center pink">SMS送信料</th>
                                <th class="text-center pink">取消し手数料</th>
                                <th class="text-center pink">CB手数料</th>
                                <th class="text-center pink">振込手数料</th>
                                <th class="text-center green">RR金額</th>
                                <th class="text-center green">RR精算</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="yellow"><strong>合計</strong></td>
                                <td class="yellow">{{ number_format($shop_count) }}</td>
                                <td class="yellow">
                                    @if($pay_amount < 0)
                                        －
                                    @endif
                                    ¥{{ number_format(ceil(abs($pay_amount))) }}
                                </td>
                                <td class="blue">{{ number_format($total_count) }}</td>
                                <td class="blue">¥{{ number_format(ceil($total_amount)) }}</td>
                                <td class="blue">{{ number_format($cc_count) }}</td>
                                <td class="blue">¥{{ number_format(ceil($cc_amount)) }}</td>
                                <td class="blue">{{ number_format($cb_count) }}</td>
                                <td class="blue">¥{{ number_format(ceil($cb_amount)) }}</td>
                                <td class="pink">¥{{ number_format(ceil($month_amount)) }}</td>
                                <td class="pink">¥{{ number_format($transaction_fee) }}</td>
                                <td class="pink">¥{{ number_format(ceil($tf_fee)) }}</td>
                                <td class="pink">¥{{ number_format($sms_fee) }}</td>
                                <td class="pink">¥{{ number_format($cc_fee) }}</td>
                                <td class="pink">¥{{ number_format($cb_fee) }}</td>
                                <td class="pink">¥{{ number_format($enter_fee) }}</td>
                                <td class="green">－¥{{ number_format(abs($rr_amount)) }}</td>
                                <td class="green">+¥{{ number_format(abs($rr_fee)) }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <!-- table -->
                <table class="table table-bordered text-center" id="invoice_datatable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center yellow">精算ID</th>
                            <th class="text-center yellow">加盟店ID</th>
                            <th class="text-center yellow">店舗ID</th>
                            <th class="text-center yellow">店舗名</th>
                            <th class="text-center yellow">支払いサイクル</th>
                            <th class="text-center yellow">発行日</th>
                            <th class="text-center yellow">決済期間</th>
                            <th class="text-center yellow">お支払い金額</th>
                            <th class="text-center yellow">ご入金予定日</th>

                            <th class="text-center blue">決済件数</th>
                            <th class="text-center blue">決済金額</th>
                            <th class="text-center blue">取消し件数</th>
                            <th class="text-center blue">取消し金額</th>
                            <th class="text-center blue">CB件数</th>
                            <th class="text-center blue">CB金額</th>

                            <th class="text-center pink">月額管理費用</th>
                            <th class="text-center pink">決済手数料</th>
                            <th class="text-center pink">TF認証料</th>
                            <th class="text-center pink">SMS送信料</th>
                            <th class="text-center pink">取消し手数料</th>
                            <th class="text-center pink">CB手数料</th>
                            <th class="text-center pink">振込手数料</th>

                            <th class="text-center darkorange">繰越金</th>
                            <th class="text-center green">RR金額</th>
                            <th class="text-center green">RR精算</th>

                            <th class="text-center blue csv hidden">(V)決済件数</th>
                            <th class="text-center blue csv hidden">(V)決済金額</th>
                            <th class="text-center blue csv hidden">(V)取消し件数</th>
                            <th class="text-center blue csv hidden">(V)取消し金額</th>
                            <th class="text-center blue csv hidden">(V)CB件数</th>
                            <th class="text-center blue csv hidden">(V)CB金額</th>

                            <th class="text-center blue csv hidden">(M)決済件数</th>
                            <th class="text-center blue csv hidden">(M)決済金額</th>
                            <th class="text-center blue csv hidden">(M)取消し件数</th>
                            <th class="text-center blue csv hidden">(M)取消し金額</th>
                            <th class="text-center blue csv hidden">(M)CB件数</th>
                            <th class="text-center blue csv hidden">(M)CB金額</th>

                            <th class="text-center blue csv hidden">(J)決済件数</th>
                            <th class="text-center blue csv hidden">(J)決済金額</th>
                            <th class="text-center blue csv hidden">(J)取消し件数</th>
                            <th class="text-center blue csv hidden">(J)取消し金額</th>
                            <th class="text-center blue csv hidden">(J)CB件数</th>
                            <th class="text-center blue csv hidden">(J)CB金額</th>

                            <th class="text-center blue csv hidden">(A)決済件数</th>
                            <th class="text-center blue csv hidden">(A)決済金額</th>
                            <th class="text-center blue csv hidden">(A)取消し件数</th>
                            <th class="text-center blue csv hidden">(A)取消し金額</th>
                            <th class="text-center blue csv hidden">(A)CB件数</th>
                            <th class="text-center blue csv hidden">(A)CB金額</th>

                            <th class="text-center green csv hidden">(V)決済手数料</th>
                            <th class="text-center green csv hidden">(V)TF認証料</th>
                            <th class="text-center green csv hidden">(V)SMS送信料</th>
                            <th class="text-center green csv hidden">(V)取消し手数料</th>
                            <th class="text-center green csv hidden">(V)CB手数料</th>
                            <th class="text-center green csv hidden">(V)消費税10％</th>

                            <th class="text-center green csv hidden">(M)決済手数料</th>
                            <th class="text-center green csv hidden">(M)TF認証料</th>
                            <th class="text-center green csv hidden">(M)SMS送信料</th>
                            <th class="text-center green csv hidden">(M)取消し手数料</th>
                            <th class="text-center green csv hidden">(M)CB手数料</th>
                            <th class="text-center green csv hidden">(M)消費税10％</th>

                            <th class="text-center green csv hidden">(J)決済手数料</th>
                            <th class="text-center green csv hidden">(J)TF認証料</th>
                            <th class="text-center green csv hidden">(J)SMS送信料</th>
                            <th class="text-center green csv hidden">(J)取消し手数料</th>
                            <th class="text-center green csv hidden">(J)CB手数料</th>
                            <th class="text-center green csv hidden">(J)消費税10％</th>

                            <th class="text-center green csv hidden">(A)決済手数料</th>
                            <th class="text-center green csv hidden">(A)TF認証料</th>
                            <th class="text-center green csv hidden">(A)SMS送信料</th>
                            <th class="text-center green csv hidden">(A)取消し手数料</th>
                            <th class="text-center green csv hidden">(A)CB手数料</th>
                            <th class="text-center green csv hidden">(A)消費税10％</th>
                            <th class="text-center edit">精算書</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($list as $invoice)
                            <tr>
                                <td class="text-center yellow">{{ $invoice->id }}</td>
                                <td class="text-center yellow">{{ $invoice->merchant_id }}</td>
                                <td class="text-center yellow">{{ $invoice->shop_id }}</td>
                                <td class="text-center yellow">{{ $invoice->shop_name }}</td>
                                <td class="text-center yellow">{{ $invoice->pay_cycle_name }}</td>
                                <td class="text-center yellow">{{ $invoice->invoice_date }}</td>
                                <td class="text-center yellow">{{ $invoice->payment_start }}～{{ $invoice->payment_end }}</td>
                                <td class="text-center yellow">
                                    @if($invoice->pay_amount < 0)
                                        －
                                    @endif
                                    ¥{{ abs($invoice->pay_amount) }}
                                </td>
                                <td class="text-center yellow">
                                    @if($invoice->pay_amount > 3000)
                                        {{ $invoice->output_date }}
                                    @else
                                        未精算
                                    @endif
                                </td>

                                <td class="text-center blue">{{ $invoice->transaction_count }}</td>
                                <td class="text-center blue">¥{{ $invoice->transaction_amount }}</td>
                                <td class="text-center blue">{{ $invoice->cc_count }}</td>
                                <td class="text-center blue">¥{{ $invoice->cc_amount }}</td>
                                <td class="text-center blue">{{ $invoice->cb_count }}</td>
                                <td class="text-center blue">¥{{ $invoice->cb_amount }}</td>

                                <td class="text-center pink">¥{{ $invoice->month_fee }}</td>
                                <td class="text-center pink">¥{{ $invoice->payment_fee }}</td>
                                <td class="text-center pink">¥{{ $invoice->tf_fee }}</td>
                                <td class="text-center pink">¥{{ $invoice->sms_fee }}</td>
                                <td class="text-center pink">¥{{ $invoice->cc_fee }}</td>
                                <td class="text-center pink">¥{{ $invoice->cb_fee }}</td>
                                <td class="text-center pink">¥{{ $invoice->enter_fee }}</td>
                                <td class="text-center darkorange">
                                    @if($invoice->carry_amount < 0)
                                        －
                                    @endif
                                    ¥{{ abs($invoice->carry_amount) }}
                                </td>
                                <td class="text-center green">－¥{{ $invoice->rr_amount }}</td>
                                <td class="text-center green">+¥{{ $invoice->rr_pay }}</td>

                                <td class="text-center blue csv hidden">{{ $invoice->v_count }}</td>
                                <td class="text-center blue csv hidden">¥{{ $invoice->v_amount }}</td>
                                <td class="text-center blue csv hidden">{{ $invoice->v_cc_count }}</td>
                                <td class="text-center blue csv hidden">¥{{ $invoice->v_cc_amount }}</td>
                                <td class="text-center blue csv hidden">{{ $invoice->v_cb_count }}</td>
                                <td class="text-center blue csv hidden">¥{{ $invoice->v_cb_amount }}</td>

                                <td class="text-center blue csv hidden">{{ $invoice->m_count }}</td>
                                <td class="text-center blue csv hidden">¥{{ $invoice->m_amount }}</td>
                                <td class="text-center blue csv hidden">{{ $invoice->m_cc_count }}</td>
                                <td class="text-center blue csv hidden">¥{{ $invoice->m_cc_amount }}</td>
                                <td class="text-center blue csv hidden">{{ $invoice->m_cb_count }}</td>
                                <td class="text-center blue csv hidden">¥{{ $invoice->m_cb_amount }}</td>

                                <td class="text-center blue csv hidden">{{ $invoice->j_count }}</td>
                                <td class="text-center blue csv hidden">¥{{ $invoice->j_amount }}</td>
                                <td class="text-center blue csv hidden">{{ $invoice->j_cc_count }}</td>
                                <td class="text-center blue csv hidden">¥{{ $invoice->j_cc_amount }}</td>
                                <td class="text-center blue csv hidden">{{ $invoice->j_cb_count }}</td>
                                <td class="text-center blue csv hidden">¥{{ $invoice->j_cb_amount }}</td>

                                <td class="text-center blue csv hidden">{{ $invoice->a_count }}</td>
                                <td class="text-center blue csv hidden">¥{{ $invoice->a_amount }}</td>
                                <td class="text-center blue csv hidden">{{ $invoice->a_cc_count }}</td>
                                <td class="text-center blue csv hidden">¥{{ $invoice->a_cc_amount }}</td>
                                <td class="text-center blue csv hidden">{{ $invoice->a_cb_count }}</td>
                                <td class="text-center blue csv hidden">¥{{ $invoice->a_cb_amount }}</td>

                                <td class="text-center green csv hidden">¥{{ $invoice->v_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->v_tf_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->v_sms_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->v_cc_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->v_cb_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->v_tax }}</td>

                                <td class="text-center green csv hidden">¥{{ $invoice->m_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->m_tf_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->m_sms_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->m_cc_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->m_cb_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->m_tax }}</td>

                                <td class="text-center green csv hidden">¥{{ $invoice->j_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->j_tf_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->j_sms_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->j_cc_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->j_cb_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->j_tax }}</td>

                                <td class="text-center green csv hidden">¥{{ $invoice->a_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->a_tf_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->a_sms_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->a_cc_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->a_cb_fee }}</td>
                                <td class="text-center green csv hidden">¥{{ $invoice->a_tax }}</td>

                                <td class="text-center edit">
                                    <a class="edit-row btn btn-success" style="width: 70px;" href="{{ url('admin/invoice/detail/' . $invoice->id) }}">精算</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <!-- links -->
                <div class="d-flex justify-content-center" style="float: right">
                    {{ $list->links() }}
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
    <link rel="stylesheet" href="{{ asset('public/admin/css/common.css') }}" />
@endsection

<!-- Custom JS -->
@section('page_js_vendor')
    <script src="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
    <script src="{{ asset('public/admin/js/views/invoice.js') }}"></script>
    <script src="{{ asset('public/admin/js/table2CSV.js') }} "></script>

    <script>

        $( document ).ready(function() {
            var s_width = $( window ).width() - 320;
            $('.panel-body').width(s_width);

            $('.datatables-footer').addClass('hidden');
            $('.pagination').addClass('mb-none');

            // search page links
            $('.pagination li').each(function(index, link) {
                var link_href = $(link).find('a').attr('href');
                if(link_href) {
                    link_href += '&' + $('#searchForm').serialize();
                    $(link).find('a').attr('href', link_href);
                }
            });

            // select page length
            var pagelen = '{{ $pagelen }}';
            var sel_pagelen = $('select[name="invoice_datatable_length"]');
            $(sel_pagelen).val(pagelen);

            $('select[name="invoice_datatable_length"] option[value="-1"]').remove();
            $(sel_pagelen).on('change', function() {
                $('#pagelen').val($(this).val());
                window.location.href = '{{ url('/admin/invoice/') }}' + '?' + $('#searchForm').serialize();
            });
        });

        $(window).resize(function() {
            var s_width = $( window ).width() - 320;
            $('.panel-body').width(s_width);
        });

        function downloadCSV()
        {
            var strYear =  ((new Date()).getYear() - 100) + 2000;
            var strMonth =  (new Date()).getMonth() + 1;
            var strDate =  (new Date()).getDate();

            $('#invoice_datatable').find("td.csv").removeClass('hidden');
            $('#invoice_datatable').find("th.csv").removeClass('hidden');
            $('#invoice_datatable').find("td.edit").addClass('hidden');
            $('#invoice_datatable').find("th.edit").addClass('hidden');

            var csv = $('#invoice_datatable').table2CSV({
                delivery: 'value'
            });

            var encodedUri = 'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURIComponent(csv);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Invoice_" + strYear + '_' + strMonth + '_' + strDate + ".csv");
            link.click();

            $('#invoice_datatable').find("td.csv").addClass('hidden');
            $('#invoice_datatable').find("th.csv").addClass('hidden');
            $('#invoice_datatable').find("td.edit").removeClass('hidden');
            $('#invoice_datatable').find("th.edit").removeClass('hidden');
        }

        function reset(){

            $('input').val('');
            $('select#pay_cycle').val('');
            $('#pagelen').val('{{ $pagelen }}');
            $('#searchForm').submit();
        }

    </script>
@endsection
