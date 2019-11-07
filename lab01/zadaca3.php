<?php
/**
 * Created by PhpStorm.
 * User: ninja
 * Date: 10/30/2019
 * Time: 7:09 PM
 */

$numArray = array(2, 5, 6, 10, 41, 24, 32, 9, 16, 19);
$hashArray = array(
    "martin" => "martin",
    "bojmaliev" => "bojmaliev",
    "gevgelija" => "gevgelija"
);

$multiDimensional = array(
    array(1, 2, 3),
    array(4, 5, 6),
    array(7, 8, 9),
);

//zadaca3.2
for ($i = 0; $i < count($numArray); $i++) echo $i . " => " . $numArray[$i] . "<br />";

echo "<br />";
$biggerThan20 = array();
foreach ($numArray as $key => $item) {
    echo $key . " => " . $item . "<br />";
    if ($item > 20) array_push($biggerThan20, $item);
}

$max = max($numArray);
$min = min($numArray);
echo "Numbers bigger than 20 are: " . implode(", ", $biggerThan20) . "<br/>";
echo "Max is $max and min is $min  <br /> <br />";

$string = "PHP is a widely-used general-purpose scripting language that is especially suited for Web development";

$strings = explode(" ", $string);
$lengthOfWords = array();

foreach($strings as $s)$lengthOfWords[$s] = strlen($s);

foreach ($lengthOfWords as $key=>$item) echo $key." => ". $item."<br />";