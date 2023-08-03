@extends('admin.layouts.app')
@section('title', 'グループ情報編集')

@php($list = $datas['list'])
@php($group = $datas['group'])

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <h2><i class="fa fa-users"></i>&nbsp;グループ情報</h2>
        </header>

        <!-- create form -->
        <div class="row">
            <section class="panel">

                <form class="form-horizontal" action="{{ url('admin/group/edit') }}" enctype="multipart/form-data" method="post">

                    <div class="panel-body">

                        <input type="hidden" value="{{ $group->id }}" name="id">

                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold text-left">グループ情報</label>
                        </div>

                        <div style="width: 800px; margin: 0 auto;">
                            <table width="100%" class="detail-table">
                                <tbody>
                                    <tr>
                                        <td style="background-color: #c0ffc6" width="50%">紐付き加盟店数</td>
                                        <td style="background-color: #c0ffc6" width="50%">{{ $group->g_merchantcount }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #c0ffc6" width="50%">紐付き店舗数</td>
                                        <td style="background-color: #c0ffc6" width="50%">{{ $group->g_shopcount }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">登録日</td>
                                        <td style="background-color: #fff56b" width="50%">{{ substr($group->created_at,0,10) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">グループID</td>
                                        <td style="background-color: #fff56b" width="50%">{{ $group->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">パスワード</td>
                                        <td style="background-color: #fff56b" width="50%">{{ $group->password1 }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">契約状況</td>
                                        <td style="background-color: #fff56b" width="50%">{{ $group->g_status }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">形態</td>
                                        <td style="background-color: #fff56b" width="50%">{{ $group->g_kind }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold text-left">紐づき店舗</label>
                        </div>

                        <!-- 紐づき店舗 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-4">
                                <textarea id="g_shoplist" class="form-control" name="g_shoplist" rows="10" required oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')">{!! $group->g_shoplist !!}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold text-left">登録グループ情報</label>
                        </div>

                        <!-- グループ名 -->
                        <div class="form-group mt-xlg">
                            <label class="col-sm-4 control-label">グループ名<span class="required">（必須）</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="g_name" class="form-control" name="g_name" required value="{{ $group->g_name }}" onchange="checkGroupname(this)" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- グループ名（カタカナ） -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">グループ名（カタカナ）<span class="required">（必須）</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="g_name_fu" class="form-control" name="g_name_fu" required value="{{ $group->g_name_fu }}" onkeypress="toKata(this)" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- グループ代表者名 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">グループ代表者名</label>
                            <div class="col-sm-4">
                                <input type="text" id="g_agency_name" class="form-control" name="g_agency_name" value="{{ $group->g_agency_name }}"/>
                            </div>
                        </div>

                        <!-- グループ代表者名（カタカナ） -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">グループ代表者名（カタカナ）</label>
                            <div class="col-sm-4">
                                <input type="text" id="g_agency_name_fu" class="form-control" name="g_agency_name_fu" value="{{ $group->g_agency_name_fu }}" />
                            </div>
                        </div>

                        <!-- グループ代表者電話番号 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">グループ代表者電話番号</label>
                            <div class="col-sm-4">
                                <input type="tel" id="g_agency_tel" class="form-control" name="g_agency_tel" value="{{ $group->g_agency_tel }}"/>
                            </div>
                        </div>

                        <!-- グループ代表者メールアドレス -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">グループ代表者メールアドレス</label>
                            <div class="col-sm-4">
                                <input type="email" id="g_agency_email" class="form-control" name="g_agency_email" value="{{ $group->g_agency_email }}" />
                            </div>
                        </div>

                        <!-- 決済後サンキューメール（確認メール） -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">決済後サンキューメール（確認メール）</label>
                            <div class="col-sm-4">
                                <input type="email" id="g_thanks_email1" class="form-control" name="g_thanks_email1" value="{{ $group->g_thanks_email1 }}"/><br>
                                <input type="email" id="g_thanks_email2" class="form-control" name="g_thanks_email2" value="{{ $group->g_thanks_email2 }}"/><br>
                                <input type="email" id="g_thanks_email3" class="form-control" name="g_thanks_email3" value="{{ $group->g_thanks_email3 }}"/>
                            </div>
                        </div>

                        <!-- 契約状況 -->
                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold">契約状況</label>
                        </div>

                        <!--  審査中/契約中/解約/休止 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-1 mt-xs" style="max-width: 130px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="g_status1" name="g_status" value="契約中" @if($group->g_status == '契約中') checked @endif>
                                    <label for="g_status1" class="c-radio-title">&nbsp;&nbsp;契約中</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs" style="max-width: 130px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="g_status2" name="g_status" value="休止" @if($group->g_status == '休止') checked @endif>
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
                                    <input type="radio" id="g_kind1" name="g_kind" value="グループ店" @if($group->g_kind == 'グループ店') checked @endif>
                                    <label for="g_kind1" class="c-radio-title">&nbsp;&nbsp;グループ店</label>
                                </div>
                            </div>
                            <div class="col-sm-2 mt-xs" style="max-width: 170px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="g_kind2" name="g_kind" value="代理店" @if($group->g_kind == '代理店') checked @endif>
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
                                <textarea id="g_memo" class="form-control" name="g_memo" rows="10">{{ $group->g_memo }}</textarea>
                            </div>
                        </div>

                    </div>

                    <footer class="panel-footer">
                        <button class="btn btn-warning pull-right" style="width:200px;;">グループ情報を変更する</button>
                        <a class="btn btn-default" onclick="window.history.back()" style="width:120px;">戻る</a>
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

        function checkShopname(obj)
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

        function checkMember(obj)
        {
            var member_id = $(obj).val();
            var arr_user = JSON.parse($('#merchants').val());

            var bExist = false;
            $.each(arr_user, function(key, user){
                if(user['name'] == member_id){
                    bExist = true;
                }
            });

            if(!bExist){
                alert('加盟店IDを正しく入力してください');
                $(obj).val('');
            }
        }

        var arr_user = JSON.parse($('#merchants').val());
        if(arr_user.length == 0){
            alert('登録された加盟店がありません。');
            window.location.href = '{{ url('admin/user/') }}';
        }

        // checkbox ; service_type
        var service_types = JSON.parse($('#service_types').val());
        if(service_types.length != 0){
            $.each(service_types, function(key, type){

                if(type['service_id'] == 1){
                    $('#service1').prop('checked', true);
                }
                if(type['service_id'] == 2){
                    $('#service2').prop('checked', true);
                }
                if(type['service_id'] == 3){
                    $('#service3').prop('checked', true);
                }
                if(type['service_id'] == 4){
                    $('#service4').prop('checked', true);
                }
            });
        }

        // checkbox ; card_type
        var card_types = JSON.parse($('#card_types').val());
        if(card_types.length != 0){
            $.each(card_types, function(key, type){

                if(type['card_id'] == 1){
                    $('#card1').prop('checked', true);
                }
                if(type['card_id'] == 2){
                    $('#card2').prop('checked', true);
                }
                if(type['card_id'] == 3){
                    $('#card3').prop('checked', true);
                }
                if(type['card_id'] == 4){
                    $('#card4').prop('checked', true);
                }
            });
        }

    </script>
@endsection
