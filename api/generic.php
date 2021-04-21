<?php
$key = "unknown";

function checkkey($private_key = ""){
    if($private_key == ""){
        $private_key = $_GET['private_key'];
    }

    global $key;

    loadkey();

    if($private_key != $key){
        echo "Private key is incorrect.";
        exit;
    }
}

function loadkey(){
    include_once($_SERVER['DOCUMENT_ROOT'] . "api/key.php");
}