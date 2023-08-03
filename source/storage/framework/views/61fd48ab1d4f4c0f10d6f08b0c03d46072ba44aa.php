
<?php $__env->startSection('title', '店舗管理 | Virtual Bank'); ?>

<?php ( $list = $datas['list']); ?>
<?php ( $data = $datas['data']); ?>
<?php ( $arr_mids = \App\Models\Mid::all()); ?>

<?php $__env->startSection('content'); ?>

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <h2><i class="fa fa-user"></i>&nbsp;店舗管理</h2>
            <div class="right-wrapper pull-right">
                <ol class="breadcrumbs">
                    <li>
                        <a class="btn btn-danger" href="<?php echo e(url('admin/shop/create')); ?>" style="color:white;">新規店舗登録</a>
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

                    <form class="form-horizontal" action="<?php echo e(url('admin/shop/search/')); ?>" enctype="multipart/form-data" method="post" id="searchForm">

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

                            <div class="col-sm-1">
                                <label class="control-label pull-right">利用MID</label>
                            </div>

                            <div class="col-sm-1">
                                <select class="form-control" name="mid" id="mid">
                                    <option value=""></option>
                                    <?php $__currentLoopData = $arr_mids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($mid->id); ?>" <?php if($data['mid'] == $mid->id): ?> selected <?php endif; ?>><?php echo e($mid->id); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-sm-1">
                                <label class="control-label pull-right">後払い決済</label>
                            </div>

                            <div class="col-sm-1" style="width: 140px;">
                                <select class="form-control" name="atobarai" id="atobarai">
                                    <?php ($arr_atobarai = [0 => '利用不可', 1 => '利用可能', 2 => '一時停止']); ?>
                                    <option value=""></option>
                                    <?php $__currentLoopData = $arr_atobarai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $atobarai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(($data['atobarai'] != null) && ($data['atobarai'] == $key)): ?>
                                            <option value="<?php echo e($key); ?>" selected><?php echo e($atobarai); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo e($key); ?>"><?php echo e($atobarai); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
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
                                        <label>店舗ID</label>
                                        <input id="name" name="name" class="form-control" value="<?php echo e($data['name']); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>店舗名</label>
                                        <input id="s_name" name="s_name" class="form-control" value="<?php echo e($data['s_name']); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>店舗電話番号</label>
                                        <input type="number" id="s_tel" name="s_tel" class="form-control" value="<?php echo e($data['s_tel']); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>加盟店ID</label>
                                        <input type="text" id="member_id" name="member_id" class="form-control" value="<?php echo e($data['member_id']); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>メンズエステ</label>
                                        <select class="form-control" id="s_service" name="s_service">
                                            <option value=""></option>
                                            <option value="1" <?php if($data['s_service'] == '1'): ?> selected <?php endif; ?>>デリヘル</option>
                                            <option value="2" <?php if($data['s_service'] == '2'): ?> selected <?php endif; ?>>ソープランド</option>
                                            <option value="3" <?php if($data['s_service'] == '3'): ?> selected <?php endif; ?>>ヘルス</option>
                                            <option value="4" <?php if($data['s_service'] == '4'): ?> selected <?php endif; ?>>エステ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>支払いサイクル</label>
                                        <select class="form-control" id="s_paycycle" name="s_paycycle">
                                            <option value=""></option>
                                            <option value="1" <?php if($data['s_paycycle'] == '1'): ?> selected <?php endif; ?>>月１支払い</option>
                                            <option value="2" <?php if($data['s_paycycle'] == '2'): ?> selected <?php endif; ?>>月２支払い</option>
                                            <option value="3" <?php if($data['s_paycycle'] == '3'): ?> selected <?php endif; ?>>週１支払い</option>
                                            <option value="4" <?php if($data['s_paycycle'] == '4'): ?> selected <?php endif; ?>>毎日支払い</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>契約状態</label>
                                        <select class="form-control" id="s_status" name="s_status">
                                            <option value=""></option>
                                            <option value="審査中" <?php if($data['s_status'] == '審査中'): ?> selected <?php endif; ?>>審査中</option>
                                            <option value="契約中" <?php if($data['s_status'] == '契約中'): ?> selected <?php endif; ?>>契約中</option>
                                            <option value="解約" <?php if($data['s_status'] == '解約'): ?> selected <?php endif; ?>>解約</option>
                                            <option value="休止" <?php if($data['s_status'] == '休止'): ?> selected <?php endif; ?>>休止</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>

                <!-- table -->
                <table class="table table-bordered table-striped text-center" id="shop_datatable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center" width="5%">ID</th>
                            <th class="text-center" width="10%">登録日</th>
                            <th class="text-center" width="10%">店舗ID</th>
                            <th class="text-center" width="10%">店舗名</th>
                            <th class="text-center" width="10%">電話番号</th>
                            <th class="text-center" width="10%">加盟店ID</th>
                            <th class="text-center" width="15%">メンズエステ</th>
                            <th class="text-center" width="10%">支払いサイクル</th>
                            <th class="text-center" width="10%">後払い決済</th>
                            <th class="text-center" width="12%">契約状況</th>
                            <th class="text-center" width="8%">利用MID</th>
                            <th class="text-center hidden" width="10%">削除</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php ( $index = 1 ); ?>
                        <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index); ?></td>
                                <td><?php echo e(substr($shop->created_at,0,10)); ?></td>
                                <td><a class="link" href="<?php echo e(url('admin/shop/edit/' . $shop->id)); ?>"><?php echo e($shop->name); ?></a></td>
                                <td><a class="link" href="<?php echo e(url('admin/shop/edit/' . $shop->id)); ?>"><?php echo e($shop->s_name); ?></a></td>
                                <td><?php echo e($shop->s_tel); ?></td>
                                <td><?php echo e($shop->member_id); ?></td>
                                <td>
                                    <?php $__currentLoopData = $shop->service_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        「<?php echo e($service->service_name); ?>」
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td><?php echo e($shop->s_paycycle_name); ?></td>
                                <td>
                                    <?php ($arr_atobarai = ['利用不可', '利用可能', '一時停止']); ?>
                                    <?php echo e($arr_atobarai[$shop->atobarai]); ?>

                                </td>
                                <td><?php echo e($shop->s_status); ?></td>
                                <td><?php echo e($shop->mid); ?></td>
                                <td class="hidden">
                                    <a class="btn btn-danger remove-row" data-plugin-tooltip data-toggle="tooltip" data-placement="top" data-original-title="削除" data-url="<?php echo e(url('/admin/shop/delete/' .$shop->id)); ?>"><i class="fa fa-trash" style="color: white;"></i></a>
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
                <h2 class="panel-title">店舗削除</h2>
            </header>
            <div class="panel-body">
                <div class="modal-wrapper">
                    <div class="modal-text">
                        <p>この店舗を削除しますか?</p>
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
    <script src="<?php echo e(asset('public/admin/js/views/shop.js')); ?>"></script>

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
            var sel_pagelen = $('select[name="shop_datatable_length"]');
            $(sel_pagelen).val(pagelen);

            $('select[name="shop_datatable_length"] option[value="-1"]').remove();
            $('select[name="shop_datatable_length"]').on('change', function() {
                $('#pagelen').val($(this).val());
                window.location.href = '<?php echo e(url('/admin/shop/')); ?>' + '?' + $('#searchForm').serialize();
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