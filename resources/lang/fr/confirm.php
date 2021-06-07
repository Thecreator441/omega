<?php

use Illuminate\Support\Facades\Session;

$member = 'Membre';

if (Session::exists('employee')) {
    $emp = Session::get('employee');

    if ($emp->collector !== null) {
        $member = 'Client';
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

    'netsave_text' => 'VOULEZ-VOUS VRAIMENT ENREGISTRER CE RESEAU?',
    'netedit_text' => 'VOULEZ-VOUS VRAIMENT MODIFIER CE RESEAU?',
    'netdel_text' => 'VOULEZ-VOUS VRAIMENT SUPPRIMER CE RESEAU?',
    
    'zonesave_text' => 'VOULEZ-VOUS VRAIMENT ENREGISTRER CETTE ZONE?',
    'zoneedit_text' => 'VOULEZ-VOUS VRAIMENT MODIFIER CETTE ZONE?',
    'zonedel_text' => 'VOULEZ-VOUS VRAIMENT SUPPRIMER CETTE ZONE?',
    
    'instsave_text' => 'VOULEZ-VOUS VRAIMENT ENREGISTRER CETTE INSTITUTION?',
    'instedit_text' => 'VOULEZ-VOUS VRAIMENT MODIFIER CETTE INSTITUTION?',
    'instdel_text' => 'VOULEZ-VOUS VRAIMENT SUPPRIMER CETTE INSTITUTION?',
    
    'bransave_text' => 'VOULEZ-VOUS VRAIMENT ENREGISTRER CETTE AGENCE?',
    'branedit_text' => 'VOULEZ-VOUS VRAIMENT MODIFIER CETTE AGENCE?',
    'brandel_text' => 'VOULEZ-VOUS VRAIMENT SUPPRIMER CETTE AGENCE?',
    
    'usersave_text' => 'VOULEZ-VOUS VRAIMENT ENREGISTRER CET UTILISATEUR?',
    'useredit_text' => 'VOULEZ-VOUS VRAIMENT MODIFIER CET UTILISATEUR?',
    'userdel_text' => 'VOULEZ-VOUS VRAIMENT SUPPRIMER CET UTILISATEUR?',


    'open_text' => 'Voulez-vous ouvrir la caisse',
    'close_text' => 'Voulez-vous fermer la caisse',
    'reopen_text'     => 'Voulez-vous reouvrir cette caisse',
    'recfund_text' => 'Voulez-vous envoyer les fonds a la caisse',
    'emisfund_text' => 'Voulez-vous émêttre les fonds a la caisse',
    'memsave_text' => 'Voulez-vous enregistrer ce nouveau ' . $member,
    'memreg_text' => 'Voulez-vous inscrire ce nouveau ' . $member,
    'cashfrbank_text' => 'Voulez-vous enregistrer cette transaction',
    'cashtobank_text' => 'Voulez-vous enregistrer cette transaction',
    'monexc_text' => 'Voulez-vous échanger cette monnaie',
    'opendate_text' => 'Voulez-vous ouvrir cette date',
    'closedate_text' => 'Voulez-vous fermer cette date',
    'adjdate_text' => 'Voulez-vous adjuster cette date',
    'ocin_text' => 'Voulez-vous enregistrer cette transaction',
    'ocout_text' => 'Voulez-vous enregistrer cette transaction',
    'opesave_text' => 'Voulez-vous enregistrer cette opération',
	'opeedit_text' => 'Voulez-vous enregistrer cette opération',
	'opedel_text' => 'Voulez-vous enregistrer cette opération',
    'cassave_text' => 'Voulez-vous enregistrer cette caisse',
    'casedit_text' => 'Voulez-vous enregistrer cette caisse',
    'casedel_text' => 'Voulez-vous enregistrer cette caisse',
    'bansave_text' => 'Voulez-vous enregistrer cette banque',
    'banedit_text' => 'Voulez-vous enregistrer cette banque',
    'banedel_text' => 'Voulez-vous enregistrer cette banque',

    'userres_text' => 'Réinitialiser les informations d\'identification de l\'utilisateur?',
    'userblun_text' => 'Voulez-vous bloquer cet utilisateur?',
    'accpdel' => 'Voulez-vous supprimer ce plan de compte?',
    'logout_text' => 'Voulez-vous vous déconnecter?',
    'coldel_text' => 'Voulez-vous vraiment supprimer ce collecteur?',
    'curdel_text'=> 'Supprimer cette devise?',
    'cursave_text' => 'Ajouter une devise?',
    'curedit_text' => 'Voulez-vous modifier cette devise?',
    'coundel_text' => 'Supprimer le pays?',
    'counsave_text' => 'Ajouter ce pays?',
    'counedit_text' => 'Voulez-vous modifier ce pays?',
    'regsave_text' => 'Ajouter une région?',
    'regedit_text' => 'Modifier une région?',
    'regdel_text' => 'Supprimer une région?',
    'divsave_text' => 'Ajouter un département?',
    'divdel_text' => 'Supprimer un département?',
    'divedit_text' => 'Modifier un département?',
    'subdivsave_text' => 'Ajouter un arrondissement?',
    'subdivedit_text' => 'Modifier un arrondissement?',
    'subdivdel_text' => 'Supprimer un arrondissement?',
    'townsave_text' => 'Ajouter une ville?',
    'townedit_text' => 'Modifier une ville?',
    'towndel_text' => 'Supprimer une ville?',
    'devicesave_text' => 'Ajouter un appareil?',
    'deviceedit_text' => 'Modifier les informations d\'identification de l\'appareil?',
    'devicedel_text' => 'Supprimer un appareil?',
    'profsave_text' => 'Ajouter une profession?',
    'profedit_text' => 'Modifier une profession?',
    'profdel_text' => 'Supprimer une profession?',

    'yes' => 'Oui',
    'no' => 'Non',
];
