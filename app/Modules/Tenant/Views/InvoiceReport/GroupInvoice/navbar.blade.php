<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<section class="margin-to-up margin-to-down">
    <nav class="nav-bar">
        <div class="nav-container">
            <ul class="nav-list">
                <li><a id="tile1" href="#">Group Invoices</a></li>

                <li class="{{ Request::segment(3) == 'invoice_grouped' ? 'active' : '' }}"><a id="tile5" href="{{ route('college.invoice.grouped', $tenant_id) }}">Group Invoice List</a></li>

                <li class="{{ Request::segment(3) == 'group_invoice' ? 'active' : '' }}"><a id="tile6" href="{{ route('college.invoice.groupInvoice', $tenant_id) }}">Create Group Invoice</a></li>
            </ul>
        </div>
    </nav>
</section>