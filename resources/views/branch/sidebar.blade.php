<li class="treeview">
    <a href="">
        <i class="fa fa-opera"></i>
        <span>@lang('sidebar.operation')</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="treeview">
            <a href=""><i class="fa fa-opera"></i>
                <span>Other Operations</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview">
                    <a href=""><i class="fa fa-bug"></i>
                        <span>Budget</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-contao"></i> Control Sheet</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href=""><i class="fa fa-home"></i>
                        <span>Assets Management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-contao"></i> Control Sheet</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href=""><i class="fa fa-stack-overflow"></i>
                        <span>Stores Management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-registered"></i> @lang('sidebar.report')</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href=""><i class="fa fa-users"></i>
                        <span>Human Resources</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-user"></i> Employees</a></li>
                        <li><a href=""><i class="fa fa-book"></i> Report</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</li>

<li class="treeview {{ active(['loan_approval', 'loan_reject', 'refinancing', 'restructuring', 'loan_list', 'delinquency_report',
'prov_acc_report', 'provision_report', 'statistics_report']) }}">
    <a href=""><i class="fa fa-money"></i>
        <span>@lang('sidebar.loans')</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{active('loan_approval')}}"><a href="{{url('loan_approval')}}"><i
                    class="fa fa-check"></i> @lang('sidebar.appro')</a></li>
        <li class="{{active('loan_reject')}}"><a href="{{url('loan_reject')}}"><i
                    class="fa fa-times"></i> @lang('sidebar.reject')</a></li>
        <li class="{{ active('refinancing') }}"><a href="{{ url('refinancing') }}"><i
                    class="fa fa-refresh"></i> @lang('sidebar.refin')</a></li>
        <li class="{{ active('restructuring') }}"><a href="{{ url('restructuring') }}"><i
                    class="fa fa-recycle"></i> @lang('sidebar.restruct')</a></li>
        <li class="treeview {{ active(['loan_list', 'delinquency_report', 'prov_acc_report', 'provision_report', 'statistics_report']) }}">
            <a href=""><i class="fa fa-registered"></i>
                <span>@lang('sidebar.report')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{active('loan_list')}}"><a href="{{url('loan_list')}}"><i
                            class="fa fa-list"></i> @lang('sidebar.list')</a></li>
                <li class="{{active('delinquency_report')}}"><a href="{{url('delinquency_report')}}"><i
                            class="fa fa-list"></i> @lang('sidebar.delinq')</a></li>
                <li class="treeview {{ active(['prov_acc_report', 'provision_report']) }}">
                    <a href=""><i class="fa fa-product-hunt"></i>
                        <span>@lang('sidebar.provi')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{active('prov_acc_report')}}"><a href="{{url('prov_acc_report')}}"><i
                                    class="fa fa-star"></i> @lang('sidebar.accounting')
                            </a></li>
                        <li class="{{active('provision_report')}}"><a href="{{url('provision_report')}}"><i
                                    class="fa fa-registered"></i> @lang('sidebar.report')</a></li>
                    </ul>
                </li>
                <li class="{{active('statistics_report')}}"><a href="{{url('statistics_report')}}"><i
                            class="fa fa-signal"></i> @lang('sidebar.stats')</a></li>
            </ul>
        </li>
    </ul>
</li>

<li class="treeview {{active(['trial_balance', 'balance_sheet', 'inc_exp', 'acc_bal_sheet', 'acc_inc_exp'])}}">
    <a href=""><i class="fa fa-fa"></i>
        <span>@lang('sidebar.finstat')</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{active('trial_balance')}}"><a href="{{url('trial_balance')}}"><i
                    class="fa fa-balance-scale"></i> @lang('sidebar.trialbal')</a></li>
        <li class="{{active('balance_sheet')}}"><a href="{{url('balance_sheet')}}"><i
                    class="fa fa-balance-scale"></i> @lang('sidebar.balsheet')</a></li>
        <li class="{{active('inc_exp')}}"><a href="{{url('inc_exp')}}"><i
                    class="fa fa-expand"></i> @lang('sidebar.inc&exp')</a></li>
        <li class="treeview {{active(['acc_bal_sheet', 'acc_inc_exp'])}}">
            <a href=""><i class="fa fa-calendar"></i>
                <span>@lang('sidebar.accshed')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{active('acc_bal_sheet')}}"><a href="{{url('acc_bal_sheet')}}"><i
                            class="fa fa-balance-scale"></i> @lang('sidebar.balsheet')</a></li>
                <li class="{{active('acc_inc_exp')}}"><a href="{{url('acc_inc_exp')}}"><i
                            class="fa fa-expand"></i> @lang('sidebar.inc&exp')</a></li>
            </ul>
        </li>
    </ul>
</li>

<li class="treeview">
    <a href=""><i class="fa fa-book"></i>
        <span>DOCUMENTATION UNIT</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href=""><i class="fa fa-archive"></i> Archives</a></li>
        <li><a href=""><i class="fa fa-search"></i> Document Research</a></li>
        <li><a href=""><i class="fa fa-registered"></i> Report</a></li>
    </ul>
</li>

<li class="treeview">
    <a href=""><i class="fa fa-stack-overflow"></i>
        <span>BUSINESS INTELLIGENCE</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href=""><i class="fa fa-key"></i> PKI's</a></li>
        <li><a href=""><i class="fa fa-circle-o"></i> Prudential Norms</a></li>
        <li><a href=""><i class="fa fa-users"></i> Human Resource</a></li>
        <li><a href=""><i class="fa fa-circle-o"></i> CRM</a></li>
        <li><a href=""><i class="fa fa-building"></i> Credit Bureau</a></li>
        <li><a href=""><i class="fa fa-bookmark"></i> Benchmarking</a></li>
    </ul>
</li>
