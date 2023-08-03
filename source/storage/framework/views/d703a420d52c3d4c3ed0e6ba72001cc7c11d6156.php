
<?php $__env->startSection('title', '加盟店管理 | Virtual Bank'); ?>

<?php ( $list = $datas['list']); ?>
<?php ( $data = $datas['data']); ?>

<?php $__env->startSection('content'); ?>

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <h2><i class="fa fa-building"></i>&nbsp;加盟店管理</h2>
            <div class="right-wrapper pull-right">
                <a href="<?php echo e(url('admin/user/create')); ?>" class="btn btn-danger" style="margin: 7px 10px">新規加盟店登録</a>
                <a class="btn btn-warning" onclick="downloadCSV()" style="margin: 7px 10px">CSV出力</a>
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

                    <form class="form-horizontal" action="<?php echo e(url('admin/user/search/')); ?>" enctype="multipart/form-data" method="post" id="searchForm">

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

                            <div class="col-sm-6 pull-right text-right">
                                <button onclick="search()" class="btn btn-success" style="width: 120px;">検索開始</button>
                                <a onclick="reset()" class="btn btn-default" style="width: 100px; margin-left: 10px;">リセット</a>
                            </div>

                        </div>

                        <div class="row" style="padding: 0">

                            <div class="col-sm-4 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>加盟店ID</label>
                                        <input id="name" name="name" class="form-control" value="<?php echo e($data['name']); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>加盟店名（契約者名）</label>
                                        <input id="u_name" name="u_name" class="form-control" value="<?php echo e($data['u_name']); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>電話番号</label>
                                        <input type="number" id="u_tel" name="u_tel" class="form-control" value="<?php echo e($data['u_tel']); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>加盟店メールアドレス</label>
                                        <input type="email" id="u_email" name="u_email" class="form-control" value="<?php echo e($data['u_email']); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>口座名義人（フリガナ）</label>
                                        <input type="text" id="u_holdername_fu" name="u_holdername_fu" class="form-control" value="<?php echo e($data['u_holdername_fu']); ?>" onkeypress="toKata(this)"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 mt-md">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>契約状態</label>
                                        <select class="form-control" id="u_status" name="u_status">
                                            <option value=""></option>
                                            <option value="審査中" <?php if($data['u_status'] == '審査中'): ?> selected <?php endif; ?>>審査中</option>
                                            <option value="契約中" <?php if($data['u_status'] == '契約中'): ?> selected <?php endif; ?>>契約中</option>
                                            <option value="解約" <?php if($data['u_status'] == '解約'): ?> selected <?php endif; ?>>解約</option>
                                            <option value="休止" <?php if($data['u_status'] == '休止'): ?> selected <?php endif; ?>>休止</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>

                <!-- table -->
                <table class="table table-bordered table-striped text-center" id="user_datatable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center" width="5%">ID</th>
                            <th class="text-center" width="10%">登録日</th>
                            <th class="text-center" width="12%">加盟店ID</th>
                            <th class="text-center" width="20%">加盟店名</th>
                            <th class="text-center" width="13%">店舗数(紐づいている)</th>
                            <th class="text-center" width="10%">契約状況</th>
                            <th class="text-center" width="10%">金融機関コード</th>
                            <th class="text-center" width="15%">加盟店メールアドレス</th>
                            <th class="text-center last-child hidden" width="5%">削除</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php ( $index = 1 ); ?>
                        <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center"><?php echo e($index); ?></td>
                                <td class="text-center"><?php echo e(substr($item->created_at,0,10)); ?></td>
                                <td class="text-center"><a class="link" href="<?php echo e(url('admin/user/edit/' . $item->id)); ?>"><?php echo e($item->name); ?></a></td>
                                <td class="text-center"><a class="link" href="<?php echo e(url('admin/user/edit/' . $item->id)); ?>"><?php echo e($item->u_name); ?></a></td>
                                <td class="text-center">
                                    <?php if($item->shops > 0): ?>
                                        <a href="<?php echo e(url('admin/user/shops/' . $item->id)); ?>" style="color: white;padding: 5px 10px; border-radius: 15px;background-color: orange"><?php echo e($item->shops); ?></a>
                                    <?php else: ?>
                                        0
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo e($item->u_status); ?></td>
                                <td class="text-center"><?php echo e($item->u_bankcode); ?></td>
                                <td class="text-center"><?php echo e($item->u_email); ?></td>
                                <td class="text-center last-child hidden">
                                    <a class="btn btn-danger remove-row" data-plugin-tooltip data-toggle="tooltip" data-placement="top" data-original-title="削除" data-url="<?php echo e(url('admin/user/delete/' .$item->id)); ?>"><i class="fa fa-trash"></i></a>
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
                <h2 class="panel-title">加盟店削除</h2>
            </header>
            <div class="panel-body">
                <div class="modal-wrapper">
                    <div class="modal-text">
                        <p>この加盟店を削除しますか?<br>紐づいている店舗も削除します。</p>
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

    <script src="https://unpkg.com/wanakana"></script>
    <script src="<?php echo e(asset('public/admin/js/views/user.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/table2CSV.js')); ?> "></script>
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
            var sel_pagelen = $('select[name="user_datatable_length"]');
            $(sel_pagelen).val(pagelen);

            $('select[name="user_datatable_length"] option[value="-1"]').remove();
            $('select[name="user_datatable_length"]').on('change', function() {
                $('#pagelen').val($(this).val());
                window.location.href = '<?php echo e(url('/admin/user/')); ?>' + '?' + $('#searchForm').serialize();
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

        function downloadCSV()
        {
            var strYear =  ((new Date()).getYear() - 100) + 2000;
            var strMonth =  (new Date()).getMonth() + 1;
            var strDate =  (new Date()).getDate();

            $('.last-child').addClass('hidden');
            var csv = $('#user_datatable').table2CSV({
                delivery: 'value'
            });

            var encodedUri = 'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURIComponent(csv);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "merchant_" + strYear + '_' + strMonth + '_' + strDate + ".csv");
            link.click();

            $('.last-child').removeClass('hidden');
        }

        function toKata(inputObj)
        {
            var inp_val = wanakana.toKatakana($(inputObj).val());
            $(inputObj).val(inp_val);
        }

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>