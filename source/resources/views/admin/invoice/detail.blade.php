@extends('admin.layouts.app')
@section('title', '精算詳細 | Virtual Bank')

@php($invoice = $datas['invoice'])

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-4">
                    <h2><i class="fa fa-files-o"></i>&nbsp;&nbsp;精算詳細</h2>
                </div>
            </div>

        </header>

        <!-- start page -->
        <section class="panel">
            <div class="panel-body">

                <div class="invoice_detail_container " style="width: 1300px;">

                    <div class="pull-left" style="width: 800px;">
                        <div class="row text-right mr-xs">
                            <a onclick="print()" style="min-width: 50px; background-color: transparent; border: none; cursor: pointer"><img src="{{ asset('public/customer/img/printer.png') }}" width="50px" /></a>
                            <a onclick="html2Image()" style="min-width: 50px; background-color: transparent; border: none; cursor: pointer"><img src="{{ asset('public/customer/img/convert.png') }}" width="50px" /></a>
                        </div>

                        <div id="invoice"  style="width: 800px;">
                            <h2 class="header-title text-center"><strong>精算書</strong></h2>

                            <!-- （加盟店様名）御中 -->
                            <div class="row mt-lg">
                                <div class="col-xs-6 text-center">
                                    <p class="mb-none" style="font-size: 20px; color: #000000"><strong>{{ $invoice->merchant_username }}</strong></p>
                                </div>
                            </div>

                            <div class="row m-xs">
                                <div class="col-xs-12 col-sm-6 invoice_topInfo mt-xs">
                                    <table width="100%">
                                        <tr>
                                            <td width="30%">加盟店名</td>
                                            <td width="70%" class="text-center">{{ $invoice->merchant_name }}</td>
                                        </tr>
                                        <tr>
                                            <td width="30%">加盟店ID</td>
                                            <td width="70%" class="text-center">{{ $invoice->merchant_id }}</td>
                                        </tr>
                                        <tr>
                                            <td width="30%">店舗名</td>
                                            <td width="70%" class="text-center">{{ $invoice->shop_name }}</td>
                                        </tr>
                                        <tr>
                                            <td width="30%">店舗ID</td>
                                            <td width="70%" class="text-center">{{ $invoice->shop_id }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-xs-12 col-sm-6 invoice_companyInfo" style="margin: 5px 0 0 2% !important;">
                                    <p>株式会社SmartPayment</p>
                                    <p>〒221-0835</p>
                                    <p>神奈川県横浜市神奈川区鶴屋町3丁目３５－１０</p>
                                    <p>TEL   :  045－314－5350</p>
                                    <p>MAIL :  contact@smart-payment.co.jp</p>
                                </div>
                            </div>

                            <!-- 発行日, お支払い金額 -->
                            <div class="row m-xs" id="invoice_date">
                                <table width="100%">
                                    <tr>
                                        <td width="40%">発行日</td>
                                        <td width="60%">{{ date('Y年m月d日', strtotime($invoice->invoice_date)) }}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">決済期間</td>
                                        <td width="60%">{{ date('Y年m月d日', strtotime($invoice->payment_start)) }}～{{ date('Y年m月d日', strtotime($invoice->payment_end)) }}</td>
                                    </tr>
                                    <tr style="background-color: #ccffcc !important;">
                                        <td width="40%">お支払い金額</td>
                                        <td width="60%" id="amount">
                                            @if($invoice->pay_amount < 3000)
                                                －
                                            @endif
                                            ¥{{ abs($invoice->pay_amount) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%">ご入金予定日</td>
                                        <td width="60%" id="output_date">
                                            @if($invoice->pay_amount > 3000)
                                                {{ date('Y年m月d日', strtotime($invoice->output_date)) }}
                                            @else
                                                未精算
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- 精算内訳 -->
                            <div class="row m-xs" id="invoice_content">
                                <p class="txt-info">※CB：チャージバック。TR：トランザクション。RR : ローリングリザーブ。</p>
                                <table width="100%">
                                    <tr><td colspan="6" class="text-center" style="font-weight: bold">精算内訳</td></tr>
                                    <tr>
                                        <td width="25%" rowspan="2">項目</td>
                                        <td width="15%">VISA</td>
                                        <td width="15%">MASTER</td>
                                        <td width="15%">JCB</td>
                                        <td width="15%">AMEX</td>
                                        <td width="15%" rowspan="2">合計</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $invoice->visa_fee }}%</td>
                                        <td>{{ $invoice->master_fee }}%</td>
                                        <td>{{ $invoice->jcb_fee }}%</td>
                                        <td style="border-right: none">{{ $invoice->amex_fee }}%</td>
                                    </tr>
                                    <tr>
                                        <td>決済件数</td>
                                        <td>{{ number_format($invoice->v_count) }}</td>
                                        <td>{{ number_format($invoice->m_count) }}</td>
                                        <td>{{ number_format($invoice->j_count) }}</td>
                                        <td>{{ number_format($invoice->a_count) }}</td>

                                        @php($ss_total = $invoice->v_count + $invoice->m_count + $invoice->j_count + $invoice->a_count)
                                        <td>{{ number_format($ss_total)  }}件</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #ffffcc !important;">決済金額(A)</td>
                                        <td>¥{{ number_format(ceil($invoice->v_amount)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->m_amount)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->j_amount)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->a_amount)) }}</td>

                                        @php($a = ceil($invoice->v_amount) + ceil($invoice->m_amount) + ceil($invoice->j_amount) + ceil($invoice->a_amount))
                                        <td style="background-color: #ffffcc !important;">¥{{ number_format($a)  }}</td>
                                    </tr>
                                    <tr>
                                        <td>取消し件数</td>
                                        <td>{{ number_format($invoice->v_cc_count) }}</td>
                                        <td>{{ number_format($invoice->m_cc_count) }}</td>
                                        <td>{{ number_format($invoice->j_cc_count) }}</td>
                                        <td>{{ number_format($invoice->a_cc_count) }}</td>

                                        @php($cc_total = $invoice->v_cc_count + $invoice->m_cc_count + $invoice->j_cc_count + $invoice->a_cc_count)
                                        <td>{{ number_format($cc_total) }}件</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #ffffcc !important;">取消し金額(B)</td>
                                        <td>¥{{ number_format(ceil($invoice->v_cc_amount)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->m_cc_amount)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->j_cc_amount)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->a_cc_amount)) }}</td>

                                        @php($b = ceil($invoice->v_cc_amount) + ceil($invoice->m_cc_amount) + ceil($invoice->j_cc_amount) + ceil($invoice->a_cc_amount))
                                        <td style="background-color: #ffffcc !important;">¥{{ number_format($b) }}</td>
                                    </tr>
                                    <tr>
                                        <td>CB件数</td>
                                        <td>{{ number_format($invoice->v_cb_count) }}</td>
                                        <td>{{ number_format($invoice->m_cb_count) }}</td>
                                        <td>{{ number_format($invoice->j_cb_count) }}</td>
                                        <td>{{ number_format($invoice->a_cb_count) }}</td>

                                        @php($cb_count = $invoice->v_cb_count + $invoice->m_cb_count + $invoice->j_cb_count + $invoice->a_cb_count)
                                        <td>{{ number_format($cb_count)  }}件</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #ffffcc !important;">CB金額(C)</td>
                                        <td>¥{{ number_format(ceil($invoice->v_cb_amount)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->m_cb_amount)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->j_cb_amount)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->a_cb_amount)) }}</td>

                                        @php($c = ceil($invoice->v_cb_amount) + ceil($invoice->m_cb_amount) + ceil($invoice->j_cb_amount) + ceil($invoice->a_cb_amount))
                                        <td style="background-color: #ffffcc !important;">¥{{ number_format($c) }}</td>
                                    </tr>
                                </table>

                                <table width="100%" class="mt-sm">
                                    <tr>
                                        <td width="25%" style="background-color: #ccffff !important;">月額管理費用(D)</td>
                                        <td colspan="4"></td>
                                        <td width="15%" style="background-color: #ccffff !important;">
                                            @php($d = $invoice->month_fee)
                                            ¥{{ number_format($d) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #ccffff !important;">決済手数料(E)</td>
                                        <td width="15%">¥{{ number_format(ceil( $invoice->v_fee)) }}</td>
                                        <td width="15%">¥{{ number_format(ceil( $invoice->m_fee)) }}</td>
                                        <td width="15%">¥{{ number_format(ceil( $invoice->j_fee)) }}</td>
                                        <td width="15%">¥{{ number_format(ceil( $invoice->a_fee)) }}</td>

                                        @php( $e = ceil($invoice->v_fee + $invoice->m_fee + $invoice->j_fee + $invoice->a_fee))
                                        <td style="background-color: #ccffff !important;">¥{{ number_format($e) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #ccffff !important;">TF認証料(F)</td>
                                        <td>¥{{ number_format(ceil($invoice->v_tf_fee)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->m_tf_fee)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->j_tf_fee)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->a_tf_fee)) }}</td>

                                        @php( $f = ceil($invoice->v_tf_fee + $invoice->m_tf_fee + $invoice->j_tf_fee + $invoice->a_tf_fee))
                                        <td style="background-color: #ccffff !important;">¥{{ number_format(ceil($f)) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #ccffff !important;">SMS送信料(G)</td>
                                        <td>¥{{ number_format($invoice->v_sms_fee) }}</td>
                                        <td>¥{{ number_format($invoice->m_sms_fee) }}</td>
                                        <td>¥{{ number_format($invoice->j_sms_fee) }}</td>
                                        <td>¥{{ number_format($invoice->a_sms_fee) }}</td>

                                        @php( $g = ceil($invoice->v_sms_fee + $invoice->m_sms_fee + $invoice->j_sms_fee + $invoice->a_sms_fee))
                                        <td style="background-color: #ccffff !important;">¥{{ number_format($g) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #ccffff !important;">取消し手数料(H)</td>
                                        <td>¥{{ number_format(ceil($invoice->v_cc_fee)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->m_cc_fee)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->j_cc_fee)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->a_cc_fee)) }}</td>

                                        @php( $h = $invoice->v_cc_fee + $invoice->m_cc_fee + $invoice->j_cc_fee + $invoice->a_cc_fee)
                                        <td style="background-color: #ccffff !important;">¥{{ number_format(ceil($h)) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #ccffff !important;">CB手数料（I）</td>
                                        <td>¥{{ number_format(ceil($invoice->v_cb_fee)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->m_cb_fee)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->j_cb_fee)) }}</td>
                                        <td>¥{{ number_format(ceil($invoice->a_cb_fee)) }}</td>

                                        @php( $i = $invoice->v_cb_fee + $invoice->m_cb_fee + $invoice->j_cb_fee + $invoice->a_cb_fee)
                                        <td style="background-color: #ccffff !important;">¥{{ number_format(ceil($i)) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #ccffff !important;">消費税10％（J)</td>
                                        <td colspan="4">※上記手数料（D~I）に対して、課税されます</td>

                                        @php( $j = ($d + $e + $f + $g + $h + $i) / 10)
                                        @php( $j = ceil($j))
                                        <td style="background-color: #ccffff !important;">¥{{ number_format($j) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #ccffff !important;">振込み手数料（K)</td>
                                        <td colspan="4"></td>

                                        @php($k = $invoice->enter_fee)
                                        <td style="background-color: #ccffff !important;">¥{{ number_format($k) }}</td>
                                    </tr>
                                </table>

                                <table width="100%" class="mt-sm">
                                    <tr>
                                        <td width="25%">繰越金（L）</td>
                                        @php($l = $invoice->carry_amount)
                                        <td width="60%">
                                            @if($l < 0)
                                                {{ date('Y年m月d日', strtotime($invoice->carry_date)) }}
                                            @endif
                                        </td>

                                        <td width="15%">
                                            @if($l >= 0)
                                                ￥{{ $l }}
                                            @else
                                                －￥{{ abs($l) }}
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                <table width="100%" class="mt-sm">
                                    <tr>
                                        <td width="25%">RR金額（M)</td>
                                        <td width="20%">決済期間</td>
                                        <td width="40%">
                                            {{ date('Y年m月d日', strtotime($invoice->payment_start)) }}～{{ date('Y年m月d日', strtotime($invoice->payment_end)) }}
                                        </td>
                                        <td width="15%">
                                            @php($m = $invoice->rr_amount)
                                            @if($m > 0)
                                                －￥{{ number_format($m) }}
                                            @else
                                                －￥0
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%">RR精算（N）</td>
                                        <td width="20%">決済期間</td>
                                        <td width="40%">
                                            @if($invoice->pay_cycle > 2)
                                                {{ date('Y年m月d日', strtotime($invoice->output_date)) }}
                                            @endif
                                        </td>
                                        <td width="15%">
                                            @php($n = $invoice->rr_pay)
                                            +￥{{ number_format($n) }}
                                        </td>
                                    </tr>
                                </table>

                                <table width="100%" class="mt-sm">
                                    <tr style="background-color: #ccffcc !important;">
                                        <td width="25%">お支払い金額</td>
                                        <td width="60%">A－(B＋C+D+E+F+G+H+I+J＋K＋M)+L+N=</td>

                                        @php($sum = ceil($a+$l+$n-($b+$c+$d+$e+$f+$g+$h+$i+$j+$k+$m)))
                                        <td width="15%" id="total">
                                            @if($sum>=0)
                                                ￥{{number_format($sum)}}
                                            @else
                                                －￥{{number_format(abs($sum))}}
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-danger" style="min-width: 150px; height: 40px;" onclick="window.history.back()">戻る</button>
                            </div>
                        </div>
                    </div>

                    <p class="pull-right" style="width: 465px; color: red; margin-top: 70px; font-size: 16px; line-height: 1.7">
                        <strong>※決済金のご精算が、土日祝日等銀行営業日以外の場合、翌銀行営業日となります。</strong><br>
                        尚、ご清算金が、3,000円以下の場合、次回以降のご精算へ繰越となります。<br><br>
                        <strong>※月額管理費用は、月間決済金総額が、下記の場合、月額管理費用は、変動致します。</strong><br>但し、毎週支払及び毎日支払は、3,000円/月額となります。<br>
                        ①月間決済金総額30万円以上の場合、3,000円/月額<br>
                        ②月間決済金総額10万円以上30万円未満の場合、1,500円/月額<br>
                        ③月間決済金総額10万円未満の場合、0円/月額<br>
                    </p>

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
@endsection

<!-- Custom JS -->
@section('page_js_vendor')
    <script src="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/select2/js/select2.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/ios7-switch/ios7-switch.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/bootstrap-confirmation/bootstrap-confirmation.js') }}"></script>

    <script src="{{ asset('public/customer/js/html2canvas.min.js') }}" type="text/javascript"></script>
    <script>

        $('#amount').html($('#total').html());
        var sum = parseInt('{{ $sum  }}');
        if(sum <= 3000){
            $('#output_date').html('未精算');
        }

        // convert to image
        function html2Image()
        {
            html2canvas(document.getElementById("invoice")).then(function (canvas) {
                var anchorTag = document.createElement("a");
                document.body.appendChild(anchorTag);
                anchorTag.download = "{{ date('Ymd') }}_invoice" + ".jpg";
                anchorTag.href = canvas.toDataURL();
                anchorTag.target = '_blank';
                anchorTag.click();
            });
        }

        function print()
        {
            var divToPrint=document.getElementById('invoice');
            var newWin=window.open('','Print-Invoice');
            newWin.document.open();

            var innerHTML = '<html><head>';
            innerHTML += '<link rel="stylesheet" href="{{ asset('public/customer/vendor/bootstrap/css/bootstrap.css') }}">';
            innerHTML += '<link rel="stylesheet" href="{{ asset('public/customer/css/common.css') }}">';
            innerHTML += '<link rel="stylesheet" href="{{ asset('public/customer/css/theme.css') }}">';
            innerHTML += '<link rel="stylesheet" href="{{ asset('public/customer/css/theme-elements.css') }}">';
            innerHTML += '<link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">';
            innerHTML += '<script src="{{ asset('public/customer/vendor/jquery/jquery.min.js')  }}"><\/script>';
            innerHTML += '<script src="{{ asset('public/customer/vendor/bootstrap/js/bootstrap.min.js')  }}"><\/script>';

            innerHTML += '</head><body onload="window.print()">';
            innerHTML += '<div role="main" class="main">';
            innerHTML += '<div class="top-container">';
            innerHTML += '<div class="invoice_detail_container">';
            innerHTML += '<div id="invoice">';
            innerHTML += divToPrint.innerHTML +'</div></div></div></div></body></html>';
            newWin.document.write(innerHTML);
            newWin.document.close();
            setTimeout(function(){newWin.close();},10);
        }

    </script>
@endsection
