<div class="content-wrapper" style="min-height: 1126px;">
    <section class="content-header">
        <h1>
            @yield('heading')
        </h1>
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
