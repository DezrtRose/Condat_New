@extends('layouts.default')
@section('title','Client Create')

@section('content')
<div class = "container">
    <div class="page-header">
		<h1>Client - <small>Create</small></h1>
	</div>

<?php

if ($errors->has()){
			foreach ($errors->all() as $error)
			{
			    print_r("<font color=red>".$error."</font></br> ");
			}
}

echo Form::open(array('url' => 'clients/save'));
?>
	<div class="form-group">
		{!! Form::label('first_name', 'First Name',array('class' => 'col-sm-2 control-label')) !!} 
			<div class="col-sm-10">
				{!! Form::text('first_name',Input::old('first_name'),array('class' => 'form-control')) !!} 
			</div>
	</div> 
 
	<div class="form-group">
		{!! Form::label('middle_name', 'Middle Name',array('class' => 'col-sm-2 control-label')) !!} 
		<div class="col-sm-10">
		{!! Form::text('middle_name',Input::old('middle_name'),array('class' => 'form-control')) !!} 
		</div>
	</div> 
	<div class="form-group">
		{!! Form::label('last_name', 'Last Name',array('class' => 'col-sm-2 control-label')) !!}  
		<div class="col-sm-10">
			{!! Form::text('last_name',Input::old('last_name'),array('class' => 'form-control')) !!} 
		</div>
	</div>
	<div class="form-group">
            <label for="dob" class="col-sm-2 control-label">DOB</label>
            <div class="col-sm-10">
                <div class='input-group date'>
                    <input type="text" name="dob" class="form-control datepicker" id="dob" placeholder="yyyy-mm-dd">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar "></span>
                    </span>
                </div>
            </div>
    </div>


	<div class="form-group">
		 <label for="sex" class="col-sm-2 control-label">Sex</label>
			<div>
			&nbsp;&nbsp;&nbsp;{!! Form::radio('sex', 'male',true ) !!} Male &nbsp;
			{!! Form::radio('sex', 'female',(Input::old('sex') == 'female' ? true : false)) !!} Female
			</div>
			
	</div>
	

	
	<div class="form-group">
		{!! Form::label('passport_no', 'Passport No',array('class' => 'col-sm-2 control-label')) !!}  
		<div class="col-sm-10">
			{!! Form::text('passport_no',Input::old('passport_no'),array('class' => 'form-control')) !!} 
		</div>
	</div>

	<div class="form-group">
		{!! Form::label('type', 'Phone Type',array('class' => 'col-sm-2 control-label')) !!} 
		<div class="col-sm-10">
			{!! Form::select('type',array('mobile'=>'Mobile','home'=>'Home','work'=>'Work'),Input::old('type'),array('class' => 'form-control')) !!} 
		</div> 
	</div>
	<div class="form-group">
		{!! Form::label('country_code', 'Country Code',array('class' => 'col-sm-2 control-label')) !!} 
		<div class="col-sm-10">
			{!! Form::text('country_code',Input::old('country_code'),array('class' => 'form-control')) !!} 
		</div> 
	</div>
	<div class="form-group">
		{!! Form::label('area_code', 'Area Code',array('class' => 'col-sm-2 control-label')) !!}  
		<div class="col-sm-10">
			{!! Form::text('area_code',Input::old('area_code'),array('class' => 'form-control')) !!}
		</div> 
	</div> 
	<div class="form-group">
		{!! Form::label('number', 'Phone Number',array('class' => 'col-sm-2 control-label')) !!} 
		<div class="col-sm-10">
			{!! Form::text('number',Input::old('number'),array('class' => 'form-control')) !!} 
		</div> 
	</div>
	<div class="form-group">
		{!! Form::label('email', 'Email',array('class' => 'col-sm-2 control-label')) !!}  
		<div class="col-sm-10">
			{!! Form::text('email',Input::old('email'),array('class' => 'form-control')) !!}
		</div> 
	</div> 
	<div class="form-group">
		{!! Form::label('street', 'Street',array('class' => 'col-sm-2 control-label')) !!} 
		<div class="col-sm-10">
			{!! Form::text('street',Input::old('street'),array('class' => 'form-control')) !!}
		</div> 
	</div> 
	<div class="form-group">
		{!! Form::label('suburb', 'Suburb',array('class' => 'col-sm-2 control-label')) !!}  
		<div class="col-sm-10">
			{!! Form::text('suburb',Input::old('suburb'),array('class' => 'form-control')) !!}
		</div> 
	</div>  
	<div class="form-group">
		{!! Form::label('state', 'State',array('class' => 'col-sm-2 control-label')) !!}  
		<div class="col-sm-10">
			{!! Form::text('state',Input::old('state'),array('class' => 'form-control')) !!}
		</div> 
	</div>   
	<div class="form-group">
		{!! Form::label('postcode', 'Postcode',array('class' => 'col-sm-2 control-label')) !!}  
		<div class="col-sm-10">
			{!! Form::text('postcode',Input::old('postcode'),array('class' => 'form-control')) !!}
		</div> 
	</div>  
	<div class="form-group">
		{!! Form::label('country_id', 'Country', array('class'=>'col-sm-2 control-label')) !!}
		<div class="col-sm-10">
		{!! Form::select('country_id', DB::table('countries')->lists('name','country_id'),Input::old('country_id'),array('class'=>'form-control')) !!}
		</div> 
	</div> 
	<div class="form-group">
			{!! Form::label('address_type', 'Address Type', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
			{!! Form::select('address_type', array('home'=>'Home','work'=>'Work','postal'=>'Postal'),Input::old('address_type'),array('class' => 'form-control')) !!}
			</div> 
	</div> 
	



	<?php
	/*
	{!! Form::hidden('user_id',Auth::user()->id) !!} 
	*/
	?>
	<div class="form-group">
		{!! Form::label('reffered_by', 'Reffered by',array('class' => 'col-sm-2 control-label')) !!} 
		<div class="col-sm-10">
			{!! Form::text('reffered_by',Input::old('reffered_by'),array('class' => 'form-control')) !!} 
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('notes', 'Notes',array('class' => 'col-sm-2 control-label')) !!} 
		<div class="col-sm-10">
			{!! Form::textarea('notes',Input::old('notes'),array('class' => 'form-control')) !!} 
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('user_id', 'User',array('class' => 'col-sm-2 control-label')) !!} 
		<div class="col-sm-10">
			{!! Form::text('user_id',Input::old('user_id'),array('class' => 'form-control')) !!} 
		</div>
	</div>
	<div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
    </div>

</div>

<link rel="stylesheet" href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css">
<script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        endDate: '+0d',
        autoclose: true
    });
</script>


@endsection

