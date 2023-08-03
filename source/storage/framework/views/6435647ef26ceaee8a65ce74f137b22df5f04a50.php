<?php $__env->startSection('title', 'VirtualBank'); ?>

<?php ($path = $datas['path']); ?>

<?php $__env->startSection('content'); ?>
<div role="main" class="main">

    <div class="top-container">
        <div class="inner">
            <h2>VIRTUALBANKは<br>株式会社SmartPaymentが<br>運営する決済サービスです</h2>
            <table class="flow-table">
                <tbody>
                    <tr>
                        <td colspan="2" class="text-center"><strong>決済手順</strong></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>カードブランドの選択</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>請求名とご利用店舗名の確認</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>決済情報の入力して、携帯電話認証ボタンを押す</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>携帯電話に届いたショートメールのURLを押す</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>決済情報を確認してから、決済の実行</td>
                    </tr>
                </tbody>
            </table>
            <h3 class="comment"><strong>※<span style="text-decoration: underline;">携帯電話認証の後に</span><br>決済の実行となります。</strong></h3>
            <div class="text-center mt-xlg">
                <a href="<?php echo e(url('/payment/step1/' . $path)); ?>" class="btn btn-default btn-gold btn-next" >次へ</a>             
            </div>
        </div>
        
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>