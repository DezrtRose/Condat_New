<div class="content-wrapper" style="min-height: 1126px;">
    <section class="content-header">
        @if(Request::segment(2) != 'client_invoice_report' && Request::segment(2) != 'college_invoice_report' && Request::segment(2) != 'client' && Request::segment(3) != 'payment')
        <h1>
            @yield('heading')
        </h1>
        @endif
    </section>
    <section class="content clearfix">
        <div class="row">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif

            @yield('content')
        </div>
    </section>
</div>
