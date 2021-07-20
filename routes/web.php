<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Middleware\VerifySessionPrivilege;
use App\Models\Account;
use App\Models\AccPlan;
use App\Models\AccPlanCommis;
use App\Models\AccType;
use App\Models\MemBalance;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Cash;
use App\Models\Cash_Diff;
use App\Models\Check;
use App\Models\CheckAccAmt;
use App\Models\Collect_Bal;
use App\Models\Collect_Mem;
use App\Models\Collect_Mem_Benef;
use App\Models\Collector;
use App\Models\Collector_Com;
use App\Models\Comaker;
use App\Models\Commis_Pay;
use App\Models\Country;
use App\Models\Currency;
use App\Models\DemComaker;
use App\Models\DemLoan;
use App\Models\Device;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Installment;
use App\Models\Institution;
use App\Models\Loan;
use App\Models\LoanPur;
use App\Models\LoanType;
use App\Models\Member;
use App\Models\Menu_Level_I;
use App\Models\Menu_Level_II;
use App\Models\Menu_Level_III;
use App\Models\Menu_Level_IV;
use App\Models\Money;
use App\Models\Mortgage;
use App\Models\Network;
use App\Models\Operation;
use App\Models\Privilege;
use App\Models\Priv_Menu;
use App\Models\Profession;
use App\Models\RegBenef;
use App\Models\Region;
use App\Models\Register;
use App\Models\SubDiv;
use App\Models\Town;
use App\Models\User;
use App\Models\ValWriting;
use App\Models\Writing;
use App\Models\Zone;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


Route::get('/', 'Omega\LoginController@index')->name('/');
Route::post('login', 'Omega\LoginController@login')->name('login');
Route::get('to_home', 'Omega\LoginController@toHome')->name('to_home');
Route::get('lang/{lang}', 'Omega\LoginController@changeLanguage')->name('lang/{lang}');
Route::get('edit_logout', 'Omega\LoginController@editLogout')->name('edit_logout');
Route::post('logout', 'Omega\LoginController@logout')->name('logout');
Route::get('change_logout', 'Omega\LoginController@changeLogout')->name('change_logout');


/***************************************************************
 ***************************************************************
 ********************** OMEGA DASHBOARD ************************
 ***************************************************************
 ***************************************************************/

