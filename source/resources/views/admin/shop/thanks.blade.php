@extends('admin.layouts.app')
@section('title', '店舗管理 | Virtual Bank')

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <h2><i class="fa fa-building"></i>&nbsp;&nbsp;店舗管理</h2>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">
                <h2 class="control-label-bold text-center" style="color: orangered;">{{ session('title') }}</h2>

                @php($shop = session('shop'))
                @if($shop != null)
                    <div class="row mt-xlg mb-xlg">
                        <div class="col-sm-6 col-sm-offset-3">
                            <table width="100%" class="detail-table">
                                <tbody>
                                    <tr>
                                        <td style="background-color: #c0ffc6" width="50%">加盟店ID</td>
                                        <td style="background-color: #c0ffc6" width="50%">{{ $shop->member_id }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">登録日</td>
                                        <td style="background-color: #fff56b" width="50%">{{ substr($shop->created_at,0,10) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">店舗ID</td>
                                        <td style="background-color: #fff56b" width="50%">{{ $shop->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">パスワード</td>
                                        <td style="background-color: #fff56b" width="50%">{{ $shop->password1 }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">決済URL</td>
                                        <td style="background-color: #fff56b" width="50%">{{ $shop->payment_url }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">契約状況</td>
                                        <td style="background-color: #fff56b" width="50%">{{ $shop->s_status }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">利用MID</td>
                                        <td style="background-color: #fff56b" width="50%">{{ $shop->mid }}</td>
                                    </tr>

                                    <tr class="text-center">
                                        <td style="background-color: #87f5ff" width="50%" colspan="2">登録店舗情報</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗名</td>
                                        <td class="border-r">{{ $shop->s_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗名（カタカナ）</td>
                                        <td class="border-r">{{ $shop->s_name_fu }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">メンズエステ</td>
                                        <td class="border-r">
                                            @foreach($shop->service_types as $service)
                                                {{ $service->service_name }}&nbsp;&nbsp;
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗住所</td>
                                        <td class="border-r">{{ $shop->s_address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗電話番号</td>
                                        <td class="border-r">{{ $shop->s_tel }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗URL</td>
                                        <td class="border-r">{{ $shop->s_url }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">決済後サンキューメール<br>（確認メール）</td>
                                        <td class="border-r">{{ $shop->s_email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">グループ名</td>
                                        <td class="border-r">{{ $shop->s_group_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗責任者名</td>
                                        <td class="border-r">{{ $shop->s_manager_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗責任者電話番号</td>
                                        <td class="border-r">{{ $shop->s_manager_tel }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗メールアドレス<br>(担当者)</td>
                                        <td class="border-r">{{ $shop->s_manager_email }}</td>
                                    </tr>


                                    <tr class="text-center">
                                        <td style="background-color: #87f5ff" width="50%" colspan="2">契約内容（手数料）</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">利用カードブランド</td>
                                        <td class="border-r">
                                            @foreach($shop->card_types as $card)
                                                {{ $card->card_name }}&nbsp;&nbsp;
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-l" style="vertical-align: middle">最低決済手数料</td>
                                        <td class="border-r">
                                            VISA : {{ $shop->s_visa_fee }} %<br>
                                            MASTER : {{ $shop->s_master_fee }} %<br>
                                            JCB : {{ $shop->s_jcb_fee }} %<br>
                                            AMEX : {{ $shop->s_amex_fee }} %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">トランザクション認証料</td>
                                        <td class="border-r">{{ $shop->s_transaction_fee }} 円/1決済</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">取消し手数料</td>
                                        <td class="border-r">{{ $shop->s_cancel_fee }} 円/件</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">チャージバック</td>
                                        <td class="border-r">{{ $shop->s_charge_fee }} 円/件</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">振込手数料</td>
                                        <td class="border-r">{{ $shop->s_enter_fee }} 円/件</td>
                                    </tr>

                                    <tr class="text-center">
                                        <td style="background-color: #87f5ff" width="50%" colspan="2">契約内容（支払いサイクル）</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">支払いサイクル</td>
                                        <td class="border-r">{{ $shop->s_paycycle_name }}</td>
                                    </tr>

                                    <tr class="text-center">
                                        <td style="background-color: #87f5ff" width="50%" colspan="2">代理店</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">代理店名</td>
                                        <td class="border-r">{{ $shop->s_agency_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">代理店手数料</td>
                                        <td class="border-r">{{ $shop->s_agency_fee }} %</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">メモ帳</td>
                                        <td class="border-r">{{ $shop->s_memo }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <a href="{{ url('admin/shop') }}" class="btn btn-warning" style="width: 150px;">店舗管理TOPへ</a>
                        </div>
                    </div>

                    <!-- qrcode -->
                    <div id="qrcode" class="hidden"></div>
                    <input type="hidden" id="img_qrcode" name="qrcode" value="" required />

                    <input type="hidden" id="user_qrcode" value="{{url('/payment/s=shop&p=' . $shop->name) .'&m=2' }}" required />
                    <input type="hidden" id="user_name" value="{{ $shop->name }}" required />

                @else
                    <input type="hidden" id="user_qrcode" value="" required />
                    <input type="hidden" id="user_name" value="" required />
                @endif

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
@endsection

<!-- Custom JS -->
@section('page_js_vendor')
    <script src="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/select2/js/select2.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/ios7-switch/ios7-switch.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/bootstrap-confirmation/bootstrap-confirmation.js') }}"></script>

    <script src="{{ asset('public/admin/js/qrcode.js') }}"></script>
    <script>

        var user_qrcode = $('#user_qrcode').val();
        if(user_qrcode != ''){
            createQRCode();
        }
        else{
            window.location.href = '{{ url('/admin/shop') }}'
        }

        function createQRCode()
        {
            var user_name = $('#user_name').val();
            new QRCode(document.getElementById("qrcode"), user_qrcode);

            $('img', '#qrcode').on('load', function () {
                $('#img_qrcode').val($(this).attr('src'));

                var url = '{{ url('/admin/shop/qrcode') }}';
                var qrcode = $(this).attr('src');

                // qrcode
                $.ajax({
                    url: url,
                    type: 'post',
                    dataType: 'json',
                    data: { name: user_name, qrcode: qrcode },
                    success: function(data) {
                        if(data.success){

                        }
                    },
                    error : function(data){}
                });

            });
        }


    </script>

@endsection
