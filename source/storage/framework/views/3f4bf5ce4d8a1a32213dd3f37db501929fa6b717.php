<?php $__env->startSection('title', 'VirtualBank'); ?>

<?php ($user = $datas['user']); ?>
<?php ($invoice_url = $datas['invoice_url']); ?>

<?php $__env->startSection('content'); ?>
<div role="main" class="main">

    <div class="top-container pt-none">
        <div class="container mt-sm">
            <div class="row" id="menu-list">

                <?php ($type = Auth::user()->type); ?>
                <div class="col-xs-6 col-sm-4 p-sm">
                    <a class="menu-item" href="<?php echo e(url('/sms-payment')); ?>">
                        <img src="<?php echo e(asset('public/customer/img/icon_sms.png')); ?>" width="60"/>
                        <p style="color: #6bb92d">SMS決済</p>
                    </a>
                    <?php if($type == 3): ?>
                    <div class="mask"></div>
                    <?php endif; ?>
                </div>

                <div class="col-xs-6 col-sm-4 p-sm">
                    <a class="menu-item" data-toggle="modal" data-target="#qrDialog">
                        <img src="<?php echo e(asset('public/customer/img/icon_qr.png')); ?>" width="60"/>
                        <p style="color: #ff6c03;">QR決済</p>
                    </a>
                    <?php if($type == 3): ?>
                    <div class="mask"></div>
                    <?php endif; ?>
                </div>

                <div class="col-xs-6 col-sm-4 p-sm">
                    <?php if($user->data->payment_url): ?>
                        <a class="menu-item" onclick="popupPayment('<?php echo e($user->data->payment_url); ?>')">
                    <?php else: ?>
                        <a class="menu-item">
                    <?php endif; ?>
                        <img src="<?php echo e(asset('public/customer/img/icon_card.png')); ?>" width="60"/>
                        <p style="color: #089ce4;">直接入力決済</p>
                    </a>
                    <?php if($type == 3): ?>
                    <div class="mask"></div>
                    <?php endif; ?>
                </div>

                <div class="col-xs-6 col-sm-4 p-sm">
                    <a class="menu-item" href="<?php echo e(url('/transaction')); ?>">
                        <img src="<?php echo e(asset('public/customer/img/icon_pay.png')); ?>" width="60"/>
                        <p style="color: #ef8c0c">決済一覧</p>
                    </a>
                </div>

                <div class="col-xs-6 col-sm-4 p-sm">
                    <?php if($type != 3): ?>
                        <a class="menu-item" href="<?php echo e(url('/fee-setting')); ?>">
                            <img src="<?php echo e(asset('public/customer/img/icon_fee.png')); ?>" width="60"/>
                            <p style="color: #2d6f9f;">手数料設定</p>
                        </a>
                    <?php else: ?>
                        <?php if($user->data->g_kind == '代理店'): ?>
                            <a class="menu-item" href="<?php echo e(url('/fee-setting')); ?>">
                                <img src="<?php echo e(asset('public/customer/img/icon_fee.png')); ?>" width="60"/>
                                <p style="color: #2d6f9f;">手数料設定</p>
                            </a>
                            <div class="mask"></div>
                        <?php else: ?>
                            <a class="menu-item" href="<?php echo e(url('/shop')); ?>">
                                <img src="<?php echo e(asset('public/customer/img/icon_fee.png')); ?>" width="60"/>
                                <p style="color: #2d6f9f;">店舗管理</p>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                </div>

                <div class="col-xs-6 col-sm-4 p-sm">
                    <a class="menu-item" onclick="showPasswordModal()">
                        <p style="margin-top: -14px; color: #f52424">準備中</p>
                        <img src="<?php echo e(asset('public/customer/img/icon_invoice.png')); ?>" width="60"/>
                        <p style="color: #f52424">精算書</p>
                    </a>
                    <?php if($type == 3): ?>
                    <div class="mask"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <!-- shop information -->
    <?php echo $__env->make('customer.layouts.info', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!-- ログアウト -->
    <div class="row">
        <div class="col-xs-12 text-center mb-md">
            <a href="<?php echo e(url('/logout')); ?>" class="btn btn-default btn-gold">ログアウト</a>
        </div>
    </div>

    <!-- QRCodeDialog -->
    <div class="modal fade" id="qrDialog" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title" id="modal-title" style="font-size: 24px;">QRコード</h5>
                </div>
                <div class="modal-body p-md">
                    <form>
                        <div class="form-group text-center">
                            <img src="<?php echo e($user->data->qrcode); ?>" width="80%"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-default btn-white" data-dismiss="modal" style="width: 90%;">閉じる</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end dialog -->

    <!-- PasswordDialog -->
    <div class="modal fade" id="pwdDialog" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center" style="border-bottom: none">
                    <h5 class="modal-title" id="modal-title" style="font-size: 24px;">パスワード</h5>
                </div>

                <div class="modal-body p-md pt-none">
                    <div class="password_body">
                        
                        <input type="text" maxlength="1" id="p1" />
                        <input type="text" maxlength="1" id="p2" />
                        <input type="text" maxlength="1" id="p3" />
                        <input type="text" maxlength="1" id="p4" />
                        <p id="wrong_password" class="mt-sm hidden">パスワードが不正です。</p>
                    </div>
                </div>

                <div class="modal-footer text-center"  style="border-top: none">
                    <button type="button" class="btn btn-danger" style="width: 120px; font-size: 18px;" onclick="checkPassword()">確認</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal" style="width: 120px; font-size: 18px;">キャンセル</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end dialog -->

</div>

<?php $__env->stopSection(); ?>

<!-- Custom CSS -->
<?php $__env->startSection('page_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/customer/css/views/top.css')); ?>">
<?php $__env->stopSection(); ?>

<!-- Custom JS -->
<?php $__env->startSection('page_js'); ?>
    <script>

        function showPasswordModal()
        {
            $('#pwdDialog').modal('show');
        }

        function checkPassword()
        {
            var p1 = $('#p1').val();
            var p2 = $('#p2').val();
            var p3 = $('#p3').val();
            var p4 = $('#p4').val();
            if((p1 == '') || (p2 == '') || (p3 == '') || (p4 == '')){
                $('#wrong_password').removeClass('hidden');
                return false;
            }

            if((p1 == '0') && (p2 == '0') && (p3 == '0') && (p4 == '0')){
                window.location.href = '<?php echo e($invoice_url); ?>';
            }
            else {
                $('#wrong_password').removeClass('hidden');
                return false;
            }
        }

        function popupPayment(url){

            const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

            const w = 400;
            const h = 1000;

            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft
            const top = (height - h) / 2 / systemZoom + dualScreenTop

            window.open(url, '_blank', `scrollbars=yes,
            width=${w / systemZoom}, 
            height=${h / systemZoom}, 
            top=${top}, 
            left=${left}
            `);
        }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>