Route::middleware([VerifySessionPrivilege::class])->group(function () {
    /***************************
     ********** HOME **********
    ***************************/

    Route::get('omega', 'Omega\OmegaController@index')->name('omega');

    /***************************
     ********** FILES **********
    ***************************/

    //     Registered File
    Route::get('registered_file', static function () {
        $registers = Register::getRegistersFile();
        return view('omega.pages.registered_file', [
            'registers' => $registers
        ]);
    });

    //     Member File
    Route::get('member_file', static function () {
        $members = Member::getMembersFile();
        return view('omega.pages.member_file', [
            'members' => $members
        ]);
    });

    //     Account File
    Route::get('account_file', static function () {
        $accounts = Account::getAccountsFile();
        return view('omega.pages.account_file', [
            'accounts' => $accounts
        ]);
    });


    /****************************
     ******** OPERATIONS ********
    ****************************/

    //     Registration
    Route::prefix('registration')->group(static function () {
        Route::get('/', 'Omega\RegistrationController@index')->name('registration');
        Route::post('store', 'Omega\RegistrationController@store')->name('registration/store');
    });

    //    Membership
    Route::prefix('membership')->group(static function () {
        Route::get('/', 'Omega\MembershipController@index')->name('membership');
        Route::post('store', 'Omega\MembershipController@store')->name('membership/store');
    });

    //    Cash Open, Close Initialisation and Closing
    Route::prefix('cash_open')->group(static function () {
        Route::get('/', 'Omega\CashOpenController@index')->name('cash_open');
        Route::post('store', 'Omega\CashOpenController@store')->name('cash_open/store');
    });
    Route::prefix('cash_close_init')->group(static function () {
        Route::get('/', 'Omega\CashCloseInitController@index')->name('cash_close_init');
        Route::post('store', 'Omega\CashCloseInitController@store')->name('cash_close_init/store');
    });
    Route::prefix('cash_close')->group(static function () {
        Route::get('/', 'Omega\CashCloseController@index')->name('cash_close');
        Route::post('store', 'Omega\CashCloseController@store')->name('cash_close/store');
    });

    //    Cash In and Out
    Route::prefix('cash_in')->group(static function () {
        Route::get('/', 'Omega\CashInController@index')->name('cash_in');
        Route::post('store', 'Omega\CashInController@store')->name('cash_in/store');
    });
    Route::prefix('cash_out')->group(static function () {
        Route::get('/', 'Omega\CashOutController@index')->name('cash_out');
        Route::post('store', 'Omega\CashOutController@store')->name('cash_out/store');
    });

    //     Cash To and From Bank
    Route::prefix('cash_to')->group(static function () {
        Route::get('/', 'Omega\CashToController@index')->name('cash_to');
        Route::post('store', 'Omega\CashToController@store')->name('cash_to/store');
    });
    Route::prefix('cash_from')->group(static function () {
        Route::get('/', 'Omega\CashFromController@index')->name('cash_from');
        Route::post('store', 'Omega\CashFromController@store')->name('cash_from/store');
    });

    //    Other Cash In and Out
    Route::prefix('other_cash_in')->group(static function () {
        Route::get('/', 'Omega\OtherCashInController@index')->name('other_cash_in');
        Route::post('store', 'Omega\OtherCashInController@store')->name('other_cash_in/store');
    });
    Route::prefix('other_cash_out')->group(static function () {
        Route::get('/', 'Omega\OtherCashOutController@index')->name('other_cash_out');
        Route::post('store', 'Omega\OtherCashOutController@store')->name('other_cash_out/store');
    });

    //    Check In and Out
    Route::prefix('check_in')->group(static function () {
        Route::get('/', 'Omega\CheckInController@index')->name('check_in');
        Route::post('store', 'Omega\CheckInController@store')->name('check_in/store');
    });
    Route::prefix('check_out')->group(static function () {
        Route::get('/', 'Omega\CheckOutController@index')->name('check_out');
        Route::post('store', 'Omega\CheckOutController@store')->name('check_out/store');
    });

    //    Other Check In and Out
    Route::prefix('other_check_in')->group(static function () {
        Route::get('/', 'Omega\OtherCheckInController@index')->name('other_check_in');
        Route::post('store', 'Omega\OtherCheckInController@store')->name('other_check_in/store');
    });
    Route::prefix('other_check_out')->group(static function () {
        Route::get('/', 'Omega\OtherCheckOutController@index')->name('other_check_out');
        Route::post('store', 'Omega\OtherCheckOutController@store')->name('other_check_out/store');
    });

    //     Funds Replenishment, Funds Reception
    Route::prefix('replenish')->group(static function () {
        Route::get('/', 'Omega\ReplenishController@index')->name('replenish');
        Route::post('store', 'Omega\ReplenishController@store')->name('replenish/store');
    });
    Route::prefix('reception')->group(static function () {
        Route::get('/', 'Omega\ReceptionController@index')->name('reception');
        Route::post('store', 'Omega\ReceptionController@store')->name('reception/store');
    });

    //    Cash Situation, Reconciliation and Regularisation
    Route::prefix('cash_situation')->group(static function () {
        Route::get('/', 'Omega\CashSituationController@index')->name('cash_situation');
        Route::post('store', 'Omega\CashSituationController@store')->name('cash_situation/store');
    });
    Route::prefix('cash_reconciliation')->group(static function () {
        Route::get('/', 'Omega\CashReconciliationController@index')->name('cash_reconciliation');
        Route::post('store', 'Omega\CashReconciliationController@store')->name('cash_reconciliation/store');
    });
    Route::prefix('cash_regularisation')->group(static function () {
        Route::get('/', 'Omega\CashRegularisationController@index')->name('cash_regularisation');
        Route::post('store', 'Omega\CashRegularisationController@store')->name('cash_regularisation/store');
    });

    //    Money Exchange
    Route::prefix('money_exchange')->group(static function () {
        Route::get('/', 'Omega\MoneyExchangeController@index')->name('money_exchange');
        Route::post('store', 'Omega\MoneyExchangeController@store')->name('money_exchange/store');
    });

    //    General, Auxiliary Account and Account FIle
    Route::prefix('gen_account')->group(static function () {
        Route::get('/', 'Omega\GenAccountController@index')->name('gen_account');
        Route::post('store', 'Omega\GenAccountController@store')->name('gen_store');
    });
    Route::prefix('aux_account')->group(static function () {
        Route::get('/', 'Omega\AuxAccountController@index')->name('aux_account');
        Route::post('store', 'Omega\AuxAccountController@store')->name('aux_store');
    });
    Route::prefix('acc_file')->group(static function () {
        Route::get('/', 'Omega\AccFileController@index')->name('acc_file');
        Route::post('store', 'Omega\AccFileController@store')->name('acc_file/store');
    });

    //    Permanent, Banking, Account to Account and Special Transfer
    Route::prefix('permanent')->group(static function () {
        Route::get('/', 'Omega\PermanentController@index')->name('permanent');
        Route::post('store', 'Omega\PermanentController@store')->name('permanent/store');
    });
    Route::prefix('banking')->group(static function () {
        Route::get('/', 'Omega\BankingController@index')->name('banking');
        Route::post('store', 'Omega\BankingController@store')->name('banking/store');
    });
    Route::prefix('acc_to_acc')->group(static function () {
        Route::get('/', 'Omega\AccToAccController@index')->name('acc_to_acc');
        Route::post('store', 'Omega\AccToAccController@store')->name('acc_to_acc/store');
    });
    Route::prefix('special')->group(static function () {
        Route::get('/', 'Omega\SpecialController@index')->name('special');
        Route::post('store', 'Omega\SpecialController@store')->name('special/store');
    });

    //    Withdrawal Slip Initialisation, Personalisation, Block/Unblock and Report
    Route::prefix('withdrawal_init')->group(static function () {
        Route::get('/', 'Omega\WithdrawalInitController@index')->name('withdrawal_init');
        Route::post('store', 'Omega\WithdrawalInitController@store')->name('withdrawal_init/store');
    });
    Route::prefix('personalisation')->group(static function () {
        Route::get('/', 'Omega\PersonalisationController@index')->name('personalisation');
        Route::post('store', 'Omega\PersonalisationController@store')->name('personalisation/store');
    });
    Route::prefix('block_unblock')->group(static function () {
        Route::get('/', 'Omega\BlockUnblockController@index')->name('block_unblock');
        Route::post('store', 'Omega\BlockUnblockController@store')->name('block_unblock/store');
    });
    Route::prefix('withdrawal_report')->group(static function () {
        Route::get('/', 'Omega\WithdrawalReportController@index')->name('withdrawal_report');
        Route::post('store', 'Omega\WithdrawalReportController@store')->name('withdrawal_report/store');
    });

    //    Account Situation and Member Situation
    Route::prefix('acc_situation')->group(static function () {
        Route::get('/', 'Omega\AccSituationController@index')->name('acc_situation');
        Route::post('store', 'Omega\AccSituationController@store')->name('acc_situation/store');
    });
    Route::prefix('mem_situation')->group(static function () {
        Route::get('/', 'Omega\MemSituationController@index')->name('mem_situation');
        Route::post('store', 'Omega\MemSituationController@store')->name('mem_situation/store');
    });

    //    Account History, Member History, Individual Balance History and Account Class Balance History
    Route::prefix('acc_history')->group(static function () {
        Route::get('/', 'Omega\AccHistoryController@index')->name('acc_history');
        Route::post('store', 'Omega\AccHistoryController@store')->name('acc_history/store');
    });
    Route::prefix('mem_history')->group(static function () {
        Route::get('/', 'Omega\MemHistoryController@index')->name('mem_history');
        Route::post('store', 'Omega\MemHistoryController@store')->name('mem_history/store');
    });
    Route::prefix('indiv_bal_history')->group(static function () {
        Route::get('/', 'Omega\IndivBalanceHistoryController@index')->name('indiv_bal_history');
        Route::post('store', 'Omega\IndivBalanceHistoryController@store')->name('indiv_bal_history/store');
    });
    Route::prefix('acc_class_bal_history')->group(static function () {
        Route::get('/', 'Omega\AccClassBalHistoryController@index')->name('acc_class_bal_history');
        Route::post('store', 'Omega\AccClassBalHistoryController@store')->name('acc_class_bal_history/store');
    });

    //    Accounting Day Opening, Closing, Adjustment and Backup
    Route::prefix('acc_day_open')->group(static function () {
        Route::get('/', 'Omega\AccDayOpenController@index')->name('acc_day_open');
        Route::post('store', 'Omega\AccDayOpenController@store')->name('acc_day_open/store');
    });
    Route::prefix('acc_day_close')->group(static function () {
        Route::get('/', 'Omega\AccDayCloseController@index')->name('acc_day_close');
        Route::post('store', 'Omega\AccDayCloseController@store')->name('acc_day_close/store');
    });
    Route::prefix('acc_day_adj')->group(static function () {
        Route::get('/', 'Omega\AccDayAdjustController@index')->name('acc_day_adj');
        Route::post('store', 'Omega\AccDayAdjustController@store')->name('acc_day_adj/store');
    });
    Route::prefix('backup')->group(static function () {
        Route::get('/', 'Omega\BackupController@index')->name('backup');
        Route::post('store', 'Omega\BackupController@store')->name('backup/store');
    });

    //    Temporal Journal, Journal and Transactions
    Route::prefix('temp_journal')->group(static function () {
        Route::get('/', 'Omega\TempJournalController@index')->name('temp_journal');
    });
    Route::prefix('journal')->group(static function () {
        Route::get('/', 'Omega\JournalController@index')->name('journal');
    });
    Route::prefix('transaction')->group(static function () {
        Route::get('/', 'Omega\TransactionController@index')->name('transaction');
    });

    //    Commission Sharing
    Route::prefix('com_sharing')->group(static function () {
        Route::get('/', 'Omega\ComSharingController@index')->name('com_sharing');
        Route::post('store', 'Omega\ComSharingController@store')->name('com_sharing/store');
    });

    //    Share Savings and Loans Insurance
    Route::prefix('share_savings_ins')->group(static function () {
        Route::get('/', 'Omega\ShareSavingsInsController@index')->name('share_savings_ins');
        Route::post('store', 'Omega\ShareSavingsInsController@store')->name('share_savings_ins/store');
    });
    Route::prefix('loan_insurance')->group(static function () {
        Route::get('/', 'Omega\LoanInsuranceController@index')->name('loan_insurance');
        Route::post('store', 'Omega\LoanInsuranceController@store')->name('loan_insurance/store');
    });

    //    Check Register, Sort and Report
    Route::prefix('check_register')->group(static function () {
        Route::get('/', 'Omega\CheckRegisterController@index')->name('check_register');
        Route::post('store', 'Omega\CheckRegisterController@store')->name('check_register/store');
    });
    Route::prefix('check_sort')->group(static function () {
        Route::get('/', 'Omega\CheckSortController@index')->name('check_sort');
        Route::post('store', 'Omega\CheckSortController@store')->name('check_sort/store');
    });
    Route::prefix('other_check_sort')->group(static function () {
        Route::get('/', 'Omega\OtherCheckSortController@index')->name('other_check_sort');
        Route::post('store', 'Omega\OtherCheckSortController@store')->name('other_check_sort/store');
    });
    Route::prefix('check_report')->group(static function () {
        Route::get('/', 'Omega\CheckReportController@index')->name('check_report');
        Route::post('store', 'Omega\CheckReportController@store')->name('check_report/store');
    });

    //    Payroll Deduction Initialisation , Distribution and Validation
    Route::prefix('pay_deduct_init')->group(static function () {
        Route::get('/', 'Omega\PayDeductInitController@index')->name('pay_deduct_init');
        Route::post('store', 'Omega\PayDeductInitController@store')->name('pay_deduct_init/store');
    });
    Route::prefix('pay_deduct_dist')->group(static function () {
        Route::get('/', 'Omega\PayDeductDistController@index')->name('pay_deduct_dist');
        Route::post('store', 'Omega\PayDeductDistController@store')->name('pay_deduct_dist/store');
    });
    Route::prefix('pay_deduct_valid')->group(static function () {
        Route::get('/', 'Omega\PayDeductValidController@index')->name('pay_deduct_valid');
        Route::post('store', 'Omega\PayDeductValidController@store')->name('pay_deduct_valid/store');
    });

    //      Budget Initialisation and Control Sheet
    Route::prefix('budget_init')->group(static function () {
        Route::get('/', 'Omega\BudgetInitController@index')->name('budget_init');
        Route::post('store', 'Omega\BudgetInitController@store')->name('budget_init/store');
    });
    Route::prefix('budget_con_sheet')->group(static function () {
        Route::get('/', 'Omega\BudgetConSheetController@index')->name('budget_con_sheet');
        Route::post('store', 'Omega\BudgetConSheetController@store')->name('budget_con_sheet/store');
    });

    //      Assets Initialisation, Accounting and Control Sheet
    Route::prefix('assets_init')->group(static function () {
        Route::get('/', 'Omega\AssetsInitController@index')->name('assets_init');
        Route::post('store', 'Omega\AssetsInitController@store')->name('assets_init/store');
    });
    Route::prefix('assets_acc')->group(static function () {
        Route::get('/', 'Omega\AssetsAccController@index')->name('assets_acc');
        Route::post('store', 'Omega\AssetsAccController@store')->name('assets_acc/store');
    });
    Route::prefix('assets_con_sheet')->group(static function () {
        Route::get('/', 'Omega\AssetsConSheetController@index')->name('assets_con_sheet');
        Route::post('store', 'Omega\AssetsConSheetController@store')->name('assets_con_sheet/store');
    });


    /****************************************
     *************** LOANS ******************
    ****************************************/

    //    Loan Simulation
    Route::prefix('loan_simulation')->group(static function () {
        Route::get('/', 'Omega\LoanSimulationController@index')->name('loan_simulation');
        // Route::get('view', 'Omega\LoanSimulationController@view');
        Route::get('print', 'Omega\LoanSimulationController@print')->name('loan_simulation/print');
    });

    //    Loan Application
    Route::prefix('loan_application')->group(static function () {
        Route::get('/', 'Omega\LoanApplicationController@index')->name('loan_application');
        Route::post('store', 'Omega\LoanApplicationController@store')->name('loan_application/store');
    });

    //    Loan Approval
    Route::prefix('loan_approval')->group(static function () {
        Route::get('/', 'Omega\LoanApprovalController@index')->name('loan_approval');
        Route::post('store', 'Omega\LoanApprovalController@store')->name('loan_approval/store');
    });

    //    Loan Rollback
    Route::prefix('rollback')->group(static function () {
        Route::get('/', 'Omega\RollbackController@index')->name('loan_rollback');
        Route::post('store', 'Omega\RollbackController@store')->name('loan_rollback/store');
    });

    //    Loan Reject
    Route::prefix('loan_reject')->group(static function () {
        Route::get('/', 'Omega\LoanRejectController@index')->name('loan_reject');
        Route::post('store', 'Omega\LoanRejectController@store')->name('loan_reject/store');
    });

    //    Refinancing
    Route::prefix('refinancing')->group(static function () {
        Route::get('/', 'Omega\RefinancingController@index')->name('refinancing');
        Route::post('store', 'Omega\RefinancingController@store')->name('refinancing/store');
    });

    //    Restructuring
    Route::prefix('restructuring')->group(static function () {
        Route::get('/', 'Omega\RestructuringController@index')->name('restructuring');
        Route::post('store', 'Omega\RestructuringController@store')->name('restructuring/store');
    });

    //    Loan List
    Route::prefix('loan_list')->group(static function () {
        Route::get('/', 'Omega\LoanListController@index')->name('loan_list');
        Route::post('store', 'Omega\LoanListController@store')->name('loan_list/store');
    });

    //    Loan History
    Route::prefix('loan_history')->group(static function () {
        Route::get('/', 'Omega\LoanHistoryController@index')->name('loan_history');
        Route::post('store', 'Omega\LoanHistoryController@store')->name('loan_history/store');
    });

    //  Delinquency Report
    Route::prefix('delinquency_report')->group(static function () {
        Route::get('/', 'Omega\DelinquencyReportController@index')->name('delinquency_report');
        Route::post('store', 'Omega\DelinquencyReportController@store')->name('delinquency_report/store');
    });

    //    Provision Accounting Report
    Route::prefix('prov_acc_report')->group(static function () {
        Route::get('/', 'Omega\ProvAccReportController@index')->name('prov_acc_report');
        Route::post('store', 'Omega\ProvAccReportController@store')->name('prov_acc_report/store');
    });

    //    Provision Report
    Route::prefix('provision_report')->group(static function () {
        Route::get('/', 'Omega\ProvisionReportController@index')->name('provision_report');
        Route::post('store', 'Omega\ProvisionReportController@store')->name('provision_report/store');
    });

    //    Statistics Report
    Route::prefix('statistics_report')->group(static function () {
        Route::get('/', 'Omega\StatisticsReportController@index')->name('statistics_report');
        Route::post('store', 'Omega\StatisticsReportController@store')->name('statistics_report/store');
    });


    /****************************************
     ********* FINANCIAL STATEMENTS *********
    ****************************************/

    //    Trial Balance
    Route::prefix('trial_balance')->group(static function () {
        Route::get('/', 'Omega\TrialBalanceController@index')->name('trial_balance');
        Route::post('store', 'Omega\TrialBalanceController@store')->name('trial_balance/store');
    });

    //    Balance Sheet
    Route::prefix('balance_sheet')->group(static function () {
        Route::get('/', 'Omega\BalanceSheetController@index')->name('balance_sheet');
        Route::post('store', 'Omega\BalanceSheetController@store')->name('balance_sheet/store');
    });

    //    Income/Expenses
    Route::prefix('inc_exp')->group(static function () {
        Route::get('/', 'Omega\IncExpController@index')->name('inc_exp');
        Route::post('store', 'Omega\IncExpController@store')->name('inc_exp/store');
    });

    //    Account Schedule Balance Sheet and Income/Expenses
    Route::prefix('acc_bal_sheet')->group(static function () {
        Route::get('/', 'Omega\AccBalSheetController@index')->name('acc_bal_sheet');
        Route::post('store', 'Omega\AccBalSheetController@store')->name('acc_bal_sheet/store');
    });
    Route::prefix('acc_inc_exp')->group(static function () {
        Route::get('/', 'Omega\AccIncExpController@index')->name('acc_inc_exp');
        Route::post('store', 'Omega\AccIncExpController@store')->name('acc_inc_exp/store');
    });


    /****************************************
     *************** REPORTS ****************
    ****************************************/

    //    Employee, Collector and Customer Lists
    Route::prefix('employee_list')->group(static function () {
        Route::get('/', 'Omega\EmployeeListController@index')->name('employee_list');
    });
    Route::prefix('collect_list')->group(static function () {
        Route::get('/', 'Omega\CollectListController@index')->name('collect_list');
    });
    Route::prefix('client_list')->group(static function () {
        Route::get('/', 'Omega\ClientListController@index')->name('client_list');
    });

    //    Collector and Client Situation
    Route::prefix('collect_sit')->group(static function () {
        Route::get('/', 'Omega\CollectSitController@index')->name('collect_sit');
    });
    Route::prefix('client_sit')->group(static function () {
        Route::get('/', 'Omega\ClientSitController@index')->name('client_sit');
    });

    //    Collector and Client Account
    Route::prefix('collect_acc')->group(static function () {
        Route::get('/', 'Omega\CollectAccController@index')->name('collect_acc');
    });
    Route::prefix('client_acc')->group(static function () {
        Route::get('/', 'Omega\ClientAccController@index')->name('client_acc');
    });

    //    Collect, Commission and Shared Commission Report
    Route::prefix('collect_report')->group(static function () {
        Route::get('/', 'Omega\CollectReportController@index')->name('collect_report');
    });
    Route::prefix('commis_report')->group(static function () {
        Route::get('/', 'Omega\CommisReportController@index')->name('commis_report');
    });
    Route::prefix('shared_commis_report')->group(static function () {
        Route::get('/', 'Omega\SharedCommisReportController@index')->name('shared_commis_report');
    });


    /****************************************
     ******** BUSINESS INTELLIGENCE *********
    ****************************************/




    /****************************************
     ******** END OF YEAR OPERATIONS ********
    ****************************************/

    //    Accounting Adjustment
    Route::prefix('acc_adj')->group(static function () {
        Route::get('/', 'Omega\AccAdjustmentController@index')->name('acc_adj');
        Route::post('store', 'Omega\AccAdjustmentController@store')->name('acc_adj/store');
    });

    //    Share Months Calculation and Adjustment
    Route::prefix('share_mon_cal')->group(static function () {
        Route::get('/', 'Omega\ShareMonthCalController@index')->name('share_mon_cal');
        Route::post('store', 'Omega\ShareMonthCalController@store')->name('share_mon_cal/store');
    });
    Route::prefix('share_mon_adj')->group(static function () {
        Route::get('/', 'Omega\ShareMonthAdjController@index')->name('share_mon_adj');
        Route::post('store', 'Omega\ShareMonthAdjController@store')->name('share_mon_adj/store');
    });

    //    Interest Distribution
    Route::prefix('int_dist')->group(static function () {
        Route::get('/', 'Omega\InterestDistController@index')->name('int_dist');
        Route::post('store', 'Omega\InterestDistController@store')->name('int_dist/store');
    });

    //    Income/Expenses Initialisation
    Route::prefix('inc-exp_init')->group(static function () {
        Route::get('/', 'Omega\IncExpInitController@index')->name('inc-exp_init');
        Route::post('store', 'Omega\IncExpInitController@store')->name('inc-exp_init/store');
    });


    /****************************************
     ********** PREVIOUS EXERCISE ***********
    ****************************************/

    //    Previous Account and Member Situation
    Route::prefix('prev_acc_situation')->group(static function () {
        Route::get('/', 'Omega\PrevAccountSituationController@index')->name('prev_acc_situation');
        Route::post('store', 'Omega\PrevAccountSituationController@store')->name('prev_acc_situation/store');
    });
    Route::prefix('prev_mem_situation')->group(static function () {
        Route::get('/', 'Omega\PrevMemberSituationController@index')->name('prev_mem_situation');
        Route::post('store', 'Omega\PrevMemberSituationController@store')->name('prev_mem_situation/store');
    });

    //    Previous Account and Member History
    Route::prefix('prev_acc_history')->group(static function () {
        Route::get('/', 'Omega\AccountHistoryController@index')->name('prev_acc_history');
        Route::post('store', 'Omega\AccountHistoryController@store')->name('prev_acc_history/store');
    });
    Route::prefix('prev_mem_history')->group(static function () {
        Route::get('/', 'Omega\PrevMemberHistoryController@index')->name('prev_mem_history');
        Route::post('store', 'Omega\PrevMemberHistoryController@store')->name('prev_mem_history/store');
    });

    //    Previous Journal
    Route::prefix('prev_journal')->group(static function () {
        Route::get('/', 'Omega\PrevJournalController@index')->name('prev_journal');
        Route::post('store', 'Omega\PrevJournalController@store')->name('prev_journal/store');
    });

    //    Previous Trial Balance, BalanceSheet and Income/Expenses
    Route::prefix('prev_trial_balance')->group(static function () {
        Route::get('/', 'Omega\PrevTrialBalanceController@index')->name('prev_trial_balance');
        Route::post('store', 'Omega\PrevTrialBalanceController@store')->name('prev_trial_balance/store');
    });
    Route::prefix('prev_balance_sheet')->group(static function () {
        Route::get('/', 'Omega\PrevBalanceSheetController@index')->name('prev_balance_sheet');
        Route::post('store', 'Omega\PrevBalanceSheetController@store')->name('prev_balance_sheet/store');
    });
    Route::prefix('prev_inc_exp')->group(static function () {
        Route::get('/', 'Omega\PrevIncExpController@index')->name('prev_inc_exp');
        Route::post('store', 'Omega\PrevIncExpController@store')->name('prev_inc_exp/store');
    });

    //    Previous Loan
    Route::prefix('prev_loan')->group(static function () {
        Route::get('/', 'Omega\PrevLoanController@index')->name('prev_loan');
        Route::post('store', 'Omega\PrevLoanController@store')->name('prev_loan/store');
    });

    //    Previous Delinquency
    Route::prefix('prev_delinquency')->group(static function () {
        Route::get('/', 'Omega\PrevDelinquencyController@index')->name('prev_delinquency');
        Route::post('store', 'Omega\PrevDelinquencyController@store')->name('prev_delinquency/store');
    });


    /****************************************
     ************** SETTINGS ****************
    ****************************************/

    //  Menu_Level_I
    Route::prefix('menu_level_1')->group(function () {
        Route::get('/', 'Omega\MenuLevelIController@index')->name('menu_level_1');
        Route::post('store', 'Omega\MenuLevelIController@store')->name('menu_level_1/store');
        Route::post('delete', 'Omega\MenuLevelIController@delete')->name('menu_level_1/delete');
    });

    //  Menu_Level_II
    Route::prefix('menu_level_2')->group(function () {
        Route::get('/', 'Omega\MenuLevelIIController@index')->name('menu_level_2');
        Route::post('store', 'Omega\MenuLevelIIController@store')->name('menu_level_2/store');
        Route::post('delete', 'Omega\MenuLevelIIController@delete')->name('menu_level_2/delete');
    });

    //  Menu_Level_III
    Route::prefix('menu_level_3')->group(function () {
        Route::get('/', 'Omega\MenuLevelIIIController@index')->name('menu_level_3');
        Route::post('store', 'Omega\MenuLevelIIIController@store')->name('menu_level_3/store');
        Route::post('delete', 'Omega\MenuLevelIIIController@delete')->name('menu_level_3/delete');
    });

    //  Menu_Level_IV
    Route::prefix('menu_level_4')->group(function () {
        Route::get('/', 'Omega\MenuLevelIVController@index')->name('menu_level_4');
        Route::post('store', 'Omega\MenuLevelIVController@store')->name('menu_level_4/store');
        Route::post('delete', 'Omega\MenuLevelIVController@delete')->name('menu_level_4/delete');
    });

    //  Privilege
    Route::prefix('privilege')->group(function () {
        Route::get('/', 'Omega\PrivilegeController@index')->name('privilege');
        Route::post('store', 'Omega\PrivilegeController@store')->name('privilege/store');
        Route::post('delete', 'Omega\PrivilegeController@delete')->name('privilege/delete');
    });

    //  Devices
    Route::prefix('device')->group(function () {
        Route::get('/', 'Omega\DeviceController@index')->name('device');
        Route::post('store', 'Omega\DeviceController@store')->name('device/store');
        Route::post('blun', 'Omega\DeviceController@blun')->name('device/blun');
        Route::post('delete', 'Omega\DeviceController@delete')->name('device/delete');
    });

    //  Currency
    Route::prefix('currency')->group(function () {
        Route::get('/', 'Omega\CurrencyController@index')->name('currency');
        Route::post('store', 'Omega\CurrencyController@store')->name('currency/store');
        Route::post('delete', 'Omega\CurrencyController@delete')->name('currency/delete');
    });

    //  Money
    Route::prefix('money')->group(function () {
        Route::get('/', 'Omega\MoneyController@index')->name('money');
        Route::post('store', 'Omega\MoneyController@store')->name('money/store');
        Route::post('delete', 'Omega\MoneyController@delete')->name('money/delete');
    });

    //  Country
    Route::prefix('country')->group(function () {
        Route::get('/', 'Omega\CountryController@index')->name('country');
        Route::post('store', 'Omega\CountryController@store')->name('country/store');
        Route::post('delete', 'Omega\CountryController@delete')->name('country/delete');
    });

    //  Region
    Route::prefix('region')->group(function () {
        Route::get('/', 'Omega\RegionController@index')->name('region');
        Route::post('store', 'Omega\RegionController@store')->name('region/store');
        Route::post('delete', 'Omega\RegionController@delete')->name('region/delete');
    });

    //  Division
    Route::prefix('division')->group(function () {
        Route::get('/', 'Omega\DivisionController@index')->name('division');
        Route::post('store', 'Omega\DivisionController@store')->name('division/store');
        Route::post('delete', 'Omega\DivisionController@delete')->name('division/delete');
    });

    //    SubDivision
    Route::prefix('subdivision')->group(function () {
        Route::get('/', 'Omega\SubDivisionController@index')->name('subdivision');
        Route::post('store', 'Omega\SubDivisionController@store')->name('subdivision/store');
        Route::post('delete', 'Omega\SubDivisionController@delete')->name('subdivision/delete');
    });

    //    Town
    Route::prefix('town')->group(function () {
        Route::get('/', 'Omega\TownController@index')->name('town');
        Route::post('store', 'Omega\TownController@store')->name('town/store');
        Route::post('delete', 'Omega\TownController@delete')->name('town/delete');
    });

    //  Profession
    Route::prefix('profession')->group(function () {
        Route::get('/', 'Omega\ProfessionController@index')->name('profession');
        Route::post('store', 'Omega\ProfessionController@store')->name('profession/store');
        Route::post('delete', 'Omega\ProfessionController@delete')->name('profession/delete');
    });

    //  Network
    Route::prefix('network')->group(function () {
        Route::get('/', 'Omega\NetworkController@index')->name('network');
        Route::post('store', 'Omega\NetworkController@store')->name('network/store');
        Route::post('delete', 'Omega\NetworkController@delete')->name('network/delete');
    });

    //  Zone
    Route::prefix('zone')->group(function () {
        Route::get('/', 'Omega\ZoneController@index')->name('zone');
        Route::post('store', 'Omega\ZoneController@store')->name('zone/store');
        Route::post('delete', 'Omega\ZoneController@delete')->name('zone/delete');
    });

    //  Institution
    Route::prefix('institution')->group(function () {
        Route::get('/', 'Omega\InstitutionController@index')->name('institution');
        Route::post('store', 'Omega\InstitutionController@store')->name('institution/store');
        Route::post('delete', 'Omega\InstitutionController@delete')->name('institution/delete');
    });

    //  Branch
    Route::prefix('branch')->group(function () {
        Route::get('/', 'Omega\BranchController@index')->name('branch');
        Route::post('store', 'Omega\BranchController@store')->name('branch/store');
        Route::post('delete', 'Omega\BranchController@delete')->name('branch/delete');
    });

    //  User
    Route::prefix('user')->group(function () {
        Route::get('/', 'Omega\UserController@index')->name('user');
        Route::post('reset', 'Omega\UserController@reset')->name('user/reset');
        Route::post('blun', 'Omega\UserController@blun')->name('user/blun');
        Route::post('store', 'Omega\UserController@store')->name('user/store');
        Route::post('delete', 'Omega\UserController@delete')->name('user/delete');
    });

    //  Account Type
    Route::prefix('acctype')->group(function () {
        Route::get('/', 'Omega\AccTypeController@index')->name('acctype');
        Route::post('store', 'Omega\AccTypeController@store')->name('acctype/store');
        Route::post('delete', 'Omega\AccTypeController@delete')->name('acctype/delete');
    });

    //  Operation
    Route::prefix('operation')->group(function () {
        Route::get('/', 'Omega\OperationController@index')->name('operation');
        Route::post('store', 'Omega\OperationController@store')->name('operation/store');
        Route::post('delete', 'Omega\OperationController@delete')->name('operation/delete');
    });

    //  Cash Setting
    Route::prefix('cash')->group(static function () {
        Route::get('/', 'Omega\CashController@index')->name('cash');
        Route::post('store', 'Omega\CashController@store')->name('cash/store');
        Route::post('delete', 'Omega\CashController@delete')->name('cash/delete');
    });

    //  Membership Setting
    Route::prefix('mem_setting')->group(static function () {
        Route::get('/', 'Omega\MemSettingController@index')->name('mem_setting');
        Route::post('store', 'Omega\MemSettingController@store')->name('mem_setting/store');
        Route::post('delete', 'Omega\MemSettingController@delete')->name('mem_setting/delete');
    });

    //  Collector
    Route::prefix('collector')->group(function () {
        Route::get('/', 'Omega\CollectorController@index')->name('collector');
        Route::post('store', 'Omega\CollectorController@store')->name('collector/store');
        Route::post('delete', 'Omega\CollectorController@delete')->name('collector/delete');
    });

    //  Bank
    Route::prefix('bank')->group(function () {
        Route::get('/', 'Omega\BankController@index')->name('bank');
        Route::post('store', 'Omega\BankController@store')->name('bank/store');
        Route::post('delete', 'Omega\BankController@delete')->name('bank/delete');
    });

    //  Account Plan
    Route::prefix('acc_plan')->group(function () {
        Route::get('/', 'Omega\AccPlanController@index')->name('acc_plan');
        Route::post('store', 'Omega\AccPlanController@store')->name('acc_plan/store');
        Route::post('delete', 'Omega\AccPlanController@delete')->name('acc_plan/delete');
    });

    //  Branch Param
    Route::prefix('branch_param')->group(function () {
        Route::get('/', 'Omega\BranchParamController@index')->name('branch');
        Route::post('store', 'Omega\BranchParamController@store')->name('branch/store');
        Route::post('delete', 'Omega\BranchParamController@delete')->name('branch/delete');
    });

    //  Institution Param
    Route::prefix('institution_param')->group(function () {
        Route::get('/', 'Omega\InstitutionParamController@index')->name('institution');
        Route::post('store', 'Omega\InstitutionParamController@store')->name('institution/store');
        Route::post('delete', 'Omega\InstitutionParamController@delete')->name('institution/delete');
    });

    //  Account Type
    Route::prefix('acctype')->group(function () {
        Route::get('/', 'Omega\AccTypeController@index')->name('acctype');
        Route::post('store', 'Omega\AccTypeController@store')->name('acctype/store');
        Route::post('delete', 'Omega\AccTypeController@delete')->name('acctype/delete');
    });

    //  Loan Type
    Route::prefix('loantype')->group(function () {
        Route::get('/', 'Omega\LoanTypeController@index')->name('loantype');
        Route::post('store', 'Omega\LoanTypeController@store')->name('loantype/store');
        Route::post('delete', 'Omega\LoanTypeController@delete')->name('loantype/delete');
    });

    //  Loan Purpose
    Route::prefix('loanpur')->group(function () {
        Route::get('/', 'Omega\LoanPurController@index')->name('loanpur');
        Route::post('store', 'Omega\LoanPurController@store')->name('loanpur/store');
        Route::post('delete', 'Omega\LoanPurController@delete')->name('loanpur/delete');
    });
});


