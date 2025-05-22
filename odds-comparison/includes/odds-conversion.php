<?php
// function ocp_fractional_to_decimal($fraction) {
//     list($num, $den) = explode('/', $fraction);
//     return round(($num / $den) + 1, 2);
// }

// function ocp_decimal_to_american($decimal) {
//     if ($decimal >= 2.0) {
//         return '+' . round(($decimal - 1) * 100);
//     } else {
//         return '-' . round(100 / ($decimal - 1));
//     }
// }

function ocp_convert_odds($odds, $from, $to) {
    if ($from === 'decimal') {
        if ($to === 'american') {
            return $odds >= 2 ? '+' . round(($odds - 1) * 100) : '-' . round(100 / ($odds - 1));
        } elseif ($to === 'fractional') {
            $numerator = $odds - 1;
            return round($numerator, 2) . '/1';
        }
    }
    // Add more as needed
    return $odds;
}

