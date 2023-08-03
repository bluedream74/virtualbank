@extends('merchant.layouts.app')
@section('title', 'QR決済 | Virtual Bank')

@php($payment_url = $datas['payment_url'])

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2 style="float:none !important;"><i class="fa fa-qrcode"></i>&nbsp;&nbsp;QR決済</h2>
                </div>
            </div>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">

                <div id="qrcode_container">

                    <p class="title">QRコード画像の調整</p>

                    <div class="text-center">

                        <div id="qrcode_box">
                            <div class="text-center mt-xlg">
                                <div id="qrcode"></div>
                                <p class="mt-sm" style="font-size: 13px;" id="size-label">画像のサイズは 150 x 150 ピクセル</p>
                            </div>
                        </div>
                    </div>

                    <div class="property">

                        <div id="spinner">
                            <p>サイズ</p>
                            <input id="size" type="range" min="4" max="6" step="0.01" value="5" onchange="changeSize(this)">
                        </div>

                        <div class="row mt-md" id="colorbox">
                            <div class="col-xs-6">
                                <p>ドットの色</p>
                                <input type="color" id="dot_color" value="#000000" onchange="changeColor(this)"><label id="dot" for="dot_color">#000000</label>
                            </div>
                            <div class="col-xs-6">
                                <p>背景の色</p>
                                <input type="color" id="back_color" value="#ffffff" onchange="changeColor(this)"><label id="back" for="back_color">#ffffff</label>
                            </div>
                        </div>

                        <div id="file_format" class="mt-md">
                            <p>ファイル形式</p>
                            <div class="row form-group pl-md">
                                <div class="col-xs-4 radio-custom radio-success">
                                    <input type="radio" id="format1" name="format" value="PNG" checked>
                                    <label for="format1" class="c-radio-title">&nbsp;&nbsp;PNG</label>
                                </div>
                                <div class="col-xs-4 radio-custom radio-success">
                                    <input type="radio" id="format2" name="format" value="JPEG">
                                    <label for="format2" class="c-radio-title">&nbsp;&nbsp;JPEG</label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-default btn-gold mt-xlg" style="padding: 10px 20px !important; font-size: 16px !important;" onclick="downloadQR();">ダウンロードする</button>
                        </div>
                    </div>

                </div>

            </div>

        </section>
        <!-- end page -->

    </section>

    @endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/jquery-ui/jquery-ui.theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/select2/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/admin/vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/merchant/css/common.css') }}" />
@endsection

<!-- Custom JS -->
@section('page_js_vendor')

    <script src="{{ asset('public/admin/js/qrcode.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-alpha1/html2canvas.js"></script>
    <script>

        function createQrcode()
        {
            $('#qrcode').html('');
            $('#qrcode').css('background-color', $('#back_color').val());

            var size = parseInt(30 * $('#size').val());
            var url = "{{ $payment_url }}";

            var qrcode = new QRCode('qrcode', {
                text: url,
                width: size,
                height: size,
                colorDark : $('#dot_color').val(),
                colorLight : $('#back_color').val(),
                correctLevel : QRCode.CorrectLevel.H
            });
        }

        function changeColor(obj)
        {
            $(obj).html($(obj).val());
            createQrcode();
        }

        function changeSize(obj)
        {
            var size = parseInt(30 * obj.value);
            var strLabel = '画像のサイズは ' + size + ' x ' +  size + ' ピクセル';
            $('#size-label').html(strLabel);
            $('#qrcode').css('width', size);
            $('#qrcode').css('height', size);
            createQrcode();
        }

        createQrcode();

        // download QRCode image
        function downloadQR()
        {
            html2canvas($('#qrcode'), {
                onrendered: function (canvas) {

                    var format = $("input[name='format']:checked").val();
                    var imgageData = canvas.toDataURL("image/png");
                    var filename = 'QRCode.png';

                    if(format == 'JPEG'){
                        imgageData = canvas.toDataURL("image/jpeg");
                        filename = 'QRCode.jpg';
                    }

                    var link = document.createElement('a');
                    document.body.appendChild(link);
                    link.href = imgageData;
                    link.download = filename;
                    link.click();
                }
            });
        }

    </script>
@endsection
