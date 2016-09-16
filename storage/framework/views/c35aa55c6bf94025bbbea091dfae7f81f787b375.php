<div class="form-group">
    <?php echo Form::label('first_name', 'First Name *', array('class' => 'col-sm-4 control-label')); ?>

    <div class="col-sm-8">
        <?php echo Form::text('first_name', null, array('class' => 'form-control', 'id'=>'first_name')); ?>

    </div>
</div>

<div class="form-group">
    <?php echo Form::label('middle_name', 'Middle Name', array('class' => 'col-sm-4 control-label')); ?>

    <div class="col-sm-8">
        <?php echo Form::text('middle_name', null, array('class' => 'form-control', 'id'=>'middle_name')); ?>

    </div>
</div>

<div class="form-group">
    <?php echo Form::label('last_name', 'Last Name *', array('class' => 'col-sm-4 control-label')); ?>

    <div class="col-sm-8">
        <?php echo Form::text('last_name', null, array('class' => 'form-control', 'id'=>'last_name')); ?>

    </div>
</div>

<div class="form-group">
    <?php echo Form::label('sex', 'Sex *', array('class' => 'col-sm-4 control-label')); ?>

    <div class="col-sm-8">
        <label>
            <?php echo Form::radio('sex', 'Male', true, array('class' => 'iCheck', 'checked'=>'checked')); ?>

            Male
        </label>
        <label>
            <?php echo Form::radio('sex', 'Female', array('class' => 'iCheck')); ?> Female
        </label>
    </div>
</div>

<div class="form-group">
    <?php echo Form::label('position', 'Position *', array('class' => 'col-sm-4 control-label')); ?>

    <div class="col-sm-8">
        <?php echo Form::text('position', null, array('class' => 'form-control', 'id'=>'position')); ?>

    </div>
</div>

<div class="form-group">
    <?php echo Form::label('number', 'Phone Number *', array('class' => 'col-sm-4 control-label')); ?>

    <div class="col-sm-8">
        <?php echo Form::text('number', null, array('class' => 'form-control phone-input', 'id'=>'number')); ?>

    </div>
</div>

<div class="form-group">
    <?php echo Form::label('email', 'Email Address *', array('class' => 'col-sm-4 control-label')); ?>

    <div class="col-sm-8">
        <?php echo Form::email('email', null, array('class' => 'form-control', 'id'=>'email')); ?>

    </div>
</div>

</div>