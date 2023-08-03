
<?php $__env->startSection('title', '店舗管理 | Virtual Bank'); ?>

<?php $__env->startSection('content'); ?>

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <h2><i class="fa fa-user"></i>&nbsp;&nbsp;店舗管理</h2>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">
                <h2 class="control-label-bold text-center" style="color: orangered;"><?php echo e(session('title')); ?></h2>

                <?php ($shop = session('shop')); ?>
                <?php if($shop != null): ?>
                    <div class="row mt-xlg mb-xlg">
                        <div class="col-sm-6 col-sm-offset-3">
                            <table width="100%" class="detail-table">
                                <tbody>
                                    <tr>
                                        <td style="background-color: #c0ffc6" width="50%">加盟店ID</td>
                                        <td style="background-color: #c0ffc6" width="50%"><?php echo e($shop->member_id); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">登録日</td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e(substr($shop->created_at,0,10)); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">店舗ID</td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($shop->name); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">パスワード</td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($shop->password1); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">決済URL</td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($shop->payment_url); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">契約状況</td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($shop->s_status); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">後払い決済</td>
                                        <?php ($arr_atobarai = ['利用不可', '利用可能', '一時停止']); ?>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($arr_atobarai[$shop->atobarai]); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">利用MID</td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($shop->mid); ?></td>
                                    </tr>

                                    <tr class="text-center">
                                        <td style="background-color: #87f5ff" width="50%" colspan="2">登録店舗情報</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗名</td>
                                        <td class="border-r"><?php echo e($shop->s_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗名（カタカナ）</td>
                                        <td class="border-r"><?php echo e($shop->s_name_fu); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">メンズエステ</td>
                                        <td class="border-r">
                                            <?php $__currentLoopData = $shop->service_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($service->service_name); ?>&nbsp;&nbsp;
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗住所</td>
                                        <td class="border-r"><?php echo e($shop->s_address); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗電話番号</td>
                                        <td class="border-r"><?php echo e($shop->s_tel); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗URL</td>
                                        <td class="border-r"><?php echo e($shop->s_url); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">決済後サンキューメール<br>（確認メール）</td>
                                        <td class="border-r"><?php echo e($shop->s_email); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">グループ名</td>
                                        <td class="border-r"><?php echo e($shop->s_group_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗責任者名</td>
                                        <td class="border-r"><?php echo e($shop->s_manager_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗責任者電話番号</td>
                                        <td class="border-r"><?php echo e($shop->s_manager_tel); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">店舗メールアドレス<br>(担当者)</td>
                                        <td class="border-r"><?php echo e($shop->s_manager_email); ?></td>
                                    </tr>


                                    <tr class="text-center">
                                        <td style="background-color: #87f5ff" width="50%" colspan="2">契約内容（手数料）</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">利用カードブランド</td>
                                        <td class="border-r">
                                            <?php $__currentLoopData = $shop->card_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($card->card_name); ?>&nbsp;&nbsp;
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-l" style="vertical-align: middle">最低決済手数料</td>
                                        <td class="border-r">
                                            VISA : <?php echo e($shop->s_visa_fee); ?> %<br>
                                            MASTER : <?php echo e($shop->s_master_fee); ?> %<br>
                                            JCB : <?php echo e($shop->s_jcb_fee); ?> %<br>
                                            AMEX : <?php echo e($shop->s_amex_fee); ?> %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">トランザクション認証料</td>
                                        <td class="border-r"><?php echo e($shop->s_transaction_fee); ?> 円/1決済</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">取消し手数料</td>
                                        <td class="border-r"><?php echo e($shop->s_cancel_fee); ?> 円/件</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">チャージバック</td>
                                        <td class="border-r"><?php echo e($shop->s_charge_fee); ?> 円/件</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">振込手数料</td>
                                        <td class="border-r"><?php echo e($shop->s_enter_fee); ?> 円/件</td>
                                    </tr>

                                    <tr class="text-center">
                                        <td style="background-color: #87f5ff" width="50%" colspan="2">契約内容（支払いサイクル）</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">支払いサイクル</td>
                                        <td class="border-r"><?php echo e($shop->s_paycycle_name); ?></td>
                                    </tr>

                                    <tr class="text-center">
                                        <td style="background-color: #87f5ff" width="50%" colspan="2">代理店</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">代理店名</td>
                                        <td class="border-r"><?php echo e($shop->s_agency_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">代理店手数料</td>
                                        <td class="border-r"><?php echo e($shop->s_agency_fee); ?> %</td>
                                    </tr>
                                    <tr>
                                        <td class="border-l">メモ帳</td>
                                        <td class="border-r"><?php echo e($shop->s_memo); ?></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <a href="<?php echo e(url('admin/shop')); ?>" class="btn btn-warning" style="width: 150px;">店舗管理TOPへ</a>
                        </div>
                    </div>

                    <!-- qrcode -->
                    <div id="qrcode" class="hidden"></div>
                    <input type="hidden" id="img_qrcode" name="qrcode" value="" required />

                    <input type="hidden" id="user_qrcode" value="<?php echo e(url('/payment/s=shop&p=' . $shop->name) .'&m=2'); ?>" required />
                    <input type="hidden" id="user_name" value="<?php echo e($shop->name); ?>" required />

                <?php else: ?>
                    <input type="hidden" id="user_qrcode" value="" required />
                    <input type="hidden" id="user_name" value="" required />
                <?php endif; ?>

            </div>

        </section>
        <!-- end page -->

    </section>

<?php $__env->stopSection(); ?>

<!-- Custom CSS -->
<?php $__env->startSection('page_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendor/jquery-ui/jquery-ui.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendor/jquery-ui/jquery-ui.theme.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendor/select2/css/select2.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendor/select2-bootstrap-theme/select2-bootstrap.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendor/jquery-datatables-bs3/assets/css/datatables.css')); ?>" />
<?php $__env->stopSection(); ?>

<!-- Custom JS -->
<?php $__env->startSection('page_js_vendor'); ?>
    <script src="<?php echo e(asset('public/admin/vendor/jquery-ui/jquery-ui.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/vendor/select2/js/select2.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/vendor/jquery-datatables/media/js/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/vendor/jquery-datatables-bs3/assets/js/datatables.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/vendor/ios7-switch/ios7-switch.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/vendor/bootstrap-confirmation/bootstrap-confirmation.js')); ?>"></script>

    <script src="<?php echo e(asset('public/admin/js/qrcode.js')); ?>"></script>
    <script>

        var user_qrcode = $('#user_qrcode').val();
        if(user_qrcode != ''){
            createQRCode();
        }
        else{
            window.location.href = '<?php echo e(url('/admin/shop')); ?>'
        }

        function createQRCode()
        {
            var user_name = $('#user_name').val();
            new QRCode(document.getElementById("qrcode"), user_qrcode);

            $('img', '#qrcode').on('load', function () {
                $('#img_qrcode').val($(this).attr('src'));

                var url = '<?php echo e(url('/admin/shop/qrcode')); ?>';
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>