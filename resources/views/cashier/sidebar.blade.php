<li class="treeview {{ active(['membership', 'cash_in', 'emission', 'cashtocash', 'check_in', 'other_cash_in', 'membership', 'cash_out',
'other_cash_out', 'cash_open', 'cash_close', 'cash_situation', 'cash_reconciliation', 'temp_journal', 'money_exchange',
'other_check_in', 'acc_situation', 'mem_situation', 'acc_history', 'mem_history', 'indiv_bal_history']) }}">
    <a href="">
        <i class="fa fa-opera"></i>
        <span>@lang('sidebar.operation')</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="treeview {{ active(['membership', 'cash_in', 'emission', 'cashtocash', 'check_in', 'other_cash_in', 'cash_out',
        'other_cash_out', 'cash_open', 'cash_close', 'cash_situation', 'cash_reconciliation', 'temp_journal', 'other_check_in',
        'money_exchange']) }}">
            <a href="">
                <i class="fa fa-toggle-on"></i>
                <span>@lang('sidebar.front')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview {{ active(['membership', 'cash_in', 'check_in', 'other_check_in', 'other_cash_in']) }}">
                    <a href="">
                        <i class="fa fa-indent"></i>
                        <span>@lang('sidebar.deposit')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('membership') }}"><a href="{{ url('membership') }}"><i
                                    class="fa fa-envira"></i> @lang('sidebar.membership')</a></li>
                        <li class="{{ active('cash_in') }}"><a href="{{ url('cash_in') }}"><i
                                    class="fa fa-indent"></i> @lang('sidebar.cin')</a></li>
                        <li class="{{ active('check_in') }}"><a href="{{ url('check_in') }}"><i
                                    class="fa fa-check"></i> @lang('sidebar.checkin')</a></li>
                        <li class="{{ active('other_cash_in') }}"><a href="{{ url('other_cash_in') }}"><i
                                    class="fa fa-random"></i> @lang('sidebar.ocin')</a></li>
                        <li class="{{ active('other_check_in') }}"><a href="{{ url('other_check_in') }}"><i
                                    class="fa fa-check"></i> @lang('sidebar.ochein')</a></li>
                    </ul>
                </li>
                <li class="treeview {{ active(['cash_out', 'other_cash_out', 'emission', 'cashtocash']) }}">
                    <a href="">
                        <i class="fa fa-outdent"></i>
                        <span>@lang('sidebar.withdraw')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('cash_out') }}"><a href="{{ url('cash_out') }}"><i
                                    class="fa fa-indent"></i> @lang('sidebar.cout')</a></li>
                        <li class="{{ active('other_cash_out') }}"><a href="{{ url('other_cash_out') }}"><i
                                    class="fa fa-random"></i> @lang('sidebar.ocout')</a></li>
                        <li class="{{ active('cashtocash') }}"><a href="{{ url('cashtocash') }}"><i
                                    class="fa fa-exchange"></i> @lang('sidebar.cashtocash')</a></li>
                        <li class="{{ active('emission') }}"><a href="{{ url('emission') }}"><i
                                    class="fa fa-refresh"></i> @lang('sidebar.emifund')</a></li>
                    </ul>
                </li>
                <li class="treeview {{ active(['temp_journal']) }}">
                    <a href="">
                        <i class="fa fa-adn"></i>
                        <span>@lang('sidebar.accounting')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('temp_journal') }}"><a href="{{ url('temp_journal') }}"><i
                                    class="fa fa-newspaper-o"></i> @lang('sidebar.tempjour')</a></li>
                    </ul>
                </li>
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
