<div class="header">Edit Companies</div>
<div class="body">
{{ Form::model($companies, array('url' => 'companies/edit', $companies->id)) }}	
		<!--id-->
		{{ Form::hidden('id') }}<br>
		<!-- name -->
		<div class="label">{{ Form::label('name', 'Name') }}</div>
		<div class="field">{{ Form::text('name') }}</div>
		<div class="label">{{ Form::label('abn', 'ABN') }}</div>
		<div class="field">{{ Form::text('abn') }}</div>

		<!-- DOB -->
		<div class="label">{{ Form::label('street', 'Street') }}</div>
		<div class="field">{{ Form::text('street') }}</div>
		<div class="label">{{ Form::label('suburb', 'Suburb') }}</div>
		<div class="field">{{ Form::text('suburb') }}</div>
		<div class="label">{{ Form::label('postcode', 'Postcode') }}</div>
		<div class="field">{{ Form::text('postcode') }}</div>
		<div class="label">{{ Form::label('state', 'State') }}</div>
		<div class="field">{{ Form::text('state') }}</div>
		<div class="label">{{ Form::label('country_id', 'Country') }}</div>
		<div class="field">{{ Form::select('country_id', DB::table('countries')->lists('name','id'), $companies->country_id) }}</div>

		<div class="label">{{ Form::label('phone_no', 'Phone No') }}</div>
		<div class="field">{{ Form::text('phone_no') }}</div>
		<div class="label">{{ Form::label('fax', 'Fax') }}</div>
		<div class="field">{{ Form::text('fax') }}</div>
		<div class="label">{{ Form::label('email', 'Email') }}</div>
		<div class="field">{{ Form::email('email') }}</div>
		<div class="label">{{ Form::label('website', 'Website') }}</div>
		<div class="field">{{ Form::text('website') }}</div>

		


		<div class="label">{{ Form::label('account_name', 'Account Name') }}</div>
		<div class="field">{{ Form::text('account_name') }}</div>
		<div class="label">{{ Form::label('account_no', 'Account No') }}</div>
		<div class="field">{{ Form::text('account_no') }}</div>
		<div class="label">{{ Form::label('bsb', 'Bsb') }}</div>
		<div class="field">{{ Form::text('bsb') }}</div>
		<div class="label">{{ Form::label('bankname', 'Bank Name') }}</div>
		<div class="field">{{ Form::text('bankname') }}</div>

		



		{{ Form::submit('Update!') }}

	{{ Form::close() }}
</div>

