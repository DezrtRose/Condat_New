<?php $current = Request::segment(4); ?>
<div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li class="<?php echo e(($current == '')? 'active' : ''); ?>"><a href=<?php echo e(url("tenant/clients/$client->client_id")); ?>>Dashboard</a></li>
        <li class="<?php echo e(($current == 'personal_details')? 'active' : ''); ?>"><a href=<?php echo e(url("tenant/clients/$client->client_id/personal_details")); ?>>Personal Details</a></li>
        <li class="<?php echo e(($current == 'applications')? 'active' : ''); ?>"><a href=<?php echo e(url("tenant/clients/$client->client_id/applications")); ?>>College Application</a></li>
        <li class="<?php echo e(($current == 'accounts')? 'active' : ''); ?>"><a href=<?php echo e(url("tenant/clients/$client->client_id/accounts")); ?>>Accounts</a></li>
        <li class="<?php echo e(($current == 'document')? 'active' : ''); ?>"><a href=<?php echo e(url("tenant/clients/$client->client_id/document")); ?>>Documents</a></li>
        <li class="<?php echo e(($current == 'notes')? 'active' : ''); ?>"><a href=<?php echo e(url("tenant/clients/$client->client_id/notes")); ?>>Notes</a></li>
    </ul>
</div><!--/.nav-collapse -->