<hr/>
<h2 class="text-center">Import Summary</h2>
<hr/>
@if(count($errors) != 0)
    <p class="lead">Some records could not be uploaded due to validation errors. Please refer the following errors
        : </p>
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors as $key => $error)
                <li>
                    <strong>Row No. : </strong>{{ $key + 1 }}<br/>
                    <ol>
                        @foreach($error as $err_key => $err)
                            <li>{{$err}}</li>
                        @endforeach
                    </ol>
                </li>
            @endforeach
        </ul>
    </div>
@endif
@if(count($clients) != 0)
    <ul class="list-unstyled">
        <li><strong>Total Number of Clients : </strong>{{ count($clients) }}</li>
    </ul>
    <div class="box-body table-responsive">
        <table id="table-lead" class="table table-hover">
            <thead>
            <tr>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Sex</th>
                <th>DOB</th>
                <th>Passport</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $key => $client)
                <tr>
                    <td>{{ $client['first_name'] }}</td>
                    <td>{{ $client['middle_name'] }}</td>
                    <td>{{ $client['last_name'] }}</td>
                    <td>{{ $client['sex'] }}</td>
                    <td>{{ $client['dob'] }}</td>
                    <td>{{ $client['passport_no'] }}</td>
                    <td>{{ $client['email'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="text-muted well">
        No any client records found.
    </p>
@endif