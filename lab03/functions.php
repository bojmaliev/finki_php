<?php

function first_100_words($text){
    $array = explode(" ", $text);
    return implode(" ", array_slice($array, 0, 100));
}