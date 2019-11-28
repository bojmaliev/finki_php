<?php
session_start();
require_once ("database.php");
function setFavorite($favId){
    $list = getFavorites();
    if(!in_array($favId, $list)){
        $list[] = $favId;
    }
    setcookie("favorites", serialize($list), time() + 3600 * 24 * 7);
}


function getFavorites(){

    return empty($_COOKIE["favorites"]) ? array() : unserialize($_COOKIE["favorites"]);
}

function isIdInFavorites($id){
    return in_array($id, getFavorites());
}

function authUserForId($id){
    $list = getAuthLists();
    if(!in_array($id, $list)){
        $list[] = $id;
    }
    $_SESSION["lists"] = serialize($list);
}
function getAuthLists(){
    return empty($_SESSION["lists"]) ? array() : unserialize($_SESSION["lists"]);

}
function isAuthForList($id){
    return in_array($id, getAuthLists());
}