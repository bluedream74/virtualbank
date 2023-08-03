@extends('admin.layouts.app')
@section('title', 'Forgot Password')
@section('content')
    <section class="body-sign">
        <div class="center-sign">
                <div class="panel panel-sign">
                <div class="panel-title-sign mt-xl text-right">
                    <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> パスワードの回復</h2>
                </div>
                <div class="panel-body">
                    <div class="alert alert-info">
                        <p class="m-none text-weight-semibold h6">メールアドレスを入力すると,リセット手順が送信されます。</p>
                    </div>

                    <form action="{{ url('admin/password/email') }}" method="post">
                        {{csrf_field()}}
                        <div class="form-group mb-none">
                            <div class="input-group">
                                <input name="email" id="email" type="email" placeholder="メールアドレス" class="form-control input-lg" />
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-lg" style="width: 120px !important;" type="submit">リセット</button>
                                </span>
                            </div>
                        </div>

                        <p class="text-center mt-lg">覚えていますか? <a href="{{ url('admin/login') }}"> ログイン</a></p>
                    </form>
                </div>
            </div>

            <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2021 All Rights Reserved.</p>
        </div>
    </section>
@endsection
