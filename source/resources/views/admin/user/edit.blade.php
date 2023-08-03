@extends('admin.layouts.app')
@section('title', '加盟店情報編集')

@php($list = $datas['list'])
@php($user = $datas['user'])

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <h2><i class="fa fa-building"></i>&nbsp;加盟店ID: {{ $user->name }}（{{ substr($user->created_at,0,10) }}登録）</h2>
            <div class="right-wrapper pull-right">
                <ol class="breadcrumbs">
                    <li>
                        <a href="{{ url('admin/user') }}">
                            <span>加盟店一覧</span>
                        </a>
                    </li>
                </ol>&nbsp;&nbsp;&nbsp;
            </div>
        </header>

        <!-- create form -->
        <div class="row">
            <section class="panel">

                <form class="form-horizontal" action="{{ url('admin/user/edit') }}" enctype="multipart/form-data" method="post">

                    <div class="panel-body">

                        <input type="hidden" value="{{ json_encode($list) }}" id="user">
                        <input type="hidden" value="{{ $user->id }}" name="id" id="id">

                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold text-left">契約者様情報</label>
                        </div>

                        <!-- 加盟店名（契約者名） -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">加盟店名（契約者名）<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <input type="text" id="u_name" class="form-control" name="u_name" value="{{ $user->u_name }}" required="" onchange="checkUserName(this)" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 加盟店名（フリガナ） -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">加盟店名（フリガナ）<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <input type="text" id="u_name_fu" class="form-control" name="u_name_fu" value="{{ $user->u_name_fu }}" required="" onkeypress="toKata(this)" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 加盟店名（パスワード） -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">パスワード<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <input type="text" id="password1" class="form-control" name="password1" value="{{ $user->password1 }}" required oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 加盟店住所 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">加盟店住所<span class="required">（必須）</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="u_address" name="u_address" class="form-control" required="" value="{{ $user->u_address }}" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 加盟店電話番号 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">加盟店電話番号<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <input type="number" id="u_tel" name="u_tel" class="form-control" required="" value="{{ $user->u_tel }}" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 加盟店メールアドレス　-->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">加盟店メールアドレス<span class="required">（必須）</span></label>
                            <div class="col-sm-4">
                                <input type="email" id="u_email" name="u_email" class="form-control" required="" value="{{ $user->u_email }}" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- URL -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">URL</label>
                            <div class="col-sm-4">
                                <input type="text" id="u_url" name="u_url" class="form-control" value="{{ $user->u_url }}" />
                            </div>
                        </div>

                        <!-- 代表取締役名 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">代表取締役名</label>
                            <div class="col-sm-4">
                                <input type="text" id="u_director_name" name="u_director_name" class="form-control" value="{{ $user->u_director_name }}" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 代表取締役名(フリガナ)  -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">代表取締役名(フリガナ)</label>
                            <div class="col-sm-4">
                                <input type="text" id="u_director_name_fu" name="u_director_name_fu" class="form-control" value="{{ $user->u_director_name_fu }}" onkeypress="toKata(this)"  oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 代表取締役住所　-->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">代表取締役住所</label>
                            <div class="col-sm-4">
                                <input type="text" id="u_director_address" name="u_director_address" class="form-control" value="{{ $user->u_director_address }}" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 代表取締役電話番号 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">代表取締役電話番号</label>
                            <div class="col-sm-2">
                                <input type="number" id="u_director_tel" name="u_director_tel" class="form-control" value="{{ $user->u_director_tel }}" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold">売上金振込み口座情報</label>
                        </div>

                        <!-- 金融機関 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">金融機関<span class="required">（必須）</span></label>
                            <div class="col-sm-4 mt-xs">
                                <input type="text" id="u_banktype" name="u_banktype" class="form-control" value="{{ $user->u_banktype }}" required="" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 金融機関コード-->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">金融機関コード<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <input type="text" id="u_bankcode" name="u_bankcode" class="form-control" required value="{{ $user->u_bankcode }}" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 支店名-->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">支店名<span class="required">（必須）</span></label>
                            <div class="col-sm-4 mt-xs">
                                <input type="text" id="u_branch" name="u_branch" class="form-control" required value="{{ $user->u_branch }}"  oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 支店コード -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">支店コード<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <input type="text" id="u_branchcode" name="u_branchcode" class="form-control" required="" value="{{ $user->u_branchcode }}" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 口座番号-->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">口座番号<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <input type="text" id="u_holdernumber" name="u_holdernumber" class="form-control" required="" value="{{ $user->u_holdernumber }}"  oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 口座種別 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">口座種別<span class="required">（必須）</span></label>
                            <div class="col-sm-1 mt-xs" style="max-width: 130px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="u_holdertype1" name="u_holdertype" value="普通" @if($user->u_holdertype == '普通') checked @endif>
                                    <label for="u_holdertype1" class="c-radio-title">&nbsp;&nbsp;普通</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs" style="max-width: 130px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="u_holdertype2" name="u_holdertype" value="当座" @if($user->u_holdertype == '当座') checked @endif>
                                    <label for="u_holdertype2" class="c-radio-title">&nbsp;&nbsp;当座</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs" style="max-width: 130px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="u_holdertype3" name="u_holdertype" value="貯蓄" @if($user->u_holdertype == '貯蓄') checked @endif>
                                    <label for="u_holdertype3" class="c-radio-title">&nbsp;&nbsp;貯蓄</label>
                                </div>
                            </div>
                        </div>

                        <!-- 口座名義人（正式）-->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">口座名義人（正式）<span class="required">（必須）</span></label>
                            <div class="col-sm-4">
                                @if($user->u_holdername_mei == '')
                                    <input type="text" id="u_holdername_sei" name="u_holdername_sei" class="form-control" placeholder="山田 太郎" value="{{ $user->u_holdername_sei }}" required="" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                                @else
                                    <input type="text" id="u_holdername_sei" name="u_holdername_sei" class="form-control" placeholder="山田 太郎" value="{{ $user->u_holdername_sei . ' ' . $user->u_holdername_mei}}" required="" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                                @endif
                            </div>
                        </div>

                        <!-- 口座名義人（フリガナ）-->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">口座名義人（フリガナ）<span class="required">（必須）</span></label>
                            <div class="col-sm-4">
                                @if($user->u_holdername_fu_mei == '')
                                    <input type="text" id="u_holdername_fu_sei" name="u_holdername_fu_sei" class="form-control" placeholder="半角英数字カタカナで入力" value="{{ $user->u_holdername_fu_sei }}"  required="" onkeypress="toKata(this)" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                                @else
                                    <input type="text" id="u_holdername_fu_sei" name="u_holdername_fu_sei" class="form-control" placeholder="半角英数字カタカナで入力" value="{{ $user->u_holdername_fu_sei . ' ' . $user->u_holdername_fu_mei }}"  required="" onkeypress="toKata(this)" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold">契約状況</label>
                        </div>

                        <!--  審査中/契約中/解約/休止 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">契約状況<span class="required">（必須）</span></label>
                            <div class="col-sm-1 mt-xs" style="max-width: 130px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="u_status1" name="u_status" value="審査中" @if($user->u_status == '審査中') checked @endif>
                                    <label for="u_status1" class="c-radio-title">&nbsp;&nbsp;審査中</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs" style="max-width: 130px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="u_status2" name="u_status" value="契約中" @if($user->u_status == '契約中') checked @endif>
                                    <label for="u_status2" class="c-radio-title">&nbsp;&nbsp;契約中</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs" style="max-width: 130px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="u_status3" name="u_status" value="解約" @if($user->u_status == '解約') checked @endif>
                                    <label for="u_status3" class="c-radio-title">&nbsp;&nbsp;解約</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="u_status4" name="u_status" value="休止" @if($user->u_status == '休止') checked @endif>
                                    <label for="u_status4" class="c-radio-title">&nbsp;&nbsp;休止</label>
                                </div>
                            </div>
                        </div>

                        <!-- memo -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">メモ</label>
                            <div class="col-sm-4">
                                <textarea id="u_memo" class="form-control" name="u_memo" rows="5"> {{ $user->u_memo }}</textarea>
                            </div>
                        </div>

                    </div>

                    <footer class="panel-footer">
                        <button class="btn btn-warning pull-right" style="width:120px;;">修正する</button>
                        <a class="btn btn-success pull-right" href="{{ url('admin/user/shops/' . $user->id) }}" style="width:120px; margin-right: 10px;">ひもつき店舗</a>
                        <a class="btn btn-default" href="{{ url('admin/user') }}" style="width:120px;">戻る</a>
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

        function checkUserName(obj)
        {
            var u_id = $('#id').val();
            var u_name = $(obj).val();
            var arr_user = JSON.parse($('#users').val());

            $.each(arr_user, function(key, user){

               if((u_id != user['id']) && (user['u_name'] == u_name)) {
                   alert('別の加盟店名を入力してください');
                   $(obj).val('');
               }
            });
        }

    </script>
@endsection
