<li class="treeview {{ active(['cash_from', 'replenish', 'cash_to', 'check_out', 'collect_report', 'journal', 'temp_journal',
'transaction', 'cash_open', 'cash_close', 'cash_reopen', 'cash_situation', 'cash_reconciliation', 'emission', 'gen_account',
'aux_account', 'permanent', 'banking', 'acc_to_acc', 'special', 'check_register', 'check_sort', 'other_check_sort',
'check_report', 'pay_deduct_init', 'pay_deduct_dist', 'pay_deduc_valid', 'share_savings_ins', 'loan_insurance', 'withdrawal_init',
'personalisation', 'block_unblock', 'withdrawal_report', 'acc_situation', 'mem_situation', 'acc_history', 'mem_history',
'indiv_bal_history', 'acc_class_bal_history', 'acc_day_open', 'acc_day_close', 'backup', 'other_check_out']) }}">
    <a href="">
        <i class="fa fa-opera"></i>
        <span>@lang('sidebar.operation')</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="treeview {{ active(['cash_from', 'replenish', 'cash_to', 'check_out', 'other_check_out', 'collect_report',
        'journal', 'emission', 'temp_journal', 'transaction', 'cash_open', 'cash_close', 'cash_reopen', 'cash_situation',
        'cash_reconciliation',]) }}">
            <a href=""><i class="fa fa-toggle-on"></i>
                <span>@lang('sidebar.front')</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @if ($emp->level != 'Z')
                    <li class="treeview {{ active(['cash_from']) }}">
                        <a href="">
                            <i class="fa fa-indent"></i>
                            <span>@lang('sidebar.deposit')</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ active('cash_from') }}"><a href="{{ url('cash_from') }}"><i
                                        class="fa fa-bank"></i> @lang('sidebar.cfbank')</a></li>
                        </ul>
                    </li>
                    <li class="treeview {{ active(['cash_to', 'check_out', 'other_check_out', 'replenish']) }}">
                        <a href="">
                            <i class="fa fa-outdent"></i>
                            <span>@lang('sidebar.withdraw')</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ active('cash_to') }}"><a href="{{ url('cash_to') }}"><i
                                        class="fa fa-bank"></i> @lang('sidebar.ctbank')</a></li>
                            <li class="{{ active('check_out') }}"><a href="{{ url('check_out') }}"><i
                                        class="fa fa-check"></i> @lang('sidebar.checkout')</a></li>
                            <li class="{{ active('other_check_out') }}"><a href="{{ url('other_check_out') }}"><i
                                        class="fa fa-resistance"></i> @lang('sidebar.ocheout')</a></li>
                            <li class="{{ active('replenish') }}"><a href="{{ url('replenish') }}"><i
                                        class="fa fa-refresh"></i> @lang('sidebar.repfund')</a></li>
                        </ul>
                    </li>
                @endif
                <li class="treeview {{ active('collect_report') }}">
                    <a href="">
                        <i class="fa fa-columns"></i>
                        <span>@lang('sidebar.dailycol')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('collector_report') }}"><a href="{{ url('collector_report') }}"><i
                                    class="fa fa-registered"></i> @lang('sidebar.report')</a></li>
                    </ul>
                </li>
                @if ($emp->level != 'Z')
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
                    <li class="{{ active('cash_open') }}"><a href="{{ url('cash_open') }}"><i
                                class="fa fa-folder-open-o"></i> @lang('sidebar.opencash')</a></li>
                    <li class="{{ active('cash_close') }}"><a href="{{ url('cash_close') }}"><i
                                class="fa fa-folder-o"></i> @lang('sidebar.closecash')</a></li>
                    <li class="{{ active('cash_situation') }}"><a href="{{ url('cash_situation') }}"><i
                                class="fa fa-signal"></i> @lang('sidebar.situatcash')</a></li>
                    <li class="{{ active('cash_reconciliation') }}"><a href="{{ url('cash_reconciliation') }}"><i
                                class="fa fa-bars"></i> @lang('sidebar.reconcash')</a></li>
                @endif
            </ul>
        </li>

        @if ($emp->level !== 'Z')
            <li class="treeview {{ active(['gen_account', 'aux_account', 'permanent', 'banking',
            'acc_to_acc', 'special', 'check_register', 'check_sort', 'other_check_sort', 'check_report', 'pay_deduct_init',
            'pay_deduct_dist', 'pay_deduc_valid', 'share_savings_ins', 'loan_insurance', 'withdrawal_init', 'personalisation',
            'block_unblock', 'withdrawal_report', 'acc_situation', 'mem_situation', 'acc_history', 'mem_history',
            'indiv_bal_history', 'acc_class_bal_history']) }}">
                <a href=""><i class="fa fa-dashboard"></i>
                    <span>@lang('sidebar.back')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview {{ active(['gen_account', 'aux_account']) }}">
                        <a href=""><i class="fa fa-address-book"></i>
                            <span>@lang('sidebar.account')</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ active('gen_account') }}"><a href="{{ url('gen_account') }}"><i
                                        class="fa fa-address-book-o"></i> @lang('sidebar.gen')</a></li>
                            <li class="{{ active('aux_account') }}"><a href="{{ url('aux_account') }}"><i
                                        class="fa fa-maxcdn"></i> @lang('sidebar.aux')</a></li>
                        </ul>
                    </li>
                    <li class="treeview {{ active(['permanent', 'banking', 'acc_to_acc', 'special']) }}">
                        <a href=""><i class="fa fa-exchange"></i>
                            <span>@if($emp->lang == 'fr') Virement @else Transfers @endif</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ active('permanent') }}"><a href="{{ url('permanent') }}"><i
                                        class="fa fa-circle"></i> Permanent</a></li>
                            <li class="{{ active('banking') }}"><a href="{{ url('banking') }}"><i
                                        class="fa fa-bank"></i> @if($emp->lang == 'fr') Bancaire @else
                                        Banking @endif</a></li>
                            <li class="{{ active('acc_to_acc') }}"><a href="{{ url('acc_to_acc') }}"><i
                                        class="fa fa-address-book"></i> @if($emp->lang == 'fr') Compte à
                                    Compte @else Account to Account @endif</a></li>
                            <li class="{{ active('special') }}"><a href="{{ url('special') }}"><i
                                        class="fa fa-star"></i> @if($emp->lang == 'fr') Spécial @else
                                        Special @endif</a></li>
                        </ul>
                    </li>
                    <li class="treeview {{ active(['check_register', 'check_sort', 'other_check_sort', 'check_report']) }}">
                        <a href=""><i class="fa fa-check"></i>
                            <span>@lang('sidebar.checktreat')</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ active('check_register') }}"><a href="{{ url('check_register') }}"><i
                                        class="fa fa-check-circle"></i> @lang('sidebar.register')</a></li>
                            <li class="{{ active('check_sort') }}"><a href="{{ url('check_sort') }}"><i
                                        class="fa fa-sort"></i> @lang('sidebar.sort')</a></li>
                            <li class="{{ active('other_check_sort') }}"><a href="{{ url('other_check_sort') }}"><i
                                        class="fa fa-sort"></i> @lang('sidebar.other_sort')</a></li>
                            <li class="{{ active('check_report') }}"><a href="{{ url('check_report') }}"><i
                                        class="fa fa-registered"></i> @lang('sidebar.report')</a></li>
                        </ul>
                    </li>
                    <li class="treeview {{ active(['pay_deduct_init', 'pay_deduct_dist', 'pay_deduc_valid']) }}">
                        <a href=""><i class="fa fa-dedent"></i>
                            <span>@if($emp->lang == 'fr') Modèles @else Payroll Deduction @endif</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ active('pay_deduct_init') }}"><a href="{{ url('pay_deduct_init') }}"><i
                                        class="fa fa-hourglass-start"></i> Initialisation</a></li>
                            <li class="{{ active('pay_deduct_dist') }}"><a href="{{ url('pay_deduct_dist') }}"><i
                                        class="fa fa-diamond"></i> Distribution</a></li>
                            <li class="{{ active('pay_deduc_valid') }}"><a href="{{ url('pay_deduc_valid') }}"><i
                                        class="fa fa-check"></i> Validation</a></li>
                        </ul>
                    </li>
                    <li class="treeview {{ active(['share_savings_ins', 'loan_insurance']) }}">
                        <a href=""><i class="fa fa-institution"></i>
                            <span>@if($emp->lang == 'fr') Assurance @else Insurance @endif</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ active('share_savings_ins') }}"><a href="{{ url('share_savings_ins') }}"><i
                                        class="fa fa-share"></i> Share Savings</a></li>
                            <li class="{{ active('loan_insurance') }}"><a href="{{ url('loan_insurance') }}"><i
                                        class="fa fa-money"></i>@if($emp->lang == 'fr') Prêt @else Loans @endif</a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview {{ active(['withdrawal_init', 'personalisation', 'block_unblock', 'withdrawal_report']) }}">
                        <a href=""><i class="fa fa-newspaper-o"></i>
                            <span>@if($emp->lang == 'fr')Bon de Retrait @else Withdrawal Slip @endif</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ active('withdrawal_init') }}"><a
                                    href="{{ url('withdrawal_init') }}"><i class="fa fa-hourglass-start"></i>
                                    Initialisation</a></li>
                            <li class="{{ active('personalisation') }}"><a
                                    href="{{ url('personalisation') }}"><i
                                        class="fa fa-user"></i>@if($emp->lang == 'fr') Personnalisation @else
                                        Personalisation @endif</a></li>
                            <li class="{{ active('block_unblock') }}"><a
                                    href="{{ url('block_unblock') }}"><i
                                        class="fa fa-close"></i>@if($emp->lang == 'fr') Opposition/Annulation
                                    Opposition @else Block/Unblock  @endif</a></li>
                            <li class="{{ active('withdrawal_report') }}"><a
                                    href="{{ url('withdrawal_report') }}"><i
                                        class="fa fa-registered"></i>@if($emp->lang == 'fr') Rapport @else
                                        Report @endif</a></li>
                        </ul>
                    </li>
                    <li class="treeview {{ active(['acc_situation', 'mem_situation']) }}">
                        <a href=""><i class="ion ion-stats-bars"></i>
                            <span>@if($emp->lang == 'fr') Situation des Comptes @else Accounts
                                Situation @endif</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ active('acc_situation') }}"><a
                                    href="{{ url('acc_situation') }}"><i
                                        class="fa fa-address-book"></i>@if($emp->lang == 'fr') Compte @else
                                        Account @endif</a></li>
                            <li class="{{ active('mem_situation') }}"><a
                                    href="{{ url('mem_situation') }}"><i
                                        class="fa fa-user"></i> @if($emp->lang == 'fr') Membres @else
                                        Members @endif</a></li>
                        </ul>
                    </li>
                    <li class="treeview {{ active(['acc_history', 'mem_history', 'indiv_bal_history', 'acc_class_bal_history']) }}">
                        <a href=""><i class="fa fa-history"></i>
                            <span>@if($emp->lang == 'fr') Historique des Comptes @else Accounts
                                History @endif</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ active('acc_history') }}"><a
                                    href="{{ url('acc_history') }}"><i
                                        class="fa fa-address-book"></i>@if($emp->lang == 'fr') Compte @else
                                        Account @endif</a></li>
                            <li class="{{ active('mem_history') }}"><a
                                    href="{{ url('mem_history') }}"><i
                                        class="fa fa-user"></i> @if($emp->lang == 'fr') Membres /
                                    Clients @else Members / Clients @endif</a></li>
                            <li class="{{ active('indiv_bal_history') }}"><a
                                    href="{{ url('indiv_bal_history') }}"><i
                                        class="fa fa-balance-scale"></i>@if($emp->lang == 'fr') Balance
                                    Individuelle @else Individual Balance @endif</a></li>
                            <li class="{{ active('acc_class_bal_history') }}"><a
                                    href="{{ url('acc_class_bal_history') }}"><i
                                        class="fa fa-balance-scale"></i>@if($emp->lang == 'fr')  @else Account
                                    Class Balance @endif</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ active(['acc_day_open', 'acc_day_close', 'backup']) }}">
                <a href=""><i class="fa fa-dashcube"></i>
                    <span>@if($emp->lang == 'fr') Traitement Journalières @else Daily Treatments @endif</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ active('acc_day_open') }}"><a href="{{ url('acc_day_open') }}"><i
                                class="fa fa-calendar-plus-o"></i>@if($emp->lang == 'fr') Ouverture Journée
                            Comptable @else Accounting Day Opening @endif</a></li>
                    <li class="{{ active('acc_day_close') }}"><a href="{{ url('acc_day_close') }}"><i
                                class="fa fa-calendar-minus-o"></i>@if($emp->lang == 'fr') Fermeture Journée
                            Comptable @else Accounting Day Closing @endif</a></li>
                    <li class="{{ active('backup') }}"><a href="{{ url('backup') }}"><i
                                class="fa fa-save"></i>@if($emp->lang == 'fr') Sauvegarde @else Backup @endif
                        </a></li>
                </ul>
            </li>
        @endif
        <li class="treeview">
            <a href=""><i class="fa fa-opera"></i>
                <span>@if($emp->lang === 'fr') Autres Opérations @else Other Operations @endif</span>
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
                        <li><a href="{{url('budget_init')}}"><i class="fa fa-hourglass-start"></i> Initialisation</a></li>
                        {{--                            @if ($emp->level === 'I')--}}
                        <li><a href=""><i class="fa fa-contao"></i>@if($emp->lang == 'fr') Feuille de
                                Contrôle @else Control Sheet @endif</a></li>
                        {{--                            @endif--}}
                    </ul>
                </li>
                @if ($emp->level !== 'B')
                    <li class="treeview">
                        <a href=""><i class="fa fa-home"></i>
                            <span>@if($emp->lang == 'fr') Gestion des Actifs @else Assets Management @endif</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href=""><i class="fa fa-hourglass-start"></i> Initialisation</a></li>
                            @if ($emp->level == 'Z')
                                <li><a href=""><i class="fa fa-circle-o"></i>@if($emp->lang == 'fr')
                                            Comptabilisation @else Accounting @endif</a></li>
                                <li><a href=""><i class="fa fa-contao"></i>@if($emp->lang == 'fr') Feuille de
                                        Contrôle @else Control Sheet @endif</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                <li class="treeview">
                    <a href=""><i class="fa fa-stack-overflow"></i>
                        <span>@if($emp->lang == 'fr') Gestion des Stocks @else Stores Management @endif</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @if ($emp->level == 'I')
                            <li class="treeview">
                                <a href=""><i class="fa fa-hourglass-start"></i>
                                    <span>Initialisation</span>
                                    <span class="pull-right-container">
                                    <i class="fa fa-angle-right pull-right"></i>
                                </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href=""><i class="fa fa-product-hunt"></i>@if($emp->lang == 'fr')
                                                Produit @else Product @endif</a></li>
                                    <li><a href=""><i class="fa fa-user-o"></i> Client</a></li>
                                    <li><a href=""><i class="fa fa-repeat"></i>@if($emp->lang == 'fr')
                                                Représentant @else Representative @endif</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href=""><i class="fa fa-share-alt"></i>
                                    <span>@if($emp->lang == 'fr') Ventes @else Sales @endif</span>
                                    <span class="pull-right-container">
                                    <i class="fa fa-angle-right pull-right"></i>
                                </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href=""><i class="fa fa-product-hunt"></i> Direct</a>
                                    </li>
                                    <li><a href=""><i class="fa fa-user-o"></i> Indirect</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href=""><i class="fa fa-circle-o"></i>@if($emp->lang == 'fr')
                                        Comptabilisation @else Accounting @endif</a></li>
                            <li><a href=""><i class="fa fa-refresh"></i>@if($emp->lang == 'fr')
                                        Réapprovisionnement @else Replenishment @endif</a></li>
                        @endif
                        <li><a href=""><i class="fa fa-registered"></i>@if($emp->lang == 'fr') Rapport @else
                                    Report @endif</a></li>
                    </ul>
                </li>
                @if ($emp->level === 'Z')
                    <li class="treeview">
                        <a href=""><i class="fa fa-users"></i>
                            <span>@if($emp->lang == 'fr') Ressources Humaine @else Human Resources @endif</span>
                            <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href=""><i class="fa fa-book"></i>@if($emp->lang == 'fr') Rapport @else
                                        Report @endif</a></li>
                        </ul>
                    </li>
                @endif
                @if ($emp->level === 'I')
                    <li><a href=""><i class="fa fa-mobile"></i>@if($emp->lang == 'fr') Banque Mobile @else Mobile
                            Banking @endif</a></li>
                @endif
                <li><a href=""><i class="fa fa-exchange"></i>@if($emp->lang == 'fr') Transfert d'Argent @else Money
                        Transfer @endif</a></li>
            </ul>
        </li>
    </ul>
