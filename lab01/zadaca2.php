<?php
/**
 * Created by PhpStorm.
 * User: ninja
 * Date: 10/30/2019
 * Time: 6:57 PM
 */

$firstName = "Martin";
$lastName = "Bojmaliev";

$name = $firstName." ".$lastName;

echo $name;
echo "<br/><br/>";

//zadaca 2.2
$sentence = "I'm really nice. but don't PLAY WITH ME";

//this function is converting every char to its uppercase one
echo strtoupper($sentence);
echo "<br/>";
//this function is converting every char to its lowercase one
echo strtolower($sentence);
echo "<br/>";
//this functions is converting the string's first char to uppercase
echo ucfirst($sentence);
echo "<br/>";
//this functions is converting every word's first char to its uppercase
echo ucwords($sentence);


//zadaca 2.3
echo "<br/><br/>";


$arr = array("programski", "praktikum", "laboratoriski", "vezbi");

$newString = implode(" _____ ", $arr);

echo $newString;