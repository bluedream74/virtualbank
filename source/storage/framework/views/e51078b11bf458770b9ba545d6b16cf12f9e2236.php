<?php $__env->startSection('title', '決済検索 | Virtual Bank'); ?>

<?php ($list = $datas['list']); ?>

<?php ($start_date = $datas['start_date']); ?>
<?php ($end_date = $datas['end_date']); ?>
<?php ($transaction_id = $datas['transaction_id']); ?>
<?php ($t_id = $datas['t_id']); ?>

<?php ($merchant_id = $datas['merchant_id']); ?>
<?php ($shop_id = $datas['shop_id']); ?>
<?php ($status = $datas['status']); ?>
<?php ($agency_name = $datas['agency_name']); ?>

<?php ($card_number = $datas['card_number']); ?>
<?php ($card_holder = $datas['card_holder']); ?>
<?php ($tel = $datas['tel']); ?>

<?php ($visa = json_decode($datas['visa'])); ?>
<?php ($master = json_decode($datas['master'])); ?>
<?php ($jcb = json_decode($datas['jcb'])); ?>)
<?php ($amex = json_decode($datas['amex'])); ?>

<?php ($merchants = json_decode($datas['merchants'])); ?>
<?php ($shops = json_decode($datas['shops'])); ?>
<?php ($paycycles = json_decode($datas['paycycles'])); ?>
<?php ($pagelen = json_decode($datas['pagelen'])); ?>

