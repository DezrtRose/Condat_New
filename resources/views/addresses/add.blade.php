<div class="header">
	<a href={{ URL::to("institutes/view/$institute_id") }}>
	{{ DB::table('institutes')->where('id', $institute_id)->pluck('name') }} </a> 
	>> Add Address
</div>
<div class="body">
<?php

if ($errors->has()){
			foreach ($errors->all() as $error)
			{
			    print_r("<font color=red>".$error."</font></br> ");
			}
}

echo Form::open(array('url' => 'addresses/save'));
?>
<div class="label">Street</div>
<div class="field">{{ Form::text('street',Input::old('street')) }}</div>
<div class="label">Suburb</div>
<div class="field">{{ Form::text('suburb',Input::old('suburb')) }}</div>
<div class="label">Post Code</div>
<div class="field">{{ Form::text('postcode',Input::old('postcode')) }}</div>
<div class="label">State</div>
<div class="field">{{ Form::text('state',Input::old('state')) }}</div>
<div class="label">Country</div>
<div class="field">{{ Form::text('country',Input::old('country')) }}</div>
<div class="label">Phone</div>
<div class="field">{{ Form::text('phone_no',Input::old('phone_no')) }}</div>
<div class="label">Email</div>
<div class="field">{{ Form::text('email',Input::old('email')) }}</div>

{{ Form::hidden('institute_id',$institute_id) }}
{{ Form::hidden('user_id',Auth::user()->id) }}
<div class="label">{{ Form::submit('Submit') }}</div>

<div>