</li>

<li class="treeview {{ active(['rollback', 'loan_list', 'delinquency_report', 'prov_acc_report', 'provision_report',
'statistics_report']) }}">
    <a href=""><i class="fa fa-money"></i>
        <span>@lang('sidebar.loans')</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{active('rollback')}}"><a href="{{url('rollback')}}"><i
                    class="fa fa-refresh"></i> @lang('sidebar.rollback')</a></li>
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

@if($emp->level != 'B')
    <li class="treeview">
        <a href=""><i class="fa fa-book"></i>
            <span>UNITÉ DE DOCUMENTATION</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
        </a>
        <ul class="treeview-menu">
            <li><a href=""><i class="fa fa-archive"></i> Archives</a></li>
            <li><a href=""><i class="fa fa-search"></i>@if($emp->lang == 'fr') Recherche Documentaire @else
                        Document Research @endif</a></li>
        </ul>
    </li>
@endif

<li class="treeview">
    <a href=""><i class="fa fa-stack-overflow"></i>
        <span>BUSINESS INTELLIGENCE</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href=""><i class="fa fa-key"></i> PKI's</a></li>
        <li><a href=""><i class="fa fa-circle-o"></i>@if($emp->lang == 'fr') Normes Prudentielles @else Prudential
                Norms @endif</a></li>
        @if($emp->level != 'B')
            @if ($emp->level == 'I')
                <li><a href=""><i class="fa fa-users"></i>@if($emp->lang == 'fr') Ressources Humaines @else Human
                        Resources @endif</a></li>
                <li><a href=""><i class="fa fa-circle-o"></i> CRM</a></li>
            @endif
            @if ($emp->level != 'B')
                <li><a href=""><i class="fa fa-building"></i> Credit Bureau</a></li>
            @endif
            @if ($emp->level == 'I')
                <li><a href=""><i class="fa fa-bookmark"></i> Benchmarking</a></li>
            @endif
        @endif
    </ul>
