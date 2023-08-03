<?php $__env->startSection('title', '決済一覧 | VirtualBank'); ?>

<?php ($page_len = $datas['page_len']); ?>
<?php ($list = $datas['list']); ?>
<?php ($cards = $datas['card_type']); ?>
<?php ($methods = $datas['payment_method']); ?>

<?php ($start_date = $datas['start_date']); ?>
<?php ($end_date = $datas['end_date']); ?>
<?php ($shop_id = $datas['shop_id']); ?>
<?php ($shop_name = $datas['shop_name']); ?>

<?php ($success_count = $datas['success_count']); ?>
<?php ($success_amount = $datas['success_amount']); ?>
<?php ($refund_count = $datas['refund_count']); ?>
<?php ($refund_amount = $datas['refund_amount']); ?>
<?php ($cb_count = $datas['cb_count']); ?>
<?php ($cb_amount = $datas['cb_amount']); ?>

<?php $__env->startSection('content'); ?>
    <div role="main" class="main">

        <div class="top-container">

            <h2 class="header-title">決済一覧</h2>
            <form method="post" action="<?php echo e(url('/transaction/search')); ?>" id="searchForm">

                <div id="search_box">
                    <div  class="row input-container">
                        <div class="col-xs-5 p-none">
                            <input type="date" name="start_date" id="start_date" value="<?php echo e(date('Y-m-d', strtotime($start_date))); ?>" data-date="" data-date-format="YYYY-MM-DD" />
                            <input type="hidden" name="old_start_date" id="old_start_date" value="<?php echo e(date('Y-m-d', strtotime($start_date))); ?>" />
                        </div>

                        <div class="col-xs-2 from">～</div>
                        <div class="col-xs-5 p-none">
                            <input type="date" name="end_date" id="end_date" value="<?php echo e(date('Y-m-d', strtotime($end_date))); ?>" data-date="" data-date-format="YYYY-MM-DD" />
                            <input type="hidden" name="old_end_date" id="old_end_date" value="<?php echo e(date('Y-m-d', strtotime($end_date))); ?>" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 mb-md <?php if(Auth::user()->type != 3): ?> hidden <?php endif; ?>">
                            <div class="row form-group">
                                <label class="control-label col-xs-4 text-right" style="color: white;">店舗ID</label>
                                <div class="col-xs-8">
                                    <input class="form-control shop" name="shop_id" id="shop_id" value="<?php echo e($shop_id); ?>" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="control-label col-xs-4 text-right" style="color: white;">店舗名</label>
                                <div class="col-xs-8">
                                    <input class="form-control shop" name="shop_name" id="shop_name" value="<?php echo e($shop_name); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 text-center mb-md">
                            <button class="btn btn-default btn-green" style="width:300px; border: 2px solid #2d2d2d !important;">検索</button>
                        </div>
                    </div>
                </div>

            </form>

            <div id="transaction-list">

                <!-- links -->
                <div class="d-flex justify-content-center">
                    <?php echo e($list->links()); ?>

                </div>

                <!-- select -->
                <div class="row">
                    <div class="col-xs-12 text-center form-group <?php if(sizeof($list) == 0): ?> hidden <?php endif; ?>">
                        <form method="post" action="<?php echo e(url('transaction/pagelen')); ?>" id="postForm">
                            <select class="form-control" id="page_len" name="page_len" style="width: 150px; margin: 0 auto; height: 40px !important; padding: 0 5px;" onchange="changeLen(this)">
                                <option value="5" <?php if($page_len == 5): ?> selected <?php endif; ?>>5件表示</option>
                                <option value="10" <?php if($page_len == 10): ?> selected <?php endif; ?>>10件表示</option>
                                <option value="30" <?php if($page_len == 30): ?> selected <?php endif; ?>>30件表示</option>
                                <option value="50" <?php if($page_len == 50): ?> selected <?php endif; ?>>50件表示</option>
                                <option value="100" <?php if($page_len == 100): ?> selected <?php endif; ?>>100件表示</option>
                            </select>
                            <input id="start_date1" name="start_date1" value="<?php echo e($start_date); ?>" type="hidden"/>
                            <input id="end_date1" name="end_date1" value="<?php echo e($end_date); ?>" type="hidden"/>
                            <input id="shop_id1" name="shop_id1" value="<?php echo e($shop_id); ?>" type="hidden"/>
                            <input id="shop_name1" name="shop_name1" value="<?php echo e($shop_name); ?>" type="hidden"/>
                        </form>
                    </div>

                    <div class="col-xs-12 text-center <?php if(sizeof($list) > 0): ?> hidden <?php endif; ?>">
                        <p style="color: #e0e0e0;">決済履歴はありません。</p>
                    </div>
                </div>

                <!-- Start PC Version -->
                <div class="hidden-xs <?php if(sizeof($list) == 0): ?> hidden <?php endif; ?>" style="width: 96%; margin: 0 auto; background-color: white; overflow-x: auto">
                    <table width="100%" style="white-space: nowrap;">
                        <thead>
                        <tr>
                            <th class="text-center success" width="5%">ID</th>
                            <th class="text-center success" width="8%">決済日時</th>
                            <th class="text-center success <?php if(Auth::user()->type != 3): ?> hidden <?php endif; ?>" width="5%">店舗ID</th>
                            <th class="text-center success <?php if(Auth::user()->type != 3): ?> hidden <?php endif; ?>" width="5%">店舗名</th>
                            <th class="text-center success" width="5%">処理</th>
                            <th class="text-center success" width="7%">サービス料</th>
                            <th class="text-center success" width="7%">最低決済手数料</th>
                            <th class="text-center success" width="7%">加算決済手数料</th>
                            <th class="text-center success" width="8%">決済金額</th>
                            <th class="text-center success" width="5%">SMS送信</th>
                            <th class="text-center fail" width="7%">カード名義</th>
                            <th class="text-center fail" width="7%">ブランド</th>
                            <th class="text-center fail" width="7%">カード番号</th>
                            <th class="text-center fail" width="8%">有効期限</th>
                            <th class="text-center fail" width="9%">電話番号</th>
                            <th class="text-center fail" width="8%">決済種別</th>
                            <th class="text-center" width="10%" style="background-color: #ffffe1">支払いサイクル</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>t_<?php echo e($transaction->t_id); ?></td>
                                <td><?php echo e($transaction->created_at); ?></td>
                                <td class="<?php if(Auth::user()->type != 3): ?> hidden <?php endif; ?>"><?php echo e($transaction->username); ?></td>
                                <td class="<?php if(Auth::user()->type != 3): ?> hidden <?php endif; ?>"><?php echo e($transaction->uname); ?></td>
                                <td class="<?php if($transaction->status == '成功'): ?> success <?php else: ?> fail <?php endif; ?>">

                                    <?php if($transaction->status == '成功'): ?>
                                        <?php if(($transaction->child != 0) && ($transaction->parent == 0)): ?>
                                            <?php echo e($transaction->status); ?>(修正)
                                        <?php else: ?>
                                            <?php echo e($transaction->status); ?>

                                        <?php endif; ?>
                                    <?php elseif($transaction->status == '失敗'): ?>
                                        <?php echo e($transaction->status . '(' . $transaction->errorCode . ')'); ?>

                                    <?php else: ?>
                                        <?php echo e($transaction->status); ?>

                                    <?php endif; ?>

                                </td>
                                <td>¥<?php echo e(ceil($transaction->service_fee)); ?></td>
                                <td><?php echo e($transaction->low_fee); ?>%</td>
                                <td><?php echo e($transaction->card_fee); ?>%</td>
                                <td>¥<?php echo e(ceil($transaction->amount)); ?></td>
                                <td>¥<?php echo e($transaction->sms_amount); ?></td>
                                <td><?php echo e($transaction->card_holdername); ?></td>
                                
                                <td><?php echo e($transaction->cardtype); ?></td>
                                <td> **** **** **** <?php echo e(substr($transaction->card_number, -4)); ?></td>
                                <td><?php echo e($transaction->expiry_date); ?></td>
                                <td><?php echo e($transaction->phone); ?></td>
                                <td><?php echo e($transaction->payment_method); ?></td>
                                <td><?php echo e($transaction->pay_cycle); ?></td>
                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>

                    </table>
                </div>
                <!-- End PC Version -->

                <!-- Start Mobile Version -->
                <div class="visible-xs">

                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item <?php if($transaction->status != '成功'): ?> fail <?php else: ?> success <?php endif; ?>" onclick="showDetail(<?php echo e($transaction->id); ?>)">

                            <div class="row m-none p-none">

                                <div class="col-xs-3 text-center pl-xs">
                                    <p class="mt-xs" style="line-height: 1.2 !important;">

                                        <?php if($transaction->status == '成功'): ?>
                                            <?php if(($transaction->child != 0) && ($transaction->parent == 0)): ?>
                                                <?php echo e($transaction->status); ?><br>(修正)
                                            <?php else: ?>
                                                <?php echo e($transaction->status); ?>

                                            <?php endif; ?>
                                        <?php elseif($transaction->status == '失敗'): ?>
                                            <?php echo e($transaction->status); ?>  <br>  (<?php echo e($transaction->errorCode); ?>)
                                        <?php else: ?>
                                            <?php echo e($transaction->status); ?>

                                        <?php endif; ?>

                                    </p>
                                    <?php ($cardname = $cards[$transaction->cardtype_id-1]['name']); ?>
                                    <img src="<?php echo e(asset('public/customer/img/' . $cardname . '.png')); ?>" width="55"/>
                                </div>

                                <div class="col-xs-9">
                                    <div class="row">
                                        <div class="col-xs-11 p-none">
                                            <p><strong>決済日時:</strong>&nbsp; <?php echo e($transaction->created_at); ?></p>
                                            <p><strong>決済額: </strong>&nbsp; ¥<?php echo e(ceil($transaction->amount)); ?></p>
                                            <p><strong>カード名義人: </strong>&nbsp; <?php echo e($transaction->card_holdername); ?></p>
                                            <p><strong>携帯番号: </strong>&nbsp;<?php echo e($transaction->phone); ?></p>
                                        </div>
                                        <div class="col-xs-1 p-none" style="margin-top: 36px;">
                                            <i class="fa fa-caret-right" style="font-size: 26px;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <!-- End Mobile Version -->

                <!-- Total -->
                <div class="total-box" style="">
                    <table style="width: 100%; white-space: nowrap;">
                        <thead>
                            <tr>
                                <th width="20%"></th>
                                <th width="15%">成功件数</th>
                                <th width="15%" style="background-color: #ccffcc">成功</th>
                                <th width="13%">返金件数</th>
                                <th width="13%" style="background-color: #ccffcc">返金</th>
                                <th width="13%">CB件数</th>
                                <th width="13%" style="background-color: #ccffcc">CB</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>合計</td>
                                <td><?php echo e($success_count); ?></td>
                                <td style="background-color: #ccffcc">¥<?php echo e(ceil($success_amount)); ?></td>
                                <td><?php echo e($refund_count); ?></td>
                                <td style="background-color: #ccffcc">¥<?php echo e(ceil($refund_amount)); ?></td>
                                <td><?php echo e($cb_count); ?></td>
                                <td style="background-color: #ccffcc">¥<?php echo e(ceil($cb_amount)); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

        <!-- shop information -->
        <?php echo $__env->make('customer.layouts.info', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    </div>

    <?php $__env->stopSection(); ?>

<!-- Custom CSS -->
<?php $__env->startSection('page_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/customer/css/views/top.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/customer/vendor/jquery-ui/jquery-ui.css')); ?>">
<?php $__env->stopSection(); ?>

