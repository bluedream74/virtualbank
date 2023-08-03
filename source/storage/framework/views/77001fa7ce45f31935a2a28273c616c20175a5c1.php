<?php $__env->startSection('title', '精算書 | VirtualBank'); ?>

<?php ($invoice_date = $datas['date']); ?>
<?php ($list = $datas['list']); ?>

<?php $__env->startSection('content'); ?>

<div role="main" class="main">

        <div class="top-container">

            <h2 class="header-title">精算書</h2>

            <form method="post" action="<?php echo e(url('/invoice/search')); ?>">
                <div class="row input-container form-group" id="select_month">
                    <div class="col-xs-12 text-center" >
                        <p>決済期間</p>
                        <input type="month" name="month" class="input-lg" value="<?php echo e(date('Y-m', strtotime($invoice_date))); ?>" data-date="" data-date-format="YYYY年MM月"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 text-center mb-md">
                        <button class="btn btn-default btn-green" style="width:170px; border: 2px solid #2d2d2d !important;">検索</button>
                    </div>
                </div>
            </form>

            <!-- Invoice Table -->
            <div id="invoice_box" class="hidden-xs">
                <table>
                    <?php ($index = 1); ?>
                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td width="15%" style="font-weight: bold">決済期間</td>
                            <td width="45%"><a href="<?php echo e(url('invoice/detail/' . $item['year'] . '/' .$item['start_date'] . '/' . $item['end_date'] . '/' . $item['output_date'] . '/' . $item['month_fee'])); ?>"><?php echo e($item['period']); ?></a></td>
                            <td width="18%" style="font-weight: bold">ご入金予定日</td>
                            <td width="22%"><?php echo e($item['output_date']); ?></td>
                        </tr>
                        <?php ($index++); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            </div>

            <div id="invoice_box" class="visible-xs p-sm">
                <table>
                    <thead>
                        <th>決済期間</th>
                        <th>ご入金予定日</th>
                    </thead>
                    <?php ($index = 1); ?>
                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <?php if($index < sizeof($list)): ?>
                                <td width="65%"><a href="<?php echo e(url('invoice/detail/' . $item['year'] . '/' .$item['start_date'] . '/' . $item['end_date'] . '/' . $item['output_date']) . '/0'); ?>"><?php echo e($item['period']); ?></a></td>
                            <?php else: ?>
                                <td width="65%"><a href="<?php echo e(url('invoice/detail/' . $item['year'] . '/' .$item['start_date'] . '/' . $item['end_date'] . '/' . $item['output_date']) . '/1'); ?>"><?php echo e($item['period']); ?></a></td>
                            <?php endif; ?>
                            <td width="35%"><?php echo e($item['output_date']); ?></td>
                        </tr>
                        <?php ($index++); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            </div>


        </div>

</div>

<?php $__env->stopSection(); ?>

<!-- Custom CSS -->
<?php $__env->startSection('page_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/customer/css/views/top.css')); ?>">
<?php $__env->stopSection(); ?>

<!-- Custom JS -->
<?php $__env->startSection('page_js'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script>

        $("input").on("change", function() {
            this.setAttribute("data-date", moment(this.value, "YYYY-MM-DD").format( this.getAttribute("data-date-format") ));
        }).trigger("change");

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>