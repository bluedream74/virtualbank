@extends('merchant.layouts.app')
@section('title', '決済検索 | Virtual Bank')

@php($list = $datas['list'])
@php($start_date = $datas['start_date'])
@php($end_date = $datas['end_date'])

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-4">
                    <h2><i class="fa fa-search"></i>&nbsp;&nbsp;決済検索</h2>
                </div>
                <div class="form-group" id="search_box">
                    <form method="post" action="{{ url('merchant/transaction/search') }}" id="searchForm" style="float: left;;">
                        <label>決済期間</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $start_date }}" class="form-control"/>
                        <label>～</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $end_date }}" class="form-control" />
                    </form>
                    <button class="btn btn-default btn-gold" onclick="search()">検索</button>
                </div>
            </div>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">

                <!-- table -->
                <table class="table table-bordered table-striped text-center" id="transaction_datatable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center" width="5%" style="background-color: #ccffff;">ID</th>
                            <th class="text-center" width="5%" style="background-color: #ccffff;">店舗ID</th>
                            <th class="text-center" width="8%" style="background-color: #ccffff;">決済日時</th>
                            <th class="text-center" width="7%" style="background-color: #ccffff;">処理</th>
                            <th class="text-center" width="7%" style="background-color: #ccffff;">サービス料</th>
                            <th class="text-center" width="7%" style="background-color: #ccffff;">最低決済手数料</th>
                            <th class="text-center" width="7%" style="background-color: #ccffff;">加算決済手数料</th>
                            <th class="text-center" width="10%" style="background-color: #ccffff;">決済金額</th>
                            <th class="text-center" width="10%" style="background-color: #ccffff;">SMS送信</th>
                            <th class="text-center" width="7%" style="background-color: #ccffcc;">カード名義</th>
                            <th class="text-center" width="7%" style="background-color: #ccffcc;">ブランド</th>
                            <th class="text-center" width="7%" style="background-color: #ccffcc;">カード番号</th>
                            <th class="text-center" width="8%" style="background-color: #ccffcc;">有効期限</th>
                            <th class="text-center" width="9%" style="background-color: #ccffcc;">電話番号</th>
                            <th class="text-center" width="8%" style="background-color: #ccffcc;">決済種別</th>
                            <th class="text-center" width="10%" style="background-color: #ffffe1">支払いサイクル</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($list as $transaction)
                        <tr>
                            <td>t_{{ $transaction->t_id }}</td>
                            <td>
                                @if($transaction->userType == '1')
                                    {{ $transaction->merchant->name }}
                                @else
                                    {{ $transaction->shop->name }}
                                @endif
                            </td>
                            <td>{{ $transaction->created_at }}</td>
                            <td class="@if($transaction->status == '成功') successed @else fail @endif">

                                @if($transaction->status == '成功')
                                    @if(($transaction->child != 0) && ($transaction->parent == 0))
                                        {{ $transaction->status }}(修正)
                                    @else
                                        {{ $transaction->status }}
                                    @endif
                                @elseif($transaction->status == '失敗')
                                    {{ $transaction->status }}({{$transaction->errorCode }})
                                @else
                                    {{ $transaction->status }}
                                @endif

                            </td>
                            <td>¥{{ ceil($transaction->service_fee) }}</td>
                            <td>{{ $transaction->low_fee }}%</td>
                            <td>{{ $transaction->card_fee }}%</td>
                            <td>¥{{ ceil($transaction->amount) }}</td>
                            <td>¥{{ $transaction->sms_amount }}</td>
                            <td>{{ $transaction->card_holdername }}</td>
                            {{--<td><img src="{{ asset('public/customer/img/' . $transaction->cardtype . '.png') }}" width="50"/></td>--}}
                            <td>{{ $transaction->cardtype }}</td>
                            <td> **** **** **** {{ substr($transaction->card_number, -4) }}</td>
                            <td>{{ $transaction->expiry_date }}</td>
                            <td>{{ $transaction->phone }}</td>
                            <td>{{ $transaction->payment_method }}</td>
                            <td>{{ $transaction->pay_cycle }}</td>
                        </tr>

                    @endforeach
                    </tbody>

                </table>
            </div>

        </section>
        <!-- end page -->

    </section>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/merchant/vendor/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/merchant/vendor/jquery-ui/jquery-ui.theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/merchant/vendor/select2/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/merchant/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/merchant/vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/merchant/css/common.css') }}" />
@endsection

<!-- Custom JS -->
@section('page_js_vendor')
    <script src="{{ asset('public/merchant/vendor/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('public/merchant/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/merchant/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
    <script src="{{ asset('public/merchant/js/views/transaction.js') }}"></script>
    <script>

        $( document ).ready(function() {
            var s_width = $( window ).width() - 320;
            $('.panel-body').width(s_width);
        });

        $(window).resize(function() {
            var s_width = $( window ).width() - 320;
            $('.panel-body').width(s_width);
        });

        function search()
        {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            // compare date
            if((start_date != '') && (end_date != '')){
                var start= new Date(start_date);
                var end= new Date(end_date);
                if (start > end){
                    alert('決済期間を正しく指定してください');
                    return;
                }
            }

            if((start_date == '') && (end_date == '')){
                alert('決済期間を指定してください');
                return;
            }

            $('#searchForm').submit();
        }

    </script>

@endsection
