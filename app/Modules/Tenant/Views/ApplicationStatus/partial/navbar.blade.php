<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<nav class="nav-bar">
  <div class="nav-container">
    <a id="nav-menu" class="nav-menu">&#9776; Menu</a>
    <ul class="nav-list application-list" id="nav">
      <li> <a href="#" id="tile1" class="text-uppercase"> Applications</a></li>
      <li class="{{ Request::segment(3) == 'enquiry' ? 'active' : '' }}"><a id="tile2" href="{{ route('applications.enquiry.index', $tenant_id) }}">Enquiry</a></li>
      <li class=" {{ Request::segment(3) == 'offer_letter_processing' ? 'active' : '' }}"><a id="tile3" href="{{ route('applications.offer_letter_processing.index', $tenant_id)}}">Offer letter<br> processing</a></li>
      <li class="{{ Request::segment(3) == 'offer_letter_issued' ? 'active' : ''}}" ><a id="tile4" href="{{ route('applications.offer_letter_issued.index', $tenant_id) }}">Offer letter<br> issued</a></li>
      <li class="{{ Request::segment(3) == 'coe_processing' ? 'active' : ''}}" ><a id="tile5" href="{{ route('applications.coe_processing.index', $tenant_id) }}">COE<br> processing</a></li>
      <li class="{{ Request::segment(3) == 'coe_issued' ? 'active' : ''}}" ><a id="tile6" href="{{ route('applications.coe_issued.index', $tenant_id) }}">COE<br> issued</a></li>
      <li class="{{ Request::segment(3) == 'enrolled' ? 'active' : ''}}" ><a id="tile7" href="#">Enrolled</a></li>
      <li class="{{ Request::segment(3) == 'completed' ? 'active' : ''}}" ><a id="tile8" href="#">Completed</a></li>
      <li class="{{ Request::segment(3) == 'cancelled' ? 'active' : ''}}" ><a id="tile9" href="#">Cancelled</a></li>
      {{--<li class="{{ Request::is('tenant/applications/search') ? 'active' : ''}}" ><a id="tile10" href="{{ route('applications.search.index', $tenant_id) }}">Advanced<br> search</a></li>--}}
    </ul>
  </div>
</nav>