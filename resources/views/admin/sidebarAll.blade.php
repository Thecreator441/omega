<li class="treeview {{ active(['cash_from', 'replenish', 'cash_to', 'check_out', 'collect_report', 'journal', 'temp_journal',
'transaction', 'cash_open', 'cash_close', 'cash_situation', 'cash_reconciliation', 'cash_regularisation', 'member_file',
'gen_account', 'aux_account', 'acc_file', 'permanent', 'banking', 'acc_to_acc', 'special', 'check_register', 'check_sort',
'check_report', 'pay_deduct_init', 'pay_deduct_dist', 'pay_deduc_valid', 'share_savings_ins', 'loan_insurance', 'withdrawal_init',
'personalisation', 'block_unblock', 'withdrawal_report', 'acc_situation', 'mem_situation', 'acc_history', 'mem_history',
'indiv_bal_history', 'acc_class_bal_history', 'acc_day_open', 'acc_day_close', 'backup']) }}">
    <a href="">
        <i class="fa fa-opera"></i>
        <span>@if ($emp->lang == 'fr') OPÉRATIONS @else OPERATIONS @endif</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="treeview {{ active(['cash_from', 'replenish', 'cash_to', 'check_out', 'collect_report', 'journal',
        'temp_journal', 'transaction', 'cash_open', 'cash_close', 'cash_situation', 'cash_reconciliation', 'cash_regularisation']) }}">
            <a href="">
                <i class="fa fa-toggle-on"></i>
                <span>Front Office</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-right pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview">
                    <a href="">
                        <i class="fa fa-indent"></i>
                        <span>@if ($emp->lang == 'fr') Versement @else Cash In @endif</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-envira"></i> Entrance</a></li>
                        <li><a href=""><i class="fa fa-indent"></i> Cash In</a></li>
                        <li class="{{ active('cash_from') }}">
                            <a href="{{ url('cash_from') }}"><i class="fa fa-bank"></i>
                                @if ($emp->lang == 'fr') Versement de la Banque @else Cash from Bank @endif
                            </a>
                        </li>
                        <li class="{{ active('replenish') }}">
                            <a href="{{ url('replenish') }}"><i class="fa fa-refresh"></i>
                                @if ($emp->lang == 'fr') Réception des Fonds @else Replenishment @endif
                            </a>
                        </li>
                        <li><a href=""><i class="fa fa-check"></i> Check</a></li>
                        <li><a href=""><i class="fa fa-random"></i> Other Cash In</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="">
                        <i class="fa fa-outdent"></i>
                        <span>@if ($emp->lang == 'fr') Retrait @else Cash Out @endif</span>
                        <span class="pull-right-container">
                                    <i class="fa fa-angle-right pull-right"></i>
                                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-outdent"></i> Cash Out</a></li>
                        <li class="{{ active('cash_to') }}"><a href="{{ url('cash_to') }}"><i
                                    class="fa fa-bank"></i> Cash to Banks</a></li>
                        <li class="{{ active('check_out') }}"><a href="{{ url('check_out') }}"><i
                                    class="fa fa-check"></i> Check</a></li>
                        <li><a href=""><i class="fa fa-futbol-o"></i> Fund Emission</a></li>
                        <li><a href=""><i class="fa fa-random"></i> Other Cash Out</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="">
                        <i class="fa fa-columns"></i>
                        <span>@if ($emp->lang == 'fr') Collectes Journalières @else Daily Collections @endif</span>
                        <span class="pull-right-container">
                                    <i class="fa fa-angle-right pull-right"></i>
                                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-indent"></i> Cash In</a></li>
                        <li><a href=""><i class="fa fa-outdent"></i> Cash Out</a></li>
                        <li class="{{ active('collect_report') }}"><a href="{{ url('collect_report') }}"><i
                                    class="fa fa-registered"></i> @if ($emp->lang == 'fr') Rapport @else
                                    Report @endif</a></li>
                    </ul>
                </li>
                <li class="treeview {{ active(['journal', 'temp_journal', 'transaction']) }}">
                    <a href="">
                        <i class="fa fa-adn"></i>
                        <span>@if ($emp->lang == 'fr') Comptabilisation @else Accountings @endif</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('journal') }}"><a href="{{ url('journal') }}"><i
                                    class="fa fa-newspaper-o"></i> Journal</a></li>
                        <li class="{{ active('temp_journal') }}"><a
                                href="{{ url('temp_journal') }}"><i
                                    class="fa fa-newspaper-o"></i>@if ($emp->lang == 'fr') Brouillard
                                Comptable @else Temporal Journal @endif</a></li>
                        <li class="{{ active('transaction') }}"><a href="{{ url('transaction') }}"><i
                                    class="fa fa-book"></i>Transactions</a></li>
                    </ul>
                </li>

                <li class="{{ active('cash_open') }}"><a href="{{ url('cash_open') }}"><i
                            class="fa fa-plus"></i>@if ($emp->lang == 'fr') Ouverture Caisse @else Cash
                        Opening @endif</a></li>
                <li class="{{ active('cash_close') }}"><a href="{{ url('cash_close') }}"><i
                            class="fa fa-close"></i>@if ($emp->lang == 'fr') Fermeture Caisse @else Cash
                        Closing @endif</a></li>
                <li class="{{ active('cash_situation') }}"><a href="{{ url('cash_situation') }}"><i
                            class="ion ion-stats-bars"></i>@if ($emp->lang == 'fr') Situation Caisse @else
                            Cash Situation @endif</a></li>
                <li class="{{ active('cash_reconciliation') }}"><a
                        href="{{ url('cash_reconciliation') }}"><i
                            class="fa fa-signal"></i>@if ($emp->lang == 'fr') Rapprochement Caisse @else
                            Cash Reconciliation @endif</a></li>
                <li><a href=""><i class="fa fa-exchange"></i> Money Exchange</a></li>
                <li class="{{ active('cash_regularisation') }}"><a
                        href="{{ url('cash_regularisation') }}"><i
                            class="fa fa-renren"></i>@if ($emp->lang == 'fr') Régularisation Caisse @else
                            Cash Regularisation @endif</a></li>
            </ul>
        </li>
        <li class="treeview {{ active(['registration', 'member_file', 'gen_account', 'aux_account', 'acc_file', 'permanent', 'banking',
            'acc_to_acc', 'special', 'check_register', 'check_sort', 'check_report', 'pay_deduct_init', 'pay_deduct_dist',
            'pay_deduc_valid', 'share_savings_ins', 'loan_insurance', 'withdrawal_init', 'personalisation', 'block_unblock',
            'withdrawal_report', 'acc_situation', 'mem_situation', 'acc_history', 'mem_history', 'indiv_bal_history',
            'acc_class_bal_history']) }}">
            <a href=""><i class="fa fa-dashboard"></i>
                <span>Back Office</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview {{ active('registration', 'member_file') }}">
                    <a href=""><i class="fa fa-users"></i>
                        <span>@if($emp->lang == 'fr') Membres @else Members @endif</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('registration') }}"><a href="{{ url('registration') }}"><i
                                    class="fa fa-user-plus"></i>
                                @if($emp->lang == 'fr') Enregistrement @else Registration @endif</a></li>
                        <li class="{{ active('member_file') }}"><a href="{{ url('member_file') }}"><i
                                    class="fa fa-file"></i>@if($emp->lang == 'fr') Fichier @else File @endif
                            </a></li>
                    </ul>
                </li>
                <li class="treeview {{ active(['gen_account', 'aux_account', 'acc_file']) }}">
                    <a href=""><i class="fa fa-address-book"></i>
                        <span>@if($emp->lang == 'fr') Comptes @else Accounts @endif</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('gen_account') }}"><a
                                href="{{ url('gen_account') }}"><i
                                    class="fa fa-gear"></i>@if($emp->lang == 'fr') Général @else General @endif
                            </a></li>
                        <li class="{{ active('aux_account') }}"><a
                                href="{{ url('aux_account') }}"><i
                                    class="fa fa-home"></i>@if($emp->lang == 'fr') Auxiliaires @else
                                    Auxiliaries @endif</a></li>
                        <li class="{{ active('acc_file') }}"><a href="{{ url('acc_file') }}"><i
                                    class="fa fa-file"></i>@if($emp->lang == 'fr') Fichier @else File @endif
                            </a></li>
                    </ul>
                </li>
                <li class="treeview {{ active(['permanent', 'banking', 'acc_to_acc', 'special']) }}">
                    <a href=""><i class="fa fa-exchange"></i>
                        <span>@if($emp->lang == 'fr') Virements @else Transfers @endif</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('permanent') }}"><a href="{{ url('permanent') }}"><i
                                    class="fa fa-circle"></i> Permanent</a></li>
                        <li class="{{ active('banking') }}"><a href="{{ url('banking') }}"><i
                                    class="fa fa-bank"></i>@if($emp->lang == 'fr') Bancaire @else
                                    Banking @endif</a></li>
                        <li class="{{ active('acc_to_acc') }}"><a href="{{ url('acc_to_acc') }}"><i
                                    class="fa fa-address-book"></i>@if($emp->lang == 'fr') Compte à
                                Compte @else Account to Account @endif</a></li>
                        <li class="{{ active('special') }}"><a href="{{ url('special') }}"><i
                                    class="fa fa-star"></i>@if($emp->lang == 'fr') Spécial @else
                                    Special @endif</a></li>
                    </ul>
                </li>
                <li class="treeview {{ active(['check_register', 'check_sort', 'check_report']) }}">
                    <a href=""><i class="fa fa-check"></i>
                        <span>@if($emp->lang == 'fr') Traitement des Chèques @else Checks
                            Treatment @endif</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ active('check_register') }}"><a href="{{ url('check_register') }}"><i
                                    class="fa fa-check-circle"></i>@if($emp->lang == 'fr')
                                    Enregistrer @else Register @endif</a></li>
                        <li class="{{ active('check_sort') }}"><a href="{{ url('check_sort') }}"><i
                                    class="fa fa-sort"></i> @if($emp->lang == 'fr')
                                    Sort @else Sort @endif</a></li>
                        <li class="{{ active('check_report') }}"><a href="{{ url('check_report') }}"><i
                                    class="fa fa-registered"></i>@if($emp->lang == 'fr') Rapport @else
                                    Report @endif</a></li>
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
                        <span>@if($emp->lang == 'fr') Bon de Retrait @else Withdrawal Slip @endif</span>
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
        <li class="treeview">
            <a href=""><i class="fa fa-opera"></i>
                <span>@if($emp->lang == 'fr') Autres Opérations @else Other Operations @endif</span>
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
                        <li><a href=""><i class="fa fa-hourglass-start"></i> Initialisation</a></li>
                        <li><a href=""><i class="fa fa-contao"></i>@if($emp->lang == 'fr') Feuille de
                                Contrôle @else Control Sheet @endif</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href=""><i class="fa fa-home"></i>
                        <span>@if($emp->lang == 'fr') Gestion des Actifs @else Assets Management @endif</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-hourglass-start"></i> Initialisation</a></li>
                        <li><a href=""><i class="fa fa-circle-o"></i>@if($emp->lang == 'fr')
                                    Comptabilisation @else Accounting @endif</a></li>
                        <li><a href=""><i class="fa fa-contao"></i>@if($emp->lang == 'fr') Feuille de
                                Contrôle @else Control Sheet @endif</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href=""><i class="fa fa-stack-overflow"></i>
                        <span>@if($emp->lang == 'fr') Gestion des Stocks @else Stores Management @endif</span>
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
                        <li><a href=""><i class="fa fa-registered"></i> Report</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href=""><i class="fa fa-users"></i>
                        <span>@if($emp->lang == 'fr') Ressources Humaine @else Human Resources @endif</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href=""><i class="fa fa-user-plus"></i>
                                <span>Recruitment</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-right pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-picture-o"></i> Post Definition</a>
                                </li>
                                <li><a href=""><i class="fa fa-user-o"></i> Offer</a></li>
                                <li><a href=""><i class="fa fa-user-o"></i> Selection</a></li>
                                <li><a href=""><i class="fa fa-check"></i> Validation</a></li>
                            </ul>
                        </li>
                        <li><a href=""><i class="fa fa-user"></i> Employees</a></li>
                        <li><a href=""><i class="fa fa-window-maximize"></i> Permission/Absences</a>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-close"></i>
                                <span>Leaves</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-right pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-calendar"></i> Annual</a></li>
                                <li><a href=""><i class="fa fa-user-o"></i> Maternity</a></li>
                                <li><a href=""><i class="fa fa-gear"></i> Technical</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href=""><i class="fa fa-user-times"></i>Retirement/Termination/Death</a>
                        </li>
                        <li><a href=""><i class="fa fa-user-circle"></i> Sanctions</a></li>
                        <li><a href=""><i class="fa fa-money"></i> Payroll</a></li>
                        <li><a href=""><i class="fa fa-book"></i>@if($emp->lang == 'fr') Rapport @else
                                    Report @endif</a></li>
                    </ul>
                </li>
                <li><a href=""><i class="fa fa-mobile"></i>@if($emp->lang == 'fr') Banque Mobile @else Mobile
                        Banking @endif</a></li>
                <li><a href=""><i class="fa fa-exchange"></i>@if($emp->lang == 'fr') Transfert d'Argent @else Money
                        Transfer @endif</a></li>
            </ul>
        </li>
    </ul>
