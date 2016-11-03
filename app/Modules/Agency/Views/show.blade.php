@extends('layouts.main')
@section('title', 'View Agency')
@section('heading', 'View Agency')
@section('breadcrumb')
    @parent
    <li><a href="{{url('agency')}}" title="All Agencies"><i class="fa fa-Agencies"></i> Agencies</a></li>
    <li>View</li>
@stop
@section('content')
    <div class="col-md-4">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                {{--<img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg"
                     alt="User profile picture">--}}

                <h3 class="profile-username text-center"><b>{{$agency->name}}</b></h3>

                <p class="text-muted text-center">Agency ID: {{format_id($agency->agency_id, 'A')}}</p>

                <strong><i class="fa fa-calendar margin-r-5"></i> Created At</strong>
                <p class="text-muted">{{format_datetime($agency->created_at)}}</p>
                <hr>
                <strong><i class="fa fa-database margin-r-5"></i> Database Name</strong>
                <p class="text-muted">{{$agency->company_database_name}}</p>
                <hr>
                <strong><i class="fa fa-file-text-o margin-r-5"></i> Description</strong>
                <p class="text-muted">{{$agency->description}}</p>
                <hr>

                <a href="{{route('agency.edit', $agency->agency_id)}}"
                   class="btn btn-primary btn-block"><b>Update</b></a>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Company Details</h3>
            </div>
            <div class="box-body">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th style="width: 34%;">Company ID</th>
                        <td>{{format_id($agency->company_id, 'C')}}</td>
                    </tr>
                    <tr>
                        <th>Company Name</th>
                        <td>{{$agency->name}}</td>
                    </tr>
                    <tr>
                        <th>Email ID</th>
                        <td>{{$agency->email_id}}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{$agency->phone_id ? $agency->phone_id : 'N/A'}}</td>
                    </tr>
                    <tr>
                        <th>ABN</th>
                        <td>{{$agency->abn or 'N/A'}}</td>
                    </tr>
                    <tr>
                        <th>ACN</th>
                        <td>{{$agency->acn or 'N/A'}}</td>
                    </tr>
                    <tr>
                        <th>Website</th>
                        <td><a href="http://{{$agency->website  or 'Undefined'}}">{{$agency->website  or 'N/A'}}</a>
                        </td>
                    </tr>
                    <tr>
                        <th>Invoice To</th>
                        <td>{{$agency->invoice_to_name}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-map-marker"></i> Address Details</h3>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt>Line 1</dt>
                    <dd>{{ $agency->line1 ? $agency->line1 : 'N/A' }}</dd>
                    <dt>Line 2</dt>
                    <dd>{{ $agency->line2 ? $agency->line2 : 'N/A' }}</dd>
                    {{--<dt>Street</dt>
                    <dd>{{ $agency->street ? $agency->street : 'N/A' }}</dd>--}}
                    <dt>Suburb</dt>
                    <dd>{{ $agency->suburb ? $agency->suburb : 'N/A' }}</dd>
                    <dt>Postcode</dt>
                    <dd>{{ $agency->postcode ? $agency->postcode : 'N/A' }}</dd>
                    <dt>State</dt>
                    <dd>{{ $agency->state ? $agency->state : 'N/A' }}</dd>
                    <dt>Country</dt>
                    <dd>{{ $agency->country_id ? config('constants.countries')[$agency->country_id] : 'N/A' }}</dd>
                    {{--<dt>Type</dt>
                    <dd>{{ $agency->type }}</dd>--}}
                </dl>
            </div>
        </div>
    </div>
@stop