/****************************************
 *********** AJAX EXECUTIONS ************
 ****************************************/

//  Get AccPlan
Route::get('getAccPlan', static function () {
    return AccPlan::getAccPlan(Request::input('id'));
});

//  Get AccPlanCommis
Route::get('getAccPlanCommis', static function () {
    return AccPlanCommis::getAccPlanCommiss(['acc_plan' => Request::input('acc_plan')]);
});

//  GetMenu
Route::get('getMenu', static function () {
    $level = Request::input("level");
    switch ($level) {
        case 1:
            return Menu_Level_I::getMenu(Request::input("id"));
            break;
        case 2:
            return Menu_Level_II::getMenu(Request::input("id"));
            break;
        case 3:
            return Menu_Level_III::getMenu(Request::input("id"));
            break;
        case 4:
            return Menu_Level_IV::getMenu(Request::input("id"));
            break;
        default:
            return null;
            break;
    }
});

//  GetPrevMenus
Route::get('getPrevMenus', static function () {
    $level = Request::input("level");
    switch ($level) {
        case 2:
            return Menu_Level_II::getMenus(null, ['menu_1' => Request::input("id")]);
            break;
        case 3:
            return Menu_Level_III::getMenus(null, ['menu_2' => Request::input("id")]);
            break;
        case 4:
            return Menu_Level_IV::getMenus(null, ['menu_3' => Request::input("id")]);
            break;
        default:
            return null;
            break;
    }
});

