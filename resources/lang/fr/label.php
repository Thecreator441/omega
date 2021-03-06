<?php

use Illuminate\Support\Facades\Session;

$member = 'Membre';
$newmem = 'Nouveau Membre';
$mempic = 'Profile Membre';
$memsign = 'Signature Membre';

if (Session::exists('employee')) {
    $emp = Session::get('employee');

    if ($emp->collector !== null) {
        $member = 'Client';
        $newmem = 'Nouveau Client';
        $mempic = 'Profile Client';
        $memsign = 'Signature Client';
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
    'file' => 'Fichiers',
    'home' => 'Accueil',
    'session' => 'Séssion',
	'alert' => 'Alerte!',
	'eng' => 'Anglais',
	'fr' => 'Français',
    'name' => 'Noms',
    'username' => 'Noms d\'Utilisateur',
    'password' => 'Mot de Passe',
    'login' => 'S\'identifier',
    'signin' => 'Connecter',
    'reconnect' => 'Reconnecter',
    'account' => 'Compte',
    'cash' => 'Caisse',
    'misacc' => 'Compte Manquant',
    'excacc' => 'Compte Excédent',
    'code' => 'Code',
    'labelfr' => 'Libellè(Fr)',
    'sloganfr' => 'Slogan(Fr)',
    'deblabfr' => 'Libellè Débit(Fr)',
    'credlabfr' => 'Libellè Crédit(Fr)',
    'labeleng' => 'Libellè(En)',
    'sloganeng' => 'Slogan(En)',
    'deblabeng' => 'Libellè Débit(En)',
    'credlabeng' => 'Libellè Crédit(En)',
    'value' => 'Valeur',
    'format' => 'Format',
    'currency' => 'Devise',
    'employee' => 'Employé',
    'break' => 'Billetage',
    'label' => 'Libellè',
    'in' => 'Entrée',
    'out' => 'Sortie',
    'amount' => 'Montant',
    'letters' => 'Montant en Lettres',
    'tobreak' => 'Total Billetage',
    'totrans' => 'Total Transaction',
    'diff' => 'Différence',
    'register' => 'Inscrit',
    'represent' => 'Représentant',
    'notes' => 'Billets',
    'coins' => 'Pièces',
    'gacc' => 'Compte Général',
    'infbanpart' => 'Informations Banque Partenaire ',
    'ouracc' => 'Nôtre Compte',
    'manager' => 'Gestionnaire',
    'phone' => 'Téléphone',
    'fax' => 'Fax',
    '@' => 'E-Mail',
    'country' => 'Pays',
    'region' => 'Région',
    'subdiv' => 'Arrondis',
    'town' => 'Ville',
    'address' => 'Addresse',
    'infintman' => 'Informations Gestion Interne',
    'theiracc' => 'Leur Compte',
    'checasacc' => 'Compte Chèque à Encaisser',
    'corecacc' => 'Compte Enc Correspondant',
    'cheaccre' => 'Compte Chèque à Crédit',
    'postal' => 'Boite Postal',
    'cashopen' => 'Ouverture Caisse',
    'cashfr' => 'Caisse Emis',
    'cashto' => 'Caisse Vers',
    'opera' => 'Opération',
    'period' => 'Période',
    'to' => 'Au',
    'from' => 'Du',
    'cashier' => 'Caissier',
    'gen' => 'Général',
    'foroper' => 'Opérations Forcé',
    'refer' => 'Réference',
    'accno' => 'N° Compte',
    'accdes' => 'Description Compte',
    'trades' => 'Description Transaction',
    'debt' => 'Débit',
    'credt' => 'Crédit',
    'tradate' => 'Date Transaction',
    'valdate' => 'Date Valuer',
    'total' => 'Total',
    'aux' => 'Auxilliaire',
    'date' => 'Date',
    'operdate' => 'Date Opération',
    'balance' => 'Solde',
	'accdate' => 'Date Comptable',
	'desc' => 'Description',
	'procedure' => 'Procédures',
	'execstat' => 'État D\'éxecution',
    'status' => 'État',
    'reason' => 'Raison',
    'sitprevval' => 'Situation Prévisionnelle de Validation',
    'refnonval' => 'Références Non Validables',
    'member' => $member,
    'time' => 'Heure',
	'surname' => 'Prénoms',
	'dob' => 'Naissance',
	'at' => 'À',
	'gender' => 'Genre',
	'male' => 'Masculin',
	'female' => 'Feminin',
	'marstatus' => 'État Civile',
	'civilty' => 'Civilité',
	'married' => 'Marié',
	'single' => 'Célibataire',
	'divorced' => 'Divorcé',
	'widow' => 'Veuve',
	'others' => 'Autres',
	'cnps' => 'CNPS',
	'prof' => 'Profession',
	'deliver' => 'Délivrée',
	'mempic' => 'Photo du Membre',
	'memsign' => 'Signature du Membre',
	'memsign1' => '1<sup>er</sup> Signature du Membre',
	'memsign2' => '2<sup>eme</sup> Signature du Membre',
	'memsign3' => '3<sup>eme</sup> Signature du Membre',
	'street' => 'Rue',
	'quarter' => 'Quartier',
	'memtype' => 'Type de Membre',
	'physic' => 'Physique',
	'assoc' => 'Association',
	'enterp' => 'Enterprise',
	'taxpayno' => 'N° Contribuable',
	'regist' => 'Registre',
	'regim' => 'Regime',
	'nxtofkin' => 'Bénéficiare',
	'nam&sur' => 'Noms et Prénoms',
	'relation' => 'Rélation',
	'ratio' => 'Proportion',
	'witnes' => 'Temoin',
    'remain' => 'Restant',
	'grptype' => 'Type de Groupe',
	'assoctype' => 'Type d\'Association',
	'assmemno' => 'N° de Membres',
	'assnumb' => 'N° Association',
	'user' => 'Utilisateur',
    'totdist' => 'Distribution Total',
	'checkno' => 'N° Chèque',
	'bank' => 'Banque',
	'carrier' => 'Porteur',
	'memotacc' => 'Autre Compte Membre',
	'entitle' => 'Entitle',
	'fines' => 'Amande',
	'finint' => 'Intérêt Amande',
	'fees' => 'Frais',
	'late' => 'Retard',
	'retint' => 'Intérêt Retard',
	'totint' => 'Total Intérêt',
	'payment' => 'Paiement',
	'intpay' => 'Paiement Intérêt',
	'interest' => 'Intérêt',
	'memloanacc' => 'Compte Prêt Membre',
	'ldnumb' => 'N° LD',
	'title' => 'Titre',
	'loanacc' => 'Compte Prêt',
	'available' => 'Disponible',
	'penalty' => 'Penalité',
	'checktype' => 'Type Chèque',
	'checkserie' => 'Series Chèque',
	'checkid' => 'ID Chèque',
	'benef' => 'Beneficiaire',
	'loaninf' => 'Infos Prêt',
	'diffloan' => 'Différé sur Prêt',
	'amort' => 'Amortissement',
	'noinstal' => 'N° d\'Écheance',
	'taxrate' => 'Taux Taxe',
	'monintrate' => 'Taux Intérêt Mensuelle',
	'inst1' => '1<sup>er</sup> Écheance',
	'capital' => 'Capital',
	'install' => 'Écheance',
	'instdate' => 'Date Écheance',
	'ann+tax' => 'Annuité + Taxe',
	'tax' => 'Taxe',
	'annuity' => 'Annuité',
	'periodicity' => 'Périodicité',
    'al_period' => 'Toute Période',
	'daily' => 'J : JOURNALIERE',
	'weekly' => 'H : HEBDOMADAIRE',
	'bimens' => 'B : BIMENSUELLE',
	'mens' => 'M : MENSUELLE',
	'trim' => 'T : TRIMESTRIELLE',
	'sem' => 'S : SEMESTRIELLE',
	'ann' => 'A : ANNUELLE',
	'day1' => '1 JOUR',
	'week1' => '1e SEMAINE',
	'mon1/2' => '2 SEMAINES',
	'mon1' => '1 MOIS',
	'trim1' => '1 TRIMESTRE',
	'sem1' => '1 SEMESTRE',
	'ann1' => '1e ANNÉE',
	'constamort' => 'C : AMORTISSEMENT CONSTANTE',
	'digramort' => 'D : AMORTISSEMENT DEGRESSIVE',
	'regramort' => 'R : AMORTISSEMENT REGRESSIVE',
	'varamort' => 'V : AMORTISSEMENT VARIABLE',
	'grace' => 'Période Grace',
	'loan_type' => 'Type Prêt',
	'loan_per' => 'Période Prêt',
	'max_dur' => 'Durée Max',
	'max_amt' => 'Montant Max',
	'inst_pen_day_space' => 'Écart Jour Éch et Pén',
	'int_paid_acc' => 'Compte Paiement Intérêt',
	'loan_accc' => 'Schema Compte Prêt',
    'loan_acc' => 'Compte Prêt',
	'seicomaker' => 'Saisie Compte Avalistes ' . $member,
	'yes' => 'Oui',
	'no' => 'Non',
	'block_acc' => 'Blockage Comptes',
	'none' => 'Aucun',
	'mem_acc' => 'Compte Membre Seul',
	'mem&co' => 'Membre et Avalistes',
	'pay_tax' => 'Paiement Taxe',
	'tax_acc' => 'Compte Taxe',
	'use_quod' => 'Utilisation Quodité',
	'pen_req' => 'Demande Pénalité',
	'pen_acc' => 'Compte Pénalité',
	'loan_off' => 'Officier du Crédit',
	'loan_amt' => 'Montant Prêt',
	'loan_pur' => 'Bût Prêt',
	'guarant' => 'Guarantie',
	'oguarant' => 'Autre Guarantie',
	'comake' => 'Avaliste',
	'loan_no' => 'N° Prêt',
	'block_amt' => 'Montant Blocké',
	'com_acc' => 'Compte Avaliste',
	'com_amt' => 'Montant Avaliste',
	'savings' => 'ÉPARGNE',
	'salary' => 'SALAIRE',
	'trans_acc' => 'Compte Transit',
	'authority' => 'Authorité',
	'loan_dem' => 'Prêts Demandé',
	'loan_app' => 'Prêts Approuvé',
	'ref_by' => 'Refinancé Par',
	'sav_fac' => 'Facilité Retrait Épargne',
	'res_by' => 'Restructuré Par',
	'open_bal' => 'Opening Balance',
	'col4' => 'Quatre Colons',
	'col6' => 'Six Colons',
	'availsavs' => 'Épargne Disponible',
	'fin' => 'Financière',
	'morg' => 'Hypothèque',
	'fin&morg' => 'Financière et Hypothèque',
	'nature' => 'Nature',
	'dem_amt' => 'Montant Demandé',
	'app_amt' => 'Montant Approuvé',
	'coporal' => 'Corporelle',
	'material' => 'Material',
	'meuble' => 'Meuble',
    'immeuble' => 'Immeuble',
	'imeuble' => 'Imeuble',
	'allloan' => 'Tout les Prêts',
	'cloloan' => 'Prêts Cloturé',
	'rem_amt' => 'Montant Restant',
	'new_amt' => 'Nouveau Montant',
	'blocked' => 'Bloqué',
	'mem_accs' => 'Comptes du Membre',
	'rejloan' => 'Prêts Rejété',
	'all' => 'Tout',
	'idplan' => 'ID Plan',
	'acctype' => 'Type Compte',
	'accint' => 'Intérêt Accumulé',
	'summary' => 'Résumé',
	'par3' => 'PAR 30',
	'par6' => 'PAR 60',
	'cats' => 'Catégories',
	'current' => 'Courant',
	'noloanout' => 'Nombre de Prêts en Cours',
	'totnumb' => 'Nombre Total',
	'amtloanout' => 'Montant de Prêts en Cours',
	'totamt' => 'Montant Total',
	'delamt' => 'Montant Délinquant',
	'group' => 'Groupe',
	'p30rate' => 'TAUX DE DÉLINQUANCE',
	'p60rate' => 'TAUX DE DÉLINQUANCE',
	'creadate' => 'Date Création',
	'jurform' => 'Forme Juridique',
	'liveper' => 'Durée de Vie',
	'loanage' => 'Age Prêt',
	'risk' => 'Risque',
	'provi' => 'Provision',
	'days' => 'Jours',
	'loan' => 'Prêt',
	'newnet' => 'Nouveau Réseaux',
	'newzone' => 'Nouvelle Zone',
	'newinst' => 'Nouvelle Institution',
	'newbran' => 'Nouvelle Agence',
	'category' => 'Categorie',
	'edit' => 'Modifier',
	'delete' => 'Effacer',
	'mfi1' => '1<sup>er</sup> Categorie',
	'mfi2' => '2<sup>eme</sup> Categorie',
	'mfi3' => '3<sup>eme</sup> Categorie',
	'abbr'=> 'Abbréviation',
	'cashman' => 'Cash Management System',
	'accrman' => 'Accrual Management System',
	'strategy' => 'Strategie',
	'zone' => 'Zone',
	'instlogo' => 'Logo de l\'Institution',
	'slogan' => 'Slogan',
	'pcode' => 'Code Plan',
	'soldmin' => 'Solde Minimum',
	'class' => 'Classe',
	'engage' => 'Engagement',
	'second' => 'Secondaire',
	'type' => 'Type',
	'adm_amort_acc' => 'Admet Compte Amortissement',
	'cont_debt' => 'Contrôle Débit',
	'calc_comm' => 'Calcul Commission',
	'bala_group' => 'Grouper Balance',
	'bila_group' => 'Grouper Bilan',
	'calc_int' => 'Calcul Intérêt',
	'cont_fron_inpu' => 'Contrôle Saisi Frontoffice',
    'min_balance' => 'Solde Minimum',
    'plan_code' => 'Code Plan',
	'openfee' => 'Frais Ouverture',
	'closefee' => 'Frais Fermeture',
	'accont' => 'Compte Contrepartie',
	'minim' => 'Minimum',
	'minimum' => 'Minimum',
	'commis' => 'Commision',
	'highover' => '+Fort Découvert',
	'move' => 'Mouvement',
	'rate' => 'Taux',
	'debitor' => 'Débiteur',
	'creditor' => 'Créditeur',
	'penwith' => 'Pénalité sur Retrait',
	'params' => 'Parametres',
	'newaccp' => 'Nouveau Plan Comptable',
	'institution' => 'Institution',
	'startdel' => 'Début Délinquance',
	'dormem' => $member . ' Dormant',
	'budget_line' => 'Ligne Budgetaire',
	'budget_exp' => 'Budget d\'Exploitation',
	'budget_inv' => 'Budget d\'Investissement',
	'branch' => 'Agence',
	'service' => 'Service',
	'direction' => 'Direction',
    'nocust' => 'N° de Clients',
    'active' => 'Active',
    'inactive' => 'Inactive',
    'nobenef' => 'N° de Beneficiaire',
    'level' => 'Niveau',
    'per'=> 'Pourcentage',
    'tab'=> 'Tableau',
    'compay'=> 'Paiement Collecteur',
    'editpass' => 'Modifier vore Mot de Passe',
    'isocode' => 'Code ISO',
    'phonecode' => 'Code Téléphonique',
    'regorigin' => 'Reg d\'Origine',
    'custcode' => 'Code Client',
    'type_name' => 'Type d\'Appareille',
    'newdevice' => 'Nouvelle Appareille',
    'dev_name' => 'Noms de l\'Appareille',
    'owner' => 'Proprietaire',
    'assigned' => 'Utilisé',
    'device' => 'Appareille',
    'not_assigned' => 'Non Assigné',
    'tablet' => 'Tablet',
    'computer' => 'Ordinateur',
    'smart' => 'SmartPhone',
    'post' => 'Poste',
    'newmem' => $newmem,
    'number' => 'Numero',
    'client_acc' => 'Compte Client',
    'collect_acc' => 'Compte Colecteur',
    'inst_acc' => 'Compte Institution',
    'revenue_acc' => 'Compte Commission',
    'pay_revenue_acc' => 'Compte Paiement Commission',
    'tax_acc' => 'Compte Tax',
    'collector' => 'Collecteur',
    'col_com' => 'Commission Collecteur',
    'inst_com' => 'Commission Institution',
    'accnum' => 'N° Compte',
    'per_rate' => 'Taux Commission',
    'bran_param' => 'Parametre Agence',
    'inst_param' => 'Parametre Institution',
    'month' => 'Mois',
    'jan' => 'Janvier',
    'feb' => 'Fervrier',
    'mar' => 'Mars',
    'apr' => 'Avril',
    'may' => 'Mai',
    'jun' => 'Juin',
    'jul' => 'Juillet',
    'aug' => 'Août',
    'sep' => 'Septembre',
    'oct' => 'Octobre',
    'nov' => 'Novembre',
    'dec' => 'Decembre',
    'newuser' => 'Nouveau Utilisateur',
    'privilege'=>  'Privilege',
    'division' => 'Département',
    'idcard' => 'Carte National d\'Identité',
    'custnam&sur' => 'Noms Client',
    'organ' => 'Organ',
    'admin' => 'Administrateur',
    'host' => 'Hoteur',
    'network' => 'Réseau',
    'newcur' => 'Nouvelle Dévise',
    'newcoun' => 'Nouveau Pays',
    'newreg' => 'Nouvelle Région',
    'newdiv' => 'Nouveau Département',
    'newsub' => 'Nouveau Arrondissement',
    'newtown' => 'Nouvelle Ville',
    'idnumb' => 'N° ID',
    'idtype' => 'Type ID',
    'passport' => 'Passport',
    'coll_limit' => 'Limit Retrait Collecteur',
    'newprof' => 'Nouvelle Profession',
    'genbac' => 'Sauvegarde Générale',
    'specbac' => 'Sauvegarde Spécifique',
    'new_back' => 'Nouvelle Sauvegrade',
    'no_down' => 'N° Téléchargé',
    'save' => 'Enregistrer',
    'reset' => 'Reinitialiser',
    'free' => 'Libre',
    'view' => 'Visualiser',
    'block' => 'Bloquer',
    'close' => 'Fermer',
    'print' => 'Imprimer',
    'copy' => 'Copier',
    'pdf' => 'PDF',
    'excel' => 'Excel',
    'online' => 'En Ligne',
    'offline' => 'Hors Ligne',
    'next' => 'Suivant',
    'prev' => 'Précedent',
	'comm' => 'Commission',
	'cashin_by' => 'Dépôt effectuer par',
	'cashout_by' => 'Retrait effectuer par',
	'det_inf' => 'INFORMATIONS DETAILLEES',
	'id' => 'ID',
	'newbal' => 'Nouveau Solde',
    'os_name' => 'Noms SE',
    'os_version' => 'Version SE',
    'dev_model' => 'Model',
    'mobile' => 'Mobile',
    'age' => 'Age',
    'size' => 'Taille',
    'open' => 'Ouverte',
    'iso' => 'Code ISO',
    'iso3' => 'Code ISO 3',
    'numcode' => 'N° Code',
    'os_name_vers' => 'Noms/Version SE',
    'last_date' => 'Dernier Paiement',
    'no_inst' => 'N° d\'Écheance',
    'loan_bal' => 'Solde Prêt',

	'acc_type_fr' => 'Type Compte(Fr)',
    'acc_type_eng' => 'Type Compte(En)',
    'loan_type_fr' => 'Type Prêt(Fr)',
    'loan_type_eng' => 'Type Prêt(En)',
    'loanpur_fr' => 'Bût Prêt(Fr)',
    'loanpur_eng' => 'Bût Prêt(En)',
	'acc_plan_fr' => 'Plan Comptable(Fr)',
    'acc_plan_eng' => 'Plan Comptable(En)',
    'acc_type' => 'Type Compte',
    'new_acctype' => 'Nouveau Type Compte',
	'chart' => 'Chart',
	'gl_account' => 'Compte Grand Livre',
	'platform' => 'Platforme',
    'new_bank' => 'Nouvelle Banque',
    'bank_fr' => 'Banque(Fr)',
    'bank_eng' => 'Banque(En)',
    'partner_bank_infos' => 'Informations de la Banque Partenaire',
    'internal_manage_infos' => 'Informations de Gestion Interne',
    'cash_check_acc' => 'Compte Chèque à Encaisser',
    'credit_check_acc' => 'Compte Chèque à Crédit Im.',
    'cash_corresp_check_acc' => 'Compte Encaissement Correspondant',
    'new_acc_plan' => 'Nouveau Plan Comptable',
    'new_privilege' => 'Nouveau Privilege',
    'new_loanpur' => 'Nouveau Bût Prêt',
    'privilege_fr' => 'Privilege(Fr)',
    'privilege_eng' => 'Privilege(En)',
    'new_cash' => 'Nouvelle Caisse',
    'cashacc' => 'Compte Caisse',
    'cash_fr' => 'Caisse(Fr)',
    'cash_eng' => 'Caisse(En)',
    'view_other_tills' => 'Voir Autre Caisses',
    'symbol' => 'Symbole',
    'new_menu_level_1' => 'Nouveau Menu Niveau I',
    'new_menu_level_2' => 'Nouveau Menu Niveau II',
    'new_menu_level_3' => 'Nouveau Menu Niveau III',
    'new_menu_level_4' => 'Nouveau Menu Niveau IV',
    'main_menu' => 'Main Menu',
    'icon' => 'Icon',
    'path' => 'Chemin d\'Access',
    'menu_level_1' => 'Menu Niveau I',
    'menu_level_2' => 'Menu Niveau II',
    'menu_level_3' => 'Menu Niveau III',
    'menu_level_4' => 'Menu Niveau IV',
    'menu_level_1_eng' => 'Menu Niveau I(Eng)',
    'menu_level_2_eng' => 'Menu Niveau II(Eng)',
    'menu_level_3_eng' => 'Menu Niveau III(Eng)',
    'menu_level_4_eng' => 'Menu Niveau IV(Eng)',
    'menu_level_1_fr' => 'Menu Niveau I(Fr)',
    'menu_level_2_fr' => 'Menu Niveau II(Fr)',
    'menu_level_3_fr' => 'Menu Niveau III(Fr)',
    'menu_level_4_fr' => 'Menu Niveau IV(Fr)',
    'access' => 'Access',
    'countryeng' => 'Pays(Eng)',
    'countryfr' => 'Pays(Fr)',
    'regioneng' => 'Région(Eng)',
    'regionfr' => 'Région(Fr)',
    'professioneng' => 'Profession(Eng)',
    'professionfr' => 'Profession(Fr)',
    'new_loan_type' => 'Nouveau Type Prêt',
    'view_other_users' => 'Voir Autre Utilisateurs',
    'all_members' => 'Tout les Membres',
    'paid' => 'Payés',
    'unpaid' => 'Impayés',
    'drop' => 'Déposés',
    'paid_checks' => 'Chèques Payés',
    'unpaid_checks' => 'Chèques Impayés',
    'drop_checks' => 'Chèques Déposés',



];
