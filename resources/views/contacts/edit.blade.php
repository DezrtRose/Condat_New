<div class="header">
	<a href={{ URL::to("institutes/view/$contacts->institute_id") }}>
	{{ DB::table('institutes')->where('id', $contacts->institute_id)->pluck('name') }} </a> 
	>> Edit Contacts
</div>
<div class="body">
{{ Form::model($contacts, array('url' => 'contacts/edit', $contacts->id)) }}	
		<!--id-->
		{{ Form::hidden('id') }}<br>
		<!-- name -->
		<div class="label">{{ Form::label('name', 'Name') }}</div>
		<div class="field">{{ Form::text('name') }}</div>

		<div class="label">{{ Form::label('phone_no', 'Phone No') }}</div>
		<div class="field">{{ Form::text('phone_no') }}</div>
		<div class="label">{{ Form::label('email', 'Email') }}</div>
		<div class="field">{{ Form::email('email') }}</div>
		<div class="label">{{ Form::label('department', 'Department') }}</div>
		<div class="field">{{ Form::text('department') }}</div>
		<div class="label">{{ Form::label('notes', 'Notes') }}</div>
		<div class="field">{{ Form::textarea('notes') }}</div>

		{{ Form::submit('Update Contacts!') }}

	{{ Form::close() }}
</div>