</li>

<li class="treeview">
    <a href=""><i class="fa fa-money"></i>
        <span>@if($emp->lang == 'fr') PRÊT @else LOANS @endif</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href=""><i class="ion ion-load-c"></i> Simulation</a></li>
        <li><a href=""><i class="fa fa-book"></i> Application</a></li>
        <li><a href=""><i class="fa fa-check"></i> Approval</a></li>
        <li><a href=""><i class="ion ion-ios-undo"></i> Rollback</a></li>
        <li class="treeview">
            <a href=""><i class="fa fa-refresh"></i>
                <span>Refinancing</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href=""><i class="fa fa-money"></i> Amount</a></li>
                <li><a href=""><i class="ion ion-help"></i> Savings Withdrawal Facility</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href=""><i class="fa fa-rebel"></i>
                <span>Restructuring</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href=""><i class="fa fa-money"></i> Amount</a></li>
                <li><a href=""><i class="fa fa-dollar"></i> Interest Rate</a></li>
                <li><a href=""><i class="fa fa-calendar-plus-o"></i> Installment</a></li>
                <li><a href=""><i class="fa fa-calendar-times-o"></i> Grace Period</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href=""><i class="fa fa-registered"></i>
                <span>@if($emp->lang == 'fr') Rapport @else Report @endif</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href=""><i class="fa fa-list"></i>@if($emp->lang == 'fr') Liste @else List @endif</a></li>
                <li><a href=""><i class="fa fa-list"></i>@if($emp->lang == 'fr') Délinquance @else
                            Delinquency @endif</a></li>
                <li class="treeview">
                    <a href=""><i class="fa fa-product-hunt"></i>
                        <span>Provision</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href=""><i class="fa fa-star"></i>@if($emp->lang == 'fr') Comptabilistion @else
                                    Accounting @endif</a></li>
                        <li><a href=""><i class="fa fa-registered"></i>@if($emp->lang == 'fr') Rapport @else
                                    Report @endif</a></li>
                    </ul>
                </li>
                <li><a href=""><i class="fa fa-star"></i>@if($emp->lang == 'fr') Statistiques @else
                            Statistics @endif</a></li>
            </ul>
        </li>
    </ul>
