<div class="header">
	<a href={{ URL::to("clients/view/$colleges->client_id") }} >
	{{  DB::table('clients')->where('id', $colleges->client_id)->pluck('first_name') }} 
	{{  DB::table('clients')->where('id', $colleges->client_id)->pluck('last_name') }} 
	</a>
	>> Edit Colleges</div>
<div class="body">
{{ Form::model($colleges, array('url' => 'colleges/edit', $colleges->id)) }}	
		<!--id-->
		{{ Form::hidden('id') }}
		<!-- name -->

		<div class="field">{{  DB::table('institutes')->where('id', $colleges->institute_id)->pluck('name') }}</div>

		<div class="field">{{  DB::table('courses')->where('id', $colleges->course_id)->pluck('name') }}</div>
		

		<div class="label">{{ Form::label('start_date', 'Start Date') }}</div>
		<div class="field">{{ Form::text('start_date') }}	</div>
		<div class="label">{{ Form::label('finish_date', 'Finish Date') }}</div>
		<div class="field">{{ Form::text('finish_date') }}	</div>
		
		<div class="label">{{ Form::label('total_tution_fee', 'Total Tution Fee') }}</div>
		<div class="field">{{ Form::text('Total Tution Fee') }}</div>
		<div class="label">{{ Form::label('total_discount', 'Total Discount') }}</div>
		<div class="field">{{ Form::text('total_discount') }}</div>
		<div class="label">{{ Form::label('discount_note', 'Discount Note') }}</div>
		<div class="field">{{ Form::textarea('discount_note') }}</div>
		<div class="label">{{ Form::label('student_id', 'Student Id') }}</div>
		<div class="field">{{ Form::text('student_id') }}</div>

		<div class="label">{{ Form::label('college_status_id', 'status') }}</div>

		<div class="field">{{ Form::select('college_status_id', DB::table('college_statuses')->lists('name','id'),$colleges->college_status_id ) }}</div>


		<div class="label">{{ Form::label('invoice_to', 'Invoice To') }}</div>
		<div class="field">{{ Form::text('invoice_to') }}</div>
		<div class="label">{{ Form::label('notes', 'Notes') }}</div>
		<div class="field">{{ Form::textarea('notes') }}</div>
		{{ Form::submit('Update College!') }}

	{{ Form::close() }}
</div>

