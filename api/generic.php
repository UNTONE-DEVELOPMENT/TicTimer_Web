<?php
$key = "unknown";

include_once($_SERVER['DOCUMENT_ROOT'] . "/api/db.php");

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
    include_once($_SERVER['DOCUMENT_ROOT'] . "/api/key.php");
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function check_utauth_key($key, $exit = false){
    $stmt = $mysqli_conection->prepare("SELECT * FROM `keys` WHERE `key` = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 0){
        $response["error"] = "key_does_not_exist";
        echo json_encode($response);
        exit;
    }
   
    while($row = $result->fetch_assoc()) {
        return $row;
    }
}

function redirect($url = "https://tictimer.untone.uk"){
    if(!isset($url)){
        $url = "https://tictimer.untone.uk";
    }
    echo "<script>
    window.location.href = '" . $url . "';
    </script>";
    exit;
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = $datetime;
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}