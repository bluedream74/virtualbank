@extends('merchant.layouts.app')
@section('title', '加盟店管理画面')
@section('content')

    <div role="main" class="main">

        <header id="page-top">

            <div class="inner-header pt-md">
                <a href="{{ url('/merchant') }}" class="logo-link" style="text-align: left;"><img src="{{ asset('public/customer/img/logo.png') }}" width="55%" style="max-width: 450px;"></a>
            </div>
        </header>

        <div class="text-center" style="margin-top: 80px;"><h2 style="font-weight: bold; color: white;">加盟店管理画面</h2></div>

        <div class="row" style="padding: 50px 10px 20px;">
            <div class="col-sm-4 col-sm-offset-4 col-xs-12">

                <form action="{{ url('/merchant/login') }}" method="post" class="input-form">
                    {{csrf_field()}}

                    @if (count($errors) > 0)
                        <label style="color:red">ログイン情報をご確認してください</label>
                    @endif

                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label class="control-label" style="color: white">ログインID</label>
                                <input type="text" name="name" id="name" class="form-control input-lg" placeholder="ログインID">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label class="control-label" style="color: white">パスワード</label>
                                <input type="password" name="password" id="password" class="form-control input-lg" placeholder="パスワード">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-sm">
                        <div class="form-group pl-md">
                            <div class="checkbox-custom checkbox-default col-xs-12">
                                <input type="checkbox" id="rememberme" name="rememberme" /><label for="rememberme" style="color: white">次回から入力を省略する。</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-lg">
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <button type="submit" style="padding: 10px 40px; width: 250px; font-weight: normal; font-size: 16px !important;" class="btn btn-default btn-gold mb-xl">ログイン</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <footer>
        <div class="footer-inner">

            <div class="contact-box pt-lg mb-xlg">
                <div class="col-xs-12 text-center"><h3 class="mb-md"><strong style="color: #000">お問い合わせ</strong></h3></div>
                <div class="col-xs-12 p-none">
                    <div class="contact-info">
                        <p><i class="fa fa-envelope"></i>&nbsp;support@smart-payment.co.jp</p>
                        <p><i class="fa fa-phone-square"></i>&nbsp;045-323-0108</p>
                    </div>
                </div>
                <div class="col-xs-12 text-center">
                    <p class="mt-xs" style="font-size: 17px; color: #999">365日24時間受付</p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 copy-right text-center p-none" style="margin-top: 20px; font-weight: bold; color: #2d2d2d;"><small>Copyright © 2021 All Rights Reserved.</small></div>
            </div>
        </div>
    </footer>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/merchant/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('public/merchant/css/views/login.css') }}">
@endsection

