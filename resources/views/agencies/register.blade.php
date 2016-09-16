<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Agency Registration</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>
<body>

<div class="container">
    <form action="{{url('agencies/register')}}" method="post">
        {!! csrf_field() !!}
    <div class="page-header">
        <h1>Agency Registration -
            <small> 30 Day Free Trial </small>
        </h1>
    </div>
    
    

    <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Subscription Details</h3>
            </div>
            <div class="panel-body">
                 <div class="form-group" >
                            {!! Form::label('standard_subscription_id', 'Standard Subscription', array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                            {!! Form::select('standard_subscription_id', DB::table('standard_subscriptions')->lists('name','standard_subscription_id'),Input::old('standard_subscription_id'),array('class'=>'form-control')) !!}
                            </div> 
                 </div>
                 <div class="form-group" >
                            {!! Form::label('subscription_status_id', 'Subscription Status', array('class'=>'col-sm-2 control-label')) !!}
                            <div class="col-sm-10">
                            {!! Form::select('subscription_status_id', DB::table('subscription_status')->lists('name','subscription_status_id'),Input::old('subscription_status_id'),array('class'=>'form-control')) !!}
                            </div> 
                 </div>
                 <div class="form-group">
                    <label for="start_date" class="col-sm-2 control-label">Start Date</label>

                    <div class="col-sm-10">
                        <input type="text" name="start_date" class="form-control" id="start_date" placeholder="Start Date" value="{{ date("Y-m-d") }} "/>
                    </div>
                </div>


                <div class="form-group">
                    <label for="end_date" class="col-sm-2 control-label">End Date</label>

                    <div class="col-sm-10">
                        <input type="text" name="end_date" class="form-control" id="end_date" placeholder="End Date" value="{{ date("Y-m-d", strtotime("+30 days")) }}"/>
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
                        <input type="text" name="name" class="form-control" id="name"
                               placeholder="Company Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="abn" class="col-sm-2 control-label">ABN</label>

                    <div class="col-sm-10">
                        <input type="text" name="abn" class="form-control" id="abn" placeholder="ABN">
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('company_phone_type', 'Phone Type',array('class' => 'col-sm-2 control-label')) !!} 
                    <div class="col-sm-10">
                        {!! Form::select('company_phone_type',array('work'=>'Work'),Input::old('company_phone_type'),array('class' => 'form-control')) !!} 
                    </div> 
                </div>
                 <div class="form-group">
                    <label for="company_country_code" class="col-sm-2 control-label">Country Code</label>

                    <div class="col-sm-10">
                        <input type="text" name="company_country_code" class="form-control" id="company_country_code" placeholder="Country Code"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="company_area_code" class="col-sm-2 control-label">Area Code</label>

                    <div class="col-sm-10">
                        <input type="text" name="company_area_code" class="form-control" id="company_area_code" placeholder="Area Code"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="company_number" class="col-sm-2 control-label">Number</label>

                    <div class="col-sm-10">
                        <input type="text" name="company_number" class="form-control" id="company_number" placeholder="Number"/>
                    </div>
                </div>


                <div class="form-group">
                    <label for="website" class="col-sm-2 control-label">Website</label>

                    <div class="col-sm-10">
                        <input type="text" name="website" class="form-control" id="website" placeholder="Website">
                    </div>
                </div>
                

            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">User Details</h3>
            </div>
            <div class="panel-body">

                <div class="form-group">
                    <label for="fname" class="col-sm-2 control-label">First Name</label>

                    <div class="col-sm-10">
                        <input type="text" name="first_name" class="form-control" id="fname" placeholder="First Name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lname" class="col-sm-2 control-label">Last Name</label>

                    <div class="col-sm-10">
                        <input type="text" name="last_name" class="form-control" id="lname" placeholder="Last Name"/>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('type', 'Phone Type',array('class' => 'col-sm-2 control-label')) !!} 
                    <div class="col-sm-10">
                        {!! Form::select('type',array('mobile'=>'Mobile','home'=>'Home','work'=>'Work'),Input::old('type'),array('class' => 'form-control')) !!} 
                    </div> 
                </div>
                 <div class="form-group">
                    <label for="country_code" class="col-sm-2 control-label">Country Code</label>

                    <div class="col-sm-10">
                        <input type="text" name="country_code" class="form-control" id="country_code" placeholder="Country Code"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="area_code" class="col-sm-2 control-label">Area Code</label>

                    <div class="col-sm-10">
                        <input type="text" name="area_code" class="form-control" id="area_code" placeholder="Area Code"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="number" class="col-sm-2 control-label">Number</label>

                    <div class="col-sm-10">
                        <input type="text" name="number" class="form-control" id="number" placeholder="Number"/>
                    </div>
                </div>
            </div>
        </div>
            <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Login Details</h3>
            </div>
             <div class="panel-body">
                <div class="form-group">
                    <label for="user_name" class="col-sm-2 control-label">Username/Email Id</label>

                    <div class="col-sm-10">
                        <input type="email" name="user_name" class="form-control" id="user_name" placeholder="Email Id"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="password"
                               placeholder="Password"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password" class="col-sm-2 control-label">Confirm Password</label>

                    <div class="col-sm-10">
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                               placeholder="Confirm Password"/>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('level_id', 'User Level',array('class' => 'col-sm-2 control-label')) !!} 
                    <div class="col-sm-10">
                        {!! Form::select('level_id',DB::table('user_levels')->lists('name','user_level_id'),Input::old('level_id'),array('class' => 'form-control')) !!} 
                    </div> 
                </div>

            </div>
        </div>

        <div class="form-group">
            <label for="captcha" class="col-sm-2 control-label">Captcha</label>

            <div class="col-sm-10">
                <!--Captcha goes here-->
                <div>1232131</div>
            </div>
        </div>
        <div class="form-group">
            <label for="word" class="col-sm-2 control-label">Type the word</label>

            <div class="col-sm-10">
                <input type="text" name="word" class="form-control" id="word"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>

<link rel="stylesheet" href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css">
<script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        endDate: '+0d',
        autoclose: true
    });
</script>