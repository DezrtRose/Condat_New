@extends('layouts.tenant')
@section('title', 'Advance Course Search')
@section('heading', 'Advance Course Search')
@section('breadcrumb')
    @parent
    <li><a href="{{url($tenant_id.'/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
    </div>
    <div class="col-md-12 col-xs-12">
        <div class="box box-primary">
            {!!Form::model($search_attributes, array('route' => ['tenant.course.search', $tenant_id], 'method' => 'post', 'class' => ''))!!}
            <div class="box-header">
                <h3 class="box-title">Filter Options</h3>
                <input type="submit" class="btn btn-primary pull-right" value="Search"/>
            </div>

            <div class="box-body">
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('institute', 'Institute', array('class' => 'control-label')) !!}
                    {!!Form::select('institute[]', $institutes, null, array('class' => 'form-control select2', 'multiple' => 'multiple'))!!}
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('course_name', 'Course', array('class' => 'control-label')) !!}
                    {!!Form::text('course_name', null, array('class' => 'form-control', 'id'=>'course_name', 'placeholder' => "Course Name"))!!}
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    {!!Form::label('level', 'Level', array('class' => 'control-label')) !!}
                    {!!Form::select('level[]', $levels, null, array('class' => 'form-control select2', 'multiple' => 'multiple'))!!}
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    {!!Form::label('amount', 'Tuition Fee', array('class' => 'control-label')) !!}
                    <div class="row">
                        <div class="col-xs-6"> {!!Form::number('from', null, array('class' => 'form-control', 'placeholder' => 'Tuition Fee From', 'id'=>'from'))!!}</div>
                        <div class="col-xs-6"> {!!Form::number('to', null, array('class' => 'form-control', 'placeholder' => 'Tuition Fee To', 'id'=>'to'))!!}</div>
                    </div>
                </div>
                <div class="form-group col-md-6 col-xs-12">
                    {!!Form::label('commission', 'Commission', array('class' => 'control-label')) !!}
                    <div class="row">
                        <div class="col-xs-6"> {!!Form::number('commission_from', null, array('class' => 'form-control', 'placeholder' => 'Commission From', 'id'=>'commission_from'))!!}</div>
                        <div class="col-xs-6"> {!!Form::number('commission_to', null, array('class' => 'form-control', 'placeholder' => 'Commission To', 'id'=>'commission_to'))!!}</div>
                    </div>
                </div>
            </div>
            {{--<div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Search"/>
            </div>--}}
            {!!Form::close()!!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Manage Courses</h3>
            </div>
            <div class="box-body">
                <table id="all-courses" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Institute Name</th>
                        <th>Course Name</th>
                        <th>Level</th>
                        <th>Tuition Fee</th>
                        <th>Com %</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td>{{format_id($course->course_id, 'COU')}}</td>
                            <td>{{$course->short_name}}</td>
                            <td>{{$course->name}}</td>
                            <td>{{$course->level}}</td>
                            <td>{{$course->total_tuition_fee}}</td>
                            <td>{{$course->commission_percent}}</td>
                            <td>{{'Action'}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
<script>
    window.onload = function() {
        $(document).ready(function () {
            oTable = $('#all-courses').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    }
</script>
