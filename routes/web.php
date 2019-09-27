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

use App\Models\Account;
use App\Models\Balance;
use App\Models\Bank;
use App\Models\Cash;
use App\Models\Check;
use App\Models\CheckAccAmt;
use App\Models\DemLoan;
use App\Models\Division;
use App\Models\Loan;
use App\Models\LoanPur;
use App\Models\LoanType;
use App\Models\Member;
use App\Models\Money;
use App\Models\Operation;
use App\Models\Region;
use App\Models\Register;
use App\Models\SubDiv;
use App\Models\Town;
use App\Models\Writing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('tamco', static function () {
    return view('omega.login');
});
Route::get('/', static function () {
    return view('omega.login');
});
Route::post('login', 'Omega\LoginController@login')->name('login');
Route::get('lang/{lang}', 'Omega\LoginController@changeLanguage')->name('lang/{lang}');
Route::post('logout', 'Omega\LoginController@logout')->name('logout');
/**
 * Administrator Routes
 */
Route::prefix('admin')->group(static function () {
    Route::get('/', function () {
        $users = DB::table('privileges')->get();
        return view('admin.index', ['users' => $users]);
    })->name('admin');

//    Currency Controller
    Route::prefix('currency')->group(function () {
        Route::get('/', 'Admin\CurrencyController@index')->name('admin/currency');
        Route::post('store', 'Admin\CurrencyController@store')->name('admin/currency/store');
        Route::post('delete', 'Admin\CurrencyController@delete')->name('admin/currency/delete');
        Route::post('getData', 'Admin\CurrencyController@getData')->name('admin/currency/getData');
    });

//    Money Controller
    Route::prefix('money')->group(function () {
        Route::get('/', 'Admin\MoneyController@index')->name('admin/money');
        Route::post('store', 'Admin\MoneyController@store')->name('admin/money/store');
        Route::post('delete', 'Admin\MoneyController@delete')->name('admin/money/delete');
    });

//     Country Country
    Route::prefix('country')->group(function () {
        Route::get('/', 'Admin\CountryController@index')->name('admin/country');
        Route::post('store', 'Admin\CountryController@store')->name('admin/country/store');
        Route::post('delete', 'Admin\CountryController@delete')->name('admin/country/delete');
    });

//    Region Controller
    Route::prefix('region')->group(function () {
        Route::get('/', 'Admin\RegionController@index')->name('admin/region');
        Route::post('store', 'Admin\RegionController@store')->name('admin/region/store');
        Route::post('delete', 'Admin\RegionController@delete')->name('admin/region/delete');
    });

//    Division Controller
    Route::prefix('division')->group(function () {
        Route::get('/', 'Admin\DivisionController@index')->name('admin/division');
        Route::post('store', 'Admin\DivisionController@store')->name('admin/division/store');
        Route::post('delete', 'Admin\DivisionController@delete')->name('admin/division/delete');
    });

//    SubDivision Controller
    Route::prefix('subdivision')->group(function () {
        Route::get('/', 'Admin\SubDivisionController@index')->name('admin/subdivision');
        Route::post('store', 'Admin\SubDivisionController@store')->name('admin/subdivision/store');
        Route::post('delete', 'Admin\SubDivisionController@delete')->name('admin/subdivision/delete');
    });

    //    SubDivision Controller
    Route::prefix('subdivision')->group(function () {
        Route::get('/', 'Admin\SubDivisionController@index')->name('admin/subdivision');
        Route::post('store', 'Admin\SubDivisionController@store')->name('admin/subdivision/store');
        Route::post('delete', 'Admin\SubDivisionController@delete')->name('admin/subdivision/delete');
    });

    //  Network Controller
    Route::prefix('network')->group(function () {
        Route::get('/', 'Admin\NetworkController@index')->name('admin/network');
        Route::post('store', 'Admin\NetworkController@store')->name('admin/network/store');
        Route::post('delete', 'Admin\NetworkController@delete')->name('admin/network/delete');
    });

    //  Zone Controller
    Route::prefix('zone')->group(function () {
        Route::get('/', 'Admin\ZoneController@index')->name('admin/zone');
        Route::post('store', 'Admin\ZoneController@store')->name('admin/zone/store');
        Route::post('delete', 'Admin\ZoneController@delete')->name('admin/zone/delete');
    });

    //  Institution Controller
    Route::prefix('institution')->group(function () {
        Route::get('/', 'Admin\InstitutionController@index')->name('admin/institution');
        Route::post('store', 'Admin\InstitutionController@store')->name('admin/institution/store');
        Route::post('delete', 'Admin\InstitutionController@delete')->name('admin/institution/delete');
    });

    //  Privilege Controller
    Route::prefix('privilege')->group(function () {
        Route::get('/', 'Admin\PrivilegeController@index')->name('admin/privilege');
        Route::post('store', 'Admin\PrivilegeController@store')->name('admin/privilege/store');
        Route::post('delete', 'Admin\PrivilegeController@delete')->name('admin/privilege/delete');
    });

    //  Branch Controller
    Route::prefix('branch')->group(function () {
        Route::get('/', 'Admin\BranchController@index')->name('admin/branch');
        Route::post('store', 'Admin\BranchController@store')->name('admin/branch/store');
        Route::post('delete', 'Admin\BranchController@delete')->name('admin/branch/delete');
    });

    //  Account Type Controller
    Route::prefix('acctype')->group(function () {
        Route::get('/', 'Admin\AccTypeController@index')->name('admin/acctype');
        Route::post('store', 'Admin\AccTypeController@store')->name('admin/acctype/store');
        Route::post('delete', 'Admin\AccTypeController@delete')->name('admin/acctype/delete');
    });

    //  Loan Type Controller
    Route::prefix('loantype')->group(function () {
        Route::get('/', 'Admin\LoanTypeController@index')->name('admin/loantype');
        Route::post('store', 'Admin\LoanTypeController@store')->name('admin/loantype/store');
        Route::post('delete', 'Admin\LoanTypeController@delete')->name('admin/loantype/delete');
    });

    //  Loan Purpose Controller
    Route::prefix('loanpur')->group(function () {
        Route::get('/', 'Admin\LoanPurController@index')->name('admin/loanpur');
        Route::post('store', 'Admin\LoanPurController@store')->name('admin/loanpur/store');
        Route::post('delete', 'Admin\LoanPurController@delete')->name('admin/loanpur/delete');
    });

});

