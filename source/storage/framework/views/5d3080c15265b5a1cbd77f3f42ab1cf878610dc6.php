<header id="page-top">

  <div class="inner-header">
        <a class="logo-link" href="<?php echo e(url('/')); ?>" style="text-align: left"><img src="<?php echo e(asset('public/customer/img/logo.png')); ?>" width="55%" style="max-width: 450px;"></a>
        <?php if(Auth::check() && (url()->current() != url('/'))): ?>
            <a href="<?php echo e(url('/')); ?>" class="btn-top text-center" id="goto_top">TOP</a>
        <?php endif; ?>
  </div>
</header>

