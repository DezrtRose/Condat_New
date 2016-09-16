<!doctype html>
<html>
<head>
    <?php echo $__env->make('layouts.partials.min.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body class="hold-transition login-page">
<div id="main" class="row">
    <div class="signup-content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>

<footer class="row">
    <?php echo $__env->make('layouts.partials.min.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</footer>
</body>
</html>