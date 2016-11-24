<?php
	$value=$addresses_details['0'];
?>
<div class="header">
	<a href={{ URL::to("institutes/view/$value->institute_id") }}>
	{{ DB::table('institutes')->where('id', $value->institute_id)->pluck('name') }} </a> 
	>> Address Details
</div>
<div class="body">
	<table>
		<tr>
			<td width="600px" align=center>
				
				<div class="label">Id </div>
				<div class="field">{{ $value->id }}</div>
				<div class="label">Street</div>
				<div class="field">{{ $value->street }}</div>
				<div class="label">Suburb</div>
				<div class="field">{{ $value->suburb }}</div>
				<div class="label">State</div>
				<div class="field">{{ $value->state }}</div>
				<div class="label">Postcode</div>
				<div class="field">{{ $value->postcode }}</div>
				<div class="label">Phone</div>
				<div class="field">{{ $value->phone_no }}</div>
				<div class="label">Email</div>
				<div class="field">{{ $value->email }}</div>
				<div class="label">Added By </div>
				<div class="field">{{ DB::table('users')->where('id',  $value->user_id)->pluck('username') }}</div>

				
			</td>
		</tr>
	</table>

</body>