</li>

@if($emp->level != 'Z')
    <li class="treeview {{ active(['acc_adj', 'share_mon_cal', 'share_mon_adj', 'int_dist', 'inc-exp_init']) }}">
        <a href=""><i class="fa fa-close"></i>
            <span>@if($emp->lang == 'fr') OPÉRATIONS DE FIN D'ANNÉE @else END OF YEAR OPERATIONS @endif</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="" data-toggle="modal" data-target="#prev_exo_init"><i
                        class="fa fa-product-hunt"></i>@if($emp->lang == 'fr') Initialisation Exercice
                    Précédent @else Previous Exercise Initialisation @endif</a></li>
            <li class="{{ active('acc_adj') }}"><a href="{{ url('acc_adj') }}"><i
                        class="fa fa-angle-double-left"></i>@if($emp->lang == 'fr') Adjustage Comptable @else
                        Accounting Adjustement @endif</a></li>

            <li class="{{ active('share_mon_cal') }}"><a href="{{ url('share_mon_cal') }}"><i
                        class="fa fa-calculator"></i>@if($emp->lang == 'fr') Calcul Parts Mensuelles @else
                        Share Month Calculation @endif</a></li>
            <li class="{{ active('share_mon_adj') }}"><a href="{{ url('share_mon_adj') }}"><i
                        class="fa fa-align-justify"></i>@if($emp->lang == 'fr') Adjustement Parts Mensuelles @else
                        Share Month Adjustment @endif</a></li>
            <li class="{{ active('int_dist') }}"><a href="{{ url('int_dist') }}"><i
                        class="fa fa-diamond"></i>@if($emp->lang == 'fr') Distribution des Intérêts @else
                        Interest Distribution @endif</a></li>
            <li class="{{ active('inc-exp_init') }}"><a href="{{ url('inc-exp_init') }}"><i
                        class="fa fa-expand"></i>@if($emp->lang == 'fr') Initialisation des Charges/Produits @else
                        Income/Expenses Initialisation @endif</a></li>
            <li><a href="" data-toggle="modal" data-target="#closure"><i
                        class="fa fa-close"></i>@if($emp->lang == 'fr') Clôture @else Closure @endif</a></li>
        </ul>
    </li>
@endif

@if($emp->level != 'B')
    <li class="treeview {{ active(['level_I', 'level_II']) }}">
        <a href=""><i class="fa fa-connectdevelop"></i>
            <span>CONSOLIDATIONS</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
        </a>
        <ul class="treeview-menu">
            @if($emp->level == 'I')
                <li class="{{ active('level_I') }}"><a href=""><i
                            class="fa fa-angle-double-left"></i>@if($emp->lang == 'fr') Niveau @else
                            Level @endif I</a></li>
            @endif
            @if ($emp->level == 'Z')
                <li class="{{ active('level_II') }}"><a href=""><i
                            class="fa fa-angle-double-left"></i>@if($emp->lang == 'fr') Niveau @else
                            Level @endif II</a></li>
            @endif
        </ul>
    </li>
@endif
