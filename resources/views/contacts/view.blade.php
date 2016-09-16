<?php
	$value=$contacts_details['0'];
?>
<div class="header">
	<a href={{ URL::to("institutes/view/$value->institute_id") }}>
	{{ DB::table('institutes')->where('id', $value->institute_id)->pluck('name') }} </a> 
	>> Contact Details
</div>
<div class="body">
	<table>
		<tr>
			<td width="600px" align=center>
				
				<div class="label">Id : </div>
				<div class="field">{{ $value->id }}</div>
				<div class="label">Name : </div>
				<div class="field">{{ $value->name }}</div>
				<div class="label">Phone : </div>
				<div class="field">{{ $value->phone_no }}</div>
				<div class="label">Email : </div>
				<div class="field">{{ $value->email }}</div>
				<div class="label">Department : </div>
				<div class="field">{{ $value->department }}</div>
				<div class="label">Added By : </div>
				<div class="field">{{ DB::table('users')->where('id', $value->user_id)->pluck('username') }}</div>
				<div class="label">Notes : </div>
				<div class="field"><pre>{{ $value->notes }}</pre></div>

				
			</td>
		</tr>
	</table>

</body>