<?php $current = Request::segment(4); ?>
<section class="section section--menu" id="Prospero">
    <nav class="menu menu--prospero">
        <ul class="menu__list">
            <li class="menu__item {{($current == '')? 'menu__item--current' : ''}}">
                <a href='{{url($tenant_id."/clients/".$client->client_id)}}' class="menu__link">Dashboard</a>
            </li>
            <li class="menu__item {{($current == 'personal_details')? 'menu__item--current' : ''}}">
                <a href='{{url($tenant_id."/clients/".$client->client_id."/personal_details")}}' class="menu__link">Personal Details</a>
            </li>
            <li class="menu__item {{($current == 'applications')? 'menu__item--current' : ''}}">
                <a href='{{url($tenant_id."/clients/".$client->client_id."/applications")}}' class="menu__link">College Application</a>
            </li>
            <li class="menu__item {{($current == 'accounts')? 'menu__item--current' : ''}}">
                <a href='{{url($tenant_id."/clients/".$client->client_id."/accounts")}}' class="menu__link">Accounts</a>
            </li>
            <li class="menu__item {{($current == 'document')? 'menu__item--current' : ''}}">
                <a href='{{url($tenant_id."/clients/".$client->client_id."/document")}}' class="menu__link">Documents</a>
            </li>
            <li class="menu__item {{($current == 'notes')? 'menu__item--current' : ''}}">
                <a href='{{url($tenant_id."/clients/".$client->client_id."/notes")}}' class="menu__link">Notes</a>
            </li>
        </ul>

    </nav>

</section>
