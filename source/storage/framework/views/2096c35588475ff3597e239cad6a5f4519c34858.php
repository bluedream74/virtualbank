<?php $__env->startSection('title', '加盟店ログイン'); ?>
<?php $__env->startSection('content'); ?>

    <div role="main" class="main">

        <div class="mt-xlg pt-xlg text-center">
            <h2 style="font-weight: bold; color: white;">加盟店ログイン</h2>
        </div>

        <div class="row" style="padding: 10px 10px 20px;">
            <div class="col-sm-4 col-sm-offset-4 col-xs-12">

                <form action="<?php echo e(url('/login')); ?>" method="post" class="input-form">
                    <?php echo e(csrf_field()); ?>


                    <?php if(count($errors) > 0): ?>
                        <label style="color:red">ログイン情報をご確認してください</label>
                    <?php endif; ?>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label class="control-label" style="color: white">ログインID</label>
                                <input type="text" name="name" id="name" class="form-control input-lg" placeholder="ログインID">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label class="control-label" style="color: white">パスワード</label>
                                <input type="password" name="password" id="password" class="form-control input-lg" placeholder="パスワード">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-sm">
                        <div class="form-group pl-md">
                            <div class="checkbox-custom checkbox-default col-xs-12">
                                <input type="checkbox" id="rememberme" name="rememberme" /><label for="rememberme" style="color: white">次回から入力を省略する。</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-lg">
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <button type="submit" style="padding: 10px 50px; width: 250px;" class="btn btn-default btn-gold mb-xl">ログイン</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<!-- Custom CSS -->
<?php $__env->startSection('page_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/customer/css/views/register.css')); ?>">
<?php $__env->stopSection(); ?>

<!-- Custom JS -->
<?php $__env->startSection('page_js'); ?>
    <script type="text/javascript" src="<?php echo e(asset('public/customer/js/views/register.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>