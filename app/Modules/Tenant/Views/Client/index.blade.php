@extends('layouts.tenant')
@section('title', 'All Clients')
@section('breadcrumb')
    @parent
    <li><a href="{{url('client')}}" title="All Clients"><i class="fa fa-dashboard"></i> Clients</a></li>
@stop
@section('content')
    <div class="col-xs-12">
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">All Clients</h3>
                <a href="{{route('tenant.client.create', $tenant_id)}}" class="btn btn-primary btn-flat pull-right">Add
                    New
                    Client</a>
            </div>
            <div class="box-body">
                <table id="clientsTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Client ID</th>
                        <th>Client Name</th>
                        <th>Phone No</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>Referred By</th>
                        <th>Added By</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            dtable = $('#clientsTable').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": appUrl + "/client/data",
                "columns": [
                    {data: 'client_id', name: 'client_id'},
                    {data: 'fullname', name: 'fullname'},
                    {data: 'number', name: 'phones.number'},
                    {data: 'email', name: 'emails.email'},
                    {data: 'country', name: 'countries.name'},
                    {data: 'referred_by', name: 'referred_by'},
                    {data: 'added_by', name: 'added_by'},
                    {data: 'status', name: 'status', searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "pageLength": 50,
                order: [[0, 'desc']]
            }).api();

            // Call datatables, and return the API to the variable for use in our code
            // Binds datatables to all elements with a class of datatable
            /*var dtable = $('#clientsTable').dataTable({
                "pageLength": 50,
                order: [[0, 'desc']]
            }).api();*/

            // Grab the datatables input box and alter how it is bound to events
            $(".dataTables_filter input")
                    .unbind() // Unbind previous default bindings
                    .bind("input", function(e) { // Bind our desired behavior
                        // If the length is 3 or more characters, or the user pressed ENTER, search
                        if(this.value.length >= 3 || e.keyCode == 13) {
                            // Call the API search function
                            dtable.search(this.value).draw();
                        }
                        // Ensure we clear the search if they backspace far enough
                        if(this.value == "") {
                            dtable.search("").draw();
                        }
                        return;
                    });
        });



        $(document).on('ifChecked', '.active', function (event) {
            var clientId = $(this).attr('id');
            $.ajax({
                url: appUrl + "/clients/" + clientId + "/active",
                success: function (result) {
                    $('.content .box-primary').before(notify('success', 'Client Made Active Successfully!'));
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                }
            });
        });

        $(document).on('ifUnchecked', '.active', function (event) {
            var clientId = $(this).attr('id');
            $.ajax({
                url: appUrl + "/clients/" + clientId + "/inactive",
                success: function (result) {
                    $('.content .box-primary').before(notify('success', 'Client Made Inactive Successfully!'));
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                }
            });
        });

        function notify(type, text) {
            return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
        }

    </script>
@stop
