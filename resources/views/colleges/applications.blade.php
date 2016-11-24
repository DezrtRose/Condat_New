<script type="text/javascript">
$(document).ready(function(){

	$("#hide").click(function(){
	  $("#search").hide();
	});

	$("#show").click(function(){
	  $("#search").show();
	});

});

</script>

<div class="header">Application Tracker</div>
<div class="body">
	<div class="options">
		<a href=<?php echo URL::to("colleges/applications/1");?>>Enquiry</a> 
		<a href=<?php echo URL::to("colleges/applications/2");?>>Offer Pending</a> 
		<a href=<?php echo URL::to("colleges/applications/3");?>>Offer Received</a> 
		<a href=<?php echo URL::to("colleges/applications/4");?>>Coe</a> 
		<a href=<?php echo URL::to("colleges/applications/5");?>>Enrolled</a> 
		<a href=<?php echo URL::to("colleges/applications/6");?>>Completed</a> 
		<a href=<?php echo URL::to("colleges/applications/7");?>>Discontinued</a>

	</div>
	<p><a href="#" id="show">show advance search</a></p>
	<div class="search" id="search" style="display:none">
		{{ Form::open(array('url' => 'colleges/search')) }}
		<?php
			// for institute list
			$arrayInstitute = DB::table('institutes')->orderBy('name', 'asc')->lists('name','id');
			//$arrayInstitute['0']="all";
			
			

			//for users list
			$arrayUsers = DB::table('users')->orderBy('username', 'asc')->lists('username','id');
			
			

			//for college list
			$arrayCollegeStatus = DB::table('college_statuses')->orderBy('name', 'asc')->lists('name','id');
			




		?>
		
			<div class="label"> Institute Name : </div>
			<div class="field">{{ Form::select('institute_id',array('0' => 'all')+$arrayInstitute,Input::old('institute_id') ) }}</div>
			
			<div class="label">Invoice To:</div>
			<div class="field"><input type="text" id="invoice_to" name="invoice_to"></div>
			<div class="label">Added By </div>
			<div class="field">{{ Form::select('added_by',array('0' => 'all')+$arrayUsers,Input::old('added_by') ) }}</div>
			<div class="label">College Status </div>
			<div class="field">{{ Form::select('college_status',array('0' => 'all')+$arrayCollegeStatus,Input::old('college_status') ) }}</div>


		{{ Form::submit('Submit') }}
		<a href="#" id="hide">hide</a>
	</div>

	<div class="data">
		<table>
		<tr><th>Id</th><th>Client Name</th><th>Phone No</th><th>Email</th><th>College Name</th><th>Course Name</th><th>Start Date</th>
			<th>Added By</th><th>Processing</th>
			<?php


			foreach ($applications as $key => $value) {
				$id=$value->id;
				?>
				<tr>
					<td>{{ $id }}</td>
					<td><a href={{ URL::to("clients/view/$value->client_id") }} >
						{{  DB::table('clients')->where('id', $value->client_id)->pluck('first_name') }} 
						{{  DB::table('clients')->where('id', $value->client_id)->pluck('last_name') }} 
						</a>
					</td>
					<td>{{ DB::table('clients')->where('id', $value->client_id)->pluck('phone_no') }}</td>
					<td>{{ DB::table('clients')->where('id', $value->client_id)->pluck('email') }}</td>
					<td>{{ DB::table('institutes')->where('id', $value->institute_id)->pluck('name') }}</td>
					<td>{{ DB::table('courses')->where('id', $value->course_id)->pluck('name') }}</td>
					<td>{{ $value->start_date }}</td>
					<td>{{ DB::table('users')->where('id', $value->user_id)->pluck('username') }}</td>
					<td>
						<?php
						if ($value->college_status_id != 6 && $value->college_status_id != 7) {
							?>
							<a href=<?php echo URL::to("colleges/status_update/$id/$value->college_status_id");?>>{{ HTML::image('images/actions/confirm.jpg','confirm',array('width' => 20 , 'height' => 20))}}</a>
							<?php
						}

						?>
						
						<a href=<?php echo URL::to("colleges/view/$id");?>>
							{{ HTML::image('images/actions/view.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
						<a href=<?php echo URL::to("colleges/edit/$id");?>>
							{{ HTML::image('images/actions/edit.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
						<a href=<?php echo URL::to("colleges/delete/$id");?>>
							{{ HTML::image('images/actions/delete.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
					</td>
				</tr>
		<?php
		}

		?>
		</table>
	</div>
</div>