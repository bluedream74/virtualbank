<?php $__env->startSection('title', '決済確認画面 | VirtualBank'); ?>

<?php ($data = $datas['data']); ?>
<?php ($support_name = $data['supplier']); ?>

<?php $__env->startSection('content'); ?>
<div role="main" class="main">

    <div class="top-container" id="confirm-container">
        <div id="inner">
            <h2>クレジットカード決済</h2>
            <div class="detail">
    
                <!-- ご利用店舗名（ShopName）-->
                <div id="shopname" class="mt-xs form-group">
                    <p class="large hint">カード利用明細の請求名</p>
                    <p class="medium mb-md"><strong><?php echo e($support_name); ?></strong></p>

                    <p class="large hint">お申込金額+決済手数料(Amount)</p>
                    <p class="medium"><i class="fa fa-yen"></i><strong><?php echo e(number_format(ceil($data['amount'] * (1 + $data['fee'] / 100)))); ?></strong></p>
                    <p class="small command mb-md">※お申込金額にご利用店舗が定めた手数料が加算されています</p>

                    <p class="large hint">携帯電話番号(Cell-Phone)</p>
                    <p class="medium mb-md"><strong><?php echo e($data['phone']); ?></strong></p>

                    <p class="large hint">カード番号(Credit Card Number)</p>
                    <p class="medium mb-md"><strong>**** **** **** <?php echo e(substr($data['card_number'], -4)); ?></strong></p>

                    <p class="large hint">カード有効期限(Expiration Date)</p>
                    <p class="medium mb-md"><strong><?php echo e($data['card_exp_month'] . '/' . $data['card_exp_year']); ?></strong></p>

                    <p class="large hint">カード名義(Your Name)</p>
                    <p class="medium mb-md"><strong><?php echo e(substr($data['card_holdername'],0,1) . '*****' . substr($data['card_holdername'], -1)); ?></strong></p>

                </div>
            </div>
            
        </div>

        <form action="<?php echo e(url('payment/confirm')); ?>" method="post" id="payForm">

            <input type="hidden" name="data" value="<?php echo e(json_encode($data)); ?>" />
            <div class="row form-group mt-xlg">
                <div class="col-xs-12 text-center">
                    <button id="btnConfirm" class="btn btn-default btn-gold" style="width: 250px; border-radius: 13px; padding: 20px">決済の実行</button>
                </div>
            </div>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>

<!-- Custom CSS -->
<?php $__env->startSection('page_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/customer/css/views/top.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/customer/css/views/payment.css')); ?>">
<?php $__env->stopSection(); ?>

<!-- Custom JS -->
<?php $__env->startSection('page_js'); ?>

    <script>

        $('#payForm').submit(function() {
            $('#btnConfirm').attr("disabled", true);
        });

    </script>
    
 <?php $__env->stopSection(); ?>
<?php echo $__env->make('customer.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>