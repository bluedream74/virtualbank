@extends('admin.layouts.app')
@section('title', 'ひもつき加盟店 | Virtual Bank')

@php( $list = $datas['list'])

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <h2><i class="fa fa-building"></i>&nbsp;&nbsp;ひもつき加盟店</h2>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">

                <!-- table -->
                <table class="table table-bordered table-striped text-center" id="user_datatable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center" width="5%">ID</th>
                            <th class="text-center" width="10%">登録日</th>
                            <th class="text-center" width="12%">加盟店ID</th>
                            <th class="text-center" width="20%">加盟店名</th>
                            <th class="text-center" width="13%">店舗数(紐づいている)</th>
                            <th class="text-center" width="10%">契約状況</th>
                            <th class="text-center" width="10%">金融機関コード</th>
                            <th class="text-center" width="15%">加盟店メールアドレス</th>
                            <th class="text-center last-child hidden" width="5%">削除</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php( $index = 1 )
                        @foreach($list as $item)
                            <tr>
                                <td class="text-center">{{ $index }}</td>
                                <td class="text-center">{{ substr($item->created_at,0,10) }}</td>
                                <td class="text-center"><a class="link" href="{{ url('admin/user/edit/' . $item->id) }}">{{ $item->name }}</a></td>
                                <td class="text-center"><a class="link" href="{{ url('admin/user/edit/' . $item->id) }}">{{ $item->u_name }}</a></td>
                                <td class="text-center">
                                    @if(sizeof($item->shops) > 0)
                                        <a href="{{ url('admin/user/shops/' . $item->id)}}" style="color: white;padding: 5px 10px; border-radius: 15px;background-color: orange">{{ sizeof($item->shops) }}</a>
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->u_status }}</td>
                                <td class="text-center">{{ $item->u_bankcode }}</td>
                                <td class="text-center">{{ $item->u_email }}</td>
                                <td class="text-center last-child hidden">
                                    <a class="btn btn-danger remove-row" data-plugin-tooltip data-toggle="tooltip" data-placement="top" data-original-title="削除" data-url="{{ url('admin/user/delete/' .$item->id) }}"><i class="fa fa-trash"></i></a>
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
