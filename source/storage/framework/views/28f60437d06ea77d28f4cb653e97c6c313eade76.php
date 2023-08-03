
<?php $__env->startSection('title', 'グループ管理 | Virtual Bank'); ?>

<?php ( $list = $datas['list']); ?>
<?php ( $data = $datas['data']); ?>

<?php $__env->startSection('content'); ?>

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <h2><i class="fa fa-users"></i>&nbsp;グループ管理</h2>
            <div class="right-wrapper pull-right">
                <ol class="breadcrumbs">
                    <li>
                        <a class="btn btn-danger" href="<?php echo e(url('admin/group/create')); ?>" style="color:white;">新規グループ登録</a>
                    </li>
                </ol>&nbsp;&nbsp;&nbsp;
            </div>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">

                <div class="row pl-md">
                    <label class="col-sm-6" style="font-weight: bold; color: #000000; font-size: 18px;">検索条件</label>
                </div>

                <!-- filter -->
                <div class="filter mb-xlg" style="padding: 15px; border: 1px solid #444;">

                    <form class="form-horizontal" action="<?php echo e(url('admin/group/search/')); ?>" enctype="multipart/form-data" method="post" id="searchForm">

                        <input type="hidden" id="pagelen" name="pagelen" class="form-control" value="<?php echo e($data['pagelen']); ?>" />
                        <div class="row" style="padding: 0 0 10px; border-bottom: 1px dashed #ccc">

                            <div class="col-sm-1" style="width: 70px;">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="mt-xs">登録日</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input id="start_date" name="start_date" type="date" class="form-control" value="<?php echo e($data['start_date']); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-1" style="width: 30px;">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>～</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input id="end_date" name="end_date" type="date" class="form-control" value="<?php echo e($data['end_date']); ?>" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-4 pull-right text-right">
                                <button onclick="search()" class="btn btn-success" style="width: 120px;">検索開始</button>
                                <a onclick="reset()" class="btn btn-default" style="width: 100px; margin-left: 10px;">リセット</a>
                            </div>

                        </div>

                        <div class="row" style="padding: 0">

                            <div class="col-sm-4 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>グループID</label>
                                        <input type="text" id="name" name="name" class="form-control" value="<?php echo e($data['name']); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>グループ名</label>
                                        <input id="g_name" name="g_name" class="form-control" value="<?php echo e($data['g_name']); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>契約状況</label>
                                        <select id="g_status" name="g_status" class="form-control">
                                            <option value=""></option> 
                                            <option value="契約中" <?php if($data['g_status'] == '契約中'): ?> selected <?php endif; ?>>契約中</option> 
                                            <option value="休止" <?php if($data['g_status'] == '休止'): ?> selected <?php endif; ?>>休止</option> 
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>形態</label>
                                        <select id="g_kind" name="g_kind" class="form-control">
                                            <option value=""></option> 
                                            <option value="グループ店" <?php if($data['g_kind'] == 'グループ店'): ?> selected <?php endif; ?>>グループ店</option> 
                                            <option value="代理店" <?php if($data['g_kind'] == '代理店'): ?> selected <?php endif; ?>>代理店</option> 
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>加盟店ID</label>
                                        <input type="text" id="merchant_id" name="merchant_id" class="form-control" value="<?php echo e($data['merchant_id']); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>店舗ID</label>
                                        <input id="shop_id" name="shop_id" class="form-control" value="<?php echo e($data['shop_id']); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>店舗名</label>
                                        <input id="shop_name" name="shop_name" class="form-control" value="<?php echo e($data['shop_name']); ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

                <!-- table -->
                <table class="table table-bordered table-striped text-center" id="group_datatable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center" width="5%">ID</th>
                            <th class="text-center" width="10%">登録日</th>
                            <th class="text-center" width="10%">グループID</th>
                            <th class="text-center" width="10%">グループ名</th>
                            <th class="text-center" width="15%">加盟店数(紐づいている)</th>
                            <th class="text-center" width="10%">店舗数(紐づいている)</th>
                            <th class="text-center" width="12%">契約状況</th>
                            <th class="text-center" width="8%">形態</th>
                            <th class="text-center" width="8%">削除</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php ( $index = 1 ); ?>
                        <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index); ?></td>
                                <td><?php echo e(substr($group->created_at,0,10)); ?></td>
                                <td><a class="link" href="<?php echo e(url('admin/group/edit/' . $group->id)); ?>"><?php echo e($group->name); ?></a></td>
                                <td><a class="link" href="<?php echo e(url('admin/group/edit/' . $group->id)); ?>"><?php echo e($group->g_name); ?></a></td>
                                <td>
                                    <?php if($group->g_merchantcount > 0): ?>
                                        <a href="<?php echo e(url('admin/group/merchants/' . $group->id)); ?>" style="color: white;padding: 5px 10px; border-radius: 15px;background-color: orange"><?php echo e($group->g_merchantcount); ?></a>
                                    <?php else: ?>
                                        <?php echo e($group->g_merchantcount); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($group->g_shopcount > 0): ?>
                                        <a href="<?php echo e(url('admin/group/shops/' . $group->id)); ?>" style="color: white;padding: 5px 10px; border-radius: 15px;background-color: orange"><?php echo e($group->g_shopcount); ?></a>
                                    <?php else: ?>
                                        <?php echo e($group->g_shopcount); ?>

                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($group->g_status); ?></td>
                                <td><?php echo e($group->g_kind); ?></td>
                                <td>
                                    <a class="btn btn-danger remove-row" data-plugin-tooltip data-toggle="tooltip" data-placement="top" data-original-title="削除" data-url="<?php echo e(url('/admin/group/delete/' .$group->id)); ?>"><i class="fa fa-trash" style="color: white;"></i></a>
                                </td>
                            </tr>
                            <?php ( $index++ ); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>

                </table>

                <!-- links -->
                <div class="d-flex justify-content-center" style="float: right">
                    <?php echo e($list->links()); ?>

                </div>

            </div>
        </section>
        <!-- end page -->

    </section>

    <!-- Delete Dialog -->
    <div id="dialog" class="modal-block mfp-hide">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">グループ削除</h2>
            </header>
            <div class="panel-body">
                <div class="modal-wrapper">
                    <div class="modal-text">
                        <p>このグループを削除しますか?</p>
                    </div>
                </div>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button id="dialogConfirm" class="btn btn-danger" style="width: 120px;">確認</button>
                        <button id="dialogCancel" class="btn btn-default" style="width: 120px;">キャンセル</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>
    <!-- end dialog -->

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

    <script src="<?php echo e(asset('public/admin/js/table2CSV.js')); ?> "></script>
    <script src="<?php echo e(asset('public/admin/js/views/group.js')); ?>"></script>

    <script>

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $( document ).ready(function() {

            $('.datatables-footer').addClass('hidden');

            // search page links
            $('.pagination li').each(function(index, link) {
                var link_href = $(link).find('a').attr('href');
                if(link_href) {
                    link_href += '&' + $('#searchForm').serialize();
                    $(link).find('a').attr('href', link_href);
                }
            });

            // select page length
            var pagelen = '<?php echo e($data['pagelen']); ?>';
            var sel_pagelen = $('select[name="group_datatable_length"]');
            $(sel_pagelen).val(pagelen);

            $('select[name="group_datatable_length"] option[value="-1"]').remove();
            $('select[name="group_datatable_length"]').on('change', function() {
                $('#pagelen').val($(this).val());
                window.location.href = '<?php echo e(url('/admin/group/')); ?>' + '?' + $('#searchForm').serialize();
            });
        });

        function search()
        {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            // compare date
            if((start_date != '') && (end_date != '')){
                var start= new Date(start_date);
                var end= new Date(end_date);
                if (start > end){
                    alert('登録日を正しく指定してください');
                    return;
                }
            }

            $('#searchForm').submit();
        }

        function reset()
        {
            $('input').val('');
            $('#start_date').val('');
            $('#end_date').val('');
            $('select').val('');
            
            $('#pagelen').val('<?php echo e($data['pagelen']); ?>');
            search();
        }

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>