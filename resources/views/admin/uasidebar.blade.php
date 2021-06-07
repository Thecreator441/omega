<li class="treeview {{ active(['network', 'zone', 'institution', 'branch', 'acc_plan', 'user', 'collector', 'cash', 'operation']) }}">
    <a href=""><i class="fa fa-gears"></i>
        <span> @lang('sidebar.setting')</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="treeview {{ active(['network', 'zone', 'institution', 'branch']) }}">
            <a href="">
                <i class="fa fa-gears"></i>
                <span> @lang('sidebar.gen')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @if ($emp->level === 'N')
                    <li class="{{ active('network') }}"><a href="{{ url('network') }}"><i class="fa fa-building"></i> @lang('sidebar.network')</a></li>
                @endif
                @if ($emp->level === 'I')
                    <li class="{{ active('institution') }}"><a href="{{ url('institution') }}"><i class="fa fa-building-o"></i> @lang('sidebar.institute')</a></li>
                @endif
                @if ($emp->level === 'B')
                    <li class="{{ active('branch') }}"><a href="{{ url('branch') }}"><i class="fa fa-home"></i> @lang('sidebar.branch')</a></li>
                @endif
            </ul>
        </li>
        <li class="treeview {{ active(['acc_plan', 'user', 'collector', 'cash', 'operation']) }}">
            <a href="">
                <i class="fa fa-gear"></i>
                <span> @lang('sidebar.specific')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @if($emp->level === 'I')
                    <li class="{{ active('acc_plan') }}"><a href="{{ url('acc_plan') }}"><i class="fa fa-book"></i> @lang('sidebar.accplan')</a></li>
                    <li class="{{ active('user') }}"><a href="{{ url('user') }}"><i class="fa fa-user-secret"></i> @lang('sidebar.user')</a></li>
                @endif
                @if ($emp->level === 'B')
                    <li class="{{ active('collector') }}"><a href="{{ url('collector') }}"><i class="fa fa-users"></i> @lang('sidebar.collector')</a></li>
                    <li class="{{ active('cash') }}"><a href="{{ url('cash') }}"><i class="fa fa-money"></i> @lang('sidebar.cash')</a></li>
                @endif
                {{--                <li class="{{ active('operation') }}"><a href="{{ url('operation') }}"><i class="fa fa-opera"></i> @lang('sidebar.opera')</a></li>--}}
            </ul>
        </li>
    </ul>
</li>
