<?php
/**
 * Created by PhpStorm.
 * User: ninja
 * Date: 11/18/2019
 * Time: 10:43 PM
 */

if (!is_dir("files")) mkdir("files");

$handle = fopen("files/prva.txt", "w");
fwrite($handle, "Ova e test na toa sto se slucuva, Kako-si-sto-si");
fclose($handle);
$handle = fopen("files/vtora.txt", "w");
fwrite($handle, "Ova e tekstot od vtoriot file");
fclose($handle);


$handle = fopen("files/prva.txt", "r");
if(file_exists("files/rezultat.txt"))unlink("files/rezultat.txt");
$resHandle = fopen("files/rezultat.txt", "a");
while (!feof($handle)) {
    $s = fread($handle, 1);
    if ($s == "-") $s = " ";
    fwrite($resHandle, $s, 1);
}
fclose($handle);
$handle = fopen("files/vtora.txt", "r");
$string = fread($handle, filesize("files/vtora.txt"));

fwrite($resHandle, $string, strlen($string));
fclose($handle);
fclose($resHandle);