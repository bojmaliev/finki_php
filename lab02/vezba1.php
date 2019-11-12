<?php
/**
 * Created by PhpStorm.
 * User: ninja
 * Date: 11/9/2019
 * Time: 12:41 AM
 */

//vezba1.1
$numList = [2, 5, 6, 10, 41, 24, 32, 9, 16, 19];
$assocList = [
    "martin"=>"martin",
    "bojmaliev"=>"bojmaliev",
    "gevgelija"=>"gevgelija"
];
$multiList = [[1,3,3],[4,2,2],[5,8,89]];

//vezba1.2
foreach ($numList as $key=>$item) echo $key.": ".$item."<br />";

//vezba1.3
$biggerThan20 = [];
foreach($numList as $item) if($item > 20) array_push($biggerThan20, $item);

//vezba1.4

$text = "PHP is a widely-used general-purpose scripting language that is especially suited for Web development";
$textList = explode(" ", $text);
$textWordCount = [];
foreach ($textList as $word)$textWordCount[$word] = strlen($word);

print_r($textWordCount);
//////////////////////////



