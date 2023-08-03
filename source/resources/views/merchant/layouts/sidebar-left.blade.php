<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">

    <div class="sidebar-header">

        <div class="sidebar-title">

            <table width="100%">
                <tbody>
                    <tr>
                        <td width="30%">店舗名</td>
                        <td style="font-weight: normal">{{ Auth::guard('merchant')->user()->username }}</td>
                    </tr>
                    <tr>
                        <td width="30%">店舗ID</td>
                        <td style="font-weight: normal">{{ Auth::guard('merchant')->user()->name }}</td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">

                    <!-- QR決済 -->
                    <li class="{{Session::get('menu') =='qr' ? 'nav-active' :'' }}">
                        <a href="{{ url('merchant/qr-payment') }}">
                            <i class="fa fa-qrcode" aria-hidden="true"></i>
                            <span>QR決済</span>
                        </a>
                    </li>

                    <!-- SMS決済-->
                    <li class="{{Session::get('menu') =='sms' ? 'nav-active' :'' }}">
                        <a href="{{ url('merchant/sms-payment') }}">
                            <i class="fa fa-comments" aria-hidden="true"></i>
                            <span>SMS決済</span>
                        </a>
                    </li>

                    <!-- 直接入力決済-->
                    <li class="{{Session::get('menu') =='payment' ? 'nav-active' :'' }}">
                        <a onclick="popupPayment('{{ Session::get('payment_url') }}')">
                            <i class="fa fa-credit-card" aria-hidden="true"></i>
                            <span>直接入力決済</span>
                        </a>
                    </li>

                    <!-- 決済検索-->
                    <li class="{{Session::get('menu') =='transaction' ? 'nav-active' :'' }}">
                        <a href="{{ url('merchant/transaction') }}">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <span>決済検索</span>
                        </a>
                    </li>

                    <!-- 店舗の決済一覧-->
                    @if(Auth::guard('merchant')->user()->type == '1')
                        <li id="transaction-shop" class="{{Session::get('menu') =='transaction-shop' ? 'nav-active' :'' }}">
                            <a href="{{ url('merchant/transaction/shop') }}">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                <span>店舗の決済一覧</span>
                            </a>
                        </li>
                    @endif

                    <!-- 設定-->
                    <li class="nav-parent {{Session::get('menu') =='setting' ? 'nav-active nav-expanded' :'' }}">
                        <a>
                            <i class="fa fa-cogs" aria-hidden="true"></i>
                            <span>設定</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="{{Session::get('platform') == 'fee' ? 'nav-active' : ''}}" >
                                <a href="{{ url('merchant/fee-setting/') }}">
                                    <span>&nbsp;&nbsp;&nbsp;<i class="fa fa-yen"></i>手数料設定</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <!-- logout -->
                    <li class="{{Session::get('menu') =='logout' ? 'nav-active' :'' }}">
                        <a href="{{ url('merchant/logout') }}">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            <span>ログアウト</span>
                        </a>
                    </li>

                </ul>
            </nav>

            <div class="contact">
                <div class="box">
                    <p class="title text-center">お問合せ先</p>
                    <p class="info text-center">support@smart-payment.co.jp<br><i class="fa fa-phone"></i>&nbsp;&nbsp;045-323-0108</p>
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