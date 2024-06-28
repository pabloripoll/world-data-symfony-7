<?php

namespace App\Support;

class Date
{
    /**
     * Laravel
     */

    /**
     * Custom
     */
    public static function normalizeDateEsOutput(string $date): string
    {
        return date('d-m-Y', strtotime($date));
    }

}
