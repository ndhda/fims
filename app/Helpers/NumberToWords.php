<?php

namespace App\Helpers;

class NumberToWords
{
    public static function convert($number)
    {
        // This function converts a numeric value to words.
        $words = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
        return ucfirst($words->format($number));
    }
}
