<?php

if (!function_exists('number_format_short')) {
    function number_format_short($n)
    {
        if ($n >= 1000000) {
            return round($n / 1000000, 1) . 'M';
        }
        if ($n >= 1000) {
            return round($n / 1000, 1) . 'k';
        }
        return $n;
    }
}