/***************************************************************
 ***************************************************************
 ********************** OMEGA DASHBOARD ************************
 ***************************************************************
 ***************************************************************/

/***************************
 ********** HOME **********
 ***************************/

Route::get('omega', static function () {
    return view('omega.index');
})->name('omega');

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

//    Cash Open, Close and Reopen
Route::prefix('cash_open')->group(static function () {
    Route::get('/', 'Omega\CashOpenController@index')->name('cash_open');
    Route::post('store', 'Omega\CashOpenController@store')->name('cash_open/store');
});
Route::prefix('cash_close')->group(static function () {
    Route::get('/', 'Omega\CashCloseController@index')->name('cash_close');
    Route::post('store', 'Omega\CashCloseController@store')->name('cash_close/store');
});
Route::prefix('cash_reopen')->group(static function () {
    Route::get('/', 'Omega\CashReopenController@index')->name('cash_reopen');
    Route::post('store', 'Omega\CashReopenController@store')->name('cash_reopen/store');
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

//     Replenishment Bank and Fund Emission
Route::prefix('replenish')->group(static function () {
    Route::get('/', 'Omega\ReplenishController@index')->name('replenish');
    Route::post('store', 'Omega\ReplenishController@store')->name('replenish/store');
});
Route::prefix('emission')->group(static function () {
    Route::get('/', 'Omega\EmissionController@index')->name('emission');
    Route::post('store', 'Omega\EmissionController@store')->name('emission/store');
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

//    Collector Cash In and Out
Route::prefix('collector')->group(static function () {
    Route::prefix('cash_in')->group(static function () {
        Route::get('/', 'Omega\CashInController@index')->name('collector/cash_in');
        Route::post('store', 'Omega\CashInController@store')->name('collector/cash_in/store');
    });
    Route::prefix('cash_out')->group(static function () {
        Route::get('/', 'Omega\CashOutController@index')->name('collector/cash_out');
        Route::post('store', 'Omega\CashOutController@store')->name('collector/cash_out/store');
    });
});

//    Collector Report
Route::prefix('collector_report')->group(static function () {
    Route::get('/', 'Omega\CollectorReportController@index')->name('collector_report');
    Route::post('store', 'Omega\CollectorReportController@store')->name('collector_report/store');
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
    Route::post('store', 'Omega\TempJournalController@store')->name('temp_journal/store');
});
Route::prefix('journal')->group(static function () {
    Route::get('/', 'Omega\JournalController@index')->name('journal');
    Route::post('store', 'Omega\JournalController@store')->name('journal/store');
});
Route::prefix('transaction')->group(static function () {
    Route::get('/', 'Omega\TransactionController@index')->name('transaction');
    Route::post('store', 'Omega\TransactionController@store')->name('transaction/store');
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
    Route::post('store', 'Omega\LoanSimulationController@store')->name('loan_simulation/store');
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
 ************** SETTINGS ****************
 ****************************************/

//    Cash Setting
Route::prefix('cash')->group(static function () {
    Route::get('/', 'Omega\CashController@index')->name('cash');
    Route::post('store', 'Omega\CashController@store')->name('cash/store');
    Route::post('delete', 'Omega\CashController@delete')->name('cash/delete');
});

//    Membership Setting
Route::prefix('mem_setting')->group(static function () {
    Route::get('/', 'Omega\MemSettingController@index')->name('mem_setting');
    Route::post('store', 'Omega\MemSettingController@store')->name('mem_setting/store');
    Route::post('delete', 'Omega\MemSettingController@delete')->name('mem_setting/delete');
});

//    Operation
Route::prefix('operation')->group(function () {
    Route::get('/', 'Omega\OperationController@index')->name('operation');
    Route::post('store', 'Omega\OperationController@store')->name('operation/store');
    Route::post('delete', 'Omega\OperationController@delete')->name('operation/delete');
});

//    Bank
Route::prefix('bank')->group(function () {
    Route::get('/', 'Omega\BankController@index')->name('bank');
    Route::post('store', 'Omega\BankController@store')->name('bank/store');
    Route::post('delete', 'Omega\BankController@delete')->name('bank/delete');
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
 *************** EXIT *******************
 ****************************************/


/****************************************
 *********** AJAX EXECUTIONS ************
 ****************************************/

//     Get Regions
Route::get('getRegions', static function () {
    return Region::query()->where('country', Request::input('country'))->get();
});

//     Get Divisions
Route::get('getDivisions', static function () {
    return Division::query()->where('region', Request::input('region'))->get();
});

//     Get SubDivisions
Route::get('getSubDivs', static function () {
    return SubDiv::query()->where('division', Request::input('division'))->get();
});

//     Get Towns
Route::get('getTowns', static function () {
    return Town::query()->where('subdivision', Request::input('subdivision'))->get();
});

//      Get Register
Route::get('getRegister', static function () {
    return Register::getRegister(Request::input('register'));
});

//      Get Member
Route::get('getMember', static function () {
    return Member::getMember(Request::input('member'));
});

//      Get Register
Route::get('getBank', static function () {
    return Bank::getBank(Request::input('bank'));
});

//      Get Moneys
Route::get('getMoneys', static function () {
    return Money::query()->where('idmoney', Request::input('money'))->get();
});

//      Get Account Description
Route::get('getAccount', static function () {
    return Account::getAccount(['idaccount' => Request::input('account')]);
});

//      Get Account Chart
Route::get('getAccChart', static function () {
    return LoanType::getAccChart(Request::input('loantype'));
});

//      Get Loan
Route::get('getLoan', static function () {
    return Loan::getLoan(Request::input('loan'));
});

//      Get Demand Loan
Route::get('getMemLoans', static function () {
    return Loan::getLoans(['member' => Request::input('member')]);
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
    return LoanType::getLoanType(Request::input('ltype'));
});

//      Get Loan Pur
Route::get('getLoanPur', static function () {
    return LoanPur::getLoanPur(Request::input('lpur'));
});

//      Get Cash Description
Route::get('getCash', static function () {
    return Cash::getCash(Request::input('cash'));
});

//      Get Operation Description
Route::get('getOperation', static function () {
    return Operation::getOperation(Request::input('operation'));
});

//      Get Account Balance
Route::get('getAccBalance', static function () {
    return Balance::getMemAccBal(Request::input('member'));
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
