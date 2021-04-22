<?php
include("set_type.php");
include($_SERVER['DOCUMENT_ROOT'] . "/api/generic.php");

checkkey();


$session = $_GET['session'];
$key = $_GET['key'];

$key_array = check_utauth_key($key, true);

$user = $key_array['untoneid'];

$stmt = $mysqli_conection->prepare("SELECT * FROM `sessions` WHERE `userid` = ?");
$stmt->bind_param("i", $user);
$stmt->execute();
$result = $stmt->get_result();

$response;
$count = 0;
while ($row = $result->fetch_assoc()) {
    $response[$count] = $row;
    $count += 1;
}

echo json_encode($response);