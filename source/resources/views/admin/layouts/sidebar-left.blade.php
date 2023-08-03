<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">

    <div class="sidebar-header">
        <div class="sidebar-title">メニュー</div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">

                    <!-- home -->
                    <li class="{{Session::get('menu') =='home' ? 'nav-active' :'' }}">
                        <a href="{{ url('admin/') }}">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Home</span>
                        </a>
                    </li>

                    <!-- 管理 -->
                    <li class="nav-parent {{Session::get('menu') =='manage' ? 'nav-active nav-expanded' :'' }}">
                        <a>
                            <i class="fa fa-cogs" aria-hidden="true"></i>
                            <span>管理</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="{{Session::get('platform') == 'user' ? 'nav-active' : ''}}" >
                                <a href="{{ url('admin/user/') }}">
                                    <span>&nbsp;&nbsp;&nbsp;<i class="fa fa-building"></i>&nbsp;&nbsp;加盟店管理</span>
                                </a>
                            </li>
                            <li class="{{Session::get('platform') == 'shop' ? 'nav-active' : ''}}" >
                                <a href="{{ url('admin/shop') }}">
                                    <span>&nbsp;&nbsp;&nbsp;<i class="fa fa-user"></i>&nbsp;&nbsp;店舗管理</span>
                                </a>
                            </li>
                            <li class="{{Session::get('platform') == 'transaction' ? 'nav-active' : ''}}" >
                                <a href="{{ url('admin/transaction') }}">
                                    <span>&nbsp;&nbsp;&nbsp;<i class="fa fa-search"></i>&nbsp;&nbsp;決済検索</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- 精算-->
                    <li class="{{Session::get('menu') =='invoice' ? 'nav-active' :'' }}">
                        <a href="{{ url('admin/invoice') }}">
                            <i class="fa fa-files-o" aria-hidden="true"></i>
                            <span>精算</span>
                        </a>
                    </li>

                    <!-- 精算CSV-->
                    <li class="{{Session::get('menu') =='invoice-csv' ? 'nav-active' :'' }}">
                        <a href="{{ url('admin/invoice/csv') }}">
                            <i class="fa fa-download" aria-hidden="true"></i>
                            <span>精算CSV</span>
                        </a>
                    </li>


                    <!-- logout -->
                    <li class="{{Session::get('menu') =='logout' ? 'nav-active' :'' }}">
                        <a href="{{ url('admin/logout') }}">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            <span>ログアウト</span>
                        </a>
                    </li>

                </ul>
            </nav>

        </div>

        <script>
            // Maintain Scroll Position
            if (typeof localStorage !== 'undefined') {
                if (localStorage.getItem('sidebar-left-position') !== null) {
                    var initialPosition = localStorage.getItem('sidebar-left-position'),
                        sidebarLeft = document.querySelector('#sidebar-left .nano-content');

                    sidebarLeft.scrollTop = initialPosition;
                }
            }
        </script>

    </div>

</aside>
<!-- end: sidebar -->