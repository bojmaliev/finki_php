<?php
/**
 * Created by PhpStorm.
 * User: ninja
 * Date: 11/19/2019
 * Time: 1:39 AM
 */

class ContactParser
{
    private $handle = null;
    private $fileName;
    private $text;

    function __construct($file)
    {
        $this->fileName = $file;
        $this->handle = fopen($file, "r");
        $this->text = fread($this->handle, filesize($this->fileName));
    }

    function getAllItems($delimiter = ";"){
        return explode($delimiter, $this->text);
    }

    function getRows()
    {
        $infos = $this->getAllItems();
        $newArr = array();
        $i = 0;
        $j = 0;
        foreach ($infos as $info) {
            $newArr[$j][] = $info;
            $i++;
            if ($i == 4) {
                $i = 0;
                $j++;
            }
        }
        return $newArr;
    }

    public function check_errors()
    {
        if(count($this->getAllItems()) % 4 != 0)return "number is not good";

        $rows = $this->getRows();

        foreach ($rows as $row){
            if(strlen($row[0]) < 6)throw new Exception("Name is not valid");
            if(preg_match("/^07[012456789][0-9]{6}$/" ,$row[1])) throw new Exception("Phone number is not valid");
            if(!filter_var($row[2], FILTER_VALIDATE_EMAIL))throw new Exception("Not valid email");
        }
        return "Everything is good";


    }

    function __destruct()
    {
        fclose($this->handle);
    }


}