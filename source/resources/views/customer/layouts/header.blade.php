<header id="page-top">

  <div class="inner-header">
        <a class="logo-link" style="text-align: left"><img src="{{ asset('public/customer/img/logo.png') }}" width="55%" style="max-width: 450px;"></a>
        @if(Auth::check())
            <a href="{{ url('/') }}" class="btn-top text-center">TOP</a>
        @endif
  </div>
</header>

