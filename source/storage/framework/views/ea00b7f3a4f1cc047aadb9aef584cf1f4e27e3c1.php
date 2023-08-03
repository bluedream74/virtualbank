<?php ($support_company = \App\Models\Setting::company()); ?>
<?php ($support_phone = \App\Models\Setting::phone()); ?>
<?php ($support_email = \App\Models\Setting::email()); ?>

<!-- footer -->
<footer>
    <div class="footer-inner">

        <div class="contact-box pt-lg mb-xlg">
            <div class="col-xs-12 p-none">
                <div class="contact-info">
                    <h3 class="mb-md title"><strong style="color: #000">お問い合わせ</strong></h3>
                    <p><?php echo e($support_company); ?></p>
                    <p><i class="fa fa-envelope"></i>&nbsp;<?php echo e($support_email); ?></p>
                    <p class="mb-sm"><i class="fa fa-phone-square"></i>&nbsp;<?php echo e($support_phone); ?></p>
                </div>
            </div>
            <div class="col-xs-12 text-center">
                <p class="mt-xs" style="font-size: 17px; color: #999">365日24時間受付</p>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 copy-right text-center p-none" style="margin-top: 20px; font-weight: bold; color: #2d2d2d;"><small>Copyright © 2021 All Rights Reserved.</small></div>
        </div>
    </div>
</footer>
