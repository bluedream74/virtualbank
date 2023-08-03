<?php $__env->startSection('title', 'VirtualBank'); ?>

<?php ($m_name = $datas['m_name']); ?>
<?php ($name = $datas['name']); ?>
<?php ($payment_method_id = $datas['payment_method_id']); ?>
<?php ($phone = $datas['phone']); ?>
<?php ($status = $datas['status']); ?>
<?php ($type = $datas['type']); ?>
<?php ($cardtype_id = $datas['cardtype_id']); ?>
<?php ($payment_token = $datas['payment_token']); ?>
<?php ($support_name = $datas['supplier']); ?>

<?php $__env->startSection('content'); ?>
<div role="main" class="main">

<?php if($status == '契約中'): ?>
    <div class="top-container" id="paymentForm">

        <form class="form-horizontal" action="<?php echo e(url('payment/step3')); ?>" enctype="multipart/form-data" method="post" id="inputForm">
            <p class="text-center mt-md mb-none command">すべてご入力後、<br>携帯認証ボタンをクリックして下さい</p>
            <div id="inputContainer">
                
                <!-- ご利用店舗名（ShopName）-->
                <div id="shopname" class="mt-xs form-group">

                    <p class="large">カード利用明細の請求名</p>
                    <p class="medium"><strong><?php echo e($support_name); ?></strong></p>
                    <p class="small mb-md">クレジットカード利用明細書に記載される請求名です</p>

                    <p class="large">ご利用店舗名(Shop Name)</p>
                    <p class="medium"><strong><?php echo e($m_name); ?></strong></p>
                    <p class="small mb-md">店舗名は、請求名として記載されません</p>

                    <input type="hidden" name="m_name" value="<?php echo e($m_name); ?>" />
                    <input type="hidden" name="name" value="<?php echo e($name); ?>" />
                    <input type="hidden" name="payment_method_id" value="<?php echo e($payment_method_id); ?>" />
                    <input type="hidden" name="type" value="<?php echo e($type); ?>" />
                    <input type="hidden" name="payment_token" value="<?php echo e($payment_token); ?>" />
                    <input type="hidden" name="supplier" value="<?php echo e($support_name); ?>" />

                    <p class="amount mb-sm">お申込金額(Amount)</p>
                    <input class="form-control" type="number" name="amount" id="amount" width="100%" placeholder="半角数値入力" required />
                </div>

                <!-- カード番号 -->
                <div id="card-info">

                    <p class="title">カード番号(Credit Card Number)</p>

                    <input class="form-control" type="text" name="card_number" id="card_number" placeholder="半角数値入力ハイフンなし" required autocomplete="cc-number" />
                    <input type="hidden" name="cardtype_id" id="cardtype_id" value="<?php echo e($cardtype_id); ?>" required  />
                    <input type="hidden" name="cardtype_name" id="cardtype_name" required  />

                    <p class="title">カード有効期限(Expiration Date)</p>
                    <div class="row">
                        <div class="col-xs-5 col-xs-offset-1">
                            <select class="form-control" name="card_exp_month" id="card_exp_month" required="" autocomplete="cc-exp-month">
                                <option value="">月</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                        <div class="col-xs-5">
                            <select class="form-control" name="card_exp_year" id="card_exp_year" required="" autocomplete="cc-exp-year">
                                <option value="">年</option>
                                <?php for($year=date('Y');$year<2100;$year++): ?>
                                    <option value="<?php echo e($year); ?>"><?php echo e($year); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <p class="title mt-md">カード名義(Your Name)</p>
                    <input class="form-control" type="text" name="card_holdername" id="card_holdername" placeholder="半角ローマ字入力" required autocomplete="cc-name"/>
                    <p class="title">セキュリティーコード(CVV)</p>
                    <input class="form-control" type="text" name="card_cvv" id="card_cvv" placeholder="半角数値入力" maxlength="4" required autocomplete="cc-csc"/>

                    <!-- 携帯電話番号(cell-phone) -->
                    <div id="phonenum" class="p-none mt-md">
                        <p class="title">携帯電話番号(Cell-Phone)</p>
                        <input class="form-control" type="number" name="phone" id="phone" width="100%" placeholder="半角数値入力ハイフンなし" value="<?php echo e($phone); ?>" required />

                        <div class="row form-group">
                            <div class="col-xs-12 hidden">
                                <div class="checkbox-custom checkbox-default col-xs-12">
                                    <input type="checkbox" id="agree_email" name="agree_email" onclick='checkEmailClick(this);'><label for="agree_email" style="line-height: 1.8">決済完了メールの受け取りを希望する</label>
                                </div>
                            </div>

                            <div class="col-xs-12 mt-sm hidden" id="email_box">
                                <input class="form-control" type="email" name="email" id="email" width="100%" placeholder="Eメールアドレス" />
                                <p>決済完了後、Eメールアドレスに決済完了メールを送信致します</p>
                            </div>
                        </div>

                    </div>
                </div>                
                
                <!-- links -->
                <div id="links">
                    <a class="page-link hidden" href="<?php echo e(url('terms')); ?>"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;利用規約</a>
                    <a class="page-link hidden" href="<?php echo e(url('privacy-policy')); ?>"><i class="fa fa-angle-right"></i>&nbsp;&nbsp;個人情報保護規約</a>

                    <div class="row form-group">
                        <div class="col-xs-12 hidden">
                            <div class="checkbox-custom checkbox-default col-xs-12">
                                <input type="checkbox" id="agree" name="agree" required /><label for="agree" id="label-agree">利用規約に同意する(Agreement)</label>
                            </div>
                        </div>
                        <div class="col-xs-12 text-center">
                            <p class="text-center mb-xlg command">※上記電話番号宛にショートメール<br>(SMS)が配信されます<br><br>すべてご入力後、<br>携帯認証ボタンをクリックして下さい</p>
                            <a class="btn btn-default btn-gold" style="min-width:200px;width:200px;border-radius: 13px;" onclick="checkForm()">携帯認証</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