//  GetNextMenus
Route::get('getNextMenus', static function () {
    $level = Request::input("level");
    switch ($level) {
        case 1:
            return Menu_Level_II::getMenus(null, ['menu_1' => Request::input("id")]);
            break;
        case 2:
            return Menu_Level_III::getMenus(null, ['menu_2' => Request::input("id")]);
            break;
        case 3:
            return Menu_Level_IV::getMenus(null, ['menu_3' => Request::input("id")]);
            break;
        default:
            return null;
            break;
    }
});

//  getPrivMenusAside
Route::get('getPrivMenusAside', static function () {
    $level = Request::input("level");
    $privi = Request::input("privilege");
    $menu = Request::input("menu");

    switch ($level) {
        case 1:
            return Priv_Menu::getPrivMenusAside(['privilege' => $privi], 'menu_1');
            break;
        case 2:
            return Priv_Menu::getPrivMenusAside(['privilege' => $privi], 'menu_2');
            break;
        case 3:
            return Priv_Menu::getPrivMenusAside(['privilege' => $privi], 'menu_3');
            break;
        case 4:
            return Priv_Menu::getPrivMenusAside(['privilege' => $privi], 'menu_4');
            break;
        default:
            return null;
            break;
    }
});

//      Get Currency
Route::get('getCurrency', static function () {
    return Currency::getCurrency(Request::input('id'));
});

