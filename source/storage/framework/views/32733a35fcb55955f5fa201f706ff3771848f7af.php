
<?php $__env->startSection('title', 'ホーム | Virtual Bank'); ?>

<?php $__env->startSection('content'); ?>

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-4">
                    <h2><i class="fa fa-home"></i>&nbsp;&nbsp;ホーム</h2>
                </div>
            </div>

        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body" style="height: 700px;">
            </div>
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
<?php $__env->stopSection(); ?>

<!-- Custom JS -->
<?php $__env->startSection('page_js_vendor'); ?>
    <script src="<?php echo e(asset('public/admin/vendor/jquery-ui/jquery-ui.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/vendor/select2/js/select2.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/vendor/jquery-datatables/media/js/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/vendor/jquery-datatables-bs3/assets/js/datatables.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/vendor/ios7-switch/ios7-switch.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/vendor/bootstrap-confirmation/bootstrap-confirmation.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>