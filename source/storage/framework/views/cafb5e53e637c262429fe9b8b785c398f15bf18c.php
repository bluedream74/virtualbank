<?php $__env->startSection('title', '決済検索 | Virtual Bank'); ?>

<?php ($list = $datas['list']); ?>
<?php ($start_date = $datas['start_date']); ?>
<?php ($end_date = $datas['end_date']); ?>
<?php ($shop_id = $datas['shop_id']); ?>
<?php ($pagelen = $datas['pagelen']); ?>
<?php ($arr_cycle = \App\Models\PayCycle::all()); ?>

<?php $__env->startSection('content'); ?>

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-4">
                    <h2><i class="fa fa-search"></i>&nbsp;&nbsp;決済検索</h2>
                </div>
                <div class="form-group" id="search_box">
                    <form method="post" action="<?php echo e(url('group/transaction/search')); ?>" id="searchForm" style="float: left;">
                        <input id="pagelen" name="pagelen" type="hidden" class="form-control" value="<?php echo e($pagelen); ?>" />
                        <label>店舗ID</label>
                        <input type="text" id="shop_id" name="shop_id" value="<?php echo e($shop_id); ?>" class="form-control mr-xlg"/>
                        <label>決済期間</label>
                        <input type="date" id="start_date" name="start_date" value="<?php echo e($start_date); ?>" class="form-control"/>
                        <label>～</label>
                        <input type="date" id="end_date" name="end_date" value="<?php echo e($end_date); ?>" class="form-control" />
                    </form>
                    <button class="btn btn-default btn-gold" style="border-radius: 5px;" onclick="search()">検索</button>
                    <a class="btn btn-white ml-xs" style="width: 100px; border: 1px solid #ccc; color: #000000" onclick="reset()" >リセット</a>
                </div>
            </div>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">

                <!-- table -->
                <table class="table table-bordered table-striped text-center" id="transaction_datatable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center" width="5%" style="background-color: #ccffff;">ID</th>
                            <th class="text-center" width="5%" style="background-color: #ccffff;">店舗ID</th>
                            <th class="text-center" width="10%" style="background-color: #ccffff;">店舗名</th>
                            <th class="text-center" width="8%" style="background-color: #ccffff;">決済日時</th>
                            <th class="text-center" width="7%" style="background-color: #ccffff;">処理</th>
                            <th class="text-center" width="7%" style="background-color: #ccffff;">サービス料</th>
                            <th class="text-center" width="7%" style="background-color: #ccffff;">最低決済手数料</th>
                            <th class="text-center" width="7%" style="background-color: #ccffff;">加算決済手数料</th>
                            <th class="text-center" width="10%" style="background-color: #ccffff;">SMS送信</th>
                            <th class="text-center" width="7%" style="background-color: #ccffcc;">カード名義</th>
                            <th class="text-center" width="7%" style="background-color: #ccffcc;">ブランド</th>
                            <th class="text-center" width="7%" style="background-color: #ccffcc;">カード番号</th>
                            <th class="text-center" width="8%" style="background-color: #ccffcc;">有効期限</th>
                            <th class="text-center" width="9%" style="background-color: #ccffcc;">電話番号</th>
                            <th class="text-center" width="8%" style="background-color: #ccffcc;">決済種別</th>
                            <th class="text-center" width="10%" style="background-color: #ffffe1">支払いサイクル</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>t_<?php echo e($transaction->t_id); ?></td>
                            <td><?php echo e($transaction->username); ?></td>
                            <td><?php echo e($transaction->uname); ?></td>
                            <td><?php echo e($transaction->created_at); ?></td>
                            <td class="<?php if($transaction->status == '成功'): ?> successed <?php else: ?> fail <?php endif; ?>">

                                <?php if($transaction->status == '成功'): ?>
                                    <?php if(($transaction->child != 0) && ($transaction->parent == 0)): ?>
                                        <?php echo e($transaction->status); ?>(修正)
                                    <?php else: ?>
                                        <?php echo e($transaction->status); ?>

                                    <?php endif; ?>
                                <?php elseif($transaction->status == '失敗'): ?>
                                    <?php if($transaction->errorCode): ?>
                                        <?php echo e($transaction->status); ?>(<?php echo e($transaction->errorCode); ?>)
                                    <?php else: ?>
                                        <?php echo e($transaction->status); ?>

                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php echo e($transaction->status); ?>

                                <?php endif; ?>

                            </td>
                            <td>¥<?php echo e(ceil($transaction->service_fee)); ?></td>
                            <td><?php echo e($transaction->low_fee); ?>%</td>
                            <td><?php echo e($transaction->card_fee); ?>%</td>
                            <td>¥<?php echo e($transaction->sms_amount); ?></td>
                            <td><?php echo e($transaction->card_holdername); ?></td>
                            <td><?php echo e($transaction->cardtype); ?></td>
                            <td> **** **** **** <?php echo e(substr($transaction->card_number, -4)); ?></td>
                            <td><?php echo e($transaction->expiry_date); ?></td>
                            <td><?php echo e($transaction->phone); ?></td>
                            <td><?php echo e($transaction->payment_method); ?></td>
                            <td>
                                <?php echo e($arr_cycle[$transaction->pay_cycle-1]['name']); ?>

                            </td>
                        </tr>
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

<?php $__env->stopSection(); ?>

<!-- Custom CSS -->
<?php $__env->startSection('page_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/vendor/jquery-ui/jquery-ui.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/vendor/jquery-ui/jquery-ui.theme.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/vendor/select2/css/select2.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/vendor/select2-bootstrap-theme/select2-bootstrap.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/vendor/jquery-datatables-bs3/assets/css/datatables.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('public/merchant/css/common.css')); ?>" />
<?php $__env->stopSection(); ?>

<!-- Custom JS -->
<?php $__env->startSection('page_js_vendor'); ?>
    <script src="<?php echo e(asset('public/merchant/vendor/jquery-ui/jquery-ui.js')); ?>"></script>
    <script src="<?php echo e(asset('public/merchant/vendor/jquery-datatables/media/js/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('public/merchant/vendor/jquery-datatables-bs3/assets/js/datatables.js')); ?>"></script>
    <script src="<?php echo e(asset('public/group/js/views/transaction.js')); ?>"></script>
    <script>

        $( document ).ready(function() {
            var s_width = $( window ).width() - 320;
            $('.panel-body').width(s_width);

            $('.datatables-footer').addClass('hidden');
            $('.pagination').addClass('mb-none');

            // search page links
            $('.pagination li').each(function(index, link) {
                var link_href = $(link).find('a').attr('href');
                if(link_href) {
                    link_href += '&' + $('#searchForm').serialize();
                    $(link).find('a').attr('href', link_href);
                }
            });

            // select page length
            var pagelen = '<?php echo e($pagelen); ?>';
            var sel_pagelen = $('select[name="transaction_datatable_length"]');
            $(sel_pagelen).val(pagelen);

            $('select[name="transaction_datatable_length"] option[value="-1"]').remove();
            $(sel_pagelen).on('change', function() {
                $('#pagelen').val($(this).val());
                window.location.href = '<?php echo e(url('/group/transaction/')); ?>' + '?' + $('#searchForm').serialize();
            });
        });

        $(window).resize(function() {
            var s_width = $( window ).width() - 320;
            $('.panel-body').width(s_width);
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
                    alert('決済期間を正しく指定してください');
                    return;
                }
            }

            $('#searchForm').submit();
        }

        function reset()
        {
            $('#start_date').val('');
            $('#end_date').val('');
            $('#shop_id').val('');

            $('#searchForm').submit();
        }

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('group.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>