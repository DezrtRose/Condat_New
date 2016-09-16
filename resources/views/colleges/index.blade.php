<div class="header">College List</div>
<div><a href=<?php echo URL::to("colleges/add");?>>Add College</a></div>

@if (Session::has('message'))
   <div class="message">{{ Session::get('message') }}</div>
@endif	

<table>
	<tr><th>Id</th><th>College Name</th><th>Course Name</th><th>Student Id</th><th>Total Tution Fee</th>
		<th>Total Discount</th><th>Invoice To</th><th>Username</th><th>Processing</th>
<?php
foreach ($colleges as $key => $value) {
	$id=$value['id'];
	?>
	<tr>
		<td>{{ $value['id'] }}</td>
		<td>{{ $value['institute_id'] }} </td>
		<td>{{ $value['course_id'] }}</td>
		<td>{{ $value['student_id'] }}</td>
		<td>{{ $value['total_tution_fee'] }}</td>
		<td>{{ $value['total_discount'] }}</td>
		<td>{{ $value['invoice_to'] }}</td>
		<td>{{ $value['username'] }}</td>
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