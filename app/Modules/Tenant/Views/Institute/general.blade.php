<strong><i class="fa fa-circle-o margin-r-5"></i> Institute Id</strong>

<p class="text-muted">{{format_id($institute->institution_id, 'I')}}</p>

<strong><i class="fa fa-star margin-r-5"></i> Institute Name</strong>

<p class="text-muted">{{$institute->name}}</p>

<strong><i class="fa fa-star-half-full margin-r-5"></i> Short Name</strong>

<p class="text-muted">{{$institute->short_name}}</p>

<strong><i class="fa fa-phone margin-r-5"></i> Phone Number</strong>

<p class="text-muted">{{$institute->number}}</p>

<strong><i class="fa fa-desktop margin-r-5"></i> Website</strong>

<p class="text-muted"><a href="http://{{ $institute->website }}"
                         target="_blank">{{$institute->website}}</a></p>

<strong><i class="fa fa-file margin-r-5"></i> Invoice To</strong>

<p class="text-muted">{{$institute->invoice_to_name}}</p>

<strong><i class="fa fa-calendar margin-r-5"></i> Created At</strong>

<p class="text-muted">{{format_datetime($institute->created_at)}}</p>

{{--<strong><i class="fa fa-envelope-o margin-r-5"></i> Email</strong>

<p class="text-muted">{{$institute->email}}</p>--}}

<strong><i class="fa fa-user margin-r-5"></i> Added By</strong>

<p class="text-muted">{{ get_tenant_name($institute->added_by)}}</p>