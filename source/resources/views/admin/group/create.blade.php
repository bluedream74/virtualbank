@extends('admin.layouts.app')
@section('title', '新規グループ登録')

@php($list = $datas['list'])

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <h2>新規グループ登録</h2>
            <div class="right-wrapper pull-right">
                <ol class="breadcrumbs">
                    <li>
                        <a href="{{ url('admin/group') }}">
                            <span>グループ管理</span>
                        </a>
                    </li>
                </ol>&nbsp;&nbsp;&nbsp;
            </div>
        </header>

        <!-- create form -->
        <div class="row">
            <section class="panel">

                <form class="form-horizontal" action="{{ url('admin/group/create') }}" enctype="multipart/form-data" method="post">

                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold text-left">紐づき店舗</label>
                        </div>

                        <!-- 紐づき店舗 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-4">
                                <textarea id="g_shoplist" class="form-control" name="g_shoplist" rows="10" required oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold text-left">登録グループ情報</label>
                        </div>

                        <!-- グループ名 -->
                        <div class="form-group mt-xlg">
                            <label class="col-sm-4 control-label">グループ名<span class="required">（必須）</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="g_name" class="form-control" name="g_name" required="" onchange="checkGroupname(this)" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- グループ名（カタカナ） -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">グループ名（カタカナ）<span class="required">（必須）</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="g_name_fu" class="form-control" name="g_name_fu" required="" onkeypress="toKata(this)" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- グループ代表者名 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">グループ代表者名</label>
                            <div class="col-sm-4">
                                <input type="text" id="g_agency_name" class="form-control" name="g_agency_name" />
                            </div>
                        </div>

                        <!-- グループ代表者名（カタカナ） -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">グループ代表者名（カタカナ）</label>
                            <div class="col-sm-4">
                                <input type="text" id="g_agency_name_fu" class="form-control" name="g_agency_name_fu" />
                            </div>
                        </div>

                        <!-- グループ代表者電話番号 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">グループ代表者電話番号</label>
                            <div class="col-sm-4">
                                <input type="tel" id="g_agency_tel" class="form-control" name="g_agency_tel"/>
                            </div>
                        </div>

                        <!-- グループ代表者メールアドレス -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">グループ代表者メールアドレス</label>
                            <div class="col-sm-4">
                                <input type="email" id="g_agency_email" class="form-control" name="g_agency_email" />
                            </div>
                        </div>

                        <!-- 決済後サンキューメール（確認メール） -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">決済後サンキューメール（確認メール）</label>
                            <div class="col-sm-4">
                                <input type="email" id="g_thanks_email1" class="form-control" name="g_thanks_email1" /><br>
                                <input type="email" id="g_thanks_email2" class="form-control" name="g_thanks_email2" /><br>
                                <input type="email" id="g_thanks_email3" class="form-control" name="g_thanks_email3" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold text-left">契約状況</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-1 mt-xs" style="max-width: 130px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="g_status1" name="g_status" value="契約中" checked>
                                    <label for="g_status1" class="c-radio-title">&nbsp;&nbsp;契約中</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs" style="max-width: 130px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="g_status2" name="g_status" value="休止">
                                    <label for="g_status2" class="c-radio-title">&nbsp;&nbsp;休止</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold text-left">形態</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-2 mt-xs" style="max-width: 170px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="g_kind1" name="g_kind" value="グループ店" checked>
                                    <label for="g_kind1" class="c-radio-title">&nbsp;&nbsp;グループ店</label>
                                </div>
                            </div>
                            <div class="col-sm-2 mt-xs" style="max-width: 170px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="g_kind2" name="g_kind" value="代理店">
                                    <label for="g_kind2" class="c-radio-title">&nbsp;&nbsp;代理店</label>
                                </div>
                            </div>
                        </div>

                        <!-- memo -->
                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold text-left">メモ欄</label>
                        </div>
                        <div class="form-group m-xlg">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-4 p-none">
                                <textarea id="g_memo" class="form-control" name="g_memo" rows="10"></textarea>
                            </div>
                        </div>

                    </div>

                    <footer class="panel-footer">
                        <button class="btn btn-warning pull-right" style="width:200px;;">新規グループ登録する</button>
                        <a class="btn btn-default" href="{{ url('admin/group') }}" style="width:120px;">戻る</a>
                    </footer>

                </form>
            </section>

        </div>

    </section>

@endsection

<!-- Custom CSS -->
@section('page_css')
@endsection

<!-- Custom JS -->
@section('page_js_vendor')

    <script src="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/bootstrap-confirmation/bootstrap-confirmation.js') }}"></script>
    <script src="https://unpkg.com/wanakana"></script>
    <script>

        function toKata(inputObj)
        {
            var inp_val = wanakana.toKatakana($(inputObj).val());
            $(inputObj).val(inp_val);
        }

        function checkGroupname(obj)
        {
            var s_name = $(obj).val();
            var arr_shop = JSON.parse($('#shops').val());
            $.each(arr_shop, function(key, shop){

                if(shop['s_name'] == s_name){
                    alert('別の店舗名を入力してください');
                    $(obj).val('');
                }
            });
        }

    </script>
@endsection
