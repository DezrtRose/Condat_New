<!doctype html>
<html>
<head>
    @include('layouts.partials.min.head')
</head>
<body class="hold-transition login-page">
<div id="main" class="row">
    <div class="signup-content">
        @yield('content')
    </div>
</div>

<footer class="row">
    @include('layouts.partials.min.footer')
</footer>
</body>
</html>