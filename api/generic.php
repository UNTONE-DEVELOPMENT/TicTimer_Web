<?php
$key = "unknown";

function checkkey($private_key = $_GET['private_key']){
    global $key;

    loadkey();

    if($private_key != $key){
        echo "Private key is incorrect.";
        exit;
    }
}

function loadkey(){
    include("key.php");
}