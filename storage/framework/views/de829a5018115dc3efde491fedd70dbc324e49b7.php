<div class="active tab-pane" id="activity">
    <!-- Post -->
    <div>
        <?php echo Form::open(['url' => 'tenant/clients/'.$client->client_id.'/notes', 'method' => 'post']); ?>

        <div class="col-sm-10">
            <input type="hidden" value=1 name="timeline" />
            <input name="description" class="form-control input-sm" type="text" placeholder="Type a Comment">
        </div>
        <div class="col-sm-2">
            <input type="submit" value="Submit" class="btn btn-primary btn-sm" />
        </div>
        <div>&nbsp;</div>
        <?php echo Form::close(); ?>

    </div>
    <!-- /.post -->
</div>

<?php /* The actual timeline */ ?>
<ul class="timeline timeline-inverse">
    <!-- timeline time label -->
    <?php foreach($timelines as $key => $grouped_timeline): ?>
        <li class="time-label">
            <span class="bg-red">
              <?php echo e(readable_date($key)); ?>

            </span>
        </li>
        <!-- /.timeline-label -->
        <!-- timeline item -->
        <?php foreach($grouped_timeline as $timeline): ?>
            <li>
                <i class="fa <?php echo e($timeline->image); ?>"></i>

                <div class="timeline-item">
                                        <span class="time"><i
                                                    class="fa fa-clock-o"></i> <?php echo e(get_datetime_diff($timeline->created_at)); ?></span>
                    <?php echo $timeline->message; ?>

                </div>
            </li>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <li>
        <i class="fa fa-clock-o bg-gray"></i>
    </li>
</ul>

<?php /*<div class="scroll">
    <?php foreach($timeline_list as $key => $grouped_timeline): ?>
        <li class="time-label">
            <span class="bg-red">
              <?php echo e(readable_date($key)); ?>

            </span>
        </li>
        <!-- /.timeline-label -->
        <!-- timeline item -->
        <?php foreach($grouped_timeline as $timeline): ?>
            <li>
                <i class="fa <?php echo e($timeline->image); ?>"></i>

                <div class="timeline-item">
                                        <span class="time"><i
                                                    class="fa fa-clock-o"></i> <?php echo e(get_datetime_diff($timeline->created_at)); ?></span>
                    <?php echo $timeline->message; ?>

                </div>
            </li>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>*/ ?>

<?php echo e(Condat::js('assets/plugins/jScroll/jquery.jscroll.js')); ?>


<script type="text/javascript">
    $(document).ready(function () {
        $('.scroll').jscroll({
            loadingHtml: '<img src="loading.gif" alt="Loading" /> Loading...',
            //padding: 20,
            //nextSelector: 'a.jscroll-next:last',
            //contentSelector: 'li'
        });
    })
</script>