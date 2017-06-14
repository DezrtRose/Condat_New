@extends('layouts.min')

@section('content')
    <section class="content">
    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content" style="padding: 15px;">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

            <p>
                We could not find the page you were looking for. It might have been deleted.
                <br/><br/>Meanwhile, you may <a href="javascript:history.back()">return back</a>.
            </p>
        </div>
        <!-- /.error-content -->
    </div>
    </section>
@endsection