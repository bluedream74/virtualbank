@extends('admin.layouts.app')
@section('title', 'ログイン | Virtual Bank')

@section('content')

    <section class="body-sign">
        <div class="center-sign">

            <div class="panel panel-sign">
                <div class="panel-title-sign mt-xl mb-xlg text-center">
                    <img src="{{ asset('public/customer/img/logo.png') }}" width="70%" />
                </div>

                <div class="panel-body pt-sm">

                    <h2 style="color:#000; font-size: 30px; font-weight: bold" class="text-center">決済会社管理画面</h2>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>ログイン情報をご確認してください</strong>
                        </div>
                    @endif

                    <form action="{{ url('admin/login') }}" method="post">
                        {{csrf_field()}}

                        <div class="form-group mb-lg mt-xlg">
                            <label>管理者ID</label>
                            <div class="input-group input-group-icon">
                                <input name="name" id="name" type="text" class="form-control input-lg" />
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group mb-lg">
                            <div class="clearfix">
                                <label class="pull-left">パスワード</label>
                                {{--<a href="{{ url('admin/password/forgot') }}" class="pull-right">※ パスワードを忘れてしまった方はこちら</a>--}}
                            </div>
                            <div class="input-group input-group-icon">
                                <input name="password" id="password" type="password" class="form-control input-lg" />
                                <span class="input-group-addon">
                                    <span class="icon icon-lg">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-7">
                                <div class="checkbox-custom checkbox-default">
                                    <input id="RememberMe" name="rememberme" type="checkbox"/>
                                    <label for="RememberMe" style="font-size: 16px;">次回から入力を省略する。</label>
                                </div>
                            </div>
                            <div class="col-sm-5 text-right">
                                <button type="submit" class="btn btn-danger" style="font-size: 18px;width: 150px; background-color: #00aa6e; border: none; padding: 15px 20px;">ログイン</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </section>
@endsection
