<?php
/*
 * Used to prevent SQL attacks
 * */
function cleanInput($string) {
    $string = str_replace("'", '&apos;', $string);
    $string = str_replace("<", '&lt;', $string);
    $string = str_replace(">", '&gt;', $string);
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}
