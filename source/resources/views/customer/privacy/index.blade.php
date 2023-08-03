@extends('customer.layouts.app')
@section('title', '個人情報保護規約 | VirtualBank')

@section('content')
<div role="main" class="main">

    <div class="top-container">

        <h2 class="header-title">個人情報の取扱い</h2>
        <div class="help-body">
            <p class="header">当社で取扱う個人情報の利用目的</p>
            <p>当社が取得した個人情報の利用目的は、以下のとおりです。</p>
            <ul>
                <li>
                    <p> 従業者の個人情報</p>
                    <ul class="sub-item">
                        <li><p> 人事、給与、総務などの雇用管理のため</p></li>
                        <li><p> 健康管理のため</p></li>
                        <li><p> セキュリティ管理のため</p></li>
                    </ul>
                </li>
                <li>
                    <p> 採用応募者の個人情報</p>
                    <ul class="sub-item">
                        <li><p> 応募者への連絡、採用選考のため</p></li>
                        <li><p> 入社手続きのため</p></li>
                    </ul>
                </li>
                <li>
                    <p> お取引先の個人情報</p>
                    <ul class="sub-item">
                        <li><p> 商談、業務上の連絡、受発注業務、契約の履行のため</p></li>
                    </ul>
                </li>

                <li>
                    <p> クレジットカード決済サービス利用者の個人情報</p>
                    <ul class="sub-item">
                        <li><p> クレジットカード決済サービス提供のため</p></li>
                        <li><p> 本人確認のため</p></li>
                        <li><p> ご連絡のため</p></li>
                        <li><p> サービス利用状況の管理のため</p></li>
                    </ul>
                </li>

                <li>
                    <p> お問合わせいただいた方の個人情報</p>
                    <ul class="sub-item">
                        <li><p> お問い合わせへの対応のため</p></li>
                        <li><p> 資料発送のため</p></li>
                    </ul>
                </li>
            </ul>


            <p class="header mt-lg">苦情・相談の申し出先</p>
            <p>個人情報の取扱いに関するお問い合わせ、苦情及びご相談につきましては、お問い合わせ窓口にご連絡ください。</p>


            <p class="header mt-lg">開示等の求めに応じる手続き</p>
            <ul>
                <li><p>開示対象の個人情報<br>事業者が本人から求められる利用目的の通知、開示、内容の訂正、追加又は削除、利用の停止、消去及び第三者への提供の停止の求めのすべてに応じます。</p></li>
                <li><p>開示請求の申出先<br>開示請求はお問合せにお問合せの上、当社が保有するご自身の個人情報の利用目的の通知、開示、内容の訂正、追加又は削除、利用の停止、消去及び第三者への提供の停止を求める場合には、当社所定の書面に必要事項をご記入の上、提出していただきます。</p></li>
                <li><p>開示請求依頼<br>本人確認をさせていただきます。その際、お預かりしております個人情報をもとに、本人確認をさせていただきます。</p></li>
                <li><p>開示請求<br>（「利用目的の通知」「個人情報の開示」の請求）にあたり、手数料は1,000円を上限に徴収いたします。これを超えることが明白な場合は別途、ご連絡いたします。</p></li>
            </ul>


            <p class="header mt-lg">個人情報の取扱いに関するお問合せ</p>
            <p>苦情及びご相談について、個人情報の取扱いに関するお問合せ、苦情及びご相談につきましては、以下の当社お問合せ窓口にご連絡ください。迅速に善処させて頂きます。</p>

            <div class="text-center mt-xlg">
                <a class="btn btn-default btn-green" style="width: 300px; border-radius: 30px; padding: 15px 40px;" onclick="window.history.back()">戻る</a>
            </div>

        </div>

    </div>

</div>

@endsection

<!-- Custom CSS -->
@section('page_css')
    <link rel="stylesheet" href="{{ asset('public/customer/css/views/top.css') }}">
@endsection

<!-- Custom JS -->
@section('page_js')
    <script src="{{ asset('public/customer/js/views/top.js') }}"></script>
@endsection