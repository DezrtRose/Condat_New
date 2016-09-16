<script type="text/javascript">
$(document).ready(function(){

	if ($('select#institute_id').val()) {
		var val = $('select#institute_id').val();
		getCourses(val);
	}

	getCourses(val);
	

	$("#institute_id").change(function(){
		var val = $('select#institute_id').val();
		getCourses(val);
	});



	function getCourses (val) {
		// for course list
		$.ajax({
			url : "{{ $host_link }}"+"public/institutes/getCourses/"+val,
			success : function(data) {
				$("#total_tution_fee").val('');
				$('#course_id').empty();
				$('#course_id').append($("<option value=0>choose a course</option>"));
				for (i=0;i<=data.length-1;i++){
					$('#course_id').append($("<option value="+data[i]['id']+">"+data[i]['name']+"</option>"));
				}
			}
		});
		//for invoice to
		$.ajax({
			url : "{{ $host_link }}"+"public/institutes/getInvoiceTo/"+val,
			success : function(data) {
				//alert(data[0]['invoice_to']);
				$('#invoice_to').val(data[0]['invoice_to']);
			}
		});
	}

	
	

	$("#course_id").change(function(){
		var val = $('select#course_id').val();

		getCoursesInfo(val);
	});

	function getCoursesInfo (val) {
		
		
		$.ajax({
			url :"{{ $host_link }}"+"laravel/public/courses/getCourseInfo/"+val,
			success : function(data) {
				
				$("#total_tution_fee").val(data[0]['total_fee']);
				
				
			}
		});
		
	}


});



</script>
<div class="header">
	<a href={{ URL::to("clients/view/$client_id") }} >
	{{  DB::table('clients')->where('id', $client_id)->pluck('first_name') }} 
	{{  DB::table('clients')->where('id', $client_id)->pluck('last_name') }} 
	</a>
 	>> Add Colleges</div>
<div class="body">
<?php

if ($errors->has()){
			foreach ($errors->all() as $error)
			{
			    print_r("<font color=red>".$error."</font></br> ");
			}
}
?>
{{ Form::open(array('url' => 'colleges/save')) }}
<div class="label">{{ Form::label('institute_id', 'Institute') }}</div>
<div class="field">{{ Form::select('institute_id', DB::table('institutes')->lists('name','id'),Input::old('institute_id') ) }}</div>
<div class="label">{{ Form::label('course_id', 'Course') }}</div>
<div class="field">{{ Form::select('course_id', DB::table('courses')->lists('name','id'),Input::old('course_id') ) }}</div>
{{ Form::hidden('client_id',$client_id) }}
<div class="label">{{ Form::label('total_tution_fee', 'Total Tution Fee') }}</div>
<div class="field">{{ Form::text('total_tution_fee',Input::old('total_tution_fee')) }}</div>
<div class="label">{{ Form::label('start_date', 'Start Date') }}</div>
<div class="field">{{ Form::text('start_date',Input::old('start_date')) }}</div>
<div class="label">{{ Form::label('finish_date', 'Finish Date') }}</div>
<div class="field">{{ Form::text('finish_date',Input::old('finish_date')) }}</div>
<div class="label">{{ Form::label('total_discount', 'Total Discount') }}</div>
<div class="field">{{ Form::text('total_discount',Input::old('total_discount')) }}</div>
<div class="label">{{ Form::label('discount_note', 'Discount Note') }}</div>
<div class="field">{{ Form::textarea('discount_note',Input::old('discount_note')) }}</div>
<div class="label">{{ Form::label('student_id', 'Student Id') }}</div>
<div class="field">{{ Form::text('student_id',Input::old('student_id')) }}</div>
<div class="field">{{ Form::hidden('user_id',Auth::user()->id) }}</div>
<div class="label">{{ Form::label('invoice_to', 'Invoice To') }}</div>
<div class="field">{{ Form::text('invoice_to') }}</div>
<div class="label">{{ Form::label('notes', 'Notes') }}</div>
<div class="field">{{ Form::textarea('notes') }}</div>
<div class="field">{{ Form::hidden('college_status_id','1') }}</div>

{{ Form::submit('Submit') }}


<div>
	
