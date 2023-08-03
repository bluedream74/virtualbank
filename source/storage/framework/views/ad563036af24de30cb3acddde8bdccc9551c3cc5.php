<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('favicon.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('favicon.png')); ?>">

    <!-- CSRF Token -->
    <title><?php echo $__env->yieldContent('title', config('app.name', 'VirtualBank')); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/vendor/bootstrap/css/bootstrap.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/vendor/font-awesome/css/font-awesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/vendor/simple-line-icons/css/simple-line-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/vendor/owl.carousel/assets/owl.carousel.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/vendor/owl.carousel/assets/owl.theme.default.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/vendor/magnific-popup/magnific-popup.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/vendor/pnotify/pnotify.custom.css')); ?>">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/css/theme.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/css/theme-custom.css')); ?>">


    <!-- Skin CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/css/skins/default.css')); ?>">

    <!-- Custom CSS -->
    <?php echo $__env->yieldContent('page_css'); ?>

    <!-- Head Libs -->
    <script src="<?php echo e(asset('public/merchant/vendor/modernizr/modernizr.js')); ?>"></script>


</head>

<body>
    <?php if(Auth::guard('group')->check()): ?>

        <section class="body">

            <?php echo $__env->make('group.layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="inner-wrapper">

                <?php echo $__env->make('group.layouts.sidebar-left', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <?php echo $__env->yieldContent('content'); ?>

            </div>

            <?php echo $__env->make('group.layouts.sidebar-right', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        </section>
    <?php else: ?>
        <?php echo $__env->yieldContent('content'); ?>

    <?php endif; ?>

    <!-- Vendor -->
    <script src="<?php echo e(asset('public/merchant/vendor/jquery/jquery.js')); ?>"></script>
    <script src="<?php echo e(asset('public/merchant/vendor/jquery-browser-mobile/jquery.browser.mobile.js')); ?>"></script>
    <script src="<?php echo e(asset('public/merchant/vendor/bootstrap/js/bootstrap.js')); ?>"></script>
    <script src="<?php echo e(asset('public/merchant/vendor/nanoscroller/nanoscroller.js')); ?>"></script>
    <script src="<?php echo e(asset('public/merchant/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('public/merchant/vendor/magnific-popup/jquery.magnific-popup.js')); ?>"></script>
    <script src="<?php echo e(asset('public/merchant/vendor/jquery-placeholder/jquery-placeholder.js')); ?>"></script>
    <script src="<?php echo e(asset('public/merchant/vendor/pnotify/pnotify.custom.js')); ?>"></script>

    <!-- Custom vendor js -->
    <?php echo $__env->yieldContent('page_js_vendor'); ?>

    <!-- Theme Base, Components and Settings -->
    <script src="<?php echo e(asset('public/merchant/js/theme.js')); ?>"></script>

    <!-- Theme Initialization Files -->
    <script src="<?php echo e(asset('public/merchant/js/theme.init.js')); ?>"></script>

    <!-- Theme Initialization Files -->
    <script src="<?php echo e(asset('public/merchant/js/theme.custom.js')); ?>"></script>

    <!-- Custom page js -->
    <?php echo $__env->yieldContent('page_js_page'); ?>
</body>
</html>

