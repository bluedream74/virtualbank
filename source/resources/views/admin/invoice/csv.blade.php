@extends('admin.layouts.app')
@section('title', '精算CSV | Virtual Bank')

@php($output_date = $datas['output_date'])
@php($bank = $datas['bank'])
@php($pagelen = $datas['pagelen'])
@php($list = $datas['list'])

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h2><i class="fa fa-download"></i>&nbsp;&nbsp;精算CSV</h2>
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

                    <form class="form-horizontal" action="{{ url('admin/invoice/search-csv') }}" enctype="multipart/form-data" method="post" id="searchForm">

                        <input id="pagelen" name="pagelen" type="hidden" value="{{ $pagelen }}" />
                        <div class="row">

                            <label class="col-sm-2 mt-xs text-right">ご入金予定日</label>
                            <div class="col-sm-2">
                                <input id="output_date" name="output_date" type="date" class="form-control" value="{{ $output_date }}" />
                            </div>

                            <label class="mt-xs col-xs-1 text-right" style="width: 125px;">銀行</label>
                            <div class="col-xs-2">
                                <select class="form-control" id="bank" name="bank">
                                    <option value="1" @if($bank == 1) selected @endif>ペイペイ銀行</option>
                                    <option value="2" @if($bank == 2) selected @endif>横浜銀行</option>
                                    <option value="3" @if($bank == 3) selected @endif>楽天銀行</option>
                                    <option value="4" @if($bank == 4) selected @endif>SBI銀行</option>
                                </select>
                            </div>

                            <div class="col-xs-3 text-center">
                                <button type="submit" class="btn btn-success" style="width: 100px;">検索</button>
                                <a class="btn btn-white ml-xs" style="width: 100px; border: 1px solid #ccc; color: #000000" onclick="reset()" >リセット</a>
                            </div>
                        </div>

                    </form>

                </div>


                <!-- table -->
                <table class="table table-bordered table-striped text-center" id="invoiceCSV_datatable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center blue" width="5%">1</th>
                            <th class="text-center blue" width="7%">21</th>
                            <th class="text-center blue" width="6%">0</th>
                            <th class="text-center blue" width="6%"></th>
                            <th class="text-center blue" width="15%">{{ mb_convert_kana('カ)スマートペイメント', 'askh') }}</th>
                            <th class="text-center blue" width="7%">
                                @if($output_date != '')
                                    {{ date('md', strtotime($output_date)) }}
                                @else
                                    {{ date('md') }}
                                @endif

                            </th>
                            <th class="text-center blue" width="7%">0033</th>
                            <th class="text-center blue" width="7%"></th>
                            <th class="text-center blue" width="6%">5</th>
                            <th class="text-center blue" width="5%"></th>
                            <th class="text-center blue" width="5%">1</th>
                            <th class="text-center blue" width="10%">5211799</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php($total_amount = 0)
                        @foreach($list as $item)
                            <tr>
                                <td class="yellow">2</td>
                                <td class="yellow">{{ $item->u_bankcode }}</td>
                                <td class="yellow"></td>
                                <td class="yellow">{{ $item->u_branchcode }}</td>
                                <td class="yellow"></td>
                                <td class="yellow"></td>
                                <td class="yellow red">{{ $item->u_holdeertype_code }}</td>
                                <td class="yellow">{{ $item->u_holdernumber }}</td>
                                <td class="yellow">
                                    @if($item->u_holdername_fu_mei != '')
                                        {{ mb_convert_kana($item->u_holdername_fu_sei . ' ' . $item->u_holdername_fu_mei, 'askh') }}
                                    @else
                                        {{ mb_convert_kana($item->u_holdername_fu_sei, 'askh') }}
                                    @endif
                                </td>
                                <td class="yellow">
                                    {{ $item->amount }}
                                    @php($total_amount += $item->amount)
                                </td>
                                <td class="yellow red">0</td>
                                <td class="yellow"></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="green">8</td>
                                <td class="green">{{ sizeof($list) }}</td>
                                <td class="green">{{ $total_amount }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="darkorange">9</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
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
    <script src="{{ asset('public/admin/vendor/select2/js/select2.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/ios7-switch/ios7-switch.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/bootstrap-confirmation/bootstrap-confirmation.js') }}"></script>
    <script src="{{ asset('public/admin/js/views/invoice_csv.js') }}"></script>
    <script src="{{ asset('public/admin/js/table2CSV.js') }} "></script>
    <script src="{{ asset('public/admin/js/encoding.min.js') }} "></script>

    <script>

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $( document ).ready(function() {

            $('.datatables-footer').addClass('hidden');

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
            var sel_pagelen = $('select[name="invoiceCSV_datatable_length"]');
            $(sel_pagelen).val(pagelen);

            $('select[name="invoiceCSV_datatable_length"] option[value="-1"]').remove();
            $('select[name="invoiceCSV_datatable_length"]').on('change', function() {
                $('#pagelen').val($(this).val());
                window.location.href = '{{ url('/admin/invoice/csv') }}' + '?' + $('#searchForm').serialize();
            });
        });

        function reset(){
            $('input').val('');
            $('select#bank').val('1');
            $('#pagelen').val('{{ $pagelen }}');
            $('#searchForm').submit();
        }

        var str2array = function(str) {
            var array = [],i,il=str.length;
            for(i=0;i<il;i++) array.push(str.charCodeAt(i));
            return array;
        };

        function downloadCSV()
        {
            var strYear =  ((new Date()).getYear() - 100) + 2000;
            var strMonth =  (new Date()).getMonth() + 1;
            var strDate =  (new Date()).getDate();
            var  filename = "精算csv_" + strYear + '_' + strMonth + '_' + strDate + ".csv";

            var csv = $('#invoiceCSV_datatable').table2CSV({
                delivery: 'value'
            });

            var sjisArray = Encoding.convert(Encoding.stringToCode(csv), {to: 'SJIS'});
            var blob  = new Blob([new Uint8Array(sjisArray)], {type: 'text/csv'});
            var url = URL.createObjectURL(blob);

            var link = document.createElement("a");
            link.setAttribute("href", url);
            link.setAttribute('charset', 'shift_jis');
            link.setAttribute("download", filename);
            link.click();
        }

    </script>
@endsection
