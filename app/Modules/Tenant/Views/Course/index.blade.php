@extends('layouts.tenant')
@section('title', 'All Courses')
@section('breadcrumb')
    @parent
    <li><a href="{{url('institute')}}" title="All Institutes"><i class="fa fa-dashboard"></i> Institutes</a></li>
@stop
@section('content')
    @include('Tenant::Institute/navbar')
    <div class="col-xs-12">
        @include('flash::message')
    </div>
    <div class="col-md-3 col-xs-12">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">General Information</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-calendar margin-r-5"></i> Institute Id</strong>

                <p class="text-muted">{{format_id($institute->institution_id, 'I')}}</p>

                <strong><i class="fa fa-calendar margin-r-5"></i> Short Name</strong>

                <p class="text-muted">{{$institute->short_name}}</p>

                <strong><i class="fa fa-phone margin-r-5"></i> Website</strong>

                <p class="text-muted"><a href="http://{{ $institute->website }}"
                                         target="_blank">{{$institute->website}}</a></p>

                <strong><i class="fa fa-calendar margin-r-5"></i> Invoice To</strong>

                <p class="text-muted">{{$institute->invoice_to_name}}</p>

                <strong><i class="fa fa-calendar margin-r-5"></i> Created At</strong>

                <p class="text-muted">{{format_datetime($institute->created_at)}}</p>

                <strong><i class="fa fa-phone margin-r-5"></i> Created By</strong>

                <p class="text-muted">{{$institute->number}}</p>

            </div>
            <!-- /.box-body -->
        </div>

    </div>

    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Manage Courses</h3>
                <a href="{{route('tenant.course.create', [$tenant_id, $institution_id])}}"
                   class="btn btn-primary btn-flat pull-right">Add New Course</a>
            </div>
            <div class="box-body">
                <table id="courses" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Cricos ID</th>
                        <th>Course Name</th>
                        <th>Level</th>
                        <th>Tuition Fee</th>
                        <th>Com %</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>{{ format_id($course->course_id, 'COU') }}</td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->level }}</td>
                                <td>{{ format_price($course->total_tuition_fee) }}</td>
                                <td>{{ $course->commission_percent }}%</td>
                                <td><a data-toggle="tooltip" title="View Course" class="btn btn-action-box" href ="{{ route('tenant.course.show', [$tenant_id, $course->course_id]) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Edit Course" class="btn btn-action-box" href ="{{ route('tenant.course.edit', [$tenant_id, $course->course_id]) }}"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Course" class="delete-user btn btn-action-box" href="{{ route('tenant.course.destroy', [$tenant_id, $course->course_id]) }}"><i class="fa fa-trash"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#courses').DataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            });
        });
    </script>
@stop