//      Get Country
Route::get('getCountry', static function () {
    return Country::getCountry(Request::input('id'));
});

//      Get Profession
Route::get('getProfession', static function () {
    return Profession::getProfession(Request::input('id'));
});

//      Get Region
Route::get('getRegion', static function () {
    return Region::getRegion(Request::input('id'));
});

//      Get Division
Route::get('getDivision', static function () {
    return Division::getDivision(Request::input('id'));
});

//      Get SubDiv
Route::get('getSubDiv', static function () {
    return SubDiv::getSubDiv(Request::input('id'));
});

//      Get Town
Route::get('getTown', static function () {
    return Town::getTown(Request::input('id'));
});

//     Get Professions
Route::get('getProfessions', static function () {
    return Profession::getProfessions(Request::input('lang'));
});

//     Get Countries
Route::get('getCountries', static function () {
    return Country::getCountries(Request::input('lang'));
});

//     Get Regions
Route::get('getRegions', static function () {
    $country = Request::input('country');

    if ($country === null) {
        return Region::getRegions(Request::input('lang'));
    }
    return Region::getRegions(Request::input('lang'), ['country' => $country]);
});

//     Get Divisions
Route::get('getDivisions', static function () {
    $region = Request::input('region');

    if ($region === null) {
        return Division::getDivisions();
    }
    return Division::getDivisions(['region' => $region]);
});

