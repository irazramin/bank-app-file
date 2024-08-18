<?php
function name_extract($str): string {
    $initials = '';

    $words = explode(' ', $str);

    foreach ($words as $word) {
        $initials .= strtoupper($word[0]);
    }

    return $initials;

}
?>