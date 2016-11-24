<div class="header">
	<a href={{ URL::to("institutes/view/$institute_id") }}>
	{{ DB::table('institutes')->where('id', $institute_id)->pluck('name') }} </a> 
	>> Add Contacts
</div>
<div class="body">
<?php

if ($errors->has()){
			foreach ($errors->all() as $error)
			{
			    print_r("<font color=red>".$error."</font></br> ");
			}
}

echo Form::open(array('url' => 'contacts/save'));
?>
<div class="label">Name</div>
<div class="field">{{Form::text('name',Input::old('name')) }}</div>
<div class="label">Phone</div>
<div class="field">{{ Form::text('phone_no',Input::old('phone_no')) }}</div>
<div class="label">Email</div>
<div class="field">{{ Form::text('email',Input::old('email')) }}</div>
<div class="label">Department</div>
<div class="field">{{ Form::text('department',Input::old('department')) }}</div>
{{ Form::hidden('institute_id',$institute_id) }}
{{ Form::hidden('user_id',Auth::user()->id) }}
<div class="label">Notes</div>
<div class="field">{{ Form::textarea('notes') }}</div>
<div class="label">{{ Form::submit('Submit') }}</div>


<div>