//     Get SubDivisions
Route::get('getSubDivs', static function () {
    $division = Request::input('division');

    if ($division === null) {
        return SubDiv::getSubDivs();
    }
    return SubDiv::getSubDivs(['division' => $division]);
});

//     Get Towns
Route::get('getTowns', static function () {
    $subdivision = Request::input('subdivision');

    if ($subdivision === null) {
        return Town::getTowns();
    }
    return Town::getTowns(['subdivision' => Request::input('subdivision')]);
});

//      Get Register
Route::get('getRegister', static function () {
    return Register::getRegister(Request::input('register'));
});

//      Get Member
Route::get('getMember', static function () {
    $emp = Session::get('employee');

    if ($emp->collector !== null) {
        return Collect_Mem::getMember(Request::input('member'));
    }
    return Member::getMember(Request::input('member'));
});

//      Get Register
Route::get('getRegister', static function () {
    return Register::getRegister(Request::input('register'));
});

//      getRegBenef
Route::get('getRegBenef', static function () {
    return RegBenef::getRegBenefs(Request::input('register'));
});

//      Get Customer
Route::get('getCustomer', static function () {
    return Collect_Mem::getMember(Request::input('member'));
});

//      getCollectMemBenef
Route::get('getCollectMemBenef', static function () {
    return Collect_Mem_Benef::getCollectMemBenefs(Request::input('member'));
});

//      Get Device
Route::get('getDevice', static function () {
    return Device::getDevice(Request::input('id'));
});

//      Get Moneys
Route::get('getMoneys', static function () {
    return Money::getMoneys(['idmoney' => Request::input('money')]);
});

//      Get Profile
Route::get('getProfile', static function () {
    $owner = Request::input('owner');

    if ($owner === 'platform') {
        return asset('storage/platforms/profiles/' . Request::input('file'));
    }

    if ($owner === 'employee') {
        return asset('storage/employees/profiles/' . Request::input('file'));
    }

    if ($owner === 'device') {
        return asset('storage/devices/profiles/' . Request::input('file'));
    }
});

//      Get Signature
Route::get('getSignature', static function () {
    $owner = Request::input('owner');

    if ($owner === 'platform') {
        return asset('storage/platforms/signatures/' . Request::input('file'));
    }

    if ($owner === 'employee') {
        return asset('storage/employees/signatures/' . Request::input('file'));
    }
});

//      Get EmProf
Route::get('getEmProf', static function () {
    return asset('storage/emprofs/' . Request::input('file'));
});

//      Get Logo
Route::get('getLogo', static function () {
    return asset('storage/logos/' . Request::input('file'));
});

//      Get File
Route::get('getFile', static function () {
    return asset('storage/files/' . Request::input('file'));
});

//      Get Network
Route::get('getNetwork', static function () {
    return Network::getNetwork(Request::input('id'));
});

//      Get Zone
Route::get('getZone', static function () {
    return Zone::getZone(Request::input('id'));
});

//      Get Institution
Route::get('getInstitution', static function () {
    return Institution::getInstitution(Request::input('id'));
});

//      Get Zones
Route::get('getZones', static function () {
    return Zone::getZones(['network' => Request::input('network')]);
});

//      Get Account
Route::get('getAccount', static function () {
    return Account::getAccount(Request::input('id'));
});

//      Get Bank
Route::get('getBank', static function () {
    return Bank::getBank(Request::input('id'));
});

//      Get Banks
Route::get('getBanks', static function () {
    return Bank::getBanks(['banks.branch' => Request::input('branch')]);
});

//      Get Institutions
Route::get('getInstitutions', static function () {
    return Institution::getInstitutions(['zone' => Request::input('zone')]);
});

//      Get Branches
Route::get('getBranches', static function () {
    return Branch::getBranches(['institution' => Request::input('institution')]);
});

//      Get Branch
Route::get('getBranch', static function () {
    return Branch::getBranch(Request::input('id'));
});

//      Get Collector
Route::get('getCollector', static function () {
    return Collector::getCollector(Request::input('id'));
});

//      Get User
Route::get('getUserInfos', static function () {
    return User::getUserInfos(Request::input('id'));
});

//      Get CollectorsBy
Route::get('getCollectorsBy', static function () {
    return Collector::getCollectorsBy(['branch' => Request::input('branch')]);
});

//      Delete Account Date
Route::get('delDate', static function () {
    Session::forget('accdate');
//    return Redirect::route('o-collect');
});

//      Get Privilege
Route::get('getPrivilege', static function () {
    return Privilege::getPrivilege(Request::input('priv'));
});

//      Get Account Type
Route::get('getAccType', static function () {
    return AccType::getAccType(Request::input('acctype'));
});

