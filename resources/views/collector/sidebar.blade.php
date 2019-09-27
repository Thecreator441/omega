<li class="treeview {{ active(['cash_in', 'cash_out', 'collect_report', 'temp_journal', 'cash_open', 'cash_close',
'cash_situation', 'cash_reconciliation',]) }}">
    <a href="">
        <i class="fa fa-opera"></i>
        <span>@if ($emp->lang == 'fr') OPÉRATIONS @else OPERATIONS @endif</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="treeview {{ active(['cash_in', 'cash_out', 'collect_report', 'temp_journal', 'cash_open',
                'cash_close', 'cash_situation', 'cash_reconciliation',]) }}">
            <a href="">
                <i class="fa fa-toggle-on"></i>
                <span>Front Office</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview {{ active(['cash_in', 'cash_out', 'collect_report']) }}">
                    <a href="">
                        <i class="fa fa-columns"></i>
                        <span>@if ($emp->lang == 'fr') Collectes Journalières @else Daily Collections @endif</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('cash_in') }}"><a href="{{ url('cash_in') }}"><i
                                    class="fa fa-indent"></i> @if ($emp->lang == 'fr') Versement Espèces @else Cash
                                In @endif</a></li>
                        <li class="{{ active('cash_out') }}"><a href="{{ url('cash_out') }}"><i
                                    class="fa fa-indent"></i> @if ($emp->lang == 'fr') Retrait Espèces @else Cash
                                Out @endif</a></li>
                        <li class="{{ active('collect_report') }}"><a href="{{ url('collect_report') }}"><i
                                    class="fa fa-registered"></i> @if ($emp->lang == 'fr') Rapport @else
                                    Report @endif</a></li>
                    </ul>
                </li>
                <li class="treeview {{ active('temp_journal') }}">
                    <a href="">
                        <i class="fa fa-adn"></i>
                        <span>@if ($emp->lang == 'fr') Comptabilisation @else Accountings @endif</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('temp_journal') }}"><a
                                href="{{ url('temp_journal') }}"><i
                                    class="fa fa-newspaper-o"></i>@if ($emp->lang == 'fr') Brouillard
                                Comptable @else Temporal Journal @endif</a></li>
                    </ul>
                </li>
                <li class="{{ active('cash_open') }}"><a href="{{ url('cash_open') }}"><i
                            class="fa fa-plus"></i>@if ($emp->lang == 'fr') Ouverture Caisse @else Cash
                        Opening @endif</a></li>
                <li class="{{ active('cash_close') }}"><a href="{{ url('cash_close') }}"><i
                            class="fa fa-close"></i>@if ($emp->lang == 'fr') Fermeture Caisse @else Cash
                        Closing @endif</a></li>
                <li class="{{ active('cash_situation') }}"><a href="{{ url('cash_situation') }}"><i
                            class="ion ion-stats-bars"></i>@if ($emp->lang == 'fr') Situation Caisse @else
                            Cash Situation @endif</a></li>
                <li class="{{ active('cash_reconciliation') }}"><a
                        href="{{ url('cash_reconciliation') }}"><i
                            class="fa fa-signal"></i>@if ($emp->lang == 'fr') Rapprochement Caisse @else
                            Cash Reconciliation @endif</a></li>
            </ul>
        </li>
    </ul>
</li>
