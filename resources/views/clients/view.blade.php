@extends('layouts.default')
@section('title','Client Dashboard')





<div class="container">
    <div class="page-header">
        <h1>Client - <small>Dashboard</small></h1>
    </div>
    <h2>{!! $clients->first_name." ".$clients->middle_name." ".$clients->last_name !!}</h2>
    <h5>{!! $clients->dob." ".$clients->sex." ".$clients->passport_no !!}</h5>

    <div class="details">
        <div class="row">
            <div class="col-xs-6">
                <h5>Course Information</h5>
                <p>
                    Currently Enrolled in<br/>
                    Diploma in Information Technology<br/>
                    from <strong>Hogwards University</strong><br/>
                    From 03/05/2014 to 05/04/2015
                </p>
            </div>
            <div class="col-xs-6">
                <h3>Contact Details</h3>
                <ul class="list-unstyled">
                    <li><strong>Phone: </strong>{!! $clients->country_code !!} {!! $clients->area_code !!} {!! $clients->number !!}  ({!! $clients->type !!})</li>
                    <li><strong>Email: </strong>{{ $clients->email }}</li>
                    <li>{{ $clients->street }}</li>
                    <li>{{ $clients->suburb }} {{ $clients->state }} {{ $clients->postcode }}</li>
                    <li>{{  DB::table('countries')->where('country_id', $clients->country_id)->pluck('name') }} </li>
                    <li>Added on : {{ $clients->created_at }}</li>
                    <li>Updated on : {{ $clients->updated_at }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div>
        <h3>Notes / Reminders</h3>
        <a href="#">View All</a>
        <ul class="list-unstyled">
            <li>[Note 1]</li>
            <li>[Note 2]</li>
            <li>[Note 3]</li>
            <li>[Note 4]</li>
        </ul>
    </div>

    <div>
        <h3>Outstanding Amount</h3>
        <div class="amount"><strong>$1200.00</strong></div>
    </div>

</div>
			
		<?php
		/*

				
			</td>
			<td>
				<div>
					<div>Recent Updates<div>
					<div>Visa Expiry Date :5/6/2015</div>
					<div>Recent Payments | 
						<a href=<?php echo URL::to("payments/client_payments/$clientId");?>> View All Payments </a> | 
						<a href=<?php echo URL::to("payments/add/$clientId");?>>
							{{ HTML::image('images/actions/add.jpeg','Add',array('width' => 20 , 'height' => 20));}} Add Payment
						</a></div>
					<div class="payment_list">
						<table>
							<tr><th>Id</th><th>Payment Type</th><th>Date</th><th>Amount</th><th>Payment Method</th><th>Added By</th><th>Processing</th></tr>
							<tr>

								<?php
								foreach ($payments as $key => $value) {
									$id=$value['id'];
									?>
									<tr>
										<td>{{ $value['id'] }}</td>
										<td>{{ DB::table('payment_types')->where('id', $value['payment_type_id'])->pluck('name') }}</td>
										
										<td>{{ $value['date'] }}</td>
										<td>{{ $value['amount'] }}</td>
										<td>{{ $value['payment_method'] }}</td>
										<td>{{ DB::table('users')->where('id', $value['user_id'])->pluck('username') }}</td>
										<td>
											<a href=<?php echo URL::to("payments/view/$id");?>>
												{{ HTML::image('images/actions/view.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
											<a href=<?php echo URL::to("payments/edit/$id");?>>
												{{ HTML::image('images/actions/edit.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
											<a href=<?php echo URL::to("payments/delete/$id");?>>
												{{ HTML::image('images/actions/delete.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
										</td>
									</tr>
								<?php
								}
								?>		
							</tr>
						</table>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>

<div class="header">College List</div>
<div class="add">
 		<a href=<?php echo URL::to("colleges/add/$clientId");?>>
				{{ HTML::image('images/actions/add.jpeg','Add',array('width' => 20 , 'height' => 20));}} Add College
		</a>
 </div>

<table>
	<tr><th>Id</th><th>College Name</th><th>Course Name</th><th>Student Id</th><th>Total Tution Fee</th>
		<th>Total Discount</th><th>Status</th><th>Outstanding Balance</th><th>Username</th><th>Processing</th>
<?php
foreach ($colleges as $key => $value) {
	$id=$value['id'];
	?>
	<tr>
		<td>{{ $value['id'] }}</td>
		<td>{{ DB::table('institutes')->where('id', $value['institute_id'])->pluck('name') }}
		</td>
		<td>{{ DB::table('courses')->where('id', $value['course_id'])->pluck('name') }}</td>
		<td>{{ $value['student_id'] }}</td>
		<td>{{ $value['total_tution_fee'] }}</td>
		<td>{{ $value['total_discount'] }}</td>
		<td>{{ DB::table('college_statuses')->where('id', $value['college_status_id'])->pluck('name') }}</td>
		<td>{{ College::studentOutstandingInvoice($id) }}</td>
		<td>{{ DB::table('users')->where('id', $value['user_id'])->pluck('username') }}</td>
		<td>
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



<div class="header">Visa List</div>

<div class="add">
 		<a href=<?php echo URL::to("visas/add/$clientId");?>>
				{{ HTML::image('images/actions/add.jpeg','Add',array('width' => 20 , 'height' => 20));}} Add Visa
		</a>
 </div>

<table>
	<tr><th>Id</th><th>Visa Type</th><th>Subclass</th><th>Visa Status</th><th>Total Charge</th><th>Expiry Date</th>
		<th>Consultant</th><th>Outstanding</th><th>Username</th><th>Processing</th>
<?php
foreach ($visas as $key => $value) {
	$id=$value['id'];
	?>
	<tr>
		<td>{{ $value['id'] }}</td>
		<td>{{ DB::table('visa_types')->where('id', $value['visa_type_id'])->pluck('name') }}</td>
		<td>{{ $value['subclass'] }}</td>
		<td>{{ DB::table('visa_statuses')->where('id', $value['visa_status_id'])->pluck('name') }} </td>
		<td>{{ $value['total_charge'] }}</td>
		<td>{{ $value['expiry_date'] }}</td>
		<td>{{ $value['consultant'] }}</td>
		<td>{{ Visa::visaOutstandingInvoice($id) }}</td>
		<td>{{ DB::table('users')->where('id', $value['user_id'])->pluck('username') }}</td>
		<td>
			<a href=<?php echo URL::to("visas/view/$id");?>>
				{{ HTML::image('images/actions/view.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
			<a href=<?php echo URL::to("visas/edit/$id");?>>
				{{ HTML::image('images/actions/edit.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
			<a href=<?php echo URL::to("visas/delete/$id");?>>
				{{ HTML::image('images/actions/delete.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
		</td>
	</tr>
<?php
}
?>
</table>

<div class="header">Healthcover List</div>
<div class="add">
 		<a href=<?php echo URL::to("healthcovers/add/$clientId");?>>
				{{ HTML::image('images/actions/add.jpeg','Add',array('width' => 20 , 'height' => 20));}} Add Healthcover
		</a>
 </div>
<table>
	<tr><th>Id</th><th>Membership Name</th><th>Membership No</th><th>Cover Length</th><th>Start Date</th><th>End Date</th>
		<th>Total Charge</th><th>Username</th><th>Processing</th>
<?php
foreach ($healthcovers as $key => $value) {
	$id=$value['id'];
	?>
	<tr>
		<td>{{ $value['id'] }}</td>
		<td>{{ $value['membership_name'] }} </td>
		<td>{{ $value['membership_no'] }}</td>
		<td>{{ $value['cover_length'] }}</td>
		<td>{{ $value['start_date'] }}</td>
		<td>{{ $value['end_date'] }}</td>
		<td>{{ $value['total_charge'] }}</td>
		<td>{{ DB::table('users')->where('id', $value['user_id'])->pluck('username') }}</td>
		<td>
			<a href=<?php echo URL::to("healthcovers/view/$id");?>>
				{{ HTML::image('images/actions/view.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
			<a href=<?php echo URL::to("healthcovers/edit/$id");?>>
				{{ HTML::image('images/actions/edit.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
			<a href=<?php echo URL::to("healthcovers/delete/$id");?>>
				{{ HTML::image('images/actions/delete.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
		</td>
	</tr>
<?php
}
?>
</table>