// Get Loan Simulation
Route::get('loan_simulation_view', static function () {
    $tot_amort_amt = 0;
    $tot_int_amt = 0;
    $tot_ann_amt = 0;
    $tot_tax_amt = 0;
    $tot_tot_amt = 0;

    $amount = trimOver(Request::input('amount'), ' ');
    $inst_no = trimOver(Request::input('amount'), ' ');
    $int_rate = (float)Request::input('int_rate') / (float)100;
    $tax_rate = (float)Request::input('tax_rate') / (float)100;
    $period = Request::input('period');

    $simulations = [];

    for ($i = 1; $i < $inst_no + 1; $i++) {
        $amort_amt = 0;
        $capital = $amount;
        $date = new \DateTime(Request::input('inst1'));
        
        if (Request::input('amorti') === 'C') {
            $amort_amt = $amount / $inst_no;

            if ($i > 1) {
                $new_capital = $amount - $amort_amt;
                for ($j = 1; $j < $i - 1; $j++) {
                    $new_capital -= $amort_amt;
                }
                $capital = $new_capital;
            }
        }

        if (Request::input('amorti') === 'V') {
            $amort_amt = ($capital * $int_rate) / (pow((1 + $int_rate), $inst_no) - 1);

            if ($i > 1) {
                $new_capital = $capital - $amort_amt;
                $amo = ($new_capital * $int_rate) / (pow((1 + $int_rate), $inst_no - 1) - 1);

                for ($j = 1; $j < $i - 1 ; $j++) {
                    $new_capital -= $amo;
                    $amo = ($new_capital * $int_rate) / (pow((1 + $int_rate), ($inst_no - ($j + 1))) - 1);
                }

                $capital = $new_capital;
                $amort_amt = $amo;
            }
        }

        if ($i === 1) {
            $date = $date;
        } else {
            if ($period === 'D') {
                $interval = $i - 1;
                $date = $date->add(new \DateInterval("P{$interval}D"));
            } else if ($period === 'W') {
                $interval = 7 * ($i - 1);
                $date = $date->add(new \DateInterval("P{$interval}D"));
                $date = date.addDays(7 * ($i - 1));
            } else if ($period === 'B') {
                $interval = 15 * ($i - 1);
                $date = $date->add(new \DateInterval("P{$interval}D"));
            } else if ($period === 'M') {
                $interval = ($i - 1);
                $date = $date->add(new \DateInterval("P{$interval}M"));
            } else if ($period === 'T') {
                $interval = 3 * ($i - 1);
                $date = $date->add(new \DateInterval("P{$interval}M"));
            } else if ($period === 'S') {
                $interval = 6 * ($i - 1);
                $date = $date->add(new \DateInterval("P{$interval}M"));
            } else {
                $interval = 12 * ($i - 1);
                $date = $date->add(new \DateInterval("P{$interval}M"));
            }
        }

        $int_amt = $capital * $int_rate;
        $ann_amt = $amort_amt + $int_amt;
        $tax_amt = $int_amt * $tax_rate;
        $tot_amt = $ann_amt + $tax_amt;

        $date = $date->format('d/m/Y');

        $tot_amort_amt += $amort_amt;
        $tot_int_amt += $int_amt;
        $tot_ann_amt += $ann_amt;
        $tot_tax_amt += $tax_amt;
        $tot_tot_amt += $tot_amt;

        $simulations['intallment'] = $i;
        $simulations['capital'] = $capital;
        $simulations['amort_amt'] = $amort_amt;
        $simulations['int_amt'] = $int_amt;
        $simulations['ann_amt'] = $ann_amt;
        $simulations['tax_amt'] = $tax_amt;
        $simulations['tot_amt'] = $tot_amt;
        $simulations['date'] = $date;

        $simulations['capital'] = 0;
        $simulations['amort_amt'] = 0;
        $simulations['int_amt'] = 0;
        $simulations['ann_amt'] = 0;
        $simulations['tax_amt'] = 0;
    }

    return ['data' => $simulations];
});

//      Get Filter Collectors
Route::get('getFilterCollectors', static function () {
    return Collector::getFilterCollectors(Request::input('institution'), Request::input('branch'));
});

//      Get Filter Collectors Balance
Route::get('getFilterCollectBals', static function () {
    return Collector::getFilterCollectBals(Request::input('institution'), Request::input('branch'), Request::input('month'));
});

//      Get Collector Balance
Route::get('getCollectBal', static function () {
    return Collector_Com::getCollectBal(Request::input('collector'));
});

//      Get Filter Customers
Route::get('getFilterCustomers', static function () {
    return Collect_Mem::getFilterCustomers(Request::input('institution'), Request::input('branch'), Request::input('collector'));
});

//      Get Filter Customer Balances
Route::get('getFilterCustBals', static function () {
    return Collect_Mem::getFilterCustBals(Request::input('institution'), Request::input('branch'), Request::input('collector'));
});

//      Get Filter Employees
Route::get('getFilterEmployees', static function () {
    return Employee::getFilterEmployees(Request::input('institution'), Request::input('branch'));
});

//      Get Cash Differences
Route::get('getCashDiffs', static function () {
    $cash_diffs = Cash_Diff::getCashDiffs(['cash' => Request::input('collector'), 'diff_status' => 'N']);

    foreach ($cash_diffs as $cash_diff) {
        $account = Account::getAccount($cash_diff->account);

        $cash_diff->accnumb = $account->accnumb;
        $cash_diff->acc_fr = $account->labelfr;
        $cash_diff->acc_en = $account->labeleng;
    }

    return $cash_diffs;
});

//      Get Cash Difference
Route::get('getCashDiff', static function () {
    return Cash_Diff::getCashDiff(Request::input('id'));
});

//      Get Collectors Cash
Route::get('getCollectorsCash', static function () {
    return Collector::getCollectorsCash(['collectors.branch' => Request::input('branch')]);
});

//      Get Filter Collectors
Route::get('getFilterSharings', static function () {
    return Collector::getFilterSharings(Request::input('branch'), Request::input('month'));
});

//      Get Filter Collects
Route::get('getFilterReports', static function () {
    return Writing::getFilterReports(Request::input('zone'), Request::input('institution'), Request::input('branch'), Request::input('collector'), Request::input('date1'), Request::input('date2'));
});

//      get Member Balance
Route::get('getMemBal', static function () {
    return Collect_Mem::getMemBal(Request::input('member'));
});


// O-COLLECT MOBILE

//Route::post('loginMob', 'Omega\LoginController@loginMob');

//      getMembersByColl
Route::get('getMembersByColl', static function () {
    return Collect_Mem::getCollectMemsByColl(Request::input('collector'));
});

//      getJournalByColl
Route::get('getJournalsByColl', static function () {
    return Writing::getJournalsByColl(Request::input('network'), Request::input('collector'), Request::input('idcollect'), '\'' . Request::input('language') . '\'');
});

//      getTransactionsByColl
Route::get('getTransactionsByColl', static function () {
    return ValWriting::getTransactionsByColl(Request::input('network'), Request::input('collector'), Request::input('idcollect'), '\'' . Request::input('language') . '\'');
});

//      getFilterTransactionsByColl
Route::get('getFilterTransactionsByColl', static function () {
    return ValWriting::getFilterTransactionsByColl(Request::input('network'), Request::input('collector'), Request::input('idcollect'), '\'' . Request::input('language') . '\'', Request::input('date1'), Request::input('date2'));
});

//      getMonth
Route::get('getMonth', static function () {
    $month = null;

    $pay = Commis_Pay::getMonth(Request::input('branch'));

    if ($pay !== null && $pay->month !== 12) {
        $month = $pay->month + 1;
    }

    return $month;
});

//      getCollectBalsByColl
Route::get('getCollectBalsByColl', static function () {
    return Collector::getCollectBalsByColl(Request::input('institution'), Request::input('collector'));
});

//      getFilterCollectBalsByColl
Route::get('getFilterCollectBalsByColl', static function () {
    return Collector::getFilterCollectBalsByColl(Request::input('institution'), Request::input('collector'), Request::input('month'));
});

//      getCustBalsByColl
Route::get('getCustBalsByColl', static function () {
    return Collect_Bal::getCustBalsByColl(Request::input('collector'));
});

//      getReportsByColl
Route::get('getReportsByColl', static function () {
    return Writing::getReportsByColl(Request::input('institution'), Request::input('collector'));
});

//      getFilterReportsByColl
Route::get('getFilterReportsByColl', static function () {
    $from = Request::input('date1');
    $to = Request::input('date2');

    if ($from === null && $to === null) {
        return Writing::getReportsByColl(Request::input('institution'), Request::input('collector'));
    }
    return Writing::getFilterReportsByColl(Request::input('institution'), Request::input('collector'), $from, $to);
});

//      getOpenCashConditions
Route::get('getOpenCashConditions', static function () {
    $error = 'null';

    if (dateOpen(Request::input('branch'))) {
        if (cashOpen(Request::input('collector'))) {
            $error = trans('alertDanger.alrcash');
        }
    } else {
        $error = trans('alertDanger.opdate');
    }

    return $error;
});

//      getCashConditions
Route::get('getCashConditions', static function () {
    $error = 'null';

    if (dateOpen(Request::input('branch'))) {
        if (!cashOpen(Request::input('collector'))) {
            $error = trans('alertDanger.opencash');
        }
    } else {
        $error = trans('alertDanger.opdate');
    }

    return $error;
});

