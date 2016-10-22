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

    'accepted'             => ':attribute doit &ecirc;tre accept&eacute;.',
    'active_url'           => ":attribute n'est par une URL valide.",
    'after'                => ':attribute doit &ecirc;tre une date apr&egrave; :date.',
    'alpha'                => ':attribute doit seulement contenir des lettres.',
    'alpha_dash'           => ':attribute doit seulement contenir des lettres, chiffres et tirets.',
    'alpha_num'            => ':attribute doit seulement contenir des lettres et des chiffres.',
    'array'                => ':attribute doit &ecirc;tre un tableau.',
    'before'               => ':attribute doit &ecirc;tre une date avant :date.',
    'between'              => [
        'numeric' => ':attribute doit &ecirc;tre compris entre :min et :max.',
        'file'    => ':attribute doit &ecirc;tre compris entre :min et :max kilo-octets.',
        'string'  => ':attribute doit &ecirc;tre compris entre :min et :max caract&egrave;res.',
        'array'   => ':attribute doit avoir entre :min et :max &eacute;l&eacute;ments.',
    ],
    'boolean'              => 'Le champ :attribute doit &ecirc;tre vrai ou faux.',
    'confirmed'            => ':attribute confirmation ne correspond pas.',
    'date'                 => ":attribute n'est pas une date valide.",
    'date_format'          => ':attribute ne correspond pas au format :format.',
    'different'            => ':attribute et :other doivent &ecirc;tre differents.',
    'digits'               => ':attribute doit contenir :digits chiffres.',
    'digits_between'       => ':attribute doit contenir entre :min et :max chiffres.',
    'dimensions'           => ":attribute a une taille d'image invalide.",
    'distinct'             => 'Le champ :attribute a une valeur en doublon.',
    'email'                => ':attribute doit &ecirc;tre une adresse email valide.',
    'exists'               => ':attribute s&eacute;lectionn&eacute est invalide.',
    'file'                 => ':attribute doit &ecirc;tre un fichier.',
    'filled'               => 'Le champ :attribute est obligatoire.',
    'image'                => ':attribute doit &ecirc;tre une image.',
    'in'                   => ':attribute s&eacute;lectionn&eacute est invalide.',
    'in_array'             => "Le champ :attribute n'existe pas dans :other.",
    'integer'              => ':attribute doit &ecirc;tre un nombre entier.',
    'ip'                   => ':attribute doit &ecirc;tre une adresse IP valide.',
    'json'                 => ':attribute doit &ecirc;tre une cha&icirc;ne JSON valide.',
    'max'                  => [
        'numeric' => ':attribute ne doit pas &ecirc;tre plus grand que :max.',
        'file'    => ':attribute ne doit pas &ecirc;tre plus grand que :max kilo-octets.',
        'string'  => ':attribute ne doit pas &ecirc;tre plus grand que :max caract&egrave;res.',
        'array'   => ':attribute ne doit pas contenir plus de :max &eacute;l&eacute;ments.',
    ],
    'mimes'                => ':attribute un fichier de type : :values.',
    'min'                  => [
        'numeric' => ':attribute doit &ecirc;tre au moins :min.',
        'file'    => ':attribute doit &ecirc;tre au moins :min kilo-octets.',
        'string'  => ':attribute doit avoir au moins :min caract&egrave;res.',
        'array'   => ':attribute doit avoir au moins :min &eacute;l&eacute;ments.',
    ],
    'not_in'               => ':attribute s&eacute;lectionn&eacute; est invalide.',
    'numeric'              => ':attribute doit &ecirc;tre un nombre.',
    'present'              => 'Le champ :attribute doit &ecirc;tre present.',
    'regex'                => 'Le format de :attribute est invalide.',
    'required'             => 'Le champ :attribute est obligatoire.',
    'required_if'          => 'Le champ :attribute est obligatoire quand :other vaut :value.',
    'required_unless'      => 'Le champ :attribute est obligatoire sauf si :other est inclus dans :values.',
    'required_with'        => 'Le champ :attribute est obligatoire quand :values est present.',
    'required_with_all'    => 'Le champ :attribute est obligatoire quand :values est present.',
    'required_without'     => "Le champ :attribute est obligatoire quand :values n'est pas present.",
    'required_without_all' => "Le champ :attribute est obligatoire quand aucun :values n'est present.",
    'same'                 => ':attribute et :other doivent correspondre.',
    'size'                 => [
        'numeric' => ':attribute doit &ecirc;tre :size.',
        'file'    => ':attribute doit &ecirc;tre :size kilo-octets.',
        'string'  => ':attribute doit avoir :size caract&egrave;res.',
        'array'   => ':attribute doit contenir :size &eacute;l&eacute;ments.',
    ],
    'string'               => ':attribute doit &ecirc;tre une cha&icirc;ne de caract&agrave;res.',
    'timezone'             => ':attribute doit &ecirc;tre un fuseau horaire valide.',
    'unique'               => ':attribute est d&eacute;j&agrave; pris.',
    'url'                  => 'Le format de :attribute est invalide.',

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
