<div class="box-body">

    <div class="form-group <?php if($errors->has('username')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
        <?php echo Form::label('username', 'Username *', array('class' => 'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <?php echo Form::text('username', null, array('class' => 'form-control', 'id'=>'username')); ?>

            <?php if($errors->has('username')): ?>
                <?php echo $errors->first('username', '<label class="control-label"
                                                       for="inputError">:message</label>'); ?>

            <?php endif; ?>
        </div>
    </div>
    <div class="form-group <?php if($errors->has('title')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
        <?php echo Form::label('title', 'Title', array('class' => 'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <?php echo Form::select('title', config('constants.title'), null, array('class' => 'form-control')); ?>

        </div>

    </div>
    <div class="form-group <?php if($errors->has('given_name')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
        <?php echo Form::label('given_name', 'Given Name *', array('class' => 'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <?php echo Form::text('given_name', null, array('class' => 'form-control', 'id'=>'given_name')); ?>

            <?php if($errors->has('given_name')): ?>
                <?php echo $errors->first('given_name', '<label class="control-label"
                                                         for="inputError">:message</label>'); ?>

            <?php endif; ?>
        </div>
    </div>
    <div class="form-group <?php if($errors->has('surname')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
        <?php echo Form::label('surname', 'Surname *', array('class' => 'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <?php echo Form::text('surname', null, array('class' => 'form-control', 'id'=>'surname')); ?>

            <?php if($errors->has('surname')): ?>
                <?php echo $errors->first('surname', '<label class="control-label"
                                                      for="inputError">:message</label>'); ?>

            <?php endif; ?>
        </div>
    </div>

    <?php if($current_user->role == 1): ?>
        <div class="form-group">
            <?php echo Form::label('role', 'User Role', array('class' => 'col-sm-2 control-label')); ?>

            <div class="col-sm-10">
                <?php echo Form::select('role', config('constants.user_role'), null, array('class' => 'form-control')); ?>

            </div>
        </div>
    <?php endif; ?>

    <div class="form-group <?php if($errors->has('email')): ?> <?php echo e('has-error'); ?> <?php endif; ?>">
        <?php echo Form::label('email', 'Email Address *', array('class' => 'col-sm-2 control-label')); ?>

        <div class="col-sm-10">
            <?php echo Form::text('email', null, array('class' => 'form-control', 'id'=>'email')); ?>

            <?php if($errors->has('email')): ?>
                <?php echo $errors->first('email', '<label class="control-label"
                                                    for="inputError">:message</label>'); ?>

            <?php endif; ?>
        </div>
    </div>
</div>