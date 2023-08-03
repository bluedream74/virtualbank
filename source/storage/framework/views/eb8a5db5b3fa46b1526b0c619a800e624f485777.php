<?php $__env->startSection('title', '決済実行 | VirtualBank'); ?>

<?php ($data = $datas['data']); ?>
<?php ($user = $datas['user']); ?>
<?php ($support_name = $data->supplier); ?>
<?php ($support_company = \App\Models\Setting::company()); ?>
<?php ($support_phone = \App\Models\Setting::phone()); ?>

<?php $__env->startSection('content'); ?>
<div role="main" class="main">

    <div class="top-container" id="paymentForm">
        <div class="inner" id="resultContainer">
            <h2 class="mb-sm">クレジットカード決済</h2>

            <?php if($data->return_code == '0000'): ?>

                <p class="success-title">決済成功</p>
                <p class="success-help">(Successful Payment)</p>
                <table class="flow-table mb-md">
                    <tbody>
                        <tr>
                            <td class="text-center detail">
                                カード利用明細の請求名<br><strong><?php echo e($support_name); ?></strong><br>クレジットカード利用明細に記載される<br>請求名です
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center detail">
                                ご請求金額<br><strong><i class="fa fa-yen"></i><?php echo e(number_format(ceil($data->amount))); ?></strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
               
                <div id="transaction-info">
                    <table>
                        <tbody>
                            <tr>
                                <td><p>決済日時</p></td>
                                <td><p>:</p></td>
                                <td><p>&nbsp;&nbsp;&nbsp;<?php echo e(date('Y-m-d H:i')); ?></p></td>
                            </tr>
                            <tr>
                                <td><p>カード番号</p></td>
                                <td><p>:</p></td>
                                <td><p>&nbsp;&nbsp;&nbsp;**** **** **** <?php echo e(substr($data->card_number, -4)); ?></p></td>
                            </tr>
                            <tr>
                                <td><p>カード名義</p></td>
                                <td><p>:</p></td>
                                <td><p>&nbsp;&nbsp;&nbsp;<?php echo e($data->card_holdername); ?></p></td>
                            </tr>
                            <tr>
                                <td><p>携帯電話番号</p></td>
                                <td><p>:</p></td>
                                <td><p>&nbsp;&nbsp;&nbsp;<?php echo e($data->phone); ?></p></td>
                            </tr>
                        </tbody>
                    </table>                   
                </div>

                <?php if($data->atobarai == 1): ?>
                <table class="flow-table mb-md">
                    <tbody>
                        <tr>
                            <td class="text-center detail pl-none pr-none">
                                後払い決済対象店<br><strong><?php echo e($user->username); ?></strong><br>次回ご決済に、<br><span style="font-weight:bold; color:red;">『後払い決済』</span>のご利用も可能となります。<br>詳細は、下記お問い合わせにご連絡下さい。
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php endif; ?>

                <table class="flow-table mb-md">
                    <tbody>
                        <tr>
                            <td class="text-center detail" style="color:red !important">携帯認証用ショートメール(SMS)は、<br>決済詳細として大切に保管ください</td>
                        </tr>
                    </tbody>
                </table>

                <p class="text-thanks">ご利用頂きありがとうございました。</p>
                <p class="comment mt-none pt-none">※画面を閉じてください※</p>

            <?php else: ?>

                <p class="fail-title">決済失敗</p>
                <p class="success-help fail-help">(Settlement Failure)</p>

                <table class="flow-table mb-md">
                    <tbody>
                        <tr>
                            <td class="text-center detail">ご利用のカードの海外決済に制限がないか<br>（ご利用のカード、特に楽天カード)<br>ご確認の上、ご決済ください</td>
                        </tr>
                        <tr>
                            <td class="text-center detail">
                                <span class="fail-help mb-lg">※再決済を行う場合※</span><br>一度画面を閉じて、再びカードブランド選択画面から操作を行ってください
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p class="text-thanks">ご利用頂きありがとうございました。</p>
                <p class="comment mt-none pt-none">※画面を閉じてください※</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- atobarai Dialog -->
    <div class="modal fade" id="atobaraiDialog" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center" style="border: none;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle-o"></i></button>
                    <span class="modal-title" id="modal-title">後払い決済対象店<br><strong><?php echo e($user->username); ?></strong></span>
                </div>
                <div class="modal-body pt-none text-center">
                    <span class="text-center">かんたんな<br><strong>後払い決済のご案内</strong><br>後払い決済がご希望の方は、<br>下記にご連絡を下さい。<br><br><strong><?php echo e($support_company); ?></strong><br><a class="phone" href="tel:<?php echo e($support_phone); ?>"><strong><?php echo e($support_phone); ?></strong></a><br>※上記電話番号をクリックして下さい※</span>
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
    <link rel="stylesheet" href="<?php echo e(asset('public/customer/css/views/payment.css')); ?>">
<?php $__env->stopSection(); ?>

<!-- Custom JS -->
<?php $__env->startSection('page_js'); ?>
    <script src="<?php echo e(asset('public/customer/js/views/top.js')); ?>" type="text/javascript"></script>
    <script>

        var return_code = '<?php echo e($data->return_code); ?>';
        var atobarai = '<?php echo e($data->atobarai); ?>';
        if((return_code != '0000') && (atobarai == 1)) {
            $('#atobaraiDialog').modal('show');
        }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>