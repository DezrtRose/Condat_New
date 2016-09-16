<div class="content-wrapper" style="min-height: 1126px;">
    <section class="content-header">
        <h1>
            <?php echo $__env->yieldContent('heading'); ?>
        </h1>
        <ol class="breadcrumb">
            <?php $__env->startSection('breadcrumb'); ?>
                <li><a href="<?php echo e(url('/')); ?>" data-push="true"><i class="fa fa-dashboard"></i> Home </a></li>
            <?php echo $__env->yieldSection(); ?>
        </ol>
    </section>
    <section class="content clearfix">
        <div class="row">
            <?php if(Session::has('message')): ?>
                <p class="alert <?php echo e(Session::get('alert-class', 'alert-info')); ?>"><?php echo e(Session::get('message')); ?></p>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </section>
</div>