//      getEmptyCashConditions
Route::get('getEmptyCashConditions', static function () {
    $error = 'null';

    if (dateOpen(Request::input('branch'))) {
        if (!cashOpen(Request::input('collector'))) {
            $error = trans('alertDanger.opencash');
        }

        if ((int)cashEmpty(Request::input('collector')) <= 10000) {
            $error = trans('alertDanger.emptycash');
        }
    } else {
        $error = trans('alertDanger.opdate');
    }

    return $error;
});

//      getCashMoneys
Route::get('getCashMoneys', static function () {
    $cash = Cash::getEmpCash(Request::input('collector'));
    $moneys = Money::getMoneysMob(Request::input('country'));

    foreach ($moneys as $money) {
        $money->billet = money($cash->{'mon' . $money->idmoney});
        $money->total = money($money->value * $cash->{'mon' . $money->idmoney});
        $money->value = money($money->value);
    }

    return $moneys;
});

//      getDashboardCount
Route::get('getDashboardCount', static function () {
    $customers = Collect_Mem::getCollectMems(Request::input('collector'))->count();
    $cash = Cash::getSumBillet(Cash::getEmpCash(Request::input('user'))->idcash)->total;

    return [
        'customers' => $customers,
        'cash' => \money($cash)
    ];
});

//      getCustomers
Route::get('getCustomers', static function () {
    return Collect_Mem::getCollectMems(Request::input('collector'));
});

//      Registration
Route::get('registration/store', 'Omega\RegistrationController@store');

//      GetCustomerBalance
Route::get('getCustomerBalance', static function () {
    $customer = Collect_Bal::getCustomerBalance(Request::input('customer'));

    $ava = (int)$customer->available;
    $evebal = (int)$customer->evebal;
    if ($ava === 0) {
        $ava = $evebal;
    }

    $customer->ava = \money($ava);

    return $customer;
//    return ['data' => $customer];
});

//      getFilterCustStatements
Route::get('getFilterCustStatements', static function () {
    $from = Request::input('date1');
    $to = Request::input('date2');

    if ($from === null && $to === null) {
        return Writing::getCustStatements(Request::input('customer'), Request::input('language'));
    }
    return Writing::getFilterCustStatements(Request::input('customer'), Request::input('language'), $from, $to);
});

//      Get Account Description
Route::get('getAccount', static function () {
    return Account::getAccount(Request::input('id'));
});

//      Get Accounts
Route::get('getAccounts', static function () {
    return Account::getAccounts();
});

//      Get Account Chart
Route::get('getAccChart', static function () {
    return LoanType::getAccChart(Request::input('loantype'));
});

//      Get Loan
Route::get('getLoan', static function () {
    return Loan::getLoan(Request::input('loan'));
});

//      Get tLoans()
Route::get('getLoansMember', static function () {
    return Loan::getLoansMember();
});

//      Get Demand Loan
Route::get('getMemLoans', static function () {
    return Loan::getMemLoans(['member' => Request::input('member')]);
});

//      Get Loan
Route::get('getFilterLoans', static function () {
    return Loan::getFilterLoans(Request::input('loanstat'), Request::input('emp'), Request::input('dateFr'), Request::input('dateTo'));
});

//      Get Demand Loan
Route::get('getDemLoan', static function () {
    return DemLoan::getLoan(Request::input('loan'));
});

//      Get Demand Loan
Route::get('getFilterDemLoans', static function () {
    return DemLoan::getFilterLoans(Request::input('loanstat'), Request::input('emp'), Request::input('dateFr'), Request::input('dateTo'));
});

//      Get Loan Type
Route::get('getLoanType', static function () {
    return LoanType::getLoanType(Request::input('id'));
});

//      Get Loan Types
Route::get('getLoanTypes', static function () {
    return LoanType::getLoanTypes();
});

//      Get Loan Pur
Route::get('getLoanPur', static function () {
    return LoanPur::getLoanPur(Request::input('loanpur'));
});

//      Get Cash
Route::get('getCash', static function () {
    return Cash::getCash(Request::input('cash'));
});

//      Get Cashes
Route::get('getCashes', static function () {
    return Cash::getCashes(['cashes.branch' => Request::input('branch')]);
});

//      Get Operation
Route::get('getOperation', static function () {
    return Operation::getOperation(Request::input('operation'));
});

//      Get Member Account
Route::get('getMemAcc', static function () {
    return MemBalance::getMemAccBal(Request::input('member'), Request::input('account'));
});

//      Get Account Balance
Route::get('getMemBals', static function () {
    $members = MemBalance::getMemBals(Request::input('member'));
    if (Request::input('acctype') !== null) {
        $members = MemBalance::getMemBals(Request::input('member'), Request::input('acctype'));
    }

    if (Request::ajax()) {
        return ['data' => $members->toArray()];
    }
    return $members;
});

//      Get Member Cash Out Account Balance
Route::get('getMemCashOutBals', static function () {
    $members = MemBalance::getMemCashOutBals(Request::input('member'));
    if (Request::input('acctype') !== null) {
        $members = MemBalance::getMemCashOutBals(Request::input('member'), Request::input('acctype'));
    }

    if (Request::ajax()) {
        if (is_array($members)) {
            return ['data' => $members];
        }
        return ['data' => $members->toArray()];
    }
    return $members;
});

//      Get Member Sum Debit
Route::get('getMemDebit', static function () {
    return Writing::getMemSumDebit(Request::input('member'), Request::input('account'));
});

//      Get Member Sum Credit
Route::get('getMemCredit', static function () {
    return Writing::getMemSumCredit(Request::input('member'), Request::input('account'));
});

//      Get Check Description
Route::get('getCheck', static function () {
    return Check::getCheck(Request::input('check'));
});

//      Get To Sort Check Description
Route::get('getToSortChecks', static function () {
    return Check::getToSortChecks(Request::input('check'));
});

//      Get Other To Sort Check Description
Route::get('getOtherToSortChecks', static function () {
    return Check::getOtherToSortChecks(Request::input('check'));
});

//      Get Checks Account Description
Route::get('getCheckAccs', static function () {
    return CheckAccAmt::getCheckAccAmts(['checkno' => Request::input('check')]);
});

//      Get Checks Account Description
Route::get('getOtherCheckAccs', static function () {
    return CheckAccAmt::getOtherCheckAccAmts(['checkno' => Request::input('check')]);
});

//      Get Loan Installments Description
Route::get('getInstalls', static function () {
    return Installment::getInstalls(Request::input('loan'));
});

//      Get Comakers
Route::get('getComakers', static function () {
    return Comaker::getComakers(['loan' => Request::input('loan')]);
});

//      Get Member Comakers
Route::get('getMemComakers', static function () {
    return Comaker::getComakers(['member' => Request::input('member')]);
});

//      Get Member Demand Comakers
Route::get('getMemDemComakers', static function () {
    return DemComaker::getDemComakers(['member' => Request::input('member')]);
});

//      Get BlockAcc
Route::get('getBlockAcc', static function () {
    return Comaker::getBlockAcc();
});

//      Get Provision Loan
Route::get('getProvLoans', static function () {
    return Loan::getProvLoans(Request::input('ltype'), Request::input('employee'));
});

//      Get Comakers
Route::get('getMortgages', static function () {
    return Mortgage::getMortgages(Request::input('loan'));
});

//  Get Filter Member Accounts
Route::get('getFilterMemAccs', static function () {
    return MemBalance::getFilterMemAccs(Request::input('member'), Request::input('date'));
});

//  Get Filter Member Loans
Route::get('getFilterMemLoans', static function () {
    return Loan::getFilterMemLoans(Request::input('member'), Request::input('date'));
});

//  Get Member Situation
Route::get('getMemSituation', static function () {
    $balances = MemBalance::getFilterMemAccs(Request::input('member'), Request::input('date'));
    $loans = Loan::getFilterMemLoans(Request::input('member'), Request::input('date'));

    return [
        'balances' => $balances,
        'loans' => $loans
    ];
});

//  Get Journals
Route::get('getJournals', static function () {
    return Writing::getJournals(Request::input('state'), Request::input('user'));
});
