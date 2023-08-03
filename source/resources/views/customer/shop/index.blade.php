@extends('customer.layouts.app')
@section('title', '店舗管理 | VirtualBank')

@php($list = $datas['list'])
@php($year = $datas['year'])
@php($month = $datas['month'])
@php($page_len = $datas['page_len'])
@php($arr_paycycle = \App\Models\PayCycle::all())

@section('content')
<div role="main" class="main">

    <div class="top-container pt-none">
        <div class="container mt-sm">
            <div class="row" id="search_box">

                <h2 class="header-title">店舗管理</h2>

                <!-- year, month -->
                <div class="form-group mt-xlg">
                    <form method="post" action="{{ url('/shop/search') }}" id="searchForm" style="display:inline-flex; width: 240px; margin-left: calc(50% - 120px);">
                        <input id="page_len" name="page_len" type="hidden" class="form-control" value="{{ $page_len }}" />
                        <select id="year" name="year" value="{{ $year }}" class="form-control" style="width: 120px; border-radius: 0;" onchange="search()">
                            <option value="">年</option>
                            @for($i=date('Y');$i>2020;$i--)
                            <option value="{{ $i }}" @if($i== $year) selected @endif>{{ $i }}年</option>
                            @endfor
                        </select>
                        <select id="month" name="month" value="{{ $month }}" class="form-control" style="width: 120px; border-radius: 0;" onchange="search()">
                            <option value="">月</option>
                            @for($i=1; $i < 13; $i++)
                            <option value="{{ $i }}" @if($i == $month) selected @endif>{{ $i }}月</option>
                            @endfor
                        </select>
                    </form>
                </div>
            </div>

            <!-- help -->
            <div id="help">
                <table id="help-table">
                    <tbody>
                        <tr>
                            <td width="30%" class="text-center">クレジット決済金額</td>
                            <td width="70%">指定した「年/月」のクレジット決済の<span class="blue">成功</span>のみを集計しています。</td>
                        </tr>
                        <tr>
                            <td width="30%" class="text-center">後払い金額</td>
                            <td width="70%">指定した「年/月」の後払い決済の<span class="blue">成功</span>のみを集計しています。</td>
                        </tr>
                    </tbody>
                </table>
                <p class="mt-xs" style="color: white; font-size:14px">※「取消/CB」は最新月の集計から減算されます。</p>
            </div>

            <div id="transaction-list" class="p-none">

                @php($user = Auth::user())
                @php($group = App\Models\Group::getGroupByName($user->name))
                @php($kind = $group->g_kind)

                <!-- links -->
                <div class="d-flex justify-content-center">
                    {{ $list->links() }}
                </div>

                <!-- select -->
                <div class="row">
                    <div class="col-xs-12 text-center form-group @if(sizeof($list) == 0) hidden @endif">
                        <form method="post" action="{{ url('shop/pagelen') }}" id="postForm">
                            <select class="form-control" id="page_len" name="page_len" style="width: 150px; margin: 0 auto; height: 40px !important; padding: 0 5px;" onchange="changeLen(this)">
                                <option value="5" @if($page_len == 5) selected @endif>5件表示</option>
                                <option value="10" @if($page_len == 10) selected @endif>10件表示</option>
                                <option value="30" @if($page_len == 30) selected @endif>30件表示</option>
                                <option value="50" @if($page_len == 50) selected @endif>50件表示</option>
                                <option value="100" @if($page_len == 100) selected @endif>100件表示</option>
                            </select>
                            <input id="year1" name="year1" value="{{ $year }}" type="hidden"/>
                            <input id="month1" name="month1" value="{{ $month }}" type="hidden"/>
                        </form>
                    </div>

                    <div class="col-xs-12 text-center @if(sizeof($list) > 0) hidden @endif">
                        <p style="color: #e0e0e0; margin-top: 60px">データがありません。</p>
                    </div>
                </div>

                <!-- Start PC Version -->
                <div class="hidden-xs @if(sizeof($list) == 0) hidden @endif" style="width: 96%; margin: 0 auto; background-color: white; overflow-x: auto">
                    <table width="100%" style="white-space: nowrap;">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%" style="background-color: #ccffff;">ID</th>
                                <th class="text-center" width="10%" style="background-color: #ccffff;">店舗ID</th>
                                <th class="text-center" width="10%" style="background-color: #ccffff;">店舗名</th>
                                <th class="text-center" width="10%" style="background-color: #ccffff;">契約状況</th>
                                <th class="text-center" width="10%" style="background-color: #ffffe1">支払いサイクル</th>
                                <th class="text-center" width="10%" style="background-color: #ccffff;">クレジット決済金額</th>
                                <th class="text-center" width="10%" style="background-color: #ccffff;">後払い金額</th>
                                <th class="text-center @if($kind == '代理店') hidden @endif" width="10%" style="background-color: #ccffcc;">精算書</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php($index = 1)
                            @foreach($list as $user)
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @if($kind != '代理店')
                                            <a class="link" onclick="loginShop('{{ $user->name }}')">{{ $user->s_name }}</a>
                                        @else
                                            {{ $user->s_name }}
                                        @endif
                                    </td>
                                    <td>{{ $user->status }}</td>
                                    <td>{{ $arr_paycycle[$user->pay_cycle-1]['name'] }}</td>
                                    <td>
                                        @if($user->success_sum[0]['amount'] >= 0)
                                            ¥{{ ceil($user->success_sum[0]['amount']) }}
                                        @else
                                            ー¥{{ abs(ceil($user->success_sum[0]['amount'])) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->success_sum_atobarai[0]['amount'] >= 0)
                                            ¥{{ ceil($user->success_sum_atobarai[0]['amount']) }}</td>
                                        @else
                                            ー¥{{ abs(ceil($user->success_sum_atobarai[0]['amount'])) }}
                                        @endif
                                    <td class="@if($kind == '代理店') hidden @endif">
                                        <a class="link" onclick="showInvoice('{{ $user->name }}')">精算書</a>
                                    </td>
                                </tr>
                                @php($index++)
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="visible-xs @if(sizeof($list) == 0) hidden @endif" id="shop_sp">
                    <table width="100%" style="white-space: nowrap;">
                        <tbody>
                            @foreach($list as $user)
                                <tr>
                                    <td width="20%"><strong>店舗ID</strong></td>
                                    <td width="30%"><strong>店舗名</strong></td>
                                    <td width="20%"><strong>契約状況</strong></td>
                                    <td width="30%"><strong>支払いサイクル</strong></td>
                                </tr>
                                <tr>
                                    <td width="20%">{{ $user->name }}</td>
                                    <td width="30%">
                                        @if($kind != '代理店')
                                            <a class="link name" onclick="loginShop('{{ $user->name }}')">{{ $user->s_name }}</a>
                                        @else
                                            {{ $user->s_name }}
                                        @endif
                                    </td>
                                    <td width="20%">{{ $user->status }}</td>
                                    <td width="30%">{{ $arr_paycycle[$user->pay_cycle-1]['name'] }}</td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="2"><strong>クレジット決済金額</strong></td>
                                    <td width="50%" colspan="2"><strong>後払い金額</strong></td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="2">
                                        @if($user->success_sum[0]['amount'] >= 0)
                                            ¥{{ ceil($user->success_sum[0]['amount']) }}
                                        @else
                                            ー¥{{ abs(ceil($user->success_sum[0]['amount'])) }}
                                        @endif
                                    </td>
                                    <td width="50%" colspan="2">
                                        @if($user->success_sum_atobarai[0]['amount'] >= 0)
                                            ¥{{ ceil($user->success_sum_atobarai[0]['amount']) }}</td>
                                        @else
                                            ー¥{{ abs(ceil($user->success_sum_atobarai[0]['amount'])) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr class="@if($kind == '代理店') hidden @endif">
                                    <td colspan='4'>
                                        <a class="link invoice" onclick="showInvoice('{{ $user->name }}')">精算書</a>
                                    </td>
                                </tr>
                                <tr style="height: 20px;"></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- login form -->
                <form action="{{ url('/shop/switch') }}" method="post" class="hidden" id="login-form">
                    {{csrf_field()}}
                    <input type="text" name="name" id="name" class="form-control input-lg" placeholder="ログインID">
                </form>

                <!-- invoice form -->
                <form action="{{ url('/shop/invoice') }}" method="post" class="hidden" id="invoice-form">
                    {{csrf_field()}}
                    <input type="text" name="shop_name" id="shop_name" class="form-control input-lg">
                </form>
                
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
    <script>

        // search page links
        $( document ).ready(function() {
            
            $('.pagination li').each(function(index, link) {
                var link_href = $(link).find('a').attr('href');
                if(link_href) {
                    link_href += '&' + $('#searchForm').serialize();
                    $(link).find('a').attr('href', link_href);
                }
            });
        });

        function changeLen(obj)
        {
            $('#start_date1').val($('#start_date').val());
            $('#end_date1').val($('#end_date').val());
            $('#shop_id1').val($('#shop_id').val());
            $('#shop_name1').val($('#shop_name').val());
            $('#postForm').submit();
        }

        function search()
        {
            var year = $('#year').val();
            var month = $('#month').val();
            $('#searchForm').submit();
        }

        function showInvoice(shop_name)
        {
            $('#shop_name').val(shop_name);
            $('#invoice-form').submit();
        }
        
        function loginShop(shop_id)
        {
            $('#name').val(shop_id);
            $('#login-form').submit();
        }

    </script>
@endsection