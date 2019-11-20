<?php
/**
 * Created by PhpStorm.
 * User: ninja
 * Date: 11/19/2019
 * Time: 12:54 AM
 */

class FileUpload
{
    private $targetDir;
    private $file;
    private $targetFile;
    function __construct($targetDir, $file)
    {
        $this->targetDir = $targetDir;
        $this->file = $file;
        $this->targetFile = $targetDir . basename($this->file["name"]);
    }

    function upload(){
        // Check if file already exists
        if (file_exists($this->targetFile)) {
            throw new Exception("Sorry, file already exists.");
        }
        if (move_uploaded_file($this->file["tmp_name"], $this->targetFile)) {
            return $this->targetFile;
        } else {
            throw new Exception("Sorry, there was an error uploading your file.");
        }

    }

    function checkSize($allowSize){
        // Check file size
        if ($this->file["size"] > $allowSize) {
            throw new Exception("Sorry, your file is too large.");
        }
        return $this;
    }

    function checkFormat($allowed){
        $imageFileType = strtolower(pathinfo($this->targetFile,PATHINFO_EXTENSION));
        if(!in_array($imageFileType, $allowed)){
            throw new Exception("Sorry, your format is not supported.");
        }
        return $this;
    }


}