<!-- Custom JS -->
<?php $__env->startSection('page_js'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script>

        $("input[type='date']").on("change", function() {

            // check start_date
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var start = new Date(start_date);
            var end = new Date(end_date);
            if (start > end){
                $('#start_date').val($('#old_start_date').val());
                $('#end_date').val($('#old_end_date').val());
                alert('決済期間を正しく指定してください');
                return false;
            }
            else {
                $('#old_start_date').val($('#start_date').val());
                $('#old_end_date').val($('#end_date').val());
            }

            this.setAttribute("data-date", moment(this.value, "YYYY-MM-DD").format( this.getAttribute("data-date-format") ));

        }).trigger("change");

        // search page links
        $( document ).ready(function() {
            
            $('.pagination li').each(function(index, link) {
                var link_href = $(link).find('a').attr('href');
                if(link_href) {
                    link_href += '&' + $('#searchForm').serialize();
                    $(link).find('a').attr('href', link_href);
                }
            });
        });

    </script>

    <script src="<?php echo e(asset('public/customer/vendor/jquery-ui/jquery-ui.js')); ?>"></script>
    <script>

        /*$.datepicker.regional['ja'] = {
            "closeText": "Done",
            "prevText": "Prev",
            "nextText": "Next",
            "currentText": "Today",
            "monthNames": ["1月","2月","3月", "4月", "5月", "6月","7月", "8月","9月","10月", "11月","12月"],
            "monthNamesShort": ["Jan","Feb", "Mar", "Apr", "May","Jun","Jul", "Aug","Sep","Oct", "Nov","Dec"],
            "dayNames": [ "Sunday","Monday","Tuesday","Wednesday", "Thursday","Friday","Saturday"],
            "dayNamesShort": ["日","月","火", "水", "木", "金","土"],
            "dayNamesMin": ["日","月","火", "水", "木", "金","土"],
            "weekHeader": "Wk",
            "dateFormat": "yy/mm/dd",
            "firstDay": 0,
            "isRTL": false,
            "showMonthAfterYear": true,
            "yearSuffix": "年"
        };

        $.datepicker.setDefaults($.datepicker.regional['ja']);

        $(function() {
            var str_start_date = '<?php echo e($start_date); ?>';
            var str_end_date = '<?php echo e($end_date); ?>';
            $("#start_date").datepicker("setDate", new Date(str_start_date) );
            $("#end_date").datepicker("setDate", new Date(str_end_date) );
        });

        function showDate(obj) {
            $(obj).datepicker('show')
        }

        $("#start_date").datepicker({
            onSelect: function(dateText) {

                // check end_date
                var start_date = this.value;
                var end_date = $(".label-end").html();
                var start = new Date(start_date);
                var end = new Date(end_date);
                if (start > end){
                    alert('決済期間を正しく指定してください');
                    return;
                }

                $('.label-start').html(this.value);
            }
        });

        $("#end_date").datepicker({
            onSelect: function(dateText) {

                // check start_date
                var end_date = this.value;
                var start_date = $(".label-start").html();
                var start = new Date(start_date);
                var end = new Date(end_date);
                if (start > end){
                    alert('決済期間を正しく指定してください');
                    return;
                }

                $('.label-end').html(this.value);
            }
        });*/

        function showDetail(id)
        {
            var url = "<?php echo e(url('/transaction/')); ?>" + '/' + id;
            window.location.href = url;
        }

        function changeLen(obj)
        {
            $('#start_date1').val($('#start_date').val());
            $('#end_date1').val($('#end_date').val());
            $('#shop_id1').val($('#shop_id').val());
            $('#shop_name1').val($('#shop_name').val());
            $('#postForm').submit();
        }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('customer.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>