@extends('admin.layouts.app')
@section('title', '加盟店管理 | Virtual Bank')

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <h2><i class="fa fa-building"></i>&nbsp;&nbsp;加盟店情報</h2>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">
                <h2 class="control-label-bold text-center" style="color: orangered;">{{ session('title') }}</h2>

                @php($user = session('user'))
                @if($user != null)
                    <div class="row mt-xlg mb-xlg">
                        <div class="col-sm-6 col-sm-offset-3">
                            <table width="100%" class="detail-table">
                                <tbody>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">登録日</td>
                                        <td style="background-color: #fff56b" width="50%">{{ substr($user->created_at,0,10) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">加盟店ID</td>
                                        <td style="background-color: #fff56b" width="50%">{{ $user->name }}</td>
                                    </tr>
                                    <tr class="text-center">
                                        <td style="background-color: #87f5ff" width="50%" colspan="2">契約者様情報</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">加盟店名（契約者名）</td>
                                        <td class="border-r">{{ $user->u_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">加盟店名（フリガナ）</td>
                                        <td class="border-r">{{ $user->u_name_fu }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">パスワード</td>
                                        <td class="border-r">{{ $user->password1 }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">加盟店住所</td>
                                        <td class="border-r">{{ $user->u_address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">加盟店電話番号</td>
                                        <td class="border-r">{{ $user->u_tel }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">URL</td>
                                        <td class="border-r">{{ $user->u_url }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">加盟店メールアドレス</td>
                                        <td class="border-r">{{ $user->u_email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">代表取締役名</td>
                                        <td class="border-r">{{ $user->u_director_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">代表取締役名(フリガナ)</td>
                                        <td class="border-r">{{ $user->u_director_name_fu }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">代表取締役住所</td>
                                        <td class="border-r">{{ $user->u_director_address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">代表取締役電話番号</td>
                                        <td class="border-r">{{ $user->u_director_tel }}</td>
                                    </tr>

                                    <tr class="text-center">
                                        <td style="background-color: #87f5ff" width="50%" colspan="2">売上金振込み口座情報</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">金融機関</td>
                                        <td class="border-r">{{ $user->u_banktype }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">金融機関コード</td>
                                        <td class="border-r">{{ $user->u_bankcode }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">金融機関支店</td>
                                        <td class="border-r">{{ $user->u_branch }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">支店コード</td>
                                        <td class="border-r">{{ $user->u_branchcode }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">口座番号</td>
                                        <td class="border-r">{{ $user->u_holdernumber }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">口座種別</td>
                                        <td class="border-r">{{ $user->u_holdertype }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">口座名義人（正式）</td>
                                        <td class="border-r">{{ $user->u_holdername_sei }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">口座名義人（フリガナ）</td>
                                        <td class="border-r">{{ $user->u_holdername_fu_sei }}</td>
                                    </tr>
                                    <tr class="text-center">
                                        <td style="background-color: #87f5ff" width="50%" colspan="2">契約状況</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">契約状況</td>
                                        <td class="border-r">{{ $user->u_status }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">メモ</td>
                                        <td class="border-r">{{ $user->u_memo }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <a href="{{ url('admin/user') }}" class="btn btn-warning" style="width: 150px;">加盟店管理TOPへ</a>
                        </div>
                    </div>

                    <!-- qrcode -->
                    <div id="qrcode" class="hidden"></div>
                    <input type="hidden" id="img_qrcode" name="qrcode" value="" required />

                    <input type="hidden" id="user_qrcode" value="{{ url('/payment/s=merchant&p=' . $user->name) . '&m=2' }}" required />
                    <input type="hidden" id="user_name" value="{{ $user->name }}" required />

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
            window.location.href = '{{ url('/admin/user') }}'
        }

        function createQRCode()
        {
            var user_name = $('#user_name').val();
            new QRCode(document.getElementById("qrcode"), user_qrcode);

             $('img', '#qrcode').on('load', function () {

                 $('#img_qrcode').val($(this).attr('src'));

                 var url = '{{ url('/admin/user/qrcode') }}';
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
