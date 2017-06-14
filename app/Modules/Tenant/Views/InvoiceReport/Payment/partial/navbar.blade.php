<link href='//fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<section class="margin-to-up margin-to-down">
<nav class="nav-bar">
    <div class="nav-container">
      <ul class="nav-list">
      <li> <a href="#" id="tile1" class="text-uppercase"> Payments</a></li>
        <li class="{{ Request::segment(3) == 'payments' && Request::segment(2) == 'client' ? 'active' : '' }}"><a id="tile2" href="{{ route('accounts.client.payments', $tenant_id) }}">Client Payments</a></li>
        
        <li class="{{ Request::segment(3) == 'payments' && Request::segment(2) == 'institutes' ? 'active' : '' }}"><a id="tile3" href="{{ route('accounts.institutes.payments', $tenant_id) }}">Institute Payments</a></li>
        
        <li class="{{ Request::segment(3) == 'payments' && Request::segment(2) == 'subagent' ? 'active' : '' }}"><a id="tile4" href="{{ route('accounts.subagent.payments', $tenant_id) }}">SubAgent Payments</a></li>

        <li class="{{ Request::segment(3) == 'payments' && Request::segment(2) == 'search' ? 'active' : '' }}"><a id="tile5" href="{{ route('accounts.search.payments', $tenant_id) }}">Advanced Search</a></li>
      </ul>
    </div>
</nav>
</section>