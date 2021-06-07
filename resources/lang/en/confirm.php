<?php

use Illuminate\Support\Facades\Session;

$member = 'Member';

if (Session::exists('employee')) {
    $emp = Session::get('employee');

    if ($emp->collector !== null) {
        $member = 'Customer';
    }
}

return [
    /*
    |--------------------------------------------------------------------------
    | Modals Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the paginator library to build
    | the simple pagination links. You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    'netsave_text' => 'You are about creating this network.\nDo you really want to create the network?',
    'netedit_text' => 'You are about editing this network.\nDo you really want to update the network?',
    'netdel_text' => 'You are about deleting this network.\nDo you really want to delete the network?',

    'zonesave_text' => 'Do you really want to create this zone?',
    'zoneedit_text' => 'Do you really want to update this zone?',
    'zonedel_text' => 'Do you really want to delete this zone?',

    'instsave_text' => 'Do you really want to create this institution?',
    'instedit_text' => 'Do you really want to update this institution?',
    'instdel_text' => 'Do you really want to delete this institution?',

    'bransave_text' => 'Do you really want to create this branch?',
    'branedit_text' => 'Do you really want to update this branch?',
    'brandel_text' => 'Do you really want to delete this branch?',

    'usersave_text' => 'Do you really want to create this user?',
    'useredit_text' => 'Do you really want to update this user?',
    'userdel_text' => 'Do you really want to delete this user?',

    'counsave_text' => 'You are about creating this country.\nDo you really want to create the country?',
    'counedit_text' => 'You are about editing this country.\nDo you really want to update the country?',
    'coundel_text' => 'You are about deleting this country.\nDo you really want to delete the country?',

    'open_text'     => 'Do you want to open the till',
    'close_text'     => 'Do you want to close the till',
    'reopen_text'     => 'Do you want to reopen the till',
    'recfund_text' => 'Do you want to send funds to the till',
    'emisfund_text' => 'Do you want to transmit funds to the till',
    'memsave_text' => 'Do you want to save this new ' . $member,
    'memreg_text' => 'Do you want to register this new ' . $member,
    'cashfrbank_text' => 'Do you want to save this transaction',
    'cashtobank_text' => 'Do you want to save this transaction',
    'monexc_text' => 'Do you want to exchange this money',
    'opendate_text' => 'Do you want to open this date',
    'closedate_text' => 'Do you want to close this date',
    'adjdate_text' => 'Do you want to adjust this date',
    
    'ocin_text' => 'Do you want to save this transaction',
    'ocout_text' => 'Do you want to save this transaction',

    'opesave_text' => 'Do you want to save this operation',
    'opeedit_text' => 'Do you want to edit this operation',
    'opedel_text' => 'Do you want to delete this operation',

    'cassave_text' => 'Do you want to save this cash',
    'casedit_text' => 'Do you want to edit this cash',
    'casedel_text' => 'Do you want to delete this cash',

    'bansave_text' => 'Do you want to save this bank',
    'banedit_text' => 'Do you want to edit this bank',
    'banedel_text' => 'Do you want to delete this bank',

    'backup_text' => 'Do you want to create a new backup?',
    'backupdel_text' => 'Do you want to delete this backup?',
    'backupdow_text' => 'Do you want to download this backup?',

    'userfree' => 'Do you want to set this user free?',
    'userblock' => 'Do you want to block this user?',

    'userres_text' => 'Reset User Credentials?',
    'userblun_text' => 'Do you want to block this user?',
    'accpdel' => 'Do you want to delete this account plan?',
    'logout_text' => 'Do you want to sign out?',
    'coldel_text' => 'Are you sure you want to delete this collector?',
    'curdel_text' => 'Delete this currency?',
    'cursave_text' => 'Add Currency?',
    'curedit_text' => 'Do you want to edit this currency?',
    'regsave_text' => 'Add Region?',
    'regedit_text' => 'Edit Region?',
    'regdel_text' => 'Delete Region?',
    'divsave_text' => 'Add a division?',
    'divdel_text' => 'Delete Division?',
    'divedit_text' => 'Edit this Division?',
    'subdivsave_text' => 'Add Sub-division?',
    'subdivedit_text' => 'Edit Sub-division?',
    'subdivdel_text' => 'Delete Sub-division?',
    'townsave_text' => 'Add Town?',
    'townedit_text' => 'Edit Town?',
    'towndel_text' => 'Delete Division?',
    'devicesave_text' => 'Add device?',
    'deviceedit_text' => 'Edit Device Credentials?',
    'devicedel_text' => 'Delete Device',
    'profsave_text' => 'Add Profession?',
    'profedit_text' => 'Edit Profession?',
    'profdel_text' => 'Delete this profession?',
    'repfunderror_text' => 'Please input the amount you want to save',
    'repfund_text' => 'Are you sure you want to replenish fund?',
    'cinerror_text' => 'Please select a customer and perform an operation',
    'cin_text' => 'Do you want to save this cash?',
    'monexcerror_text' => 'Please perform an operation',
    'memregerror_text' => 'An error occurred. Please try filling the form again',
    'couterror_text' => 'Please perform an operation',
    'regulcash_text' => 'Are you sure you want to regularise this cash',
    'brpedit_text' => 'Do you want to edit branch parameter',
    'colledit_text' => 'Do you want to update credentials of this collector?',
    'collsave_text' => 'Do you want to create a new collector?',
    'casdel_text' => 'Do you want to delete this till?',

    'yes' => 'Yes',
    'no' => 'No',
];
