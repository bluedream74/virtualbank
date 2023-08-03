@extends('merchant.layouts.app')
@section('title', '手数料設定 | Virtual Bank')

@php($visa_fee = $datas['visa_fee'])
@php($master_fee = $datas['master_fee'])
@php($jcb_fee = $datas['jcb_fee'])
@php($amex_fee = $datas['amex_fee'])

@section('content')

    <section role="main" class="content-body">

        <!-- header -->
        <header class="page-header">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2 style="float:none !important;"><i class="fa fa-yen"></i>&nbsp;&nbsp;手数料設定</h2>
                </div>
            </div>
        </header>

        <!-- start page -->
        <section class="panel">

            <div class="panel-body">

                <form action="{{ url('/merchant/fee-setting/edit') }}" method="post" class="input-form" id="editForm">
                    {{csrf_field()}}

                    <input type="hidden" name="visa_fee" id="visa_fee" value="{{ $visa_fee }}"/>
                    <input type="hidden" name="master_fee" id="master_fee" value="{{ $master_fee }}"/>
                    <input type="hidden" name="jcb_fee" id="jcb_fee" value="{{ $jcb_fee }}"/>
                    <input type="hidden" name="amex_fee" id="amex_fee" value="{{ $amex_fee }}"/>
                </form>

                <div class="row mt-lg" id="fee_edit">
                    <div class="col-xs-12">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-center success" width="100%"><strong>現在の加算決済手数料</strong></td>
                                </tr>
                                <tr>
                                    <td width="50%">VISA</td>
                                    <td width="50%">{{ $visa_fee }} %</td>
                                </tr>
                                <tr>
                                    <td width="50%">MASTER</td>
                                    <td width="50%">{{ $master_fee }} %</td>
                                </tr>
                                <tr>
                                    <td width="50%">JCB</td>
                                    <td width="50%">{{ $jcb_fee }} %</td>
                                </tr>
                                <tr>
                                    <td width="50%">AMEX</td>
                                    <td width="50%">{{ $amex_fee }} %</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-xs-12 text-center">
                        <i class="fa fa-caret-down" style="font-size: 30px;"></i>
                    </div>

                    <div class="col-xs-12">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center fail" width="100%"><strong>変更後の加算決済手数料</strong></td>
                                </tr>
                                <tr>
                                    <td width="40%">VISA</td>
                                    <td width="20%">
                                        <select name="visa_fee11" id="visa_fee11">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </td>
                                    <td width="20%">
                                        <select name="visa_fee12" id="visa_fee12">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </td>

                                    <td class="dot" width="2%">.</td>
                                    <td width="13%">
                                        <select name="visa_fee2" id="visa_fee2">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </td>
                                    <td width="5%">%</td>
                                </tr>

                                <tr>
                                    <td width="40%">MASTER</td>
                                    <td width="20%">
                                        <select name="master_fee11" id="master_fee11">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </td>
                                    <td width="20%">
                                        <select name="master_fee12" id="master_fee12">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </td>

                                    <td class="dot" width="2%">.</td>
                                    <td width="13%">
                                        <select name="master_fee2" id="master_fee2">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </td>
                                    <td width="5%">%</td>
                                </tr>

                                <tr>
                                    <td width="50%">JCB</td>
                                    <td width="15%">
                                        <select name="jcb_fee11" id="jcb_fee11">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </td>
                                    <td width="15%">
                                        <select name="jcb_fee12" id="jcb_fee12">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </td>

                                    <td class="dot" width="2%">.</td>
                                    <td width="10%">
                                        <select name="jcb_fee2" id="jcb_fee2">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </td>
                                    <td width="5%">%</td>
                                </tr>

                                <tr>
                                    <td width="50%">AMEX</td>
                                    <td width="15%">
                                        <select name="amex_fee11" id="amex_fee11">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </td>
                                    <td width="15%">
                                        <select name="amex_fee12" id="amex_fee12">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </td>

                                    <td class="dot" width="2%">.</td>
                                    <td width="10%">
                                        <select name="amex_fee2" id="amex_fee2">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </td>
                                    <td width="5%">%</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="row p-sm" id="fee_help">
                        <div class="col-xs-12 text-center mt-md">
                            <p style="color: #000000; font-size: 20px; line-height: 1.7;">加算決済手数料は、自由に変更できます。<br>最小0.0％から最大29.9％の設定ができます。</p>
                        </div>
                    </div>
                </div>

                <div class="row" id="fee_buttons">
                    <div class="col-xs-12 text-center pb-xlg">
                        <button class="btn btn-default btn-gold mt-md mb-md" style="padding: 10px 40px !important;" onclick="submitEdit()">変更する</button>
                        <button class="btn btn-default btn-white" style="padding: 10px 40px !important;" onclick="window.history.back();">戻る</button>
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
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">
    <link rel="stylesheet" href="{{ asset('public/merchant/css/common.css') }}">
