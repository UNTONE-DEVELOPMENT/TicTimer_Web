<?php
include("set_type.php");
include($_SERVER['DOCUMENT_ROOT'] . "/api/generic.php");

checkkey();


$session = $_GET['session'];
$key = $_GET['key'];

$key_array = check_utauth_key($key, true);

$stmt = $mysqli_conection->prepare("INSERT INTO `sessions` (`id`, `userid`, `json`) VALUES (NULL, ?, ?);");
$stmt->bind_param("is", $user, $session);
$stmt->execute();
$result = $stmt->get_result();

$response["response"] = "success";
echo json_encode($response);