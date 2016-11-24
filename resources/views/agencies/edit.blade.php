@extends('layouts.default')
@section('title','Agency List')

@section('content')
<?php
print_r($agencies);
?>

<div class="container">
    {!! Form::model($agencies, array('url' => 'agencies/edit')) !!}
    {!! Form::hidden('company_id',$agencies->company_id) !!}
    {!! Form::hidden('phone_id',$agencies->phone_id) !!}
    <div class="page-header">
        <h1>Edit Agency </h1>
    </div>
    <?php

    if ($errors->has()){
                foreach ($errors->all() as $error)
                {
                    print_r("<font color=red>".$error."</font></br> ");
                }
    }
    ?>
    <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Subscription Details</h3>
            </div>
            <div class="panel-body">
                

                  <div class="row">
                     <label for="start_date" class="col-sm-2 control-label">Standard Subscription</label>
                      <div class="col-sm-10"> 
                        <div class="col-sm-4">
                             {!!  
                             DB::table('standard_subscriptions')->where('standard_subscription_id', $agencies->standard_subscription_id)->pluck('name')
                             !!}
                        </div>
                      </div>
                  </div>


                 <div class="row">
                            <label for="start_date" class="col-sm-2 control-label">Subscription Status</label>
                            <div class="col-sm-10">
                                <div class="col-sm-4">
                                    {!!  
                                     DB::table('subscription_status')->where('subscription_status_id', $agencies->subscription_status_id)->pluck('name')
                                     !!}
                                </div>
                            </div> 
                 </div>

                 <div class="row">
                            <label for="start_date" class="col-sm-2 control-label">Start Date</label>
                            <div class="col-sm-10">
                                <div class="col-sm-4">
                                    {!!  $agencies->start_date !!}
                                </div>
                            </div> 
                 </div>


                <div class="row">
                    <label for="end_date" class="col-sm-2 control-label">End Date</label>

                    <div class="col-sm-10">
                         <div class="col-sm-4">
                            {{ $agencies->end_date }}
                         </div>
                    </div>
                </div>
        
    </div>
     
        

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Company Details</h3>
            </div>
            <div class="panel-body">
                

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Company Name</label>

                    <div class="col-sm-10">
                        {!! Form::text('name',Input::old('name'),array('class' => 'form-control')) !!} 
                    </div>
                </div>
                <div class="form-group">
                    <label for="abn" class="col-sm-2 control-label">ABN</label>

                    <div class="col-sm-10">
                        {!! Form::text('abn',Input::old('abn'),array('class' => 'form-control')) !!}
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('type', 'Phone Type',array('class' => 'col-sm-2 control-label')) !!} 
                    <div class="col-sm-10">
                        {!! Form::select('type',array('work'=>'Work'),Input::old('type'),array('class' => 'form-control')) !!} 
                    </div> 
                </div>
                 <div class="form-group">
                    <label for="country_code" class="col-sm-2 control-label">Country Code</label>

                    <div class="col-sm-10">
                         {!! Form::text('country_code',Input::old('country_code'),array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="area_code" class="col-sm-2 control-label">Area Code</label>

                    <div class="col-sm-10">
                        {!! Form::text('area_code',Input::old('area_code'),array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="number" class="col-sm-2 control-label">Number</label>

                    <div class="col-sm-10">
                        {!! Form::text('number',Input::old('number'),array('class' => 'form-control')) !!}
                    </div>
                </div>


                <div class="form-group">
                    <label for="website" class="col-sm-2 control-label">Website</label>

                    <div class="col-sm-10">
                        {!! Form::text('website',Input::old('website'),array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </div>

            
        </div>

        
        
    </form>
</div>
@endsection

<link rel="stylesheet" href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css">
<script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        endDate: '+0d',
        autoclose: true
    });
</script>


