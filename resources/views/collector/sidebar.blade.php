<li class="treeview {{ active(['cash_in', 'cash_out', 'money_exchange', 'temp_journal', 'cash_open', 'cash_close',
'cash_situation', 'cash_reconciliation', 'registration']) }}">
    <a href="">
        <i class="fa fa-opera"></i>
        <span>@lang('sidebar.operation')</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="treeview {{ active(['cash_in', 'cash_out', 'money_exchange', 'temp_journal', 'cash_open', 'cash_situation', 'cash_reconciliation']) }}">
            <a href="">
                <i class="fa fa-toggle-on"></i>
                <span>@lang('sidebar.front')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ active('cash_in') }}"><a href="{{ url('cash_in') }}"><i class="fa fa-indent"></i> @lang('sidebar.cin')</a></li>
{{--                <li class="treeview {{ active(['cash_in']) }}">--}}
{{--                    <a href="">--}}
{{--                        <i class="fa fa-indent"></i>--}}
{{--                        <span>@lang('sidebar.deposit')</span>--}}
{{--                        <span class="pull-right-container">--}}
{{--                            <i class="fa fa-angle-right pull-right"></i>--}}
{{--                        </span>--}}
{{--                    </a>--}}
{{--                    <ul class="treeview-menu">--}}
{{--                        <li class="{{ active('cash_in') }}"><a href="{{ url('cash_in') }}"><i class="fa fa-indent"></i> @lang('sidebar.cin')</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
                <li class="{{ active('cash_out') }}"><a href="{{ url('cash_out') }}"><i
                            class="fa fa-indent"></i> @lang('sidebar.cout')</a></li>
{{--                <li class="treeview {{ active(['cash_out']) }}">--}}
{{--                    <a href="">--}}
{{--                        <i class="fa fa-outdent"></i>--}}
{{--                        <span>@lang('sidebar.withdraw')</span>--}}
{{--                        <span class="pull-right-container">--}}
{{--                            <i class="fa fa-angle-right pull-right"></i>--}}
{{--                        </span>--}}
{{--                    </a>--}}
{{--                    <ul class="treeview-menu">--}}
{{--                        <li class="{{ active('cash_out') }}"><a href="{{ url('cash_out') }}"><i--}}
{{--                                    class="fa fa-indent"></i> @lang('sidebar.cout')</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--                <li class="treeview {{ active(['temp_journal']) }}">--}}
{{--                    <a href="">--}}
{{--                        <i class="fa fa-adn"></i>--}}
{{--                        <span>@lang('sidebar.accounting')</span>--}}
{{--                        <span class="pull-right-container">--}}
{{--                            <i class="fa fa-angle-right pull-right"></i>--}}
{{--                        </span>--}}
{{--                    </a>--}}
{{--                    <ul class="treeview-menu">--}}
{{--                        <li class="{{ active('temp_journal') }}"><a href="{{ url('temp_journal') }}"><i class="fa fa-newspaper-o"></i> @lang('sidebar.tempjour')</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
                <li class="{{ active('cash_open') }}"><a href="{{ url('cash_open') }}"><i class="fa fa-folder-open-o"></i> @lang('sidebar.opencash')</a></li>
                <li class="{{ active('cash_situation') }}"><a href="{{ url('cash_situation') }}"><i class="fa fa-signal"></i> @lang('sidebar.situatcash')</a></li>
                <li class="{{ active('cash_reconciliation') }}"><a href="{{ url('cash_reconciliation') }}"><i class="fa fa-bars"></i>@lang('sidebar.reconcash')</a></li>
                <li class="{{ active('money_exchange') }}"><a href="{{ url('money_exchange') }}"><i class="fa fa-exchange"></i> @lang('sidebar.monexc')</a></li>
            </ul>
        </li>
        <li class="treeview {{ active(['registration']) }}">
            <a href=""><i class="fa fa-dashboard"></i>
                <span>@lang('sidebar.back')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ active('registration') }}">
                    <a href="{{ url('registration') }}"><i class="fa fa-user-plus"></i> @lang('sidebar.registration')</a></li>
{{--                <li class="treeview {{ active(['registration']) }}">--}}
{{--                    <a href=""><i class="fa fa-users"></i>--}}
{{--                        <span>@lang('sidebar.member')s</span>--}}
{{--                        <span class="pull-right-container">--}}
{{--                    <i class="fa fa-angle-right pull-right"></i>--}}
{{--                </span>--}}
{{--                    </a>--}}
{{--                    <ul class="treeview-menu">--}}
{{--                        <li class="{{ active('registration') }}">--}}
{{--                            <a href="{{ url('registration') }}"><i class="fa fa-user-plus"></i> @lang('sidebar.registration')</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
            </ul>
        </li>
    </ul>
</li>

<li class="treeview {{ active(['journal', 'temp_journal', 'transaction', 'employee_list', 'collect_list', 'client_list', 'client_acc', 'collect_acc', 'client_sit', 'collect_sit', 'collect_report', 'commis_report', 'shared_commis_report']) }}">
    <a href="">
        <i class="fa fa-files-o"></i>
        <span>@lang('sidebar.reports')</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ active('client_list') }}"><a href="{{ url('client_list') }}"><i class="fa fa-user-circle-o"></i> @lang('sidebar.client')</a></li>

{{--        <li class="treeview {{ active(['employee_list', 'collect_list', 'client_list']) }}">--}}
{{--            <a href=""><i class="fa fa-users"></i>--}}
{{--                <span> @lang('sidebar.list')</span>--}}
{{--                <span class="pull-right-container">--}}
{{--                    <i class="fa fa-angle-right pull-right"></i>--}}
{{--                </span>--}}
{{--            </a>--}}
{{--            <ul class="treeview-menu">--}}
{{--                <li class="{{ active('employee_list') }}"><a href="{{ url('employee_list') }}"><i class="fa fa-user-secret"></i> @lang('sidebar.employee')</a></li>--}}
{{--                <li class="{{ active('collect_list') }}"><a href="{{ url('collect_list') }}"><i class="fa fa-user"></i> @lang('sidebar.collector')</a></li>--}}
{{--                <li class="{{ active('client_list') }}"><a href="{{ url('client_list') }}"><i class="fa fa-user-circle-o"></i> @lang('sidebar.client')</a></li>--}}
{{--            </ul>--}}
{{--        </li>--}}

        <li class="treeview {{ active(['journal', 'temp_journal', 'transaction']) }}">
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
                <li class="{{ active('transaction') }}"><a href="{{ url('transaction') }}"><i
                            class="fa fa-book"></i> @lang('sidebar.valtrans')</a></li>
            </ul>
        </li>
        {{--        <li class="{{ active('collect_report') }}"><a href="{{ url('collect_report') }}"><i class="fa fa-user-circle-o"></i> @lang('sidebar.dailycol')</a></li>--}}
        <li class="{{ active('client_sit') }}"><a href="{{ url('client_sit') }}"><i class="fa fa-user-circle-o"></i> @lang('sidebar.client_sit')</a></li>

        {{--        <li class="treeview {{ active(['client_sit', 'collect_sit']) }}">--}}
        {{--            <a href=""><i class="fa fa-address-book"></i>--}}
        {{--                <span> @lang('sidebar.sit')</span>--}}
        {{--                <span class="pull-right-container">--}}
        {{--                    <i class="fa fa-angle-right pull-right"></i>--}}
        {{--                </span>--}}
        {{--            </a>--}}
        {{--            <ul class="treeview-menu">--}}
        {{--                <li class="{{ active('collect_sit') }}"><a href="{{ url('collect_sit') }}"><i class="fa fa-user"></i> @lang('sidebar.collect_sit')</a></li>--}}
        {{--                <li class="{{ active('client_sit') }}"><a href="{{ url('client_sit') }}"><i class="fa fa-user-circle-o"></i> @lang('sidebar.client_sit')</a></li>--}}
        {{--            </ul>--}}
        {{--        </li>--}}
        <li class="{{ active('client_acc') }}"><a href="{{ url('client_acc') }}"><i class="fa fa-user-circle-o"></i> @lang('sidebar.client_acc')</a></li>

        {{--        <li class="treeview {{ active(['client_acc', 'collect_acc']) }}">--}}
        {{--            <a href=""><i class="fa fa-address-book"></i>--}}
        {{--                <span> @lang('sidebar.acc_state')</span>--}}
        {{--                <span class="pull-right-container">--}}
        {{--                    <i class="fa fa-angle-right pull-right"></i>--}}
        {{--                </span>--}}
        {{--            </a>--}}
        {{--            <ul class="treeview-menu">--}}
        {{--                <li class="{{ active('collect_acc') }}"><a href="{{ url('collect_acc') }}"><i class="fa fa-user"></i> @lang('sidebar.collect_acc')</a></li>--}}
        {{--                <li class="{{ active('client_acc') }}"><a href="{{ url('client_acc') }}"><i class="fa fa-user-circle-o"></i> @lang('sidebar.client_acc')</a></li>--}}
        {{--            </ul>--}}
        {{--        </li>--}}
        <li class="{{ active('shared_commis_report') }}"><a href="{{ url('shared_commis_report') }}"><i class="fa fa-trademark"></i> @lang('sidebar.shared_commis_report')</a></li>
        {{--        <li class="treeview {{ active(['collect_report', 'commis_report', 'shared_commis_report']) }}">--}}
        {{--            <a href=""><i class="fa fa-opera"></i>--}}
        {{--                <span> @lang('sidebar.dailycol')</span>--}}
        {{--                <span class="pull-right-container">--}}
        {{--                    <i class="fa fa-angle-right pull-right"></i>--}}
        {{--                </span>--}}
        {{--            </a>--}}
        {{--            <ul class="treeview-menu">--}}
        {{--                <li class="{{ active('collect_report') }}"><a href="{{ url('collect_report') }}"><i class="fa fa-user"></i> @lang('sidebar.collect_report')</a></li>--}}
        {{--                <li class="{{ active('commis_report') }}"><a href="{{ url('commis_report') }}"><i class="fa fa-opera"></i> @lang('sidebar.commis_report')</a></li>--}}
        {{--                <li class="{{ active('shared_commis_report') }}"><a href="{{ url('shared_commis_report') }}"><i class="fa fa-trademark"></i> @lang('sidebar.shared_commis_report')</a></li>--}}
        {{--            </ul>--}}
        {{--        </li>--}}
    </ul>
</li>


{{--<li class="treeview">--}}
{{--    <a href=""><i class="fa fa-stack-overflow"></i>--}}
{{--        <span> @lang('sidebar.bi')</span>--}}
{{--        <span class="pull-right-container">--}}
{{--            <i class="fa fa-angle-right pull-right"></i>--}}
{{--        </span>--}}
{{--    </a>--}}
{{--    <ul class="treeview-menu">--}}
{{--        <li><a href=""><i class="fa fa-key"></i>@lang('sidebar.pki')</a></li>--}}
{{--        <li><a href=""><i class="fa fa-circle-o"></i>@lang('sidebar.prud_norm')</a></li>--}}
{{--        @if ($emp->level === 'I')--}}
{{--            <li><a href=""><i class="fa fa-circle-o"></i>@lang('sidebar.crm')</a></li>--}}
{{--            <li><a href=""><i class="fa fa-building"></i>@lang('sidebar.credt_off')</a></li>--}}
{{--            <li><a href=""><i class="fa fa-bookmark"></i>@lang('sidebar.bench')</a></li>--}}
{{--        @endif--}}
{{--    </ul>--}}
{{--</li>--}}

