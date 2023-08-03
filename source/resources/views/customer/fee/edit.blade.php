@extends('customer.layouts.app')
@section('title', '手数料設定 | VirtualBank')

@php($visa_fee = $datas['visa_fee'])
@php($master_fee = $datas['master_fee'])
@php($jcb_fee = $datas['jcb_fee'])
@php($amex_fee = $datas['amex_fee'])

@section('content')
<div role="main" class="main">

    <div class="top-container">
        <h2 class="header-title">手数料設定</h2>

        <form action="{{ url('/fee-setting/edit') }}" method="post" class="input-form" id="editForm">
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

            <div class="col-xs-12 text-center" style="margin-top: -15px; margin-bottom: -15px;">
                <i class="fa fa-caret-down" style="font-size: 50px; color: white;"></i>
            </div>

            <div class="col-xs-12">
                <table width="100%">
                    <tbody>

                        <tr>
                            <td colspan="6" class="text-center fail" width="100%"><strong>変更後の加算決済手数料</strong></td>
                        </tr>

                        <!-- VISA -->
                        <tr>
                            <td width="50%">VISA</td>
                            <td width="15%">
                                <select name="visa_fee11" id="visa_fee11">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </td>
                            <td width="15%">
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
                            <td width="10%">
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

                        <!-- MASTER -->
                        <tr>
                            <td width="50%">MASTER</td>
                            <td width="60px">
                                <select name="master_fee11" id="master_fee11">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </td>
                            <td width="15%">
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
                            <td width="10%">
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

                        <!-- JCB -->
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

                        <!-- AMEX -->
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

            <div class="col-xs-12 text-center">
                <p style="font-size: 16px; color: white">加算決済手数料は、自由に変更できます。<br>最小0.0％から最大29.9％の設定ができます。</p>
            </div>

        </div>

        <div class="row" id="fee_buttons">
            <div class="col-xs-12 text-center">
                <a class="btn btn-default btn-gold pull-left mb-sm" style="width: 300px; border-radius: 30px; padding: 15px 40px;" onclick="submitEdit()">確定</a>
                <a class="btn btn-default btn-green" style="width: 300px; border-radius: 30px; padding: 15px 40px;" href="{{ url('fee-setting/') }}">戻る</a>
            </div>
        </div>

    </div>

    <!-- shop information -->
    @include('customer.layouts.info')

</div>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">
@endsection

<!-- Custom JS -->
@section('page_js')

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