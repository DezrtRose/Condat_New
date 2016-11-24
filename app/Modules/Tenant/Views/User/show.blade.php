@extends('layouts.tenant')
@section('title', 'Agent View')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/users')}}" title="All Users"><i class="fa fa-users"></i> Agents</a></li>
    <li>View</li>
@stop
@section('content')
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">

                <h3 class="profile-username ">Full Name</h3>
                 

                <p class="text-muted ">User ID: </p>
                <hr>
                <strong><i class="fa fa-calendar margin-r-5"></i> Role</strong>
                <p class="text-muted ">Role: </p>
                <hr>
                <strong><i class="fa fa-calendar margin-r-5"></i> Created At</strong>
                <p class="text-muted"></p>
                <hr>
                <strong><i class="fa fa-calendar margin-r-5"></i> No.of Clients</strong>
                <p class="text-muted">No. of Client Added by this User</p>
                <hr>
                
                
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        
    </div>
    <div class="col-xs-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">User Details</h3>
                <div class="box-tools pull-right"><a data-toggle="tooltip" title="Edit Agent" class="btn btn-action-box" href ="{{route('tenant.agents.edit', [$tenant_id, $agent->agent_id])}}"><i class="fa fa-edit"></i></a> </div>
            </div>
            <div class="box-body">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th style="width: 34%;">User ID</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Full Name</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>DOB</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Sex</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td></td>
                    </tr>
                    
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-map-marker"></i> Address Details</h3>
            </div>
            <div class="box-body">
                <table class="table table-hover">
                <tbody>
                <tr style="width: 34%;">
                    <th>Street</th>
                    <td>{{ $agent->street }}</td>
                </tr>
                <tr>
                    <th>Suburb</th>
                    <td>{{ $agent->suburb }}</td>
                </tr>
                <tr>
                    <th>Postcode</th>
                    <td>{{ $agent->postcode }}</td>
                </tr>
                <tr>
                    <th>State</th>
                    <td>{{ $agent->state }}</td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>{{ get_country($agent->country_id) }}</td>
                </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
