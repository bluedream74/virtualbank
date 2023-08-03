<?php $__env->startSection('title', 'VirtualBank'); ?>

<?php ($path = $datas['path']); ?>
<?php ($m_name = $datas['m_name']); ?>
<?php ($support_name = $datas['supplier']); ?>

<?php $__env->startSection('content'); ?>
<div role="main" class="main">

    <div class="top-container">
        <div class="inner">
            <h2>請求名、ご利用店舗名を<br>必ずご確認ください</h2>
            <table class="flow-table mb-md">
                <tbody>
                    <tr>
                        <td class="text-center detail">
                            カード利用明細の請求名<br><strong><?php echo e($support_name); ?></strong><br>クレジットカード利用明細に記載される<br>請求名です
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center detail">
                            ご利用店舗名<br><strong><?php echo e($m_name); ?></strong><br>店舗名は、請求名として記載されません
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- <h2>チェックボックスにチェックを入れ<br>次へお進みください</h2> -->
            <div class="form-group" id="check-next-container">
                <div class="checkbox-custom checkbox-default ml-sm">
                    <input type="checkbox" id="next" name="next" /><label for="next" class="check-next">チェックボックスにチェックを入れ次へ<br>お進みください</label>
                </div>
            </div>

            <div class="text-center mt-md mb-md">
                <a href="<?php echo e(url('/payment/step3/' . $path)); ?>" class="btn btn-default btn-gold btn-next disabled" id="btn-next">次へ</a>
            </div>

            <div class="text-center">
                <a class="btn btn-default btn-green btn-next" onclick="history.back()">戻る</a>
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

    <script>
        $('#next').change(function() {
            if($(this).is(":checked")) {
                $('#btn-next').removeClass('disabled');
            }
            else {
                $('#btn-next').addClass('disabled');
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>