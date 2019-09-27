<aside class="main-sidebar">
    <!-- sidebar: -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset($emp->pic) }}" class="img-circle"
                     alt="{{ $emp->surname }}">
            </div>
            <div class="pull-left info">
                <p>{{ $emp->name }}</p>
                <p>@if ($emp->lang == 'fr') {{ $emp->labelfr }}@else {{ $emp->labeleng }}@endif</p>
            </div>
        </div>
        <!-- sidebar menu: -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview {{ active(['admin', 'omega']) }} home"><a href="{{url('omega')}}"><i
                        class="fa fa-home"></i> <span>@lang('sidebar.home')</span></a></li>

            <li class="treeview {{ active(['registered_file', 'member_file', 'account_file']) }}">
                <a href=""><i class="fa fa-files-o"></i>
                    <span>@lang('sidebar.files')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{active('registered_file')}}"><a href="{{url('registered_file')}}"><i
                                class="fa fa-user-circle-o"></i> @lang('sidebar.registered')s</a></li>
                    <li class="{{active('member_file')}}"><a href="{{url('member_file')}}"><i
                                class="fa fa-user"></i> @lang('sidebar.member')s</a></li>
                    <li class="{{active('account_file')}}"><a href="{{url('account_file')}}"><i
                                class="fa fa-book"></i> @lang('sidebar.account')</a></li>
                </ul>
            </li>
            @switch($emp->privilege)
                @case (1)
                @include('admin.sidebar')
                @break
                @case (2)
                @include('member.sidebar')
                @break
                @case (3)
                @include('cashier.sidebar')
                @break
                @case (4)
                @include('collector.sidebar')
                @break
                @case (5)
                @case (9)
                @case (18)
                @include('account.sidebar')
                @break
                @case (6)
                @include('loanoff.sidebar')
                @break
                @case (7)
                @case (8)
                @include('branch.sidebar')
                @break
                @case (10)
                @include('control.sidebar')
                @break
                @case (11)
                @case (24)
                @include('credit.sidebar')
                @break
                @case (12)
                @include('analyst.sidebar')
                @break
                @case (13)
                @include('finance.sidebar')
                @break
                @case (14)
                @case (28)
                @include('human.sidebar')
                @break
                @case (15)
                @case (25)
                @include('store.sidebar')
                @break
                @case (16)
                @case (17)
                @case (21)
                @case (22)
                @include('general.sidebar')
                @break
                @case (19)
                @case (23)
                @include('auditor.sidebar')
                @break
                @case (20)
                @case (27)
                @include('recovery.sidebar')
                @break
                @case (26)
                @include('supervisor.sidebar')
                @break
                @case (29)
                @include('insurance.sidebar')
                @break
                @case (30)
                @include('statistic.sidebar')
                @break
                @case (31)
                @case (32)
                @case (33)
                @case (34)
                @include('organ.sidebar')
                @break
                @default
                @include('admin.sidebar')
                @break
            @endswitch
            @if($emp->idpriv != -1)
                <li class="treeview {{ active(['prev_acc_situation', 'prev_mem_situation', 'prev_acc_history', 'prev_mem_history', 'prev_trial_balance',
                'prev_balance_sheet', 'prev_inc_exp', 'prev_journal', 'prev_loan', 'prev_delinquency']) }}">
                    <a href=""><i class="fa fa-angle-double-left"></i>
                        <span>@if($emp->lang == 'fr') EXERCICE ANTERIEUR @else PREVIOUS EXERCISE @endif</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview {{ active(['prev_acc_situation', 'prev_mem_situation']) }}">
                            <a href=""><i class="ion ion-stats-bars"></i>
                                <span>@lang('sidebar.acc_sit')</span>
                                <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ active('prev_acc_situation') }}"><a
                                        href="{{ url('prev_acc_situation') }}"><i
                                            class="fa fa-address-book"></i> @lang('sidebar.account')</a></li>
                                <li class="{{ active('prev_mem_situation') }}"><a
                                        href="{{ url('prev_mem_situation') }}"><i
                                            class="fa fa-user"></i> @lang('sidebar.member')</a></li>
                            </ul>
                        </li>
                        <li class="treeview {{ active(['prev_acc_history', 'prev_mem_history']) }}">
                            <a href=""><i class="fa fa-history"></i>
                                <span> @lang('sidebar.acc_his')</span>
                                <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ active('prev_acc_history') }}"><a
                                        href="{{ url('prev_acc_history') }}"><i
                                            class="fa fa-address-book"></i> @lang('sidebar.account')</a></li>
                                <li class="{{ active('prev_mem_history') }}"><a
                                        href="{{ url('prev_mem_history') }}"><i
                                            class="fa fa-user"></i> @lang('sidebar.member')
                                    </a></li>
                            </ul>
                        </li>
                        <li class="treeview {{ active(['prev_trial_balance', 'prev_balance_sheet', 'prev_inc_exp']) }}">
                            <a href=""><i class="fa fa-fa"></i>
                                <span>@lang('sidebar.finstat')</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ active('prev_trial_balance') }}"><a
                                        href="{{ url('prev_trial_balance') }}"><i
                                            class="fa fa-balance-scale"></i> @lang('sidebar.trialbal')</a></li>
                                <li class="{{ active('prev_balance_sheet') }}"><a
                                        href="{{ url('prev_balance_sheet') }}"><i
                                            class="fa fa-balance-scale"></i> @lang('sidebar.balsheet')</a></li>
                                <li class="{{ active('prev_inc_exp') }}"><a href="{{ url('prev_inc_exp') }}"><i
                                            class="fa fa-expand"></i> @lang('sidebar.inc&exp')</a>
                                </li>
                            </ul>
                        </li>
                        <li class="{{ active('prev_journal') }}"><a href="{{ url('prev_journal') }}"><i
                                    class="fa fa-newspaper-o"></i> Journal</a></li>
                        <li class="{{ active('prev_loan') }}"><a href="{{ url('prev_loan') }}"><i
                                    class="fa fa-money"></i>@if($emp->lang == 'fr') Prêt @else Loans @endif</a>
                        <li class="{{ active('prev_delinquency') }}"><a href="{{ url('prev_delinquency') }}"><i
                                    class="fa fa-list"></i>@if($emp->lang == 'fr') Délinquance @else Delinquency @endif
                            </a>
                    </ul>
                </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
