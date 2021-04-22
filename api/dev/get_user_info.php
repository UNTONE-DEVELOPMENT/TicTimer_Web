<?php
include("set_type.php");
include($_SERVER['DOCUMENT_ROOT'] . "/api/generic.php");

checkkey();


$session = $_GET['session'];
$key = $_GET['key'];

$clientsecret = $client_key;

$key_array = check_utauth_key($key, true);

$ukey = $key_array['untonekey'];

$post = [
    'client_secret' => $clientsecret,
    'user_secret'   => $ukey,
];
// this sets post variables to shout at the api
$ch = curl_init('https://www.untone.uk/id/api/user/me.php'); // contact api
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$data = curl_exec($ch); // execute curl request
$response = json_decode($data, true); // decode json data into array
session_start(); // start session to store data


$finaljson['name'] = $response['first_name'];
$finaljson['pfp'] = $response['pfp'];
$finaljson['id'] = $response['id'];

echo json_encode($finaljson);