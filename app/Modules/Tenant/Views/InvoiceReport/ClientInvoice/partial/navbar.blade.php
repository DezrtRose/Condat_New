<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<nav class="nav-bar">
  <div class="nav-container">
    <a id="nav-menu" class="nav-menu">&#9776; Menu</a>
    <ul class="nav-list " id="nav">
      <li> <a href="#" id="tile1" class="text-uppercase"> Client Invoices</a></li>
      <li class="{{ Request::segment(3) == 'invoice_pending' ? 'active' : '' }}"> <a href="{{ route('client.invoice.pending', $tenant_id) }}" id="tile2"><i class="fa fa-hourglass-half"></i> Pending Invoices</a></li>
      <li class="{{ Request::segment(3) == 'invoice_paid' ? 'active' : '' }}"> <a href="{{ route('client.invoice.paid', $tenant_id) }}" id="tile3"><i class="fa fa-money"></i> Paid Invoices</a></li>
      <li class="{{ Request::segment(3) == 'invoice_future' ? 'active' : '' }}"> <a href="{{ route('client.invoice.future', $tenant_id) }}" id="tile4"><i class="glyphicon glyphicon-piggy-bank"></i> Future Invoices</a></li>
      <li class="{{ Request::segment(3) == 'search' ? 'active' : '' }}"> <a href="{{ route('client.invoice.search', $tenant_id) }}" id="tile5"><i class="fa fa-search-plus"></i> Advance Search</a></li>
    </ul>
  </div>
</nav>