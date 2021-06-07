<li class="treeview {{ active(['cash_open', 'cash_situation', 'cash_reconciliation', 'temp_journal', 'money_exchange']) }}">
    <a href="">
        <i class="fa fa-opera"></i>
        <span>OPERATIONS</span>
        <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
    </a>
    <ul class="treeview-menu">
        <li class="treeview {{ active(['cash_open', 'cash_situation', 'cash_reconciliation', 'temp_journal', 'money_exchange']) }}">
            <a href="">
                <i class="fa fa-toggle-on"></i>
                <span>Front Office</span>
                <span class="pull-right-container">
                                    <i class="fa fa-angle-right pull-right"></i>
                                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ active('cash_open') }}"><a href="{{ url('cash_open') }}"><i
                            class="fa fa-folder-open-o"></i> @lang('sidebar.opencash')</a></li>
                <li class="{{ active('cash_situation') }}"><a href="{{ url('cash_situation') }}"><i
                            class="fa fa-signal"></i> @lang('sidebar.situatcash')</a></li>
                <li class="{{ active('cash_reconciliation') }}"><a href="{{ url('cash_reconciliation') }}"><i
                            class="fa fa-bars"></i>@lang('sidebar.reconcash')</a></li>
                <li class="{{ active('money_exchange') }}"><a href="{{ url('money_exchange') }}"><i
                            class="fa fa-exchange"></i> @lang('sidebar.monexc')</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href=""><i class="fa fa-opera"></i>
                <span>Other Operations</span>
                <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview">
                    <a href=""><i class="fa fa-home"></i>
                        <span>Assets Management</span>
                        <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-hourglass-start"></i> Initialisation</a></li>
                        <li><a href=""><i class="fa fa-circle-o"></i> Accountability</a></li>
                        <li><a href=""><i class="fa fa-contao"></i> Control Sheet</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href=""><i class="fa fa-stack-overflow"></i>
                        <span>Stocks Management</span>
                        <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href=""><i class="fa fa-hourglass-start"></i>
                                <span>Initialisation</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-right pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-product-hunt"></i> Product</a></li>
                                <li><a href=""><i class="fa fa-user-o"></i> Client</a></li>
                                <li><a href=""><i class="fa fa-repeat"></i> Representative</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-share-alt"></i>
                                <span>Sales</span>
                                <span class="pull-right-container">
                                                <i class="fa fa-angle-right pull-right"></i>
                                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-product-hunt"></i> Direct</a></li>
                                <li><a href=""><i class="fa fa-user-o"></i> Indirect</a></li>
                            </ul>
                        </li>
                        <li><a href=""><i class="fa fa-circle-o"></i> Accounting</a></li>
                        <li><a href=""><i class="fa fa-refresh"></i> Replenishment</a></li>
                        <li><a href=""><i class="fa fa-registered"></i> Report</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</li>
