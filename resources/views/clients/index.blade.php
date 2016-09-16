@extends('layouts.default')
@section('title','Client List')

@section('content')
    

<body class="container">
    <div class="page-header">
        <h1>Client - <small>List</small></h1>
    </div>
    <form class="form-inline" action='clients/search' method="POST">
        <div class="form-group">
            <label for="filter">Filter By: </label>
           <form method="POST" action="/clients/search">
			<select name="searchIn" id="searchIn">
				<option value="first_name">First Name</option>
				<option value="last_name">Last Name</option>
				<option value="phone_no">Phone No</option>
				<option value="email">Email</option>
				<option value="country_id">Country</option>
				<option value="username">Username</option>
				<option value="reference">Reference</option>
			</select>
		
            <label for="search">Search For: </label>
            <input type="email" name="search" class="form-control" name="searchFor" id="searchFor" placeholder="">
        </div>
        <button type="submit" class="btn btn-success">Search</button>
        <a href=<?php echo url("clients/add");?>><button type="button" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-plus"></i> Create Client</button></a>



		
        
	        
	        	
	        
        </form>
    <p>&nbsp;</p>
    <div>
    @if (Session::has('message'))
   <div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif


    <div>
        <!-- Table -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <tr><th>Id</th>
                    	<th>First Name</th>
                    	<th>Last Name</th>
                    	<th>Phone</th>
                    	<th>Email</th>
                    	<th>Country</th>
                    	<th>Reference</th>
                    	<th>Added By</th>
                    	<th>Processing</th>
                </tr>
            </thead>
            <tbody>
            	<?php
					foreach ($clients as $key => $value) {
						$id=$value->client_id ;
				?>
                <tr>
                    <td>{{ $value->client_id  }}</td>
					<td>{{ $value->first_name  }} </td>
					<td>{{ $value->last_name  }}</td>
					<td>{{ "$value->country_code $value->area_code $value->number" }}</td>
					<td>{{ $value->email }}</td>
					<td>{{ DB::table('countries')->where('country_id', $value->country_id )->pluck('name')}}</td>
					<td>{{ $value->reffered_by  }}</td>
					<td>{{ DB::table('users')->where('user_id', $value->user_id )->pluck('user_name') }}</td>
                    <td>
                        <div>
                            <a href=<?php echo url("clients/view/$id");?> title="View" class="btn"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                            <a href=<?php echo url("clients/edit/$id");?> title="Edit" class="btn"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                            <a href=<?php echo url("clients/delete/$id");?> title="Delete" class="btn"><i class="glyphicon glyphicon-trash"></i> Delete</a>
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
	{!! $clients->setPath('')->render() !!}
	</div>
</body>


@endsection



