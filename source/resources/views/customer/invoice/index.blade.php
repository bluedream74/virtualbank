@extends('customer.layouts.app')
@section('title', '精算書 | VirtualBank')

@php($invoice_date = $datas['date'])
@php($list = $datas['list'])

@section('content')

<div role="main" class="main">

        <div class="top-container">

            <h2 class="header-title">精算書</h2>

            <form method="post" action="{{ url('/invoice/search') }}">
                <div class="row input-container form-group" id="select_month">
                    <div class="col-xs-12 text-center" >
                        <p>決済期間</p>
                        <input type="month" name="month" class="input-lg" value="{{ date('Y-m', strtotime($invoice_date)) }}" data-date="" data-date-format="YYYY年MM月"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 text-center mb-md">
                        <button class="btn btn-default btn-green" style="width:170px; border: 2px solid #2d2d2d !important;">検索</button>
                    </div>
                </div>
            </form>

            <!-- Invoice Table -->
            <div id="invoice_box" class="hidden-xs">
                <table>
                    @php($index = 1)
                    @foreach($list as $item)
                        <tr>
                            <td width="15%" style="font-weight: bold">決済期間</td>
                            <td width="45%"><a href="{{ url('invoice/detail/' . $item['year'] . '/' .$item['start_date'] . '/' . $item['end_date'] . '/' . $item['output_date'] . '/' . $item['month_fee']) }}">{{ $item['period'] }}</a></td>
                            <td width="18%" style="font-weight: bold">ご入金予定日</td>
                            <td width="22%">{{ $item['output_date'] }}</td>
                        </tr>
                        @php($index++)
                    @endforeach
                </table>
            </div>

            <div id="invoice_box" class="visible-xs p-sm">
                <table>
                    <thead>
                        <th>決済期間</th>
                        <th>ご入金予定日</th>
                    </thead>
                    @php($index = 1)
                    @foreach($list as $item)
                        <tr>
                            @if($index < sizeof($list))
                                <td width="65%"><a href="{{ url('invoice/detail/' . $item['year'] . '/' .$item['start_date'] . '/' . $item['end_date'] . '/' . $item['output_date']) . '/0' }}">{{ $item['period'] }}</a></td>
                            @else
                                <td width="65%"><a href="{{ url('invoice/detail/' . $item['year'] . '/' .$item['start_date'] . '/' . $item['end_date'] . '/' . $item['output_date']) . '/1' }}">{{ $item['period'] }}</a></td>
                            @endif
                            <td width="35%">{{ $item['output_date'] }}</td>
                        </tr>
                        @php($index++)
                    @endforeach
                </table>
            </div>


        </div>

</div>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">
@endsection

<!-- Custom JS -->
@section('page_js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script>

        $("input").on("change", function() {
            this.setAttribute("data-date", moment(this.value, "YYYY-MM-DD").format( this.getAttribute("data-date-format") ));
        }).trigger("change");

    </script>

@endsection