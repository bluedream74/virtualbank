@extends('group.layouts.app')
@section('title', '店舗管理 | Virtual Bank')

@php($list = $datas['list'])
@php($year = $datas['year'])
@php($month = $datas['month'])
@php($pagelen = $datas['pagelen'])
@php($arr_paycycle = \App\Models\PayCycle::all())

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-4">
                    <h2><i class="fa fa-home"></i>&nbsp;&nbsp;店舗管理</h2>
                </div>
            </div>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">

                @php($user = Auth::guard('group')->user())
                @if($user->type == 3)
                    @php($group = App\Models\Group::getGroupByName($user->name))
                    @php($kind = $group->g_kind)
                @else
                    @php($kind = '代理店')
                @endif

                <!-- year, month -->
                <div class="form-group">
                    <form method="post" action="{{ url('group/shop/search') }}" id="searchForm" style="display:inline-flex; width: 240px; margin-left: calc(50% - 120px);">
                        <input id="pagelen" name="pagelen" type="hidden" class="form-control" value="{{ $pagelen }}" />
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
                    <p class="mt-xs" style="color: black">※「取消/CB」は最新月の集計から減算されます。</p>
                </div>
                

                <!-- table -->
                <table class="table table-bordered table-striped text-center" id="shop_datatable">
                    <thead class="text-center">
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

                <!-- links -->
                <div class="d-flex justify-content-center" style="float: right">
                    {{ $list->links() }}
                </div>

                <!-- login form -->
                <form action="{{ url('/group/shop/switch') }}" method="post" class="hidden" id="login-form">
                    {{csrf_field()}}
                    <input type="text" name="name" id="name" class="form-control input-lg" placeholder="ログインID">
                </form>

                 <!-- invoice form -->
                 <form action="{{ url('/group/shop/invoice') }}" method="post" class="hidden" id="invoice-form">
                    {{csrf_field()}}
                    <input type="text" name="shop_name" id="shop_name" class="form-control input-lg">
                </form>

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
    <script src="{{ asset('public/group/js/views/shop.js') }}"></script>
    <script>

        $( document ).ready(function() {
            var s_width = $( window ).width() - 320;
            $('.panel-body').width(s_width);
            $('#shop_datatable_filter').addClass('hidden');
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
            var sel_pagelen = $('select[name="shop_datatable_length"]');
            $(sel_pagelen).val(pagelen);

            $('select[name="shop_datatable_length"] option[value="-1"]').remove();
            $(sel_pagelen).on('change', function() {
                $('#pagelen').val($(this).val());
                window.location.href = '{{ url('/group/shop/') }}' + '?' + $('#searchForm').serialize();
            });
        });

        $(window).resize(function() {
            var s_width = $( window ).width() - 320;
            $('.panel-body').width(s_width);
        });

        function search()
        {
            var year = $('#year').val();
            var month = $('#month').val();
            $('#searchForm').submit();
        }

        function loginShop(shop_id)
        {
            $('#name').val(shop_id);
            $('#login-form').submit();
        }

        function showInvoice(shop_name)
        {
            $('#shop_name').val(shop_name);
            $('#invoice-form').submit();

            /*$.ajax({
                type: "POST",
                url: "{{ url('group/shop/invoice') }}",
                data: {shop_name: shop_name},
                dataType: 'JSON',
                success: function(response) {
                    var Backlen= history.length;
                    history.go(-Backlen);
                    window.location.href = response['url'];
                }
            });*/
        }
        
    </script>

@endsection
