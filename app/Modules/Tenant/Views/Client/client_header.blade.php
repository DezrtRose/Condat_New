<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-sm-2 text-center">
                <div class="client-header-img">
                    <img src="{{ ($client->filename != null)? url($client->shelf_location.$client->filename) : asset('assets/img/default-user.png') }}"
                         class=""
                         alt="{{$client->first_name}} {{$client->middle_name}} {{$client->last_name}}"
                         height="150"/>
                    <button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#url-modal">
                        <i class="fa fa-camera fa-fw"></i>
                        <span class="hidden-sm" style="font-size: 13px">Upload From URL</span>
                    </button>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="row margin-top client-header-body">
                    <div class="col-md-2"><h4 class="text-uppercase">{{$client->first_name}} {{$client->middle_name}}
                            <br/>
                            <b>{{$client->last_name}}</b></h4></div>
                    <div class="col-md-2"><span class="text-muted"><i class="fa fa-phone"></i> PHONE</span> <br/>

                        <p class="text-blue">{{$client->number}}</p>
                    </div>
                    <div class="col-md-3"><span class="text-muted"><i class="fa fa-envelope"></i> EMAIL</span> <br/>

                        <a href="mailto:{{$client->email}}" class="text-blue">{{$client->email}}</a>
                    </div>
                    <div class="col-md-3"><span class="text-muted"><i class="fa fa-map-marker"></i> ADDRESS</span> <br/>

                        <p class="text-blue">
                            {{ $client->street }}&nbsp;,
                            {{ $client->suburb }}&nbsp;<br/>
                            {{ $client->state }} , &nbsp;
                            {{ $client->postcode }}&nbsp;
                            <strong>{{ get_country($client->country_id) }}</strong>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success">Action</button>
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('tenant.client.edit', [$tenant_id, $client->client_id]) }}"><i
                                                    class="fa fa-edit"></i> Edit</a><br/>
                                    </li>
                                    <li>
                                        <a href="{{ route('tenant.client.compose', [$tenant_id, $client->client_id]) }}"><i
                                                    class="fa fa-envelope"></i> Email</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row margin-top">
                    @include('Tenant::Client/navbar')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="url-modal" tabindex="-1" role="dialog" aria-labelledby="url-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Save Image From URL</h4>
                </div>
                {!!Form::open(['route' => ['tenant.client.urlUpload', $tenant_id, $client->client_id], 'method'=> 'post', 'files' => 'true', 'class' => 'form-left'])!!}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">URL * </label>
                        <input type="text" class="form-control" name="url"/>
                    </div>
                    <div class="form-group">
                        <label for="">Title * </label>
                        <input type="text" class="form-control" name="title"/>
                    </div>

                    <div class="well">
                        <h4><strong>Steps to Upload Image</strong></h4>
                        <ul class="">
                            <li>Find the Image you would like to Upload</li>
                            <li>Right click on Image and choose open Image in New Tab</li>
                            <li>Copy the Link and put into the URL field</li>
                            <li>Type Image description and submit to Upload Image</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                        Save
                    </button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>

</div>