<div class="header">Companies Details</div>
<div class="body">
	<table>
		<tr>
			<td width="600px" align=center>
				<?php
				$value=$companies_details[0];
				?>
				<div>{{ $value->id }} . <a href={{ URL::to("companies/edit/$value->id") }} >edit</a></div>
				
				<div class="label">Name : </div>
				<div class="field">{{ $value->name }}</div>
				<div class="label">ABN</div>
				<div class="field">{{ $value->abn }}</div>
				<div class="label">Street : </div>
				<div class="field">{{ $value->street }}</div>
				<div class="label">Suburb</div>
				<div class="field">{{ $value->suburb }}</div>
				<div class="label">State : </div>
				<div class="field">{{ $value->state }}</div>
				<div class="label">Postcode : </div>
				<div class="field">{{ $value->postcode }}</div>
				<div class="label">Country</div>
				<div class="field">{{ DB::table('countries')->where('id', $value->country_id)->pluck('name') }} &nbsp;</div>
				<div class="label">Phone No : </div>
				<div class="field">{{ $value->phone_no }}</div>
				<div class="label">Email : </div>
				<div class="field">{{ $value->email }}</div>
				<div class="label">Fax : </div>
				<div class="field">{{ $value->fax }}</div>
				<div class="label">Website : </div>
				<div class="field">{{ $value->website }}</div>
				<div class="label">Account Name : </div>
				<div class="field">{{ $value->account_name }}</div>
				<div class="label">Account No : </div>
				<div class="field">{{ $value->account_no }}</div>
				<div class="label">BSB : </div>
				<div class="field">{{ $value->bsb }}</div>
				<div class="label">Bank Name : </div>
				<div class="field">{{ $value->bankname }}</div>


				
			</td>
			
		</tr>
	</table>
</div>
