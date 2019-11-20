<?php
/**
 * Created by PhpStorm.
 * User: ninja
 * Date: 11/19/2019
 * Time: 2:18 AM
 */

class Logger
{
    private $handle;
    public function __construct($logFile)
    {
        $this->handle = fopen($logFile, "a");
    }

    function write($write){
        fwrite($this->handle, $write);
    }

    function __destruct()
    {
        fclose($this->handle);
    }
}