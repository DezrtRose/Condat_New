<div class="header">Contacts List</div>
<div><a href=<?php echo URL::to("contacts/add");?>>Add Contacts</a></div>	
@if (Session::has('message'))
   <div class="message">{{ Session::get('message') }}</div>
@endif
<table>
	<tr><th>Id</th><th>Name</th><th>Department</th><th>Phone No</th><th>Email</th><th>Institute Id</th><th>username</th><th>Processing</th>
<?php
foreach ($contacts as $key => $value) {
	$id=$value['id'];
	?>
	<tr>
		<td>{{ $value['id'] }}</td>
		<td>{{ $value['name'] }} </td>
		<td>{{ $value['department'] }}</td>
		<td>{{ $value['phone_no'] }}</td>
		<td>{{ $value['email'] }}</td>
		<td>{{ $value['institute_id'] }}</td>
		<td>{{ $value['user_id'] }}</td>
		<td>
			<a href=<?php echo URL::to("contacts/view/$id");?>>
				{{ HTML::image('images/actions/view.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
			<a href=<?php echo URL::to("contacts/edit/$id");?>>
				{{ HTML::image('images/actions/edit.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
			<a href=<?php echo URL::to("contacts/delete/$id");?>>
				{{ HTML::image('images/actions/delete.jpg','delete',array('width' => 20 , 'height' => 20));}}</a>
		</td>
	</tr>
<?php
}
?>
</table>
