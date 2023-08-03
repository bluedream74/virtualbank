@extends('admin.layouts.app')
@section('title', '情報編集 | VirtualBank')

@php( $user = $datas['user'])
@php( $db_date = $datas['db_date'])
@php( $enable_db_date = $datas['enable_db_date'])

@section('content')

    <section role="main" class="content-body">

        <header class="page-header">
            <h2><i class="fa fa-user"></i>&nbsp;&nbsp;情報編集&nbsp;&nbsp;</h2>
        </header>

        <!-- detail -->
        <div class="row">
            <section class="panel form-wizard">

               <div class="col-md-12">

                   <form class="form-horizontal" action="{{ url('admin/profile/edit/') }}" enctype="multipart/form-data" method="post" id="editForm">

                        <div class="panel-body">

                            <!-- error -->
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-4">
                                    <div class="alert alert-danger hidden">
                                        <strong id="error_msg"></strong>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" value="{{ $user->id }}" name="id" />

                            <!-- 管理者名 -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label">ユーザー名<span class="required">（必須）</span></label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-icon">
                                        <input type="text" id="name" class="form-control input-lg" name="name" value="{{ $user->name }}" placeholder="" required/>
                                        <span class="input-group-addon">
                                            <span class="icon icon-lg">
                                                <i class="fa fa-user"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- 管理者メールアドレス -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label">メールアドレス<span class="required">（必須）</span></label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-icon">
                                        <input type="email" id="email" class="form-control input-lg" name="email" value="{{ $user->email }}" placeholder="your@email.com" required/>
                                        <span class="input-group-addon">
                                            <span class="icon icon-lg">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- パスワード -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label">パスワード</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-icon">
                                        <input type="password" id="password" class="form-control input-lg" name="password" placeholder="パスワード" required/>
                                        <span class="input-group-addon">
                                            <span class="icon icon-lg">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- パスワード確認 -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label">パスワード確認</label>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-icon">
                                        <input type="password" id="confirm" class="form-control input-lg" name="confirm" placeholder="パスワード確認" required/>
                                        <span class="input-group-addon">
                                            <span class="icon icon-lg">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- DB時間 -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label">DB時間</label>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control input-lg" id="db_date" name="db_date" @if($db_date != '1900-01-31') value="{{ $db_date }}" @endif/>
                                    <input type="checkbox" name="enable_db_date" id="enable_db_date" class="mt-md" @if($enable_db_date) checked @endif/><label for="enable_db_date">&nbsp;&nbsp;DB時間を変更します。</label>
                                </div>
                            </div>

                        </div>

                       <footer class="panel-footer">
                           <a class="btn btn-warning pull-right" style="width: 120px" onclick="validateForm()">変更する</a>
                           <a class="btn btn-default" onclick="window.history.back();"  style="width: 120px">戻る</a>
                       </footer>

                   </form>

                </div>

            </section>
        </div>
        <!-- end content-->

    </section>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/select2/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/css/views/user.css') }}" />

@endsection

<!-- Custom JS -->
@section('page_js_vendor')
    <script src="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/select2/js/select2.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js') }}"></script>

    <script>

        function validateForm()
        {
            $('.alert').addClass('hidden');
            $('#error_msg').html('');

            var username = $('#name').val();
            if(username == ''){
                $('.alert').removeClass('hidden');
                $('#error_msg').html('お客様IDを入力してください。');
                $('#name').focus();
                return false;
            }

            var email = $('#email').val();
            if(email == ''){
                $('.alert').removeClass('hidden');
                $('#error_msg').html('メールアドレスを入力してください。');
                $('#email').focus();
                return false;
            }

            if(!isEmail(email)){
                $('.alert').removeClass('hidden');
                $('#error_msg').html('メールアドレスをご確認ください。');
                $('#email').focus();
                return false;
            }

            var password = $('#password').val();
            var confirm = $('#confirm').val();
            if(password == ''){
                if(confirm != ''){
                    $('.alert').removeClass('hidden');
                    $('#error_msg').html('パスワードを入力してください。');
                    $('#password').focus();
                    return false;
                }

            } else {
                if(confirm != password){
                    $('.alert').removeClass('hidden');
                    $('#error_msg').html('パスワードをご確認ください。');
                    $('#confirm').focus();
                    return false;
                }
            }

            // db date
            if($('#enable_db_date').prop('checked')){
                if($('#db_date').val() == ''){
                    $('#db_date').focus();
                    return false;
                }
            }

            $('#editForm').submit();

        }

        function isEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

    </script>

@endsection