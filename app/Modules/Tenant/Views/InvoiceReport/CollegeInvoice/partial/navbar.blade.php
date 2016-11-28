<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<section class="margin-to-up margin-to-down">
<nav class="nav-bar">
    <div class="nav-container">
      <ul class="nav-list">
        <li><a id="tile1" href="#">College Invoices</a></li>
        <li class="{{ Request::segment(3) == 'invoice_pending' ? 'active' : '' }}"><a id="tile2" href="{{ route('college.invoice.pending', $tenant_id) }}">Pending Invoices</a></li>
        
        <li class="{{ Request::segment(3) == 'invoice_paid' ? 'active' : '' }}"><a id="tile3" href="{{ route('college.invoice.paid', $tenant_id) }}">Paid Invoices</a></li>
        
        <li class="{{ Request::segment(3) == 'invoice_future' ? 'active' : '' }}"><a id="tile4" href="{{ route('college.invoice.future', $tenant_id) }}">Future Invoices</a></li>

        <li class="{{ Request::segment(3) == 'invoice_grouped' ? 'active' : '' }}"><a id="tile5" href="{{ route('college.invoice.grouped', $tenant_id) }}">Group Invoices</a></li>

        <li class="{{ Request::segment(3) == 'search' ? 'active' : '' }}"><a id="tile6" href="{{ route('college.invoice.search', $tenant_id) }}">Advance Search</a></li>
      </ul>
    </div>
</nav>
</section>