<?php $__env->startSection('content'); ?>

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h2><i class="fa fa-search"></i>&nbsp;&nbsp;決済検索</h2>
                    <a class="btn btn-danger pull-right text-right mr-xlg" style="margin-top: 7px;" onclick="downloadCSV();">CSVダウンロード</a>
                </div>
            </div>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">

                <div class="row pl-md">
                    <label class="col-sm-6" style="font-weight: bold; color: #000000; font-size: 18px;">検索条件</label>
                </div>

                <!-- filter -->
                <div class="filter mb-xlg" style="padding: 15px; border: 1px solid #444;">

                    <form class="form-horizontal" action="<?php echo e(url('admin/transaction/search/')); ?>" enctype="multipart/form-data" method="post" id="searchForm">

                        <input type="hidden" value="<?php echo e(json_encode($merchants)); ?>" id="merchants" />
                        <input type="hidden" value="<?php echo e(json_encode($shops)); ?>" id="shops" />
                        <input type="hidden" value="<?php echo e(json_encode($list)); ?>" id="list" />
                        <input type="hidden" value="<?php echo e(json_encode($paycycles)); ?>" id="paycycles" />

                        <div class="row">

                            <div class="col-sm-2" style="width: 100px;">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="mt-xs">決済期間</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input id="start_date" name="start_date" type="date" class="form-control" value="<?php echo e($start_date); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2" style="width: 100px;">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <label>～</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input id="end_date" name="end_date" type="date" class="form-control" value="<?php echo e($end_date); ?>" />
                                    </div>
                                </div>
                            </div>

                            <label class="col-sm-1 control-label" style="width: 150px;">トランザクションID</label>
                            <div class="col-sm-2">
                                <input id="transaction_id" name="transaction_id" class="form-control" value="<?php echo e($transaction_id); ?>" />
                            </div>

                            <label class="col-sm-1 control-label" style="width: 70px;">ID</label>
                            <div class="col-sm-2">
                                <input id="t_id" name="t_id" type="text" class="form-control" value="<?php echo e($t_id); ?>" />
                            </div>

                        </div>

                        <div class="row mt-sm">
                            <div class="col-sm-2" style="width: 100px;">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="mt-xs">加盟店ID</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input id="merchant_id" name="merchant_id" type="text" class="form-control" value="<?php echo e($merchant_id); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2" style="width: 100px;">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <label class="mt-xs">店舗ID</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input id="shop_id" name="shop_id" type="text" class="form-control" value="<?php echo e($shop_id); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2" style="width: 150px;">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <label class="mt-xs">処理</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <select id="status" name="status"  class="form-control">
                                            <option value=""></option>
                                            <option value="成功" <?php if($status=='成功'): ?>selected <?php endif; ?>>成功</option>
                                            <option value="失敗" <?php if($status=='失敗'): ?>selected <?php endif; ?>>失敗</option>
                                            <option value="未決済" <?php if($status=='未決済'): ?>selected <?php endif; ?>>未決済</option>
                                            <option value="返金申請" <?php if($status=='返金申請'): ?>selected <?php endif; ?>>返金申請</option>
                                            <option value="返金完了" <?php if($status=='返金完了'): ?>selected <?php endif; ?>>返金完了</option>
                                            <option value="返金失敗" <?php if($status=='返金失敗'): ?>selected <?php endif; ?>>返金失敗</option>
                                            <option value="CB調整中" <?php if($status=='CB調整中'): ?>selected <?php endif; ?>>CB調整中</option>
                                            <option value="CB確定" <?php if($status=='CB確定'): ?>selected <?php endif; ?>>CB確定</option>
                                            <option value="テスト" <?php if($status=='テスト'): ?>selected <?php endif; ?>>テスト</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2" style="width: 70px;">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <label class="mt-xs">代理店</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input id="agency_name" name="agency_name" type="text" class="form-control" value="<?php echo e($agency_name); ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-sm">

                            <div class="col-sm-2" style="width: 100px;">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <label class="mt-xs">カード番号</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input id="card_number" name="card_number" type="number" class="form-control" value="<?php echo e($card_number); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2" style="width: 100px;">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <label class="mt-xs">カード名義</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input id="card_holder" name="card_holder" type="text" class="form-control" value="<?php echo e($card_holder); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2" style="width: 150px;">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <label class="mt-xs">電話番号</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input id="tel" name="tel" type="number" class="form-control" value="<?php echo e($tel); ?>" />
                                    </div>
                                </div>
                            </div>

                            <input id="pagelen" name="pagelen" type="hidden" class="form-control" value="<?php echo e($pagelen); ?>" />
                        </div>

                        <div class="row mt-sm">
                            <div class="col-sm-3 col-sm-offset-9 text-center">
                                <a class="btn btn-success" onclick="searchResult()" style="width: 100px;">検索</a>
                                <a class="btn btn-white ml-xs" style="width: 100px; border: 1px solid #ccc; color: #000000" onclick="reset()" >リセット</a>
                            </div>
                        </div>

                    </form>

                </div>
                
                <!-- 集計機能 -->
                <div id="report" class="mb-lg">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="text-center">
                            <tr>
                                <th></th>
                                <th class="text-center">決済件数</th>
                                <th class="text-center green">決済</th>
                                <th class="text-center">成功件数</th>
                                <th class="text-center green">成功</th>
                                <th class="text-center">失敗件数</th>
                                <th class="text-center green">失敗</th>
                                <th class="text-center">返金件数</th>
                                <th class="text-center green">返金</th>
                                <th class="text-center">CB件数</th>
                                <th class="text-center green">CB</th>
                                <th class="text-center">SMS送信件数</th>
                                <th class="text-center green">SMS送信</th>
                                <th class="text-center">SMS決済</th>
                                <th class="text-center">バナー決済</th>
                                <th class="text-center">QR決済</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>VISA</strong></td>
                                <td><?php echo e(number_format($visa->t_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($visa->t_amount))); ?></td>
                                <td><?php echo e(number_format($visa->ss_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($visa->ss_amount))); ?></td>
                                <td><?php echo e(number_format($visa->ff_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($visa->ff_amount))); ?></td>
                                <td><?php echo e(number_format($visa->cc_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($visa->cc_amount))); ?></td>
                                <td><?php echo e(number_format($visa->cb_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($visa->cb_amount))); ?></td>
                                <td><?php echo e(number_format($visa->sms_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($visa->sms_amount))); ?></td>
                                <td><?php echo e(number_format($visa->sms_ss_count)); ?></td>
                                <td><?php echo e(number_format($visa->banner_count)); ?></td>
                                <td><?php echo e(number_format($visa->qr_count)); ?></td>
                            </tr>
                            <tr>
                                <td><strong>MASTER</strong></td>
                                <td><?php echo e(number_format($master->t_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($master->t_amount))); ?></td>
                                <td><?php echo e(number_format($master->ss_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($master->ss_amount))); ?></td>
                                <td><?php echo e(number_format($master->ff_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($master->ff_amount))); ?></td>
                                <td><?php echo e(number_format($master->cc_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($master->cc_amount))); ?></td>
                                <td><?php echo e(number_format($master->cb_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($master->cb_amount))); ?></td>
                                <td><?php echo e(number_format($master->sms_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($master->sms_amount))); ?></td>
                                <td><?php echo e(number_format($master->sms_ss_count)); ?></td>
                                <td><?php echo e(number_format($master->banner_count)); ?></td>
                                <td><?php echo e(number_format($master->qr_count)); ?></td>
                            </tr>
                            <tr>
                                <td><strong>JCB</strong></td>
                                <td><?php echo e(number_format($jcb->t_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($jcb->t_amount))); ?></td>
                                <td><?php echo e(number_format($jcb->ss_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($jcb->ss_amount))); ?></td>
                                <td><?php echo e(number_format($jcb->ff_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($jcb->ff_amount))); ?></td>
                                <td><?php echo e(number_format($jcb->cc_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($jcb->cc_amount))); ?></td>
                                <td><?php echo e(number_format($jcb->cb_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($jcb->cb_amount))); ?></td>
                                <td><?php echo e(number_format($jcb->sms_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($jcb->sms_amount))); ?></td>
                                <td><?php echo e(number_format($jcb->sms_ss_count)); ?></td>
                                <td><?php echo e(number_format($jcb->banner_count)); ?></td>
                                <td><?php echo e(number_format($jcb->qr_count)); ?></td>
                            </tr>
                            <tr>
                                <td><strong>AMEX</strong></td>
                                <td><?php echo e(number_format($amex->t_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($amex->t_amount))); ?></td>
                                <td><?php echo e(number_format($amex->ss_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($amex->ss_amount))); ?></td>
                                <td><?php echo e(number_format($amex->ff_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($amex->ff_amount))); ?></td>
                                <td><?php echo e(number_format($amex->cc_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($amex->cc_amount))); ?></td>
                                <td><?php echo e(number_format($amex->cb_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($amex->cb_amount))); ?></td>
                                <td><?php echo e(number_format($amex->sms_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($amex->sms_amount))); ?></td>
                                <td><?php echo e(number_format($amex->sms_ss_count)); ?></td>
                                <td><?php echo e(number_format($amex->banner_count)); ?></td>
                                <td><?php echo e(number_format($amex->qr_count)); ?></td>
                            </tr>
                            <tr>
                                <td><strong>合計</strong></td>
                                <td><?php echo e(number_format($visa->t_count+$master->t_count+$jcb->t_count+$amex->t_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($visa->t_amount+$master->t_amount+$jcb->t_amount+$amex->t_amount))); ?></td>
                                <td><?php echo e(number_format($visa->ss_count+$master->ss_count+$jcb->ss_count+$amex->ss_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($visa->ss_amount+$master->ss_amount+$jcb->ss_amount+$amex->ss_amount))); ?></td>
                                <td><?php echo e(number_format($visa->ff_count+$master->ff_count+$jcb->ff_count+$amex->ff_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($visa->ff_amount+$master->ff_amount+$jcb->ff_amount+$amex->ff_amount))); ?></td>
                                <td><?php echo e(number_format($visa->cc_count+$master->cc_count+$jcb->cc_count+$amex->cc_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($visa->cc_amount+$master->cc_amount+$jcb->cc_amount+$amex->cc_amount))); ?></td>
                                <td><?php echo e(number_format($visa->cb_count+$master->cb_count+$jcb->cb_count+$amex->cb_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($visa->cb_amount+$master->cb_amount+$jcb->cb_amount+$amex->cb_amount))); ?></td>
                                <td><?php echo e(number_format($visa->sms_count+$jcb->sms_count+$master->sms_count+$amex->sms_count)); ?></td>
                                <td class="green">¥<?php echo e(number_format(ceil($visa->sms_amount+$master->sms_amount+$jcb->sms_amount+$amex->sms_amount))); ?></td>
                                <td><?php echo e(number_format($visa->sms_ss_count+$master->sms_ss_count+$jcb->sms_ss_count+$amex->sms_ss_count)); ?></td>
                                <td><?php echo e(number_format($visa->banner_count+$master->banner_count+$jcb->banner_count+$amex->banner_count)); ?></td>
                                <td><?php echo e(number_format($visa->qr_count+$master->qr_count+$jcb->qr_count+$amex->qr_count)); ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <!-- table -->
                <table class="table table-bordered table-striped text-center" id="transaction_datatable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center successed" width="5%">ID</th>
                            <th class="text-center successed" width="8%">決済日時</th>
                            <th class="text-center option hidden" width="7%">処理</th>
                            <th class="text-center successed status" width="7%">処理</th>
                            <th class="text-center successed" width="7%">サービス料</th>
                            <th class="text-center successed" width="7%">最低決済手数料</th>
                            <th class="text-center successed" width="7%">加算決済手数料</th>
                            <th class="text-center successed" width="10%">決済金額</th>
                            <th class="text-center successed" width="10%">SMS送信</th>
                            <th class="text-center fail" width="7%">カード名義</th>

                            <th class="text-center option hidden" width="7%">ブランド</th>

                            <th class="text-center fail status" width="7%">ブランド</th>
                            <th class="text-center fail" width="7%">カード番号</th>
                            <th class="text-center fail" width="8%">有効期限</th>
                            <th class="text-center fail" width="9%">電話番号</th>
                            <th class="text-center fail" width="8%">決済種別</th>
                            <th class="text-center" width="8%" style="background-color: #ffffe1">加盟店ID</th>

                            <th class="text-center option hidden" width="8%" style="background-color: #ffffe1">加盟店名</th>
                            <th class="text-center option hidden" width="8%" style="background-color: #ffffe1">加盟店メールアドレス</th>

                            <th class="text-center" width="9%" style="background-color: #ffffe1">店舗ID</th>
                            <th class="text-center" width="8%" style="background-color: #ffffe1">店舗名</th>
                            <th class="text-center" width="10%" style="background-color: #ffffe1">支払いサイクル</th>

                            <th class="text-center option hidden" width="10%" style="background-color: #ffffe1">(店舗)契約状況</th>
                            <th class="text-center option hidden" width="10%" style="background-color: #5898ff">金融機関コード</th>
                            <th class="text-center option hidden" width="10%" style="background-color: #5898ff">支店コード</th>
                            <th class="text-center option hidden" width="10%" style="background-color: #5898ff">口座種別</th>
                            <th class="text-center option hidden" width="10%" style="background-color: #5898ff">口座番号（7桁）</th>
                            <th class="text-center option hidden" width="10%" style="background-color: #5898ff">口座名義（カタカナ）</th>
                            <th class="text-center option hidden" width="10%" style="background-color: #ccffcc">代理店名</th>
                            <th class="text-center option hidden" width="10%" style="background-color: #ccffcc">代理店手数料</th>

                            <th class="text-center" width="8%" style="background-color: #ccffcc">利用MID</th>
                            <th class="text-center" width="8%" style="background-color: #ccffcc">トランザクションID</th>
                            <th class="text-center option hidden" width="10%" style="background-color: #feff47">メモ帳</th>

                        </tr>
                    </thead>

                    <tbody>

                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php if($transaction->parent == 0): ?>
                            <tr>
                        <?php else: ?>
                            <?php if(($transaction->status == '返金完了') || ($transaction->status == 'CB確定')): ?>
                                <tr style="background-color: #ffc000">
                            <?php else: ?>
                                <tr style="background-color: #fff2cc">
                            <?php endif; ?>
                        <?php endif; ?>

                            <td>t_<?php echo e($transaction->t_id); ?></td>
                            <td><?php echo e($transaction->created_at); ?></td>
                            <td class="option hidden">
                                <?php if($transaction->status == '成功'): ?>
                                    <?php if(($transaction->child != 0) && ($transaction->parent == 0)): ?>
                                        <?php echo e($transaction->status); ?>(修正)
                                    <?php else: ?>
                                        <?php echo e($transaction->status); ?>

                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php echo e($transaction->status); ?>

                                <?php endif; ?>
                            </td>

                            <?php if($transaction->status == '成功'): ?>
                                <td class="status successed">
                            <?php elseif($transaction->status == '失敗'): ?>
                                <td class="status fail">
                            <?php elseif(($transaction->status == '返金完了') || ($transaction->status == 'CB確定')): ?>
                                <td class="status" style="background-color: #ffc000">
                            <?php else: ?>
                                <td class="status" style="background-color: #fff2cc">
                            <?php endif; ?>

                                <?php if($transaction_id != ''): ?>
                                    <?php if((($transaction->child == 0) && ($transaction->parent != 0)) || (($transaction->child == 0) && ($transaction->parent == 0))): ?>
                                        <select style="background-color: transparent; border: none; text-align-last: center;" onchange="changeTransaction(this, '<?php echo e($transaction->id); ?>', '<?php echo e($transaction->memo); ?>', '<?php echo e($transaction->status); ?>')">
                                            <option value="成功" style="background-color: #00b0f0; color: white" <?php if($transaction->status == '成功'): ?> selected <?php endif; ?>>成功</option>
                                            <option value="失敗" style="background-color: #fff2cc" <?php if($transaction->status == '失敗'): ?> selected <?php endif; ?>>失敗</option>
                                            <option value="未決済" style="background-color: #fff2cc" <?php if($transaction->status == '未決済'): ?> selected <?php endif; ?>>未決済</option>
                                            <option value="返金申請" style="background-color: #fff2cc" <?php if($transaction->status == '返金申請'): ?> selected <?php endif; ?>>返金申請</option>
                                            <option value="返金完了" style="background-color: #ffc000" <?php if($transaction->status == '返金完了'): ?> selected <?php endif; ?>>返金完了</option>
                                            <option value="返金失敗" style="background-color: #fff2cc" <?php if($transaction->status == '返金失敗'): ?> selected <?php endif; ?>>返金失敗</option>
                                            <option value="CB調整中" style="background-color: #fff2cc" <?php if($transaction->status == 'CB調整中'): ?> selected <?php endif; ?>>CB調整中</option>
                                            <option value="CB確定" style="background-color: #ffc000" <?php if($transaction->status == 'CB確定'): ?> selected <?php endif; ?>>CB確定</option>
                                            <?php if(($transaction->child == 0) && ($transaction->parent != 0)): ?>
                                                <option value="削除" style="background-color: red; color: white;" <?php if($transaction->status == '削除'): ?> selected <?php endif; ?>>削除</option>
                                            <?php endif; ?>
                                        </select>
                                    <?php else: ?>
                                        <?php if(($transaction->child != 0) && ($transaction->parent == 0)): ?>
                                            <?php echo e($transaction->status); ?>(修正)
                                        <?php else: ?>
                                            <?php echo e($transaction->status); ?>

                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                        <?php if(($transaction->child != 0) && ($transaction->parent == 0)): ?>
                                            <?php echo e($transaction->status); ?>(修正)
                                        <?php else: ?>
                                            <?php echo e($transaction->status); ?>

                                        <?php endif; ?>
                                <?php endif; ?>

                            </td>

                            <td>¥<?php echo e(ceil($transaction->service_fee)); ?></td>
                            <td><?php echo e($transaction->low_fee); ?>%</td>
                            <td><?php echo e($transaction->card_fee); ?>%</td>
                            <td>¥<?php echo e(ceil($transaction->amount)); ?></td>
                            <td>¥<?php echo e($transaction->sms_amount); ?></td>
                            <td><?php echo e($transaction->card_holdername); ?></td>
                            <td class="option hidden"><?php echo e($transaction->cardtype); ?></td>
                            <td class="status"><?php echo e($transaction->cardtype); ?></td>
                            <td> &zwnj;<?php echo e($transaction->card_number); ?></td>
                            <td>&zwnj;<?php echo e($transaction->expiry_date); ?></td>
                            <td>&zwnj;<?php echo e($transaction->phone); ?></td>
                            <td><?php echo e($transaction->payment_method); ?></td>
                            <td id="merchant_name<?php echo e($transaction->id); ?>">
                                <?php if($transaction->merchant): ?>
                                    <?php echo e($transaction->merchant->name); ?>

                                <?php endif; ?>
                            </td>
                            <td class="option hidden" id="merchant_u_name<?php echo e($transaction->id); ?>">
                                <?php if($transaction->merchant): ?>
                                    <?php echo e($transaction->merchant->u_name); ?>

                                <?php endif; ?>
                            </td>
                            <td class="option hidden" id="merchant_u_email<?php echo e($transaction->id); ?>">
                                <?php if($transaction->merchant): ?>
                                    <?php echo e($transaction->merchant->u_email); ?>

                                <?php endif; ?>
                            </td>
                            <td id="shop_name<?php echo e($transaction->id); ?>">
                                <?php if($transaction->shop && $transaction->userType == '2'): ?>
                                    <?php echo e($transaction->shop->name); ?>

                                <?php endif; ?>
                            </td>
                            <td id="shop_s_name<?php echo e($transaction->id); ?>">
                                <?php if($transaction->shop && $transaction->userType == '2'): ?>
                                    <?php echo e($transaction->shop->s_name); ?>

                                <?php endif; ?>
                            </td>
                            <td id="pay_cycle<?php echo e($transaction->id); ?>">
                                <?php echo e($transaction->pay_cycle); ?>

                            </td>

                            <td class="option hidden" id="merchant_u_status<?php echo e($transaction->id); ?>">
                                <?php if($transaction->userType == '1'): ?>
                                    <?php if($transaction->merchant): ?>
                                        <?php echo e($transaction->merchant->u_status); ?>

                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if($transaction->shop): ?>
                                        <?php echo e($transaction->shop->s_status); ?>

                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td class="option hidden" id="merchant_u_bankcode<?php echo e($transaction->id); ?>">
                                <?php if($transaction->merchant): ?>
                                    &zwnj;<?php echo e($transaction->merchant->u_bankcode); ?>

                                <?php endif; ?>
                            </td>
                            <td class="option hidden" id="merchant_u_branchcode<?php echo e($transaction->id); ?>">
                                <?php if($transaction->merchant): ?>    
                                    <?php echo e($transaction->merchant->u_branchcode); ?>

                                <?php endif; ?>
                            </td>
                            <td class="option hidden" id="merchant_u_holdertype<?php echo e($transaction->id); ?>">
                                <?php if($transaction->merchant): ?>
                                    <?php echo e($transaction->merchant->u_holdertype); ?>

                                <?php endif; ?>
                            </td>
                            <td class="option hidden" id="merchant_u_holdernumber<?php echo e($transaction->id); ?>">
                                <?php if($transaction->merchant): ?>
                                    <?php echo e(substr($transaction->merchant->u_holdernumber,0,7)); ?>

                                <?php endif; ?>
                            </td>
                            <td class="option hidden" id="merchant_u_holdername<?php echo e($transaction->id); ?>">
                                <?php if($transaction->merchant): ?>
                                    <?php echo e($transaction->merchant->u_holdername_sei . ' ' . $transaction->merchant->u_holdername_mei); ?>

                                <?php endif; ?>
                            </td>
                            <td class="option hidden" id="shop_s_agency_name<?php echo e($transaction->id); ?>">
                                <?php if(($transaction->userType == '2') && ($transaction->shop)): ?>
                                    <?php echo e($transaction->shop->s_agency_name); ?>

                                <?php endif; ?>
                            </td>
                            <td class="option hidden" id="shop_s_agency_fee<?php echo e($transaction->id); ?>">
                                <?php if(($transaction->userType == '2') && $transaction->shop): ?>
                                    <?php echo e($transaction->shop->s_agency_fee); ?>%
                                <?php endif; ?>
                            </td>

                            <td><?php echo e($transaction->mid); ?></td>
                            <td><?php echo e($transaction->transaction_no); ?></td>
                            <td class="option hidden"><?php echo e($transaction->memo); ?></td>
                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>

                </table>

                <!-- links -->
                <div class="d-flex justify-content-center" style="float: right">
                    <?php echo e($list->links()); ?>

                </div>
            </div>

        </section>
        <!-- end page -->

        <!-- Modal dialog -->
        <div class="modal fade" id="changeDialog" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="<?php echo e(url('/admin/transaction/create')); ?>" method="post" >
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h5 class="modal-title" id="modal-title" style="font-size: 24px;">トランザクション更新</h5>
                        </div>
                        <div class="modal-body p-md">
                            <div class="form-group">
                                <label for="content" class="col-form-label">メモ帳</label>
                                <textarea class="form-control" id="memo" name="memo" maxlength="500" rows="5"></textarea>
                                <input type="hidden" name="trans_id" id="trans_id" />
                                <input type="hidden" name="status_new" id="status_new" />
                                <input type="hidden" name="s_start_date" id="s_start_date" />
                                <input type="hidden" name="s_end_date" id="s_end_date" />
                                <input type="hidden" name="s_transaction_id" id="s_transaction_id" />
                                <input type="hidden" name="pagelen" id="pagelen" value="<?php echo e($pagelen); ?>" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" onclick="cancelStatus()" style="width: 110px; background-color: #ffffff;border: 1px solid #555; color: #000000">キャンセル</button>
                            <button type="submit" class="btn btn-success" style="width: 110px;">更新</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end Modai -->

    </section>

