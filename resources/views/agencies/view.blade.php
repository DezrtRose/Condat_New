@extends('layouts.default')
@section('title','Agency View')

@section('content')

<div class="container">
    <div class="page-header">
        <h1>Agency - <small>View</small></h1>
    </div>
    <h5>{!! $agencies->agency_id !!}</h5><h2>{!! $agencies->name !!}</h2>
    <h5>{!! $agencies->abn." | ".$agencies->acn !!}</h5>


    <div class="details">
        <div class="row">
            <div class="col-xs-6">
               
                <ul class="list-unstyled">
                    <li><strong>Status </strong>{{ DB::table('subscription_status')->where('subscription_status_id', $agencies->subscription_status_id)->pluck('name') }} <strong></li>
                    <li>Start Date : </strong>{{ $agencies->start_date }} <strong>End Date :</strong> {{ $agencies->end_date }}</li>
                    <li><strong>Subscription </strong>{{ DB::table('standard_subscriptions')->where('standard_subscription_id', $agencies->standard_subscription_id)->pluck('name') }}</li>
                    <li><strong>Website: </strong>{!! $agencies->website !!}</li>
                    <li><strong>Invoice To: </strong>{{ $agencies->invoice_to_name }}</li>  
                    <li><strong>Number :</strong> {{ $agencies->country_code }} {{ $agencies->area_code }} {{ $agencies->number }}</li>
                   
                </ul>
            </div>
        </div>
    </div>

    <div class="body">
        <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th><th>Username</th><th>First Name</th><th>Last Name</th><th>Phone</th><th>Role</th><th>Processing</th>
            </tr>
        </thead>
        <?php

        foreach ($agency_super_admins as $key => $value) {
            $id=$value->user_id;
            
        ?>


            <tbody>
                <tr>
                    <td>{{ $id }}</td>
                    <td>{{ $value->user_name }} </td>   
                    <td>{{ $value->first_name }}</td>
                    <td>{{ $value->last_name }}</td>
                    <td>{{ "$value->country_code $value->area_code $value->number" }}</td>
                    <td>{{  DB::table('user_levels')->where('user_level_id', $value->level_id)->pluck('name') }}</td>

                    <td>
                            <a href=<?php echo url("users/view/$id");?> title="View" class="btn"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                            <a href=<?php echo url("users/edit/$id");?> title="Edit" class="btn"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                            <a href=<?php echo url("users/delete/$id");?> title="Delete" class="btn"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                        
                    </td>
                </tr>
            </tbody>
        <?php
        }

        ?>
        </table>
    </div>

</div>
@endsection