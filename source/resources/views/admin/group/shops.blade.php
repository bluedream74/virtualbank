@extends('admin.layouts.app')
@section('title', 'ひもつき店舗 | Virtual Bank')

@php( $list = $datas['list'])

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <h2><i class="fa fa-user"></i>&nbsp;&nbsp;ひもつき店舗</h2>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">

                <!-- table -->
                <table class="table table-bordered table-striped text-center" id="shop_datatable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center" width="5%">ID</th>
                            <th class="text-center" width="10%">登録日</th>
                            <th class="text-center" width="10%">店舗ID</th>
                            <th class="text-center" width="10%">店舗名</th>
                            <th class="text-center" width="10%">電話番号</th>
                            <th class="text-center" width="10%">加盟店ID</th>
                            <th class="text-center" width="15%">メンズエステ</th>
                            <th class="text-center" width="10%">支払いサイクル</th>
                            <th class="text-center" width="10%">契約状況</th>
                            <th class="text-center hidden" width="10%">削除</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php( $index = 1 )
                        @foreach($list as $shop)
                            <tr>
                                <td>{{ $index }}</td>
                                <td>{{ substr($shop->created_at,0,10) }}</td>
                                <td><a class="link" href="{{ url('admin/shop/edit/' . $shop->id) }}">{{ $shop->name }}</a></td>
                                <td><a class="link" href="{{ url('admin/shop/edit/' . $shop->id) }}">{{ $shop->s_name }}</a></td>
                                <td>{{ $shop->s_tel }}</td>
                                <td>{{ $shop->member_id }}</td>
                                <td>
                                    @foreach($shop->service_types as $service)
                                        「{{ $service->service_name }}」
                                    @endforeach
                                </td>
                                <td>{{ $shop->s_paycycle_name }}</td>
                                <td>{{ $shop->s_status }}</td>
                                <td class="hidden">
                                    <a class="btn btn-danger remove-row" data-plugin-tooltip data-toggle="tooltip" data-placement="top" data-original-title="削除" data-url="{{ url('/admin/shop/delete/' .$shop->id) }}"><i class="fa fa-trash" style="color: white;"></i></a>
                                </td>
                            </tr>
                            @php( $index++ )
                        @endforeach
                    </tbody>

                </table>
            </div>
        </section>
        <!-- end page -->

    </section>


    <!-- Delete Dialog -->
    <div id="dialog" class="modal-block mfp-hide">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">店舗削除</h2>
            </header>
            <div class="panel-body">
                <div class="modal-wrapper">
                    <div class="modal-text">
                        <p>この店舗を削除しますか?</p>
                    </div>
                </div>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button id="dialogConfirm" class="btn btn-danger" style="width: 120px;">確認</button>
                        <button id="dialogCancel" class="btn btn-default" style="width: 120px;">キャンセル</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>
    <!-- end dialog -->

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
    <script src="{{ asset('public/admin/js/views/shop.js') }}"></script>
@endsection
