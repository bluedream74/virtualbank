@php($support_company = \App\Models\Setting::company())
@php($support_phone = \App\Models\Setting::phone())
@php($support_email = \App\Models\Setting::email())

<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">

    <div class="sidebar-header">

        <div class="sidebar-title">

            <table width="100%">
                <tbody>
                    <tr>
                        <td width="30%">グループ名</td>
                        <td style="font-weight: normal">{{ Auth::guard('group')->user()->username }}</td>
                    </tr>
                    <tr>
                        <td width="30%">グループID</td>
                        <td style="font-weight: normal">{{ Auth::guard('group')->user()->name }}</td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">

                    @php( $user = Auth::guard('group')->user())
                    @if($user->type == 3)
                        @php($group = \App\Models\Group::getGroupByName($user->name))
                        @if($group->g_kind == 'グループ店')
                            <!-- 決済検索-->
                            <li class="{{Session::get('menu') =='transaction' ? 'nav-active' :'' }}">
                                <a href="{{ url('group/transaction') }}">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    <span>決済検索</span>
                                </a>
                            </li>
                        @endif
                    @endif
                    
                    <!-- 店舗管理-->
                    <li class="{{Session::get('menu') =='shop' ? 'nav-active' :'' }}">
                        <a href="{{ url('group/shop') }}">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>店舗管理</span>
                        </a>
                    </li>
                    

                    <!-- logout -->
                    <li class="{{Session::get('menu') =='logout' ? 'nav-active' :'' }}">
                        <a href="{{ url('group/logout') }}">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            <span>ログアウト</span>
                        </a>
                    </li>

                </ul>
            </nav>

            <div class="contact">
                <div class="box">
                    <p class="title text-center">お問い合わせ</p>
                    <p class="info text-center">{{ $support_company }}<br>{{ $support_email }}<br><i class="fa fa-phone"></i>&nbsp;&nbsp;{{ $support_phone }}</p>
                </div>
            </div>
        </div>

    </div>

</aside>
<!-- end: sidebar -->

<script>

    function popupPayment(url){

        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

        const w = 400;
        const h = 1000;

        const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left = (width - w) / 2 / systemZoom + dualScreenLeft
        const top = (height - h) / 2 / systemZoom + dualScreenTop

        window.open(url, '_blank', `scrollbars=yes,
                width=${w / systemZoom},
                height=${h / systemZoom},
                top=${top},
                left=${left}
        `);
    }

</script>