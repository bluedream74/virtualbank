<!-- start: header -->
<header class="header">
    <div class="logo-container">
        <a href=" <?php echo e(url('admin')); ?>" class="logo" style="color: black;">
            <img src="<?php echo e(asset('public/customer/img/logo.png')); ?>" height="38" alt="Admin" />
        </a>
        <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <!-- start: user box -->
    <div class="header-right">

        <span class="separator"></span>

        <div id="userbox" class="userbox">
            <a href="#" data-toggle="dropdown">
                <figure class="profile-picture">
                    <i class="fa fa-user"></i>
                </figure>
                <div class="profile-info" data-lock-name="Admin" data-lock-email="admin@gamil.com">
                    <span class="name">管理者</span>
                </div>

                <i class="fa custom-caret"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled">
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="<?php echo e(url('admin/profile/edit')); ?>"><i class="fa fa-edit"></i> 情報編集</a>
                        <a role="menuitem" tabindex="-1" href="<?php echo e(url('admin/logout')); ?>"><i class="fa fa-power-off"></i> ログアウト</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>
<!-- end: header -->
