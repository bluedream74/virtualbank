<?php $__env->startSection('title', '店舗管理 | Virtual Bank'); ?>

<?php ($list = $datas['list']); ?>
<?php ($year = $datas['year']); ?>
<?php ($month = $datas['month']); ?>
<?php ($pagelen = $datas['pagelen']); ?>
<?php ($arr_paycycle = \App\Models\PayCycle::all()); ?>

<?php $__env->startSection('content'); ?>

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-4">
                    <h2><i class="fa fa-home"></i>&nbsp;&nbsp;店舗管理</h2>
                </div>
            </div>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">

                <?php ($user = Auth::guard('group')->user()); ?>
                <?php if($user->type == 3): ?>
                    <?php ($group = App\Models\Group::getGroupByName($user->name)); ?>
                    <?php ($kind = $group->g_kind); ?>
                <?php else: ?>
                    <?php ($kind = '代理店'); ?>
                <?php endif; ?>

                <!-- year, month -->
                <div class="form-group">
                    <form method="post" action="<?php echo e(url('group/shop/search')); ?>" id="searchForm" style="display:inline-flex; width: 240px; margin-left: calc(50% - 120px);">
                        <input id="pagelen" name="pagelen" type="hidden" class="form-control" value="<?php echo e($pagelen); ?>" />
                        <select id="year" name="year" value="<?php echo e($year); ?>" class="form-control" style="width: 120px; border-radius: 0;" onchange="search()">
                            <option value="">年</option>
                            <?php for($i=date('Y');$i>2020;$i--): ?>
                            <option value="<?php echo e($i); ?>" <?php if($i== $year): ?> selected <?php endif; ?>><?php echo e($i); ?>年</option>
                            <?php endfor; ?>
                        </select>
                        <select id="month" name="month" value="<?php echo e($month); ?>" class="form-control" style="width: 120px; border-radius: 0;" onchange="search()">
                            <option value="">月</option>
                            <?php for($i=1; $i < 13; $i++): ?>
                            <option value="<?php echo e($i); ?>" <?php if($i == $month): ?> selected <?php endif; ?>><?php echo e($i); ?>月</option>
                            <?php endfor; ?>
                        </select>
                    </form>
                </div>

                <!-- help -->
                <div id="help">
                    <table id="help-table">
                        <tbody>
                            <tr>
                                <td width="30%" class="text-center">クレジット決済金額</td>
                                <td width="70%">指定した「年/月」のクレジット決済の<span class="blue">成功</span>のみを集計しています。</td>
                            </tr>
                            <tr>
                                <td width="30%" class="text-center">後払い金額</td>
                                <td width="70%">指定した「年/月」の後払い決済の<span class="blue">成功</span>のみを集計しています。</td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="mt-xs" style="color: black">※「取消/CB」は最新月の集計から減算されます。</p>
                </div>
                

                <!-- table -->
                <table class="table table-bordered table-striped text-center" id="shop_datatable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center" width="5%" style="background-color: #ccffff;">ID</th>
                            <th class="text-center" width="10%" style="background-color: #ccffff;">店舗ID</th>
                            <th class="text-center" width="10%" style="background-color: #ccffff;">店舗名</th>
                            <th class="text-center" width="10%" style="background-color: #ccffff;">契約状況</th>
                            <th class="text-center" width="10%" style="background-color: #ffffe1">支払いサイクル</th>
                            <th class="text-center" width="10%" style="background-color: #ccffff;">クレジット決済金額</th>
                            <th class="text-center" width="10%" style="background-color: #ccffff;">後払い金額</th>
                            <th class="text-center <?php if($kind == '代理店'): ?> hidden <?php endif; ?>" width="10%" style="background-color: #ccffcc;">精算書</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php ($index = 1); ?>
                        <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index); ?></td>
                                <td><?php echo e($user->name); ?></td>
                                <td>
                                    <?php if($kind != '代理店'): ?>
                                        <a class="link" onclick="loginShop('<?php echo e($user->name); ?>')"><?php echo e($user->s_name); ?></a>
                                    <?php else: ?>
                                        <?php echo e($user->s_name); ?>

                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($user->status); ?></td>
                                <td><?php echo e($arr_paycycle[$user->pay_cycle-1]['name']); ?></td>
                                <td>
                                    <?php if($user->success_sum[0]['amount'] >= 0): ?>
                                        ¥<?php echo e(ceil($user->success_sum[0]['amount'])); ?>

                                    <?php else: ?>
                                        ー¥<?php echo e(abs(ceil($user->success_sum[0]['amount']))); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($user->success_sum_atobarai[0]['amount'] >= 0): ?>
                                        ¥<?php echo e(ceil($user->success_sum_atobarai[0]['amount'])); ?></td>
                                    <?php else: ?>
                                        ー¥<?php echo e(abs(ceil($user->success_sum_atobarai[0]['amount']))); ?>

                                    <?php endif; ?>
                                <td class="<?php if($kind == '代理店'): ?> hidden <?php endif; ?>">
                                    <a class="link" onclick="showInvoice('<?php echo e($user->name); ?>')">精算書</a>
                                </td>
                            </tr>
                            <?php ($index++); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>

                </table>

                <!-- links -->
                <div class="d-flex justify-content-center" style="float: right">
                    <?php echo e($list->links()); ?>

                </div>

                <!-- login form -->
                <form action="<?php echo e(url('/group/shop/switch')); ?>" method="post" class="hidden" id="login-form">
                    <?php echo e(csrf_field()); ?>

                    <input type="text" name="name" id="name" class="form-control input-lg" placeholder="ログインID">
                </form>

                 <!-- invoice form -->
                 <form action="<?php echo e(url('/group/shop/invoice')); ?>" method="post" class="hidden" id="invoice-form">
                    <?php echo e(csrf_field()); ?>

                    <input type="text" name="shop_name" id="shop_name" class="form-control input-lg">
                </form>

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
    <script src="<?php echo e(asset('public/group/js/views/shop.js')); ?>"></script>
    <script>

        $( document ).ready(function() {
            var s_width = $( window ).width() - 320;
            $('.panel-body').width(s_width);
            $('#shop_datatable_filter').addClass('hidden');
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
            var sel_pagelen = $('select[name="shop_datatable_length"]');
            $(sel_pagelen).val(pagelen);

            $('select[name="shop_datatable_length"] option[value="-1"]').remove();
            $(sel_pagelen).on('change', function() {
                $('#pagelen').val($(this).val());
                window.location.href = '<?php echo e(url('/group/shop/')); ?>' + '?' + $('#searchForm').serialize();
            });
        });

        $(window).resize(function() {
            var s_width = $( window ).width() - 320;
            $('.panel-body').width(s_width);
        });

        function search()
        {
            var year = $('#year').val();
            var month = $('#month').val();
            $('#searchForm').submit();
        }

        function loginShop(shop_id)
        {
            $('#name').val(shop_id);
            $('#login-form').submit();
        }

        function showInvoice(shop_name)
        {
            $('#shop_name').val(shop_name);
            $('#invoice-form').submit();

            /*$.ajax({
                type: "POST",
                url: "<?php echo e(url('group/shop/invoice')); ?>",
                data: {shop_name: shop_name},
                dataType: 'JSON',
                success: function(response) {
                    var Backlen= history.length;
                    history.go(-Backlen);
                    window.location.href = response['url'];
                }
            });*/
        }
        
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('group.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>