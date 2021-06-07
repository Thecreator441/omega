<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Le :attribute doit être accepté.',
    'active_url'           => 'Le :attribute n\'est pas une URL valide.',
    'after'                => 'Le :attribute doit être une date après :date.',
    'after_or_equal'       => 'Le :attribute doit être une date après ou égale à :date.',
    'alpha'                => 'Le :attribute ne peut contenir que des lettres.',
    'alpha_dash'           => 'Le :attribute ne peut contenir que des lettres, des chiffres et des tirets.',
    'alpha_num'            => 'Le :attribute ne peut contenir que des lettres et des chiffres.',
    'array'                => 'Le :attribute doit être un tableau.',
    'before'               => 'Le :attribute doit être une date avant :date.',
    'before_or_equal'      => 'Le :attribute doit être une date antàrieure ou égale à :date.',
    'between'              => [
        'numeric' => 'Le :attribute Doit être entre :min et :max.',
        'file'    => 'Le :attribute Doit être entre :min et :max kilo-octets.',
        'string'  => 'Le :attribute Doit être entre :min et :max caractéres.',
        'array'   => 'Le :attribute doit avoir entre :min et :max articles.',
    ],
    'boolean'              => 'Le :attribute champ doit être vrai ou faux.',
    'confirmed'            => 'Le :attribute confirmation ne correspond pas.',
    'date'                 => 'Le :attribute n\'est pas une date valide.',
    'date_format'          => 'Le :attribute ne correspond pas au format :format.',
    'different'            => 'Le :attribute et :other doit être différent.',
    'digits'               => 'Le :attribute doit être :digits chiffres.',
    'digits_between'       => 'Le :attribute doit être entre :min et :max chiffres.',
    'dimensions'           => 'Le :attribute a des dimensions d\'image non valides.',
    'distinct'             => 'Le :attribute champ a une valeur en double.',
    'email'                => 'Le :attribute doit être une adresse e-mail valide.',
    'exists'               => 'Le selectionné :attribute est invalide.',
    'file'                 => 'Le :attribute doit être un fichier.',
    'filled'               => 'Le :attribute champ doit avoir une valeur.',
    'image'                => 'Le :attribute doit être une image.',
    'in'                   => 'Le :attribute selectionné est invalide.',
    'in_array'             => 'Le :attribute champ n\'existe pas dans :other.',
    'integer'              => 'Le :attribute doit être un entier.',
    'ip'                   => 'Le :attribute doit être une adresse IP valide.',
    'ipv4'                 => 'Le :attribute doit être une adresse IPv4 valide.',
    'ipv6'                 => 'Le :attribute doit être une adresse IPv6 valide.',
    'json'                 => 'Le :attribute doit être une chaîne JSON valide.',
    'max'                  => [
        'numeric' => 'Le :attribute ne peut pas être supérieur à :max.',
        'file'    => 'Le :attribute ne peut pas être supérieur à :max kilo-octets.',
        'string'  => 'Le :attribute ne peut pas être supérieur à :max caractéres.',
        'array'   => 'Le :attribute peut ne pas avoir plus de :max articles.',
    ],
    'mimes'                => 'Le :attribute doit être un fichier de type: :values.',
    'mimetypes'            => 'Le :attribute doit être un fichier de type: :values.',
    'min'                  => [
        'numeric' => 'Le :attribute doit être au moins :min.',
        'file'    => 'Le :attribute doit être au moins :min kilo-octets.',
        'string'  => 'Le :attribute doit être au moins :min caractéres.',
        'array'   => 'Le :attribute doit avoir au moins :min articles.',
    ],
    'not_in'               => 'Le selectionné :attribute est invalide.',
    'numeric'              => 'Le :attribute doit être un nombre.',
    'present'              => 'Le :attribute champ doit être présent.',
    'regex'                => 'Le :attribute format est invalide.',
    'required'             => 'Le :attribute champ requis.',
    'required_if'          => 'Le :attribute champ est requis lorsque :other est :value.',
    'required_unless'      => 'Le :attribute champ est obligatoire sauf si :other est dans :values.',
    'required_with'        => 'Le :attribute champ est requis lorsque :values est présent.',
    'required_with_all'    => 'Le :attribute champ est requis lorsque :values est présent.',
    'required_without'     => 'Le :attribute champ est requis lorsque :values est absent.',
    'required_without_all' => 'Le :attribute champ est requis lorsqu\'aucun des :values sont présentes.',
    'same'                 => 'Le :attribute et :other doivent correspondre.',
    'size'                 => [
        'numeric' => 'Le :attribute doit être :size.',
        'file'    => 'Le :attribute doit être :size kilo-octets.',
        'string'  => 'Le :attribute doit être :size caractéres.',
        'array'   => 'Le :attribute doit contenir :size articles.',
    ],
    'string'               => 'Le :attribute doit être une chaîne.',
    'timezone'             => 'Le :attribute doit être une zone valide.',
    'unique'               => 'Le :attribute a dêjà étè pris.',
    'uploaded'             => 'Le :attribute a échoué d\'envoyer.',
    'url'                  => 'Le :attribute format est invalide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