<?php elseif(($status == '審査中') || ($status == '休止')): ?>
    <p class="comment" style="margin: 70px 0;">この店舗のクレジットカード決済は只今休止中です。<br>詳細は店舗にご確認ください。</p>
<?php elseif($status == '解約'): ?>
    <p class="comment" style="margin: 70px 0;">この店舗のクレジットカード決済はご利用頂けません。<br>詳細は店舗にご確認ください。</p>
<?php endif; ?>

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

        function checkCardType(number)
        {
            var cardtype_name = '';
            var cardtype_id = 0;

            // visa
            var re = new RegExp("^4");
            if (number.match(re) != null){
                cardtype_id = 1; //  "Visa";
                cardtype_name = 'VISA';
            }

            // Mastercard
            re = new RegExp("^5[1-5][0-9]");
            if (number.match(re) != null){
                cardtype_id = 2; // "Mastercard";
                cardtype_name = 'MASTERCARD';
            }

            // JCB
            re = new RegExp("^35(2[89]|[3-8][0-9])");
            if (number.match(re) != null){
                cardtype_id = 3; // "JCB";
                cardtype_name = 'JCB';
            }

            // AMEX
            re = new RegExp("^3[47]");
            if (number.match(re) != null){
                cardtype_id = 4;
                cardtype_name = 'AMEX';
            }

            // card type            
            if(cardtype_id != $('#cardtype_id').val()) {
                return false;
            }

            $('#cardtype_name').val(cardtype_name);
            return true;
        }

        // 携帯電話番号
        $('#phone').on('keyup', function(e){

            var val = $(this).val();
            if(val.length > 11) {
                $(this).val(val.substring(0,11));
                return false;
            }
        });

        // カード番号
        $('#card_number').on('keyup', function(e){
            var val = $(this).val();
            var newval = '';
            val = val.replace(/\s/g, '');
            var isOverflow = false;
            if (val.length > 16){
                isOverflow = true;
                val = val.substring(0, 16);
            }
            for(var i=0; i < val.length; i++) {
                if(i%4 == 0 && i > 0) newval = newval.concat(' ');
                newval = newval.concat(val[i]);
            }
            $(this).val(newval);
			return isOverflow;
        });

        function checkForm()
        {
            $('.error').removeClass('error');

            // 申込金額
            var amount = $('#amount').val();
            if((amount == '')){
                $('#amount').addClass('error');
                $('#amount').focus();
                setTimeout(function() { alert('申込金額を入力してください。'); }, 700);
                return false;
            }

            if((amount > 500000) || (amount < 0)){
                $('#amount').addClass('error');
                $('#amount').focus();
                setTimeout(function() { alert('申込金額は50万円までを上限とする。'); }, 700);
                return false;
            }

            // card_number
            var card_number = $('#card_number').val();
            if(card_number == ''){
                $('#card_number').addClass('error');
                $('#card_number').focus();
                setTimeout(function() { alert('カード番号を入力してください。'); }, 700);
                return false;
            }

            if(checkCardType(card_number) == ''){
                $('#card_number').addClass('error');
                $('#card_number').focus();
                setTimeout(function() { alert('カード番号が不正です。'); }, 700);
                return false;
            }

            // カード有効期限
            var card_exp_month = $('#card_exp_month').val();
            if(card_exp_month == ''){
                $('#card_exp_month').addClass('error');
                $('#card_exp_month').focus();
                setTimeout(function() { alert('カード有効期限を選択してください。'); }, 700);
                return false;
            }

            var card_exp_year = $('#card_exp_year').val();
            if(card_exp_year == ''){
                $('#card_exp_year').addClass('error');
                $('#card_exp_year').focus();
                setTimeout(function() { alert('カード有効期限を選択してください。'); }, 700);
                return false;
            }

            // カード名義
            var card_holdername = $('#card_holdername').val();
            if(card_holdername == ''){
                $('#card_holdername').addClass('error');
                $('#card_holdername').focus();
                setTimeout(function() { alert('カード名義を入力してください。'); }, 700);
                return false;
            }

            // セキュリティーコード
            var card_cvv = $('#card_cvv').val();
            if(card_cvv == ''){
                $('#card_cvv').addClass('error');
                $('#card_cvv').focus();
                setTimeout(function() { alert('セキュリティーコードを入力してください。'); }, 700);
                return false;
            }
            
            // cell-phone
            var phonenum = $('#phone').val();
            if(phonenum == ''){
                $('#phone').addClass('error');
                $('#phone').focus();
                setTimeout(function() { alert('携帯電話番号を入力してください。'); }, 700);
                return false;
            }

            $('#inputForm').submit();
        }

        function checkEmailClick(obj)
        {
            if(obj.checked){
                $('#email_box').removeClass('hidden');
            }
            else{
                $('#email_box').addClass('hidden');
                $('#email').val('');
            }
        }

        function validateEmail(email) {
            const re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return re.test(String(email).toLowerCase());
        }

        $('form').submit(function() {
            $(this).find("#btnConfirm").prop('disabled',true);
        });
        
        $('#goto_top').on('click', function(){
            window.close();
        });

        // check if popup or direct
        if (window.opener && window.opener !== window) {
            $('#payment_direct').val(0);    // popup
        }
        else{
            $('#payment_direct').val(1);    // no-popup
        }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>