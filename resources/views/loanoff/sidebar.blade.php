<li class="treeview {{ active(['acc_situation', 'mem_situation', 'acc_history', 'mem_history', 'indiv_bal_history']) }}">
    <a href="">
        <i class="fa fa-opera"></i>
        <span>@lang('sidebar.operation')</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="treeview {{ active(['mem_situation', 'mem_history']) }}">
            <a href=""><i class="fa fa-dashboard"></i>
                <span>@lang('sidebar.back')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview {{ active(['mem_situation', 'mem_history']) }}">
                    <a href=""><i class="ion ion-stats-bars"></i>
                        <span>@lang('sidebar.acc_sit')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('mem_situation')}}"><i class="fa fa-user"></i>@lang('sidebar.member')</a>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href=""><i class="fa fa-history"></i>
                        <span>@lang('sidebar.acc_his')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('mem_history')}}"><i class="fa fa-user"></i>@lang('sidebar.member')</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</li>

<li class="treeview {{ active(['loan_simulation', 'loan_application', 'loan_approval', 'refinancing', 'restructuring',
'loan_list', 'delinquency_report', 'prov_acc_report', 'provision_report', 'statistics_report']) }}">
    <a href=""><i class="fa fa-money"></i>
        <span>@lang('sidebar.loans')</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{active('loan_simulation')}}"><a href="{{url('loan_simulation')}}"><i
                    class="fa fa-signal"></i> @lang('sidebar.simul')</a></li>
        <li class="{{active('loan_application')}}"><a href="{{url('loan_application')}}"><i
                    class="fa fa-book"></i> @lang('sidebar.appli')</a></li>
        <li class="{{active('loan_approval')}}"><a href="{{url('loan_approval')}}"><i
                    class="fa fa-check"></i> @lang('sidebar.appro')</a></li>
        @if ($emp->privilege != 6)
            <li class="{{ active('refinancing') }}"><a href="{{ url('refinancing') }}"><i
                        class="fa fa-refresh"></i> @lang('sidebar.refin')</a></li>
            <li class="{{ active('restructuring') }}"><a href="{{ url('restructuring') }}"><i
                        class="fa fa-recycle"></i> @lang('sidebar.restruct')</a></li>
        @endif
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

<li class="treeview">
    <a href=""><i class="fa fa-stack-overflow"></i>
        <span>BUSINESS INTELLIGENCE</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href=""><i class="fa fa-building"></i> Credit Bureau</a></li>
    </ul>
</li>
