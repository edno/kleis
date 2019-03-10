<?php

namespace App\Lib;

function mb_normalise($string)
{
    $string = html_entity_decode(
        preg_replace(
            '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i',
            '$1',
            htmlentities($string)
        ),
        ENT_QUOTES,
        'UTF-8'
    );
    return preg_replace('/[^A-z0-9]/', '_', mb_strtolower($string));
}
