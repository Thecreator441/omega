<?php

    use App\Models\Menu_Level_I;
    use App\Models\Menu_Level_II;
    use App\Models\Menu_Level_III;
    use App\Models\Menu_Level_IV;
    use App\Models\Priv_Menu;

    $path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $uri = explode('/', $path);
?>

<aside class="main-sidebar">
    <!-- sidebar: -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                @if($emp->pic === null)
                    <img src="{{ asset('storage/logos/logo.png') }}" class="img-circle" alt="{{ $emp->surname }}">
                @else
                    @if ($emp->level !== 'P')
                        <img src="{{ asset('storage/employees/profiles/'.$emp->pic) }}" class="img-circle" alt="{{ $emp->surname }}">
                    @elseif ($emp->level === 'P')
                        <img src="{{ asset('storage/platforms/profiles/'.$emp->pic) }}" class="img-circle" alt="{{ $emp->surname }}">
                    @else
                        <img src="{{ asset('storage/logos/logo.png') }}" class="img-circle" alt="{{ $emp->surname }}">
                    @endif
                @endif
            </div>
            <div class="pull-left info">
                <p>{{$emp->name}}</p>
                <p>
                    @if ($emp->lang == 'fr') {{$emp->labelfr}} @else {{$emp->labeleng}}@endif
                    @if ($emp->level === 'O')
                        - @lang('label.organ')
                    @elseif ($emp->level === 'N')
                        - @lang('label.network')  
                    @elseif ($emp->level === 'Z')
                        - @lang('label.zone')
                    @elseif ($emp->level === 'I')
                        - @lang('label.institution')
                    @elseif ($emp->level === 'B')
                        - @lang('label.branch')
                    @else
                        - @lang('label.platform')
                    @endif
                </p>
            </div>
        </div>
        <!-- sidebar menu: -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview {{ active(['admin', 'omega']) }} home"><a href="{{route('to_home')}}"><i class="fa fa-home"></i> <span>@lang('sidebar.homes')</span></a></li>
            <form action="{{route('to_home')}}" method="get" role="form" id="homePage" style="display: none">
                {{ csrf_field() }}
            </form>

            @foreach($menus_1 as $menu_1)
                <?php 
                    $menu1 = Menu_Level_I::getMenu($menu_1->menu_1);
                    if($emp->lang == 'fr') {
                        $title = $menu1->labelfr;
                    } else {
                        $title = $menu1->labeleng;
                    }
                ?>
                @section('title', $title)
                @if($menu1->view_path !== null)
                    <?php
                        $active = "{$menu1->view_path}";
                        $url = "{$menu1->view_path}?level=1&menu={$menu1->idmenus_1}";
                    ?>
                    <li class="treeview {{ active($active) }}">
                        <a href="{{url($url)}}"><i class="{{$menu1->view_icon}}"></i> 
                        <span>@if($emp->lang == 'fr') {{$menu1->labelfr}} @else {{$menu1->labeleng}} @endif</span></a>
                    </li>
                    {{-- <form action="{{route('$url')}}" method="get" role="form" id="{$menu1->view_path}" style="display: none">
                        {{ csrf_field() }}
                    </form> --}}
                @else
                    <?php
                        $active = '';
                        
                        $menus2 = Menu_Level_II::getMenus(null, ['menu_1' => $menu1->idmenus_1]);

                        foreach ($menus2 as $menu2_key => $menu2) {
                            if ($menu2->view_path == null) {
                                $menus3 = Menu_Level_III::getMenus(null, ['menu_2' => $menu2->idmenus_2]);
                                foreach ($menus3 as $menu3_key => $menu3) {
                                    if ($menu3->view_path == null) {
                                        $menus4 = Menu_Level_IV::getMenus(null, ['menu_3' => $menu3->idmenus_3]);
                                        foreach ($menus4 as $menu4_key => $menu4) {
                                            if ($uri[1] == $menu4->view_path) {
                                                $active = "{$menu4->view_path}";
                                            }
                                        }
                                    } else {
                                        if ($uri[1] == $menu3->view_path) {
                                            $active = "{$menu3->view_path}";
                                        }
                                    }
                                }
                            } else {
                                if ($uri[1] == $menu2->view_path) {
                                    $active = "{$menu2->view_path}";
                                }
                            }
                        }
                    ?>
                    <li class="treeview {{ active($active) }}">
                        <a href=""><i class="{{$menu1->view_icon}}"></i>
                            <span>@if($emp->lang == 'fr') {{$menu1->labelfr}} @else {{$menu1->labeleng}} @endif</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        
                        <?php
                            $menus_2 = Priv_Menu::getPrivMenusAside(['privilege' => $emp->privilege, 'menu_1' => $menu_1->menu_1], 'menu_2');
                        ?>
                        
                        @if($menus_2->count() > 0)
                            <ul class="treeview-menu">
                                @foreach($menus_2 as $menu_2_key => $menu_2)
                                    @if($menu_2->menu_2 !== null)
                                        <?php 
                                            $menu2 = Menu_Level_II::getMenu($menu_2->menu_2);
                                            if($emp->lang == 'fr') {
                                                $title = $menu2->labelfr;
                                            } else {
                                                $title = $menu2->labeleng;
                                            }
                                        ?>
                                        @section('title', $title)
                                        @if($menu2->view_path !== null)
                                            <?php
                                                $active = "{$menu2->view_path}";
                                                $url = "{$menu2->view_path}?level=2&menu={$menu_2->menu_2}";
                                            ?>
                                            <li class="{{ active($active) }}">
                                            <a href="{{ url($url) }}">
                                            <i class="{{$menu2->view_icon}}"></i>@if($emp->lang == 'fr') {{$menu2->labelfr}} @else {{$menu2->labeleng}} @endif
                                            </a></li>
                                        @else
                                            <?php
                                                $active = '';
                                                
                                                $menus3 = Menu_Level_III::getMenus(null, ['menu_2' => $menu2->idmenus_2]);
                                                foreach ($menus3 as $menu3_key => $menu3) {
                                                    if ($menu3->view_path === null) {
                                                        $menus4 = Menu_Level_IV::getMenus(null, ['menu_3' => $menu3->idmenus_3]);
                                                        foreach ($menus4 as $menu4_key => $menu4) {
                                                            if ($menu4->view_path !== null) {
                                                                if ($uri[1] == $menu4->view_path) {
                                                                    $active = "{$menu4->view_path}";
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        if ($uri[1] == $menu3->view_path) {
                                                            $active = "{$menu3->view_path}";
                                                        }
                                                    }
                                                }
                                            ?>
                                            <li class="treeview {{ active($active) }}">
                                                <a href=""><i class="{{$menu2->view_icon}}"></i>
                                                    <span>@if($emp->lang == 'fr') {{$menu2->labelfr}} @else {{$menu2->labeleng}} @endif</span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-right pull-right"></i>
                                                    </span>
                                                </a>

                                                <?php
                                                    $menus_3 = Priv_Menu::getPrivMenusAside(['privilege' => $emp->privilege, 'menu_2' => $menu_2->menu_2], 'menu_3');
                                                ?>
        
                                                @if($menus_3->count() > 0)
                                                    <ul class="treeview-menu">
                                                        @foreach($menus_3 as $menu_3_key => $menu_3)
                                                            @if($menu_3->menu_3 !== null)
                                                                <?php 
                                                                    $menu3 = Menu_Level_III::getMenu($menu_3->menu_3);
                                                                    if($emp->lang == 'fr') {
                                                                        $title = $menu3->labelfr;
                                                                    } else {
                                                                        $title = $menu3->labeleng;
                                                                    }
                                                                ?>
                                                                @section('title', $title)
                                                                @if($menu3->view_path !== null)
                                                                    <?php
                                                                        $active = "{$menu3->view_path}";
                                                                        $url = "{$menu3->view_path}?level=3&menu={$menu_3->menu_3}" 
                                                                    ?>
                                                                    <li class="{{ active($active) }}">
                                                                    <a href="{{ url($url) }}">
                                                                    <i class="{{$menu3->view_icon}}"></i>@if($emp->lang == 'fr') {{$menu3->labelfr}} @else {{$menu3->labeleng}} @endif
                                                                    </a></li>
                                                                @else
                                                                    <?php
                                                                        $active = '';

                                                                        $menus4 = Menu_Level_IV::getMenus(null, ['menu_3' => $menu3->idmenus_3]);
                                                                        foreach ($menus4 as $menu4_key => $menu4) {
                                                                            if ($menu4->view_path !== null) {
                                                                                if ($uri[1] == $menu4->view_path) {
                                                                                    $active = "{$menu4->view_path}";
                                                                                }
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <li class="treeview {{ active($active) }}">
                                                                        <a href=""><i class="{{$menu3->view_icon}}"></i>
                                                                            <span>@if($emp->lang == 'fr') {{$menu3->labelfr}} @else {{$menu3->labeleng}} @endif</span>
                                                                            <span class="pull-right-container">
                                                                                <i class="fa fa-angle-right pull-right"></i>
                                                                            </span>
                                                                        </a>

                                                                        <?php
                                                                            $menus_4 = Priv_Menu::getPrivMenusAside(['privilege' => $emp->privilege, 'menu_3' => $menu_3->menu_3], 'menu_4');
                                                                        ?>

                                                                        @if($menus_4->count() > 0)
                                                                            <ul class="treeview-menu">
                                                                                @foreach($menus_4 as $menu_4_key => $menu_4)
                                                                                    @if($menu_4->menu_4 !== null)
                                                                                        <?php 
                                                                                            $menu4 = Menu_Level_IV::getMenu($menu_4->menu_4);
                                                                                            if($emp->lang == 'fr') {
                                                                                                $title = $menu4->labelfr;
                                                                                            } else {
                                                                                                $title = $menu4->labeleng;
                                                                                            }
                                                                                        ?>
                                                                                        @section('title', $title)
                                                                                        @if($menu4->view_path !== null)
                                                                                            <?php
                                                                                                $active = '';
                                                                                                if ($uri[1] == $menu4->view_path) {
                                                                                                    $active = "{$menu4->view_path}";
                                                                                                }
                                                                                                $url = "{$menu4->view_path}?level=4&menu={$menu4->idmenus_4}" 
                                                                                            ?>
                                                                                            <li class="{{ active($active) }}">
                                                                                            <a href="{{ url($url) }}">
                                                                                            <i class="{{$menu4->view_icon}}"></i>@if($emp->lang == 'fr') {{$menu4->labelfr}} @else {{$menu4->labeleng}} @endif
                                                                                            </a></li>
                                                                                        @endif
                                                                                    @endif
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </li>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach

            {{-- @if ($emp->employee === null && $emp->collector === null)
                @include('admin.sidebar')
            @elseif ($emp->collector !== null)
                @include('collector.sidebar')
            @else
                @switch($emp->code)
                    @case (1)
                    @include('member.sidebar')
                    @break
                    @case (2)
                    @include('cashier.sidebar')
                    @break
                    @case (4)
                    @case (8)
                    @case (17)
                    @include('account.sidebar')
                    @break
                    @case (6)
                    @include('loanoff.sidebar')
                    @break
                    @case (6)
                    @case (7)
                    @include('branch.sidebar')
                    @break
                    @case (9)
                    @case (39)
                    @include('control.sidebar')
                    @break
                    @case (10)
                    @case (23)
                    @include('credit.sidebar')
                    @break
                    @case (11)
                    @include('analyst.sidebar')
                    @break
                    @case (12)
                    @include('finance.sidebar')
                    @break
                    @case (13)
                    @case (27)
                    @include('human.sidebar')
                    @break
                    @case (14)
                    @case (24)
                    @case (40)
                    @include('store.sidebar')
                    @break
                    @case (15)
                    @case (16)
                    @case (20)
                    @case (21)
                    @include('general.sidebar')
                    @break
                    @case (18)
                    @case (22)
                    @include('auditor.sidebar')
                    @break
                    @case (19)
                    @case (26)
                    @include('recovery.sidebar')
                    @break
                    @case (25)
                    @include('supervisor.sidebar')
                    @break
                    @case (28)
                    @include('insurance.sidebar')
                    @break
                    @case (30)
                    @include('statistic.sidebar')
                    @break
                    @case (30)
                    @case (31)
                    @case (32)
                    @case (33)
                    @include('organ.sidebar')
                    @break
                    @case (34)
                    @case (35)
                    @case (36)
                    @case (37)
                    @case (38)
                    @include('admin.uasidebar')
                    @break
                    @default
                    @include('admin.sidebar')
                    @break
                @endswitch
            @endif --}}

            {{--            <li class="treeview {{active(['employee_list', 'collect_list', 'client_list', 'registered_file', 'member_file', 'account_file', 'client_acc', 'collect_acc', 'client_sit', 'collect_sit', 'collect_report', 'commis_report', 'shared_commis_report']) }}">--}}
            {{--                <a href=""><i class="fa fa-files-o"></i>--}}
            {{--                    <span>@lang('sidebar.reports')</span>--}}
            {{--                    <span class="pull-right-container">--}}
            {{--                        <i class="fa fa-angle-right pull-right"></i>--}}
            {{--                    </span>--}}
            {{--                </a>--}}
            {{--                <ul class="treeview-menu">--}}
            {{--                    <li class="treeview {{active(['employee_list', 'collect_list', 'client_list', 'registered_file', 'member_file', 'account_file']) }}">--}}
            {{--                        <a href=""><i class="fa fa-users"></i>--}}
            {{--                            <span> @lang('sidebar.list')</span>--}}
            {{--                            <span class="pull-right-container">--}}
            {{--                                <i class="fa fa-angle-right pull-right"></i>--}}
            {{--                            </span>--}}
            {{--                        </a>--}}
            {{--                        <ul class="treeview-menu">--}}
            {{--                            <li class="{{ active('registered_file')}}"><a href="{{url('registered_file')}}"><i class="fa fa-user-circle-o"></i> @lang('sidebar.registereds')</a></li>--}}
            {{--                            <li class="{{ active('member_file')}}"><a href="{{url('member_file')}}"><i class="fa fa-user"></i> @lang('sidebar.member')s</a></li>--}}
            {{--                            <li class="{{ active('client_list') }}"><a href="{{ url('client_list') }}"><i class="fa fa-user-circle-o"></i> @lang('sidebar.client')</a></li>--}}
            {{--                            <li class="{{ active('account_file')}}"><a href="{{url('account_file')}}"><i class="fa fa-book"></i> @lang('sidebar.account')</a></li>--}}
            {{--                            <li class="{{ active('employee_list') }}"><a href="{{ url('employee_list') }}"><i class="fa fa-user-secret"></i> @lang('sidebar.employee')</a></li>--}}
            {{--                            <li class="{{ active('collect_list') }}"><a href="{{ url('collect_list') }}"><i class="fa fa-user"></i> @lang('sidebar.collector')</a></li>--}}

            {{--                        </ul>--}}
            {{--                    </li>--}}
            {{--                    <li class="treeview {{active(['client_sit', 'collect_sit']) }}">--}}
            {{--                        <a href=""><i class="fa fa-address-book"></i>--}}
            {{--                            <span> @lang('sidebar.sit')</span>--}}
            {{--                            <span class="pull-right-container">--}}
            {{--                                <i class="fa fa-angle-right pull-right"></i>--}}
            {{--                            </span>--}}
            {{--                        </a>--}}
            {{--                        <ul class="treeview-menu">--}}
            {{--                            <li class="{{ active('collect_sit') }}"><a href="{{ url('collect_sit') }}"><i class="fa fa-user"></i> @lang('sidebar.collect_sit')</a></li>--}}
            {{--                            <li class="{{ active('client_sit') }}"><a href="{{ url('client_sit') }}"><i class="fa fa-user-circle-o"></i> @lang('sidebar.client_sit')</a></li>--}}
            {{--                        </ul>--}}
            {{--                    </li>--}}
            {{--                    <li class="treeview {{active(['client_acc', 'collect_acc']) }}">--}}
            {{--                        <a href=""><i class="fa fa-address-book"></i>--}}
            {{--                            <span> @lang('sidebar.acc_state')</span>--}}
            {{--                            <span class="pull-right-container">--}}
            {{--                    <i class="fa fa-angle-right pull-right"></i>--}}
            {{--                </span>--}}
            {{--                        </a>--}}
            {{--                        <ul class="treeview-menu">--}}
            {{--                            <li class="{{ active('collect_acc') }}"><a href="{{ url('collect_acc') }}"><i class="fa fa-user"></i> @lang('sidebar.collect_acc')</a></li>--}}
            {{--                            <li class="{{ active('client_acc') }}"><a href="{{ url('client_acc') }}"><i class="fa fa-user-circle-o"></i> @lang('sidebar.client_acc')</a></li>--}}
            {{--                        </ul>--}}
            {{--                    </li>--}}
            {{--                    <li class="treeview {{active(['collect_report', 'commis_report', 'shared_commis_report']) }}">--}}
            {{--                        <a href=""><i class="fa fa-opera"></i>--}}
            {{--                            <span> @lang('sidebar.dailycol')</span>--}}
            {{--                            <span class="pull-right-container">--}}
            {{--                                <i class="fa fa-angle-right pull-right"></i>--}}
            {{--                            </span>--}}
            {{--                        </a>--}}
            {{--                        <ul class="treeview-menu">--}}
            {{--                            <li class="{{ active('collect_report') }}"><a href="{{ url('collect_report') }}"><i class="fa fa-user"></i> @lang('sidebar.collect_report')</a></li>--}}
            {{--                            <li class="{{ active('commis_report') }}"><a href="{{ url('commis_report') }}"><i class="fa fa-opera"></i> @lang('sidebar.commis_report')</a></li>--}}
            {{--                            <li class="{{ active('shared_commis_report') }}"><a href="{{ url('shared_commis_report') }}"><i class="fa fa-trademark"></i> @lang('sidebar.shared_commis_report')</a></li>--}}
            {{--                        </ul>--}}
            {{--                    </li>--}}
            {{--                </ul>--}}
            {{--            </li>--}}
            {{--
            @if($emp->employee !== null)
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
            --}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
