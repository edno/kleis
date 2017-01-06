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

    'accepted'             => ':attribute muss sich hingenommen.',
    'active_url'           => ':attribute ist keine gültige URL.',
    'after'                => ':attribute nach dem Datum :date muss.',
    'alpha'                => ':attribute darf nur aus Buchstabe bestehen.',
    'alpha_dash'           => ':attribute darf nur aus Buchstabe, Ziffern und Strich bestehen.',
    'alpha_num'            => ':attribute darf nur aus Buchstabe und Ziffern bestehen.',
    'array'                => ':attribute muss sich ein Array.',
    'before'               => ':attribute vor dem Datum :date muss.',
    'between'              => [
        'numeric' => ':attribute muss sich zwischen :min und :max.',
        'file'    => ':attribute muss sich zwischen :min und :max Kilobytes.',
        'string'  => ':attribute muss sich zwischen :min und :max Zeichen.',
        'array'   => ':attribute muss sich zwischen :min und :max Elementen.',
    ],
    'boolean'              => ':attribute Wahr oder Falsch eingestellt werden.',
    'confirmed'            => ':attribute Bestätigung stimmt nicht überein.',
    'date'                 => ':attribute ist keine gültige Datum.',
    'date_format'          => ':attribute passt nichtas Format :format.',
    'different'            => ':attribute und :other muss anders sein.',
    'digits'               => ':attribute muss mindestens :digits Ziffern.',
    'digits_between'       => ':attribute muss sich zwischen :min und :max Ziffern.',
    'dimensions'           => ':attribute ist keine gültige Bildgröße.',
    'distinct'             => ':attribute hat einen doppelten Wert.',
    'email'                => ':attribute ist keine gültige Email Adresse.',
    'exists'               => 'Gewählte :attribute ist ungültige.',
    'file'                 => ':attribute eine Datei seinen muss.',
    'filled'               => ':attribute Feld ist erforderlich.',
    'image'                => ':attribute ein Bild seinen muss.',
    'in'                   => 'Gewählte :attribute ist ungültige.',
    'in_array'             => ':attribute auf :other nicht existiert.',
    'integer'              => ':attribute eine Zahl seinen muss.',
    'ip'                   => ':attribute muss sich eine gültige IP-Adresse.',
    'json'                 => ':attribute muss sich ein gültige JSON-String.',
    'max'                  => [
        'numeric' => ':attribute darf nicht mehr als :max.',
        'file'    => ':attribute darf nicht mehr als :max Kilobytes.',
        'string'  => ':attribute darf nicht mehr als :max Zeichen.',
        'array'   => ':attribute darf nicht mehr als :max Elementen.',
    ],
    'mimes'                => ':attribute muss sich um eine Datei des Typs: :values.',
    'min'                  => [
        'numeric' => ':attribute darf mindestens :min.',
        'file'    => ':attribute darf mindestens :min Kilobytes.',
        'string'  => ':attribute darf mindestens :min Zeichen.',
        'array'   => ':attribute darf mindestens :min Elementen.',
    ],
    'not_in'               => 'Gewählte :attribute ist ungültige.',
    'numeric'              => ':attribute muss sich ein Ziffern.',
    'present'              => ':attribute Feld muss vorhanden.',
    'regex'                => ':attribute ist keine gültige Format.',
    'required'             => ':attribute Feld ist erforderlich.',
    'required_if'          => ':attribute Feld ist erforderlich sofern :other ist :value.',
    'required_unless'      => ':attribute Feld ist erforderlich sofern nicht :other in :values ist.',
    'required_with'        => ':attribute Feld ist erforderlich sofern :values vorhanden sind.',
    'required_with_all'    => ':attribute Feld ist erforderlich sofern :values vorhanden sind.',
    'required_without'     => ':attribute Feld ist erforderlich sofern nicht :values vorhanden sind.',
    'required_without_all' => ':attribute Feld ist erforderlich sofern kein :values vorhanden sind.',
    'same'                 => ':attribute und :other müssen übereinstimmen.',
    'size'                 => [
        'numeric' => ':attribute muss sich :size.',
        'file'    => ':attribute muss sich :size Kilobytes.',
        'string'  => ':attribute muss sich :size Zeichen.',
        'array'   => ':attribute must enthalten :size Elementen.',
    ],
    'string'               => ':attribute muss sich ein String.',
    'timezone'             => ':attribute eine gültige Zeitzone.',
    'unique'               => ':attribute bereits vergeben ist.',
    'url'                  => ':attribute ist keine gültige URL.',

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
