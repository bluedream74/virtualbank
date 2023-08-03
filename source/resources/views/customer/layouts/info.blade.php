<!-- shop information -->
<div class="footer-container">

    <div class="row">

        <!-- contact information -->
        <div class="contact-box">

            <div class="col-xs-12 mt-md mb-md">
                <div class="shop-info">
                    <div class="row m-none">
                        <div class="col-xs-5 p-none">
                            <p><i class="fa fa-home"></i>&nbsp;&nbsp;店舗名</p>
                        </div>
                        <div class="col-xs-7 p-none">
                            <p>{{ Auth::user()->username }}</p>
                        </div>
                    </div>

                    <div class="row m-none">
                        <div class="col-xs-5 p-none">
                            <p style="border:none !important;"><i class="fa fa-user"></i>&nbsp;&nbsp;店舗ID</p>
                        </div>
                        <div class="col-xs-7 p-none">
                            <p style="border:none !important;">{{ Auth::user()->name }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>