<?php $__env->startSection('title', 'Virtual Bank'); ?>

<?php $__env->startSection('content'); ?>

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2 style="float:none !important;">&nbsp;&nbsp;Virtual Bank</h2>
                </div>
            </div>
        </header>

        <!-- start page -->
        <section class="panel">
            <div class="panel-body"></div>
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
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/css/common.css')); ?>" />
<?php $__env->stopSection(); ?>

<!-- Custom JS -->
<?php $__env->startSection('page_js_vendor'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('group.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>