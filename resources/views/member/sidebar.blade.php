<li class="treeview {{ active(['registration', 'mem_situation', 'mem_history']) }}">
    <a href="">
        <i class="fa fa-opera"></i>
        <span>@lang('sidebar.operation')</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="treeview {{ active(['registration', 'mem_situation', 'mem_history']) }}">
            <a href=""><i class="fa fa-dashboard"></i>
                <span>@lang('sidebar.back')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview {{ active(['registration']) }}">
                    <a href=""><i class="fa fa-users"></i>
                        <span>@lang('sidebar.member')s</span>
                        <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('registration') }}">
                            <a href="{{ url('registration') }}"><i
                                    class="fa fa-user-plus"></i>@lang('sidebar.registration')</a></li>
                    </ul>
                </li>
                <li class="treeview {{ active('mem_situation') }}">
                    <a href=""><i class="fa fa-bars"></i>
                        <span>@lang('sidebar.acc_sit')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('mem_situation') }}">
                            <a href="{{ url('mem_situation') }}"><i class="fa fa-user"></i> @lang('sidebar.member')</a>
                        </li>
                    </ul>
                </li>
                <li class="treeview {{ active('mem_history') }}">
                    <a href=""><i class="fa fa-history"></i>
                        <span>@lang('sidebar.acc_his')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('mem_history') }}"><a
                                href="{{ url('mem_history') }}"><i
                                    class="fa fa-user"></i> @lang('sidebar.member')</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="treeview">
            <a href=""><i class="fa fa-opera"></i>
                <span>@if($emp->lang == 'fr') Autre Opérations @else Other Operations @endif</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href=""><i class="fa fa-exchange"></i>@if($emp->lang == 'fr') Transfert
                        d'Argent @else Money Transfer @endif</a></li>
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
        <li><a href=""><i class="fa fa-circle-o"></i> CRM</a></li>
        <li><a href=""><i class="fa fa-building"></i> Credit Bureau</a></li>
    </ul>
</li>
