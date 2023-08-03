<?php $__env->startSection('title', '店舗情報編集'); ?>

<?php ($shop = $datas['shop']); ?>
<?php ($shops = $datas['shops']); ?>
<?php ($merchants = $datas['merchants']); ?>
<?php ($enable_edit_cycle = $datas['enable_edit_cycle']); ?>
<?php ($arr_mids = \App\Models\Mid::all()); ?>

<?php $__env->startSection('content'); ?>

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <h2><i class="fa fa-user"></i>&nbsp;店舗情報</h2>
        </header>

        <!-- create form -->
        <div class="row">
            <section class="panel">

                <form class="form-horizontal" action="<?php echo e(url('admin/shop/edit')); ?>" enctype="multipart/form-data" method="post">

                    <div class="panel-body">

                        <input type="hidden" value="<?php echo e(json_encode($merchants)); ?>" id="merchants">
                        <input type="hidden" value="<?php echo e(json_encode($shops)); ?>" id="shops">
                        <input type="hidden" value="<?php echo e($shop->id); ?>" name="id">
                        <input type="hidden" value="<?php echo e($shop->member_id); ?>" name="member_id">

                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold text-left">店舗情報</label>
                        </div>

                        <!-- 店舗名 -->
                        <div style="width: 800px; margin: 0 auto;">
                            <table width="100%" class="detail-table">
                                <tbody>
                                    <tr>
                                        <td style="background-color: #c0ffc6" width="50%"><strong>加盟店ID</strong></td>
                                        <td style="background-color: #c0ffc6" width="50%"><?php echo e($shop->member_id); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%"><strong>登録日</strong></td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e(substr($shop->created_at,0,10)); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%"><strong>店舗ID</strong></td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($shop->name); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%"><strong>パスワード</strong></td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($shop->password1); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%"><strong>決済URL</strong></td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($shop->payment_url); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%"><strong>契約状況</strong></td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($shop->s_status); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold text-left">登録店舗情報</label>
                        </div>

                        <!-- 店舗名 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">店舗名<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <input type="text" id="s_name" class="form-control" name="s_name" required="" value="<?php echo e($shop->s_name); ?>" onchange="checkUsername(this)" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 店舗名（カタカナ） -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">店舗名（カタカナ）<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <input type="text" id="s_name_fu" class="form-control" name="s_name_fu" required="" value="<?php echo e($shop->s_name_fu); ?>" onkeypress="toKata(this)" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- パスワード -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">パスワード<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <input type="text" id="password" class="form-control" name="password" required="" value="<?php echo e($shop->password1); ?>" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- サービス種目 -->
                        <div class="form-group">
                            <input type="hidden" id="service_types" value="<?php echo e(json_encode($shop->service_types)); ?>">

                            <label class="col-sm-4 control-label">サービス種目<span class="required">（必須）</span></label>
                            <div class="checkbox-custom checkbox-default col-sm-1 ml-md">
                                <input type="checkbox" id="service1" name="service_type[]" value="1"/><label for="service1">デリヘル</label>
                            </div>
                            <div class="checkbox-custom checkbox-default col-sm-1">
                                <input type="checkbox" id="service2" name="service_type[]"  value="2"/><label for="service2">ソープランド</label>
                            </div>
                            <div class="checkbox-custom checkbox-default col-sm-1">
                                <input type="checkbox" id="service3" name="service_type[]" value="3"/><label for="service3">ヘルス</label>
                            </div>
                            <div class="checkbox-custom checkbox-default col-sm-1">
                                <input type="checkbox" id="service4" name="service_type[]" value="4"/><label for="service4">メンズエステ</label>
                            </div>
                        </div>

                        <!-- 店舗住所 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">店舗住所<span class="required">（必須）</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="s_address" name="s_address" class="form-control" required="" value="<?php echo e($shop->s_address); ?>" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 店舗電話番号 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">店舗電話番号<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <input type="number" id="s_tel" name="s_tel" class="form-control" required="" value="<?php echo e($shop->s_tel); ?>" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 店舗URL -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">店舗URL<span class="required">（必須）</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="s_url" name="s_url" class="form-control"  value="<?php echo e($shop->s_url); ?>" required="" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 決済後サンキューメール（確認メール）　-->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">決済後サンキューメール（確認メール）<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <input type="email" id="s_email" name="s_email" class="form-control" required="" value="<?php echo e($shop->s_email); ?>" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- グループ名 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">グループ名</label>
                            <div class="col-sm-2">
                                <input type="text" id="s_group_name" name="s_group_name" class="form-control" value="<?php echo e($shop->s_group_name); ?>"/>
                            </div>
                        </div>

                        <!-- 店舗責任者名 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">店舗責任者名</label>
                            <div class="col-sm-2">
                                <input type="text" id="s_manager_name" name="s_manager_name" class="form-control" value="<?php echo e($shop->s_manager_name); ?>" />
                            </div>
                        </div>

                        <!-- 店舗責任者電話番号 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">店舗責任者電話番号</label>
                            <div class="col-sm-2">
                                <input type="number" id="s_manager_tel" name="s_manager_tel" class="form-control" value="<?php echo e($shop->s_manager_tel); ?>" />
                            </div>
                        </div>

                        <!-- 店舗メールアドレス(担当者) -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">店舗メールアドレス(担当者)</label>
                            <div class="col-sm-2">
                                <input type="email" id="s_manager_email" name="s_manager_email" class="form-control" value="<?php echo e($shop->s_manager_email); ?>" />
                            </div>
                        </div>

                        <!-- 契約内容（手数料）-->
                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold">契約内容（手数料）</label>
                        </div>

                        <!-- 利用カードブランド -->
                        <div class="form-group">
                            <input type="hidden" id="card_types" value="<?php echo e(json_encode($shop->card_types)); ?>">

                            <label class="col-sm-4 control-label">利用カードブランド<span class="required">（必須）</span></label>
                            <div class="checkbox-custom checkbox-default col-sm-1 ml-md">
                                <input type="checkbox" id="card1" name="card_type[]" value="1"/><label for="card1">VISA</label>
                            </div>
                            <div class="checkbox-custom checkbox-default col-sm-1">
                                <input type="checkbox" id="card2" name="card_type[]" value="2" /><label for="card2">MASTER</label>
                            </div>
                            <div class="checkbox-custom checkbox-default col-sm-1">
                                <input type="checkbox" id="card3" name="card_type[]" value="3" /><label for="card3">JCB</label>
                            </div>
                            <div class="checkbox-custom checkbox-default col-sm-1">
                                <input type="checkbox" id="card4" name="card_type[]" value="4" /><label for="card4">AMEX</label>
                            </div>
                        </div>

                        <!-- 最低決済手数料 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">最低決済手数料 (<i class="fa fa-percent"></i>)<span class="required">（必須）</span></label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="number" id="s_visa_fee" step="0.01" name="s_visa_fee" min="0" max="100" value="<?php echo e($shop->s_visa_fee); ?>" class="form-control" placeholder="VISA" required="" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                                            <span class="input-group-addon">
                                                <span class="icon">VISA</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="number" id="s_master_fee" step="0.01" name="s_master_fee" min="0" max="100" value="<?php echo e($shop->s_master_fee); ?>" class="form-control" placeholder="MASTER" required="" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                                            <span class="input-group-addon">
                                                <span class="icon">MASTER</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-md">
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="number" id="s_jcb_fee" name="s_jcb_fee" step="0.01" min="0" max="100" value="<?php echo e($shop->s_jcb_fee); ?>"  class="form-control" placeholder="JCB" required="" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                                             <span class="input-group-addon">
                                                <span class="icon">JCB</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="number" id="s_amex_fee" name="s_amex_fee" step="0.01" min="0" max="100" value="<?php echo e($shop->s_amex_fee); ?>"  class="form-control" placeholder="AMEX" required="" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                                             <span class="input-group-addon">
                                                <span class="icon">AMEX</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- トランザクション認証料  -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">トランザクション認証料<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="number" id="s_transaction_fee" name="s_transaction_fee" class="form-control" value="<?php echo e($shop->s_transaction_fee); ?>" required="" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                                    <span class="input-group-addon">
                                        <span class="icon">円/1決済</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- 取消し手数料  -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">取消し手数料<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="number" id="s_cancel_fee" name="s_cancel_fee" class="form-control" value="<?php echo e($shop->s_cancel_fee); ?>" required="" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                                    <span class="input-group-addon">
                                        <span class="icon">円/件</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- チャージバック  -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">チャージバック<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="number" id="s_charge_fee" name="s_charge_fee" class="form-control" value="<?php echo e($shop->s_charge_fee); ?>" required="" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                                    <span class="input-group-addon">
                                        <span class="icon">円/件</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- 振込手数料  -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">振込手数料<span class="required">（必須）</span></label>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="number" id="s_enter_fee" name="s_enter_fee" class="form-control" value="<?php echo e($shop->s_enter_fee); ?>" required="" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                                    <span class="input-group-addon">
                                        <span class="icon">円/件</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- 契約内容（支払いサイクル）-->
                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold">契約内容（支払いサイクル）</label>
                        </div>

                        <!-- 支払いサイクル -->
                        <div class="form-group mb-none">
                            <label class="col-sm-4 control-label">支払いサイクル<span class="required">（必須）</span></label>
                            <div class="col-sm-1 mt-xs" style="width: 170px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="s_paycycle1" name="s_paycycle_id" value="1" <?php if($shop->s_paycycle_id == 1): ?> checked <?php endif; ?> <?php if(!$enable_edit_cycle): ?> disabled <?php endif; ?>>
                                    <label for="s_paycycle1" class="c-radio-title">&nbsp;&nbsp;月１支払い</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs" style="width: 170px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="s_paycycle2" name="s_paycycle_id" value="2" <?php if($shop->s_paycycle_id == 2): ?> checked <?php endif; ?> <?php if(!$enable_edit_cycle): ?> disabled <?php endif; ?>>
                                    <label for="s_paycycle2" class="c-radio-title">&nbsp;&nbsp;月２支払い</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs" style="width: 170px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="s_paycycle3" name="s_paycycle_id" value="3" <?php if($shop->s_paycycle_id == 3): ?> checked <?php endif; ?> <?php if(!$enable_edit_cycle): ?> disabled <?php endif; ?>>
                                    <label for="s_paycycle3" class="c-radio-title">&nbsp;&nbsp;週１支払い</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs" style="width: 170px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="s_paycycle4" name="s_paycycle_id" value="4" <?php if($shop->s_paycycle_id == 4): ?> checked <?php endif; ?> <?php if(!$enable_edit_cycle): ?> disabled <?php endif; ?>>
                                    <label for="s_paycycle4" class="c-radio-title">&nbsp;&nbsp;毎日支払い</label>
                                </div>
                            </div>
                        </div>

                        <!-- Help -->
                        <div class="form-group mb-none">
                            <div class="col-sm-4"></div>
                            <label class="col-sm-8 control-label mt-none" style="color:red; font-size: 14px; text-align:left !important;">※支払いサイクルの変更は１日のみ可能です</label>
                        </div>

                        <!-- 代理店 -->
                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold">代理店</label>
                        </div>

                        <!-- 代理店名 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">代理店名</label>
                            <div class="col-sm-2">
                                <input type="text" id="s_agency_name" name="s_agency_name" class="form-control" value="<?php echo e($shop->s_agency_name); ?>" oninvalid="this.setCustomValidity('入力してください')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>

                        <!-- 代理店手数料-->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">代理店手数料</label>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="number" id="s_agency_fee" step="0.01" min="0" max="100" name="s_agency_fee" class="form-control" value="<?php echo e($shop->s_agency_fee); ?>" />
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fa fa-percent"></i> </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- 後払い決済 -->
                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold">後払い決済</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">後払い決済<span class="required">（必須）</span></label>
                            <div class="col-sm-1 mt-xs" style="width: 140px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="atobarai1" name="atobarai" value="1" <?php if($shop->atobarai == 1): ?> checked <?php endif; ?>>
                                    <label for="atobarai1" class="c-radio-title">&nbsp;&nbsp;利用可能</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs" style="width: 140px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="atobarai2" name="atobarai" value="0" <?php if($shop->atobarai == 0): ?> checked <?php endif; ?>>
                                    <label for="atobarai2" class="c-radio-title">&nbsp;&nbsp;利用不可</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs" style="width: 140px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="atobarai3" name="atobarai" value="2" <?php if($shop->atobarai == 2): ?> checked <?php endif; ?>>
                                    <label for="atobarai3" class="c-radio-title">&nbsp;&nbsp;一時停止</label>
                                </div>
                            </div>
                        </div>

                        <!-- 利用MID -->
                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold">利用MID</label>
                        </div>

                        <!-- 利用MID -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">利用MID</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="mid" id="mid">
                                    <?php $__currentLoopData = $arr_mids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($mid->id); ?>" <?php if($shop->mid == $mid->id): ?> selected <?php endif; ?>><?php echo e($mid->id); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <!-- 契約状況 -->
                        <div class="form-group">
                            <label class="col-sm-12 control-label-bold">契約状況</label>
                        </div>

                        <!--  審査中/契約中/解約/休止 -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">契約状況<span class="required">（必須）</span></label>
                            <div class="col-sm-1 mt-xs" style="width: 140px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="s_status1" name="s_status" value="審査中" <?php if($shop->s_status == '審査中'): ?> checked <?php endif; ?>>
                                    <label for="s_status1" class="c-radio-title">&nbsp;&nbsp;審査中</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs" style="width: 140px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="s_status2" name="s_status" value="契約中" <?php if($shop->s_status == '契約中'): ?> checked <?php endif; ?>>
                                    <label for="s_status2" class="c-radio-title">&nbsp;&nbsp;契約中</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs" style="width: 140px;">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="s_status3" name="s_status" value="解約" <?php if($shop->s_status == '解約'): ?> checked <?php endif; ?>>
                                    <label for="s_status3" class="c-radio-title">&nbsp;&nbsp;解約</label>
                                </div>
                            </div>
                            <div class="col-sm-1 mt-xs">
                                <div class="radio-custom radio-success">
                                    <input type="radio" id="s_status4" name="s_status" value="休止" <?php if($shop->s_status == '休止'): ?> checked <?php endif; ?>>
                                    <label for="s_status4" class="c-radio-title">&nbsp;&nbsp;休止</label>
                                </div>
                            </div>
                        </div>

                        <!-- memo -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">メモ</label>
                            <div class="col-sm-4">
                                <textarea id="s_memo" class="form-control" name="s_memo" rows="5"><?php echo e($shop->s_memo); ?></textarea>
                            </div>
                        </div>

                    </div>

                    <footer class="panel-footer">
                        <button class="btn btn-warning pull-right" style="width:200px;;">店舗情報を変更する</button>
                        <a class="btn btn-default" onclick="window.history.back()" style="width:120px;">戻る</a>
                    </footer>

                </form>
            </section>

        </div>

    </section>

    <?php $__env->stopSection(); ?>

<!-- Custom CSS -->
<?php $__env->startSection('page_css'); ?>
    <?php $__env->stopSection(); ?>

<!-- Custom JS -->
<?php $__env->startSection('page_js_vendor'); ?>

    <script src="<?php echo e(asset('public/admin/vendor/jquery-ui/jquery-ui.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/vendor/bootstrap-confirmation/bootstrap-confirmation.js')); ?>"></script>
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
            window.location.href = '<?php echo e(url('admin/user/')); ?>';
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>