
<?php $__env->startSection('title', 'グループ管理 | Virtual Bank'); ?>

<?php $__env->startSection('content'); ?>

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <h2><i class="fa fa-users"></i>&nbsp;&nbsp;グループ管理</h2>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">
                <h2 class="text-center" style="color: orangered; font-weight: bold"><?php echo e(session('title')); ?></h2>

                <?php ($group = session('group')); ?>
                <?php if($group != null): ?>

                    <div class="row form-group mt-xlg mb-xlg">
                        <label class="col-sm-12 control-label-bold text-left">グループ情報</label>
                    </div>
                    
                    <div class="row mt-xlg mb-xlg">
                        <div class="col-sm-6 col-sm-offset-3">
                            <table width="100%" class="detail-table">
                                <tbody>
                                    <tr>
                                        <td style="background-color: #c0ffc6" width="50%">紐付き加盟店数</td>
                                        <td style="background-color: #c0ffc6" width="50%"><?php echo e($group->g_merchantcount); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #c0ffc6" width="50%">紐付き店舗数</td>
                                        <td style="background-color: #c0ffc6" width="50%"><?php echo e($group->g_shopcount); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">登録日</td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e(substr($group->created_at,0,10)); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">グループID</td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($group->name); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">パスワード</td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($group->password1); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">契約状況</td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($group->g_status); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: #fff56b" width="50%">形態</td>
                                        <td style="background-color: #fff56b" width="50%"><?php echo e($group->g_kind); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row form-group mt-xlg mb-xlg">
                        <label class="col-sm-12 control-label-bold text-left">紐づき店舗</label>
                    </div>

                    <div class="row form-group mb-xlg">
                        <div class="col-sm-6 col-sm-offset-3"><?php echo nl2br($group->g_shoplist); ?></div>
                    </div>

                    <div class="row form-group mt-xlg mb-xlg">
                        <label class="col-sm-12 control-label-bold text-left">登録グループ情報</label>
                    </div>

                    <div class="row mt-xlg mb-xlg">
                        <div class="col-sm-6 col-sm-offset-3">
                            <table width="100%" class="detail-table">
                                <tbody>
                                    <tr>
                                        <td class="border-l" width="50%">グループ名</td>
                                        <td class="border-r" width="50%" style="border-top: 1px solid #ccc;"><?php echo e($group->g_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l" width="50%">グループ名（カタカナ）</td>
                                        <td class="border-r" width="50%"><?php echo e($group->g_name_fu); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l" width="50%">グループ代表者名</td>
                                        <td class="border-r" width="50%"><?php echo e($group->g_agency_name); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l" width="50%">グループ代表者名（カタカナ）</td>
                                        <td class="border-r" width="50%"><?php echo e($group->g_agency_name_fu); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l" width="50%">グループ代表者電話番号</td>
                                        <td class="border-r" width="50%"><?php echo e($group->g_agency_tel); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l" width="50%">グループ代表者メールアドレス</td>
                                        <td class="border-r" width="50%"><?php echo e($group->g_agency_email); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="border-l" width="50%">決済後サンキューメール<br>（確認メール）</td>
                                        <td class="border-r" width="50%">
                                            <?php echo e($group->g_thanks_email1); ?>

                                            <?php if($group->g_thanks_email2 != ''): ?>
                                                <br><?php echo e($group->g_thanks_email2); ?>

                                            <?php endif; ?>
                                            <?php if($group->g_thanks_email3 != ''): ?>
                                                <br><?php echo e($group->g_thanks_email3); ?>

                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row form-group mt-xlg mb-xlg">
                        <label class="col-sm-12 control-label-bold text-left">メモ欄</label>
                    </div>

                    <div class="row form-group mb-xlg">
                        <div class="col-sm-6 col-sm-offset-3"><?php echo nl2br($group->g_memo); ?></div>
                    </div>

                    <div class="row mb-xlg">
                        <div class="col-sm-12 text-center">
                            <a href="<?php echo e(url('admin/group')); ?>" class="btn btn-warning" style="width: 200px;">グループ管理TOPへ</a>
                        </div>
                    </div>

                <?php endif; ?>

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

    <script>

        var group = '<?php echo e($group); ?>';
        if(group == ''){
            window.location.href = '<?php echo e(url('/admin/group')); ?>'
        }

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>