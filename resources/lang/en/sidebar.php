<?php

use Illuminate\Support\Facades\Session;

$member = 'Members';

if (Session::exists('employee')) {
    $emp = Session::get('employee');

    if ($emp->collector !== null) {
        $member = 'Customers';
    }
}

return [

    /*
    |--------------------------------------------------------------------------
    | Label Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during designing form for various
    | label that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

	'login' => 'Login',
	'discon' => 'Sign Out',
	'recon' => 'Reconnection',
	'editpass' => 'Edit Password',

	'home' => 'Dashboard',
	'homes' => 'DASHBOARD',
	'omega' => 'Omega',
	'footer' => 'All rights reserved.',


    'operation' => 'OPERATIONS',
    'front' => 'Front Office',
    'deposit' => 'Deposit',
    'cin' => 'Cash In',
    'membership' => 'Membership',
    'cfbank' => 'Cash from Bank',
    'recfund' => 'Funds Reception',
    'repfund' => 'Funds Replenishment',
	'cashtocash' => 'Inter-Cash Replenishment',
    'checkin' => 'Check In',
    'ocin' => 'Other Cash In',
    'withdraw' => 'Withdrawal',
    'cout' => 'Cash Out',
    'ctbank' => 'Cash to Bank',
    'checkout' => 'Check Out',
    'emifund' => 'Funds Insuance',
    'ocout' => 'Other Cash Out',
    'dailycol' => 'Daily Collections',
    'report' => 'Report',
    'accounting' => 'Accountings',
    'tempjour' => 'Temporal Journal',
    'valtrans' => 'Validated Transactions',
    'opencash' => 'Till Opening',
    'closecash' => 'Till Closing',
    'situatcash' => 'Till Position',
    'reconcash' => 'Cash Reconciliation',
    'regulcash' => 'Cash Regularisation',
    'monexc' => 'Money Exchange',
	'ochein' => 'Other Check In',
	'ocheout' => 'Other Check Out',
	'checktreat' => 'Check Treatment',
	'sort' => 'Check Cash In',
	'other_sort' => 'Other Check Cash In',
	'register' => 'Register',

	'back' => 'Back Office',
	'registration' => 'Registration',
	'member' => 'Member',
	'account' => 'Accounts',
	'gen' => 'General',
	'aux' => 'Auxiliaries',
	'acc_his' => 'Account History',
	'acc_sit' => 'Account Situation',
	'mem_his' => 'Member History',
	'mem_sit' => 'Member Situation',
    'cust' => 'Customer',
    'memb' => 'Member',
	'com_sharing' => 'Commission Sharing',
	'daily_treat' => 'Daily Treatment',
    'open_acc_date' => 'Account Day Opening',
    'close_acc_date' => 'Account Day Closing',
    'backup' => 'Backup',
    'journals' => 'Journals',
    'div_opera' => 'Journal',
    'transfers' => 'Transfers',
    'acctoacc' => 'Account to Account',
    'trantoloan' => 'To Repay Loan',
    'grouptran' => 'Group',


	'loans' => 'LOANS',
	'simul' => 'Simulation',
	'appli' => 'Application',
	'appro' => 'Approval',
	'reject' => 'Reject',
	'refin' => 'Refinancing',
	'amount' => 'Amount',
	'savwithfac' => 'Savings Withdrawal Facility',
	'restruct' => 'Restructuring',
	'intrate' => 'Interest Rate',
	'instal' => 'Installment',
	'grace' => 'Grace Period',
	'list' => 'Loans List',
	'delinq' => 'Delinquency',
	'provi' => 'Provision',
	'stats' => 'Statistics',
	'rollback' => 'Rollback',

    'bi' => 'BUSINESS INTELLIGENCE',
    'pki' => 'PKI\'s',
    'crm' => 'CRM',
    'credt_off' => 'Credit Bureau',
    'bench' => 'Benchmarking',
    'prud_norm' => 'Prudential Norms',


	'finstat' => 'FINANCIAL STATEMENTS',
	'trialbal' => 'Trial Balance',
	'balsheet' => 'Balance Sheet',
	'inc&exp' => 'Income / Expenses',
	'accshed' => 'Account Schedule',


	'reports' => 'REPORTS',
    'employee' => 'Employees',
    'client' => 'Customers',
    'acc_state' => 'Account Statements',
    'collect_report' => 'Collections',
    'commis_report' => 'Commissions',
    'shared_commis_report' => 'Shared Commissions',
    'transaction' => 'Transactions',
    'sit'=>'Situations',
    'collect_acc'=>'Collector Statements',
    'client_acc'=>'Customer Statements',
    'client_sit' => 'Customer Situation',
    'collect_sit' => 'Collector Situation',
	'registereds' => 'Registereds',
	'accounts' => 'Accounts',
    'members' => $member,
    'coll_custs' => 'Collection Customers',


	'setting' => 'SETTINGS',
    'network' => 'Networks',
    'zone' => 'Zones',
    'institute' => 'Institutions',
    'branch' => 'Branches',
    'money' => 'Money',
    'specific' => 'Specific',
    'accplan' => 'Account Plan',
    'banks' => 'Banks',
    'device' => 'Devices',
    'profs' => 'Professions',
    'country' => 'Countries',
    'region' => 'Regions',
    'division' => 'Divisions',
    'subdiv' => 'Sub Divisions',
    'privi' => 'Privileges',
    'cash' => 'Tills',
    'opera' => 'Operations',
    'collector' => 'Collectors',
    'user'=> 'Users',
    'town' => 'Towns',
    'currency' => 'Currencies',
    'budget_init' => 'Budget Initialisation'




];
