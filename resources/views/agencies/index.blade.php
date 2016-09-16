@extends('layouts.default')
@section('title','Agency List')

@section('content')
    

<div class="container">
    <div class="page-header">
        <h1>Agencies - <small>List</small></h1>
    </div>
    
    
    @if (Session::has('message'))
   <div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif


    <div>
        <!-- Table -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <tr><th>Id</th>
                    	<th>Company Name</th>
                    	<th>Website</th>
                    	<th>Phone</th>
                    	<th>subscription</th>
                    	<th>Status</th>
                    	<th>Start Date</th>
                    	<th>End Date </th>
                    	<th>Processing</th>
                </tr>
            </thead>
            <tbody>
            	<?php
					foreach ($agencies as $key => $value) {
						$id=$value->agency_id ;
				?>
                <tr>
                    <td>{{ $value->agency_id  }}</td>
					<td>{{ $value->name  }} </td>
					<td>{{ $value->website  }}</td>
					<td>{{ "$value->country_code $value->area_code $value->number" }}</td>
					<td>{{  DB::table('standard_subscriptions')->where('standard_subscription_id', $value->standard_subscription_id)->pluck('name') }}</td>
					<td>{{  DB::table('subscription_status')->where('subscription_status_id', $value->subscription_status_id)->pluck('name') }}</td>
					<td>{{ $value->start_date  }}</td>
					<td>{{ $value->end_date }}</td>
                    <td>
                        <div>
                            <a href=<?php echo url("agencies/view/$id");?> title="View" class="btn"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                            <a href=<?php echo url("agencies/edit/$id");?> title="Edit" class="btn"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                            <a href=<?php echo url("agencies/delete/$id");?> title="Delete" class="btn"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                        </div>
                    </td>
                </tr>
                <?php
					}
				?>
               
            </tbody>
        </table>
    </div>

    <div>
	{!! $agencies->setPath('')->render() !!}
	</div>
</div>


@endsection



