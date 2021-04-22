<?php
include("set_type.php");
include($_SERVER['DOCUMENT_ROOT'] . "/api/generic.php");

checkkey();

$clientsecret = $client_key;
you
if (isset($_GET['key'])) {
    // set post fields
    $post = [
        'client_secret' => $clientsecret,
        'user_secret'   => $_GET['key'],
    ];
    // this sets post variables to shout at the api

    $ch = curl_init('https://www.untone.uk/id/api/user/me.php'); // contact api
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    $data = curl_exec($ch); // execute curl request
    $response = json_decode($data, true); // decode json data into array
    session_start(); // start session to store data

    $_SESSION['id'] = $response['id']; // set session vars
    $_SESSION['username'] = $response['username'];
    $_SESSION['purejson'] = $response;

    $stmt = $mysqli_conection->prepare("SELECT * FROM `keys` WHERE `untoneid` = ?");
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $keygenerated = false;
    }

    while ($row = $result->fetch_assoc()) {
        $keygenerated = true;
        $key = $row['key'];
    }

    if ($keygenerated == false) {
        $key = generateRandomString(32);
        $stmt = $mysqli_conection->prepare("INSERT INTO `keys` (`untoneid`, `key`, `untonekey`) VALUES (?, ?, ?);");
        $stmt->bind_param("iss", $_SESSION['id'], $key, $_GET['key']);
        $stmt->execute();
    }

    echo $key;
}
?>

<?php
if (isset($_SESSION['comesfromview'])) {
    redirect("https://tictimer.untone.uk/utauth/viewsessions.php");
}
?>