<?php $__env->stopSection(); ?>

<!-- Custom CSS -->
<?php $__env->startSection('page_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendor/jquery-ui/jquery-ui.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendor/jquery-ui/jquery-ui.theme.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendor/select2/css/select2.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendor/select2-bootstrap-theme/select2-bootstrap.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendor/jquery-datatables-bs3/assets/css/datatables.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/css/common.css')); ?>" />
<?php $__env->stopSection(); ?>

<!-- Custom JS -->
<?php $__env->startSection('page_js_vendor'); ?>
    <script src="<?php echo e(asset('public/admin/vendor/jquery-ui/jquery-ui.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/vendor/jquery-datatables/media/js/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/vendor/jquery-datatables-bs3/assets/js/datatables.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/views/transaction.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/table2CSV.js')); ?> "></script>
    <script>

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $( document ).ready(function() {
            var s_width = $( window ).width() - 320;
            $('.panel-body').width(s_width);
            $('.datatables-footer').addClass('hidden');

            // search page links
            $('.pagination li').each(function(index, link) {
                var link_href = $(link).find('a').attr('href');
                if(link_href) {
                    link_href += '&' + $('#searchForm').serialize();
                    $(link).find('a').attr('href', link_href);
                }
            });

            // init merchant, shop list
            initTransaction();

            // select page length
            var pagelen = '<?php echo e($pagelen); ?>';
            var sel_pagelen = $('select[name="transaction_datatable_length"]');
            $(sel_pagelen).val(pagelen);

            $('select[name="transaction_datatable_length"] option[value="-1"]').remove();
            $('select[name="transaction_datatable_length"]').on('change', function() {
                $('#pagelen').val($(this).val());
                window.location.href = '<?php echo e(url('/admin/transaction/')); ?>' + '?' + $('#searchForm').serialize();
            });
        });

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        function initTransaction()
        {
            var transactionObj = JSON.parse($('#list').val());
            var list = Object.values(transactionObj.data);
            list.forEach((transaction) => {

                var pay_cycle_id = 1;
                var merchant = null;
                var shop = null;

                if(transaction['userType'] == '1') {
                    merchant = getMerchantByName(transaction['username']);
                }
                else {
                    shop = getShopByName(transaction['username']);
                    if(shop) {
                        pay_cycle_id = shop['s_paycycle_id'];
                        merchant = getMerchantByName(shop['member_id']);
                    }
                }

                // display merchant
                if(merchant) {
                    $('#merchant_name' + transaction['id']).html(merchant['name']);
                    $('#merchant_u_name' + transaction['id']).html(merchant['u_name']);
                    $('#merchant_u_email' + transaction['id']).html(merchant['u_email']);

                    if(transaction['userType'] == '1') 
                        $('#merchant_u_status' + transaction['id']).html(merchant['u_status']);
                    else
                        $('#merchant_u_status' + transaction['id']).html(shop['s_status']);

                    $('#merchant_u_bankcode' + transaction['id']).html('&zwnj;' + merchant['u_bankcode']);
                    $('#merchant_u_branchcode' + transaction['id']).html(merchant['u_branchcode']);
                    $('#merchant_u_holdertype' + transaction['id']).html(merchant['u_holdertype']);
                    $('#merchant_u_holdernumber' + transaction['id']).html(merchant['u_holdernumber'].substring(0,7));
                    $('#merchant_u_holdername' + transaction['id']).html(merchant['u_holdername_sei'] + ' ' + merchant['u_holdername_mei']);
                }

                // display merchant
                if(shop) {
                    $('#shop_name' + transaction['id']).html(shop['name']);
                    $('#shop_s_name' + transaction['id']).html(shop['s_name']);
                    $('#shop_s_agency_name' + transaction['id']).html(shop['s_agency_name']);
                    $('#shop_s_agency_fee' + transaction['id']).html(shop['s_agency_fee'] + '%');
                }

                var pay_cycle = getPaycycles(pay_cycle_id);
                $('#pay_cycle' + transaction['id']).html(pay_cycle['name']);

            });
        }

        function getMerchantByName(username)
        {
            var s_merchant = null;
            var arr_merchant = JSON.parse($('#merchants').val());
            arr_merchant.forEach((merchant) => {
                if(merchant['name'] == username)
                    s_merchant = merchant;
                    return;
            });

            return s_merchant;
        }

        function getShopByName(username)
        {
            var s_shop = null;
            var arr_shop = JSON.parse($('#shops').val());
            arr_shop.forEach((shop) => {
                if(shop['name'] == username)
                    s_shop = shop;
                    return;
            });

            return s_shop;
        }

        function getPaycycles(paycycle_id)
        {
            var s_pay_cycle = null;
            var arr_paycycles = JSON.parse($('#paycycles').val());
            arr_paycycles.forEach((paycycle) => {
                if(paycycle['id'] == paycycle_id)
                    s_pay_cycle = paycycle;
                    return;
            });

            return s_pay_cycle;
            
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $(window).resize(function() {
            var s_width = $( window ).width() - 320;
            $('.panel-body').width(s_width);
        });

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        function searchResult()
        {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var transaction_id = $('#transaction_id').val();
            var t_id = $('#t_id').val();
            var merchant_id = $('#merchant_id').val();
            var shop_id = $('#shop_id').val();
            var status = $('#status').val();
            var agency_name = $('#agency_name').val();
            var card_number = $('#card_number').val();
            var card_holder = $('#card_holder').val();
            var tel = $('#tel').val();

            // compare date
            if((start_date != '') && (end_date != '')){
                var start= new Date(start_date);
                var end= new Date(end_date);
                if (start > end){
                    alert('決済期間を正しく指定してください');
                    return;
                }
            }

            //if((start_date != '') || (end_date != '') || (transaction_id != '') || (t_id != '') || (merchant_id != '') || (shop_id != '') || (status != '') || (agency_name != '') || (card_number != '') || (card_holder != '') || (tel != ''))
            $('#searchForm').submit();
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        function downloadCSV()
        {
            var strYear =  ((new Date()).getYear() - 100) + 2000;
            var strMonth =  (new Date()).getMonth() + 1;
            var strDate =  (new Date()).getDate();
            $('#transaction_datatable').find("td.option").removeClass('hidden');
            $('#transaction_datatable').find("th.option").removeClass('hidden');
            $('#transaction_datatable').find("th.status").addClass('hidden');
            $('#transaction_datatable').find("td.status").addClass('hidden');

            var csv = $('#transaction_datatable').table2CSV({
                delivery: 'value'
            });

            var encodedUri = 'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURIComponent(csv);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "transaction_" + strYear + '_' + strMonth + '_' + strDate + ".csv");
            link.click();

            $('#transaction_datatable').find("td.option").addClass('hidden');
            $('#transaction_datatable').find("th.option").addClass('hidden');
            $('#transaction_datatable').find("td.status").removeClass('hidden');
            $('#transaction_datatable').find("th.status").removeClass('hidden');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        var old_select = null;
        var old_status = '';
        function changeTransaction(obj, transaction_id, memo, old)
        {
            var status = $(obj).val();
            if(status == '削除') {
                deleteTransaction(transaction_id);
                return;
            }

            old_select = obj;
            old_status = old;
            $('#memo').html(memo);
            $('#status_new').val(status);
            $('#trans_id').val(transaction_id);
            $('#s_start_date').val($('#start_date').val());
            $('#s_end_date').val($('#end_date').val());
            $('#s_transaction_id').val($('#transaction_id').val());

            $('#changeDialog').modal('show');
        }

        function deleteTransaction(transaction_id)
        {
            var url = "<?php echo e(url('/admin/transaction/delete')); ?>";
            $.ajax({
                type: 'POST',
                url: url,
                data: { transaction_id : transaction_id},
                dataType: 'json',
                success: function( res ) {
                    $('#searchForm').submit();
                },
                error : function(res){}
            });
        }

        function cancelStatus()
        {
            $(old_select).val(old_status);
            $('#changeDialog').modal('hide');
        }

        function reset()
        {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var transaction_id = $('#transaction_id').val();
            var t_id = $('#t_id').val();
            var merchant_id = $('#merchant_id').val();
            var shop_id = $('#shop_id').val();
            var status = $('#status').val();
            var agency_name = $('#agency_name').val();
            var card_number = $('#card_number').val();
            var card_holder = $('#card_holder').val();
            var tel = $('#tel').val();

            if((start_date != '') || (end_date != '') || (transaction_id != '') || (t_id != '') || (merchant_id != '') || (shop_id != '') || (status != '') || (agency_name != '') || (card_number != '') || (card_holder != '') || (tel != '')) {

                $('input').val('');
                $('select#status').val('');
                $('#pagelen').val('<?php echo e($pagelen); ?>');
                $('#searchForm').submit();
            }
        }

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>