<section class="margin-to-up margin-to-down">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="{{ Request::is('tenant/client/payments') ? 'active' : '' }}"><a href="{{ route('accounts.client.payments', $tenant_id) }}">Client Payments</a></li>
        
        <li class="{{ Request::is('tenant/institutes/payments') ? 'active' : '' }}"><a href="{{ route('accounts.institutes.payments', $tenant_id) }}">Institute Payments</a></li>
        
        <li class="{{ Request::is('tenant/subagent/payments') ? 'active' : '' }}"><a href="{{ route('accounts.subagent.payments', $tenant_id) }}">SubAgent Payments</a></li>

        <li class="{{ Request::is('tenant/search/payments') ? 'active' : '' }}"><a href="{{ route('accounts.search.payments', $tenant_id) }}">Advanced Search</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</section>