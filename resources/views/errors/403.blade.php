@extends('layouts.min')

@section('content')
    <section class="content">
    <div class="error-page">
        <h2 class="headline text-yellow"> 403</h2>

        <div class="error-content" style="padding: 15px;">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Tenant not found.</h3>

            <p>
                We could not find the tenant with the id you provided. Please confirm your id and try again.
                Meanwhile, you may <a href="javascript:history.back()">return back</a>.
            </p>
        </div>
        <!-- /.error-content -->
    </div>
    </section>
@endsection