</li>

<li class="treeview">
    <a href=""><i class="fa fa-fa"></i>
        <span>@if($emp->lang == 'fr') ÉTATS FINANCIERS @else FINANCIAL STATEMENTS @endif</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href=""><i class="fa fa-balance-scale"></i> Trial Balance</a></li>
        <li><a href=""><i class="fa fa-balance-scale"></i> Balance Sheet</a></li>
        <li><a href=""><i class="fa fa-expand"></i> Income/Expenses</a></li>
        <li class="treeview">
            <a href=""><i class="fa fa-calendar"></i>
                <span>Account Schedule</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href=""><i class="fa fa-balance-scale"></i> Balance Sheet</a></li>
                <li><a href=""><i class="fa fa-expand"></i> Income/Expenses</a></li>
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
        <li><a href=""><i class="fa fa-sort"></i> Normalisation</a></li>
        <li><a href=""><i class="fa fa-hourglass-start"></i> Initialisation</a></li>
        <li><a href=""><i class="fa fa-archive"></i> Archives</a></li>
        <li><a href=""><i class="fa fa-search"></i>@if($emp->lang == 'fr') Recherche Documentaire @else Document Research @endif</a></li>
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
        <li><a href=""><i class="fa fa-circle-o"></i>@if($emp->lang == 'fr') Normes Prudentielles @else Prudential
                Norms @endif</a></li>
        <li><a href=""><i class="fa fa-users"></i>@if($emp->lang == 'fr') Ressources Humaines @else Human
                Resources @endif</a></li>
        <li><a href=""><i class="fa fa-circle-o"></i> CRM</a></li>
        <li><a href=""><i class="fa fa-building"></i> Credit Bureau</a></li>
        <li><a href=""><i class="fa fa-bookmark"></i> Benchmarking</a></li>
    </ul>
</li>

<li><a href=""><i class="fa fa-audio-description"></i> <span>INTERNAL AUDIT</span></a></li>

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

<li class="treeview">
    <a href=""><i class="fa fa-connectdevelop"></i>
        <span>CONSOLIDATIONS</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ active('level_I') }}"><a href=""><i
                    class="fa fa-angle-double-left"></i>@if($emp->lang == 'fr') Niveau @else
                    Level @endif I</a></li>
        <li class="{{ active('level_II') }}"><a href=""><i
                    class="fa fa-angle-double-left"></i>@if($emp->lang == 'fr') Niveau @else
                    Level @endif II</a></li>
        <li><a href=""><i class="fa fa-y-combinator"></i> Combination</a></li>
    </ul>
</li>

<li class="treeview {{ active(['admin/currency', 'admin/billeting', 'admin/country', 'admin/region', 'admin/division', 'admin/subdivision',
'admin/network', 'admin/zone', 'admin/institution', 'admin/branch', 'admin/operation', 'admin/acctype', 'admin/loantype', 'admin/loanpur', 'admin/privilege']) }}">
    <a href=""><i class="ion ion-settings"></i>
        <span>@if($emp->lang == 'fr') RÉGLAGES @else SETTINGS @endif</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="treeview {{ active(['admin/currency', 'admin/billeting', 'admin/country', 'admin/region', 'admin/division',
        'admin/subdivision', 'admin/network', 'admin/zone', 'admin/institution', 'admin/privilege']) }}">
            <a href="">
                <i class="fa fa-gears"></i>
                <span>@if($emp->lang == 'fr') Général @else General @endif</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ active('admin/currency') }}"><a href="{{ url('admin/currency') }}"><i
                            class="fa fa-money"></i>@if($emp->lang == 'fr') Dévise @else Currency @endif</a>
                </li>
                <li class="{{ active('admin/billeting') }}"><a href="{{ url('admin/billeting') }}"><i
                            class="fa fa-money"></i>@if($emp->lang == 'fr') Billetage @else Billeting @endif</a>
                </li>
                <li class="{{ active('admin/country') }}"><a href="{{ url('admin/country') }}"><i
                            class="fa fa-flag"></i>@if($emp->lang == 'fr') Pays @else Country @endif</a></li>
                <li class="{{ active('admin/region') }}"><a href="{{ url('admin/region') }}"><i
                            class="fa fa-gear"></i>@if($emp->lang == 'fr') Région @else Region @endif</a></li>
                <li class="{{ active('admin/division') }}"><a href="{{ url('admin/division') }}"><i
                            class="fa fa-gear"></i>@if($emp->lang == 'fr') Département @else Division @endif
                    </a></li>
                <li class="{{ active('admin/subdivision') }}"><a href="{{ url('admin/subdivision') }}"><i
                            class="fa fa-gear"></i>@if($emp->lang == 'fr') Arrondissement @else Sub
                        Division @endif</a></li>
                <li class="{{ active('admin/network') }}"><a href="{{ url('admin/network') }}"><i
                            class="fa fa-gear"></i>@if($emp->lang == 'fr') Réseau @else Network @endif</a></li>
                <li class="{{ active('admin/zone') }}"><a href="{{ url('admin/zone') }}"><i class="fa fa-gear"></i>Zone</a>
                </li>
                <li class="{{ active('admin/institution') }}"><a href="{{ url('admin/institution') }}"><i
                            class="fa fa-gear"></i>Institution</a></li>
                <li class="{{ active('admin/privilege') }}"><a href="{{ url('admin/privilege') }}"><i
                            class="fa fa-gear"></i>@if($emp->lang == 'fr') Privilège @else Privilege @endif</a>
                </li>
            </ul>
        </li>
        <li class="treeview {{ active(['admin/branch', 'admin/operation', 'admin/acctype', 'admin/loantype', 'admin/loanpur']) }}">
            <a href="">
                <i class="fa fa-gear"></i>
                <span>@if($emp->lang == 'fr') Spécifique @else Specific @endif</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-right pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ active('admin/branch') }}"><a href="{{ url('admin/branch') }}"><i
                            class="fa fa-home"></i>@if($emp->lang == 'fr')
                            Agences @else Branch @endif</a></li>
                {{--                <li class="{{ active('admin/operation') }}"><a href="{{ url('admin/operation') }}"><i--}}
                {{--                            class="fa fa-opera"></i>@if($employee->lang == 'fr')--}}
                {{--                            Opération @else Operation @endif</a></li>--}}
                <li class="{{ active('admin/acctype') }}"><a href="{{ url('admin/acctype') }}"><i
                            class="fa fa-address-card"></i>@if($emp->lang == 'fr') Type Compte @else
                            AccountType @endif</a></li>
                <li class="{{ active('admin/loantype') }}"><a href="{{ url('admin/loantype') }}"><i
                            class="fa fa-money"></i>@if($emp->lang == 'fr') Type
                        Prêt @else Loan Type @endif</a></li>
                <li class="{{ active('admin/loanpur') }}"><a href="{{ url('admin/loanpur') }}"><i
                            class="fa fa-money"></i>@if($emp->lang == 'fr') Bût Prêt @else Loan Purpose @endif</a>
                </li>
            </ul>
        </li>
    </ul>
</li>
