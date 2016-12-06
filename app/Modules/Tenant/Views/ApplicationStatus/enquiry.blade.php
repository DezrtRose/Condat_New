@extends('layouts.tenant')
@section('title', 'Application Enquiry')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/clients')}}" title="All Applications"><i class="fa fa-users"></i> Applications</a></li>
    <li>Enquiry</li>
@stop

@section('content')
    <div class="col-md-12">
        @include('Tenant::ApplicationStatus/partial/navbar')

        @include('flash::message')
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Application - Enquiry</h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered table-condensed" id="application_table">
                    <thead>
                    <tr class="text-nowrap">
                        <th>Id</th>
                        <th>Client Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>College Name</th>
                        <th>Course Name</th>
                        <th>Start date</th>
                        <th>Invoice To</th>
                        <th>Processing</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($applications as $application)
                        <tr>
                            <td>{{ format_id($application->course_application_id, 'AP') }}</td>
                            <td>{{ $application->fullname }}</td>
                            <td>{{ $application->number }}</td>
                            <td>{{ $application->email }}</td>
                            <td>{{ $application->company }}</td>
                            <td>{{ $application->name }}</td>
                            <td>{{ format_date($application->intake_date) }}</td>
                            <td>{{ $application->invoice_to }}</td>
                            <td>
                                <a href="{{ route('applications.apply.offer',[$tenant_id, $application->course_application_id])}}"
                                   title="Apply Offer"><i class=" btn btn-primary btn-sm glyphicon glyphicon-education"
                                                          data-toggle="tooltip" data-placement="top"
                                                          title="Apply Offer"></i></a>
                                <a href="{{ route('tenant.application.show', [$tenant_id, $application->course_application_id])  }}" title="view"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-eye-open"
                                            data-toggle="tooltip" data-placement="top" title="View"></i></a>
                                <a href="{{ route('tenant.application.edit', [$tenant_id, $application->course_application_id]) }}" title="edit"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-edit"
                                            data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                <a href="{{ route('applications.cancel.application',[$tenant_id, $application->course_application_id])}}"
                                   title="Cancel / Quarantine"><i
                                            class="processing btn btn-primary btn-sm glyphicon glyphicon-trash"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Cancel"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#application_table').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            });
        });
    </script>
@stop