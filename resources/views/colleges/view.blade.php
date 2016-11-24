<?php
$value=$colleges_details['0'];
?>
<div class="header">
			<a href={{ URL::to("clients/view/$value->client_id") }} >
				{{  DB::table('clients')->where('id', $value->client_id)->pluck('first_name') }} 
				{{  DB::table('clients')->where('id', $value->client_id)->pluck('last_name') }} 
			</a> >>
	College Details</div>
<div class="body">
	<table>
		<tr>
			<td width="600px" align=center>
				
				<div>{{ $value->id }} . <a href={{ URL::to("institutes/view/$value->institute_id") }} >
					{{  DB::table('institutes')->where('id', $value->institute_id)->pluck('name') }}</a>
					
				 <a href=<?php echo URL::to("colleges/edit/$value->id");?>>
				{{ HTML::image('images/actions/edit.jpg','delete',array('width' => 20 , 'height' => 20));}}
				</a>
				 </div>
				
				<div><a href={{ URL::to("courses/view/$value->course_id") }} >
					{{  DB::table('courses')->where('id', $value->course_id)->pluck('name') }}</div>
					</a></div>
				<div class="label">Status:</div>
				<div class="field">{{ DB::table('college_statuses')->where('id', $value->college_status_id)->pluck('name') }}</div>
				<div class="label">Student Id:</div>
				<div class="field">{{ $value->student_id }}</div>
				<div class="label">Start Date</div>
				<div class="field">{{ $value->start_date }}</div>
				<div class="label">End Date</div>
				<div class="field">{{ $value->finish_date }}</div>
				<div class="label">Total Tution Fee</div>
				<div class="field">{{ $value->total_tution_fee }}</div>
				<div class="label">Total Discount</div>
				<div class="field">{{ $value->total_discount }}</div>
				<div class="label">Discount Notes : </div>
				<div class="field">{{ $value->discount_note }}</div>
				<div class="label">Invoice To</div>
				<div class="field">{{ $value->invoice_to }}</div>
				<div class="label">Added By : </div>
				<div class="field">{{  DB::table('users')->where('id', $value->user_id)->pluck('username') }}</div>
				<div class="label">Notes : </div>
				<div class="field">{{ $value->notes }}</div>

			</td>
			
		</tr>
	</table>
</div>
<div class="invoices index">
	<div class="page-header">
		<h2> College Invoices </h2>
 	</div>
 	<div class="add">
 		<a href=<?php echo URL::to("invoices/add/$value->id");?>>
				{{ HTML::image('images/actions/add.jpeg','Add',array('width' => 20 , 'height' => 20));}} Add invoices
		</a>
 	</div>

	<table cellpadding="5" cellspacing="5">
	<tr align="center">
			<th><?php echo ('id'); ?></th>
			<th><?php echo ('Invoice Date'); ?></th>
			<th><?php echo ('Tution Fee'); ?></th>
			<th><?php echo ('Total Commission'); ?></th>
			<th><?php echo ('GST'); ?></th>
			
			<th><?php echo ('Claimed Date'); ?></th>
			<th><?php echo ('Added By'); ?></th>
			<th class="actions"><?php echo "Processing"; ?></th>
	</tr>
	<?php
	foreach ($invoices as $i=>$invoice): 
		$id=$invoice['id'];
		?>
	<tr align="center">
		<td><?php echo ($invoice['id']); ?>&nbsp;</td>
		<td><?php echo ($invoice['invoice_date']); ?>&nbsp;</td>
		<td><?php echo ($invoice['tution_fee']); ?>&nbsp;</td>
		<td><?php echo ($invoice['totalCommission']); ?>&nbsp;</td>
		<td><?php echo ($invoice['gst']); ?>&nbsp;</td>
		
		<td><?php echo ($invoice['claimed_date']); ?>&nbsp;</td>
		<td>{{ DB::table('users')->where('id', $invoice['user_id'])->pluck('username') }}</td>
		<td width="80">
		
			<a href=<?php echo URL::to("invoices/view/$id");?>>{{ HTML::image("images/actions/view.jpg", "view") }}</a>
			<a href=<?php echo URL::to("invoices/edit/$id");?>>{{ HTML::image("images/actions/edit.jpg", "view") }}</a>
			<a href=<?php echo URL::to("invoices/delete/$id");?>>{{ HTML::image("images/actions/delete.jpg", "view") }}</a>
			
  		</td>
	</tr>
	<?php endforeach; ?>
	</table>
	
</div>

<div class="student invoices index">
	<div class="page-header">
		<h2> Student Invoices </h2>
 	</div>

 	<div class="add">
 		<a href=<?php echo URL::to("student_invoices/add/$value->id");?>>
				{{ HTML::image('images/actions/add.jpeg','Add',array('width' => 20 , 'height' => 20));}} Add Student Invoices
		</a>
 	</div>
	<table cellpadding="5" cellspacing="5">
	<tr align="center">
			
				<th>Id</th><th>Date</th><th>Amount</th><th>Discount</th><th>Payable Amount</th><th>Added By</th><th>Processing</th>
			
	</tr>
	<?php
	foreach ($student_invoices as $i=>$invoice): 
		$id=$invoice->id;
		?>
	<tr align="center">
		<td><?php echo ($invoice->id); ?>&nbsp;</td>
		<td><?php echo ($invoice->date); ?>&nbsp;</td>
		<td><?php echo ($invoice->amount); ?>&nbsp;</td>
		<td><?php echo ($invoice->discount); ?>&nbsp;</td>
		<td><?php echo ($invoice->payable_amount); ?>&nbsp;</td>
		<td>{{ DB::table('users')->where('id', $invoice->user_id)->pluck('username') }}</td>
		
		
		<td width="80">
		
			<a href=<?php echo URL::to("student_invoices/view/$id");?>>{{ HTML::image("images/actions/view.jpg", "view") }}</a>
			<a href=<?php echo URL::to("student_invoices/edit/$id");?>>{{ HTML::image("images/actions/edit.jpg", "view") }}</a>
			<a href=<?php echo URL::to("student_invoices/delete/$id");?>>{{ HTML::image("images/actions/delete.jpg", "view") }}</a>
			
  		</td>
	</tr>
	<?php endforeach; ?>
	</table>
	
</div>


<div class="student payment index">
	<div class="page-header">
		<h2> Student Payment List</h2>
 	</div>


	<table cellpadding="5" cellspacing="5">
	<tr align="center">
			
				<th>Id</th><th>Date</th><th>Amount</th><th>Notes</th><th>Added By</th><th>Payment Type</th><th>Actual Payment Id</th><th>Processing</th>
			
	</tr>
	<?php
	foreach ($payment_invoices as $i=>$invoice): 
		$id=$invoice->id;
		?>
	<tr align="center">
		<td><?php echo ($invoice->id); ?>&nbsp;</td>
		<td><?php echo ($invoice->date); ?>&nbsp;</td>
		<td><?php echo ($invoice->amount); ?>&nbsp;</td>
		<td><?php echo ($invoice->notes); ?>&nbsp;</td>
		<td>{{ DB::table('users')->where('id', $invoice->user_id)->pluck('username') }}</td>
		<td>{{ DB::table('payment_types')->where('id', 
			DB::table('payments')->where('id', $invoice->payment_id)->pluck('payment_type_id')
			)->pluck('name') }}</td>
		<td><a href=<?php echo URL::to("payments/view/$invoice->payment_id");?>><?php echo ($invoice->payment_id); ?></a></td>
		
		
		
		<td width="80">
		
			<a href=<?php echo URL::to("payment_invoices/view/$id");?>>{{ HTML::image("images/actions/view.jpg", "view") }}</a>
			<a href=<?php echo URL::to("payment_invoices/edit/$id");?>>{{ HTML::image("images/actions/edit.jpg", "view") }}</a>
			<a href=<?php echo URL::to("payment_invoices/delete/$id");?>>{{ HTML::image("images/actions/delete.jpg", "view") }}</a>
			
  		</td>
	</tr>
	<?php endforeach; ?>
	
	</table>
	
</div>