@endsection

<!-- Custom JS -->
@section('page_js_vendor')

    <script>

        function initEdit()
        {
            var visa_fee = $('#visa_fee').val();
            var master_fee = $('#master_fee').val();
            var jcb_fee = $('#jcb_fee').val();
            var amex_fee = $('#amex_fee').val();

            // visa fee setting
            var dotPos = visa_fee.indexOf('.');
            if(dotPos == -1)
                dotPos = visa_fee.length;

            var visa_top = visa_fee.substring(0, dotPos);
            var visa_down = visa_fee.substring(dotPos+1, visa_fee.length);
            if(parseInt(visa_top) <= 9){
                $('#visa_fee12').val(visa_top);
            }
            else{
                $('#visa_fee11').val(visa_top.substring(0,1));
                $('#visa_fee12').val(visa_top.substring(1,2));
            }

            if(visa_down == '')
                visa_down = 0;
            $('#visa_fee2').val(visa_down);

            // master fee setting
            dotPos = master_fee.indexOf('.');
            if(dotPos == -1)
                dotPos = master_fee.length;

            var master_top = master_fee.substring(0, dotPos);
            var master_down = master_fee.substring(dotPos+1, master_fee.length);
            if(parseInt(master_top) <= 9){
                $('#master_fee12').val(master_top);
            }
            else{
                $('#master_fee11').val(master_top.substring(0,1));
                $('#master_fee12').val(master_top.substring(1,2));
            }

            if(master_down == '')
                master_down = 0;
            $('#master_fee2').val(master_down);

            // jcb fee setting
            dotPos = jcb_fee.indexOf('.');
            if(dotPos == -1)
                dotPos = jcb_fee.length;

            var jcb_top = jcb_fee.substring(0, dotPos);
            var jcb_down = jcb_fee.substring(dotPos+1, jcb_fee.length);
            if(parseInt(jcb_top) <= 9){
                $('#jcb_fee12').val(jcb_top);
            }
            else{
                $('#jcb_fee11').val(jcb_top.substring(0,1));
                $('#jcb_fee12').val(jcb_top.substring(1,2));
            }

            if(jcb_down == '')
                jcb_down = 0;
            $('#jcb_fee2').val(jcb_down);

            // AMEX
            dotPos = amex_fee.indexOf('.');
            if(dotPos == -1)
                dotPos = amex_fee.length;

            var amex_top = amex_fee.substring(0, dotPos);
            var amex_down = amex_fee.substring(dotPos+1, amex_fee.length);
            if(parseInt(amex_top) <= 9){
                $('#amex_fee12').val(amex_top);
            }
            else{
                $('#amex_fee11').val(amex_top.substring(0,1));
                $('#amex_fee12').val(amex_top.substring(1,2));
            }

            if(amex_down == '')
                amex_down = 0;
            $('#amex_fee2').val(amex_down);
        }

        initEdit();

        function submitEdit()
        {
            var visa_fee= $('#visa_fee11').val() + $('#visa_fee12').val() + '.' + $('#visa_fee2').val();
            var master_fee= $('#master_fee11').val() + $('#master_fee12').val() + '.' + $('#master_fee2').val();
            var jcb_fee= $('#jcb_fee11').val() + $('#jcb_fee12').val() + '.' + $('#jcb_fee2').val();
            var amex_fee= $('#amex_fee11').val() + $('#amex_fee12').val() + '.' + $('#amex_fee2').val();

            $('#visa_fee').val(visa_fee);
            $('#master_fee').val(master_fee);
            $('#jcb_fee').val(jcb_fee);
            $('#amex_fee').val(amex_fee);

            $('#editForm').submit();
        }

    </script>
@endsection
