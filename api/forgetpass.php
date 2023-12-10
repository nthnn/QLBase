<?php

include_once("../controller/db_config.php");
include_once("../controller/validator.php");

header('Content-Type: application/json; charset=utf-8');

function failedResponse() {
    echo "{\"result\": \"0\"}";
}

global $db_conn;
if(!(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST")) {
    failedResponse();
    return;
}

if(isset($_POST["ue"]) && !empty($_POST["ue"])) {
    $ue = $_POST["ue"];

    if(!validateUsername($ue) &&
        !validateEmail($ue)) {
        failedResponse();
        return;
    }

    echo shell_exec("../bin/forgetpass ".$ue);
    return;
}
else if(isset($_POST["email"]) && !empty($_POST["email"]) &&
    isset($_POST["newpass"]) && !empty($_POST["newpass"]) &&
    isset($_POST["track_id"]) && !empty($_POST["track_id"])) {

    $email = $_POST["email"];
    if(!validateEmail($email)) {
        failedResponse();
        return;
    }

    $password = $_POST["newpass"];
    if(!validateLoginPassword($password)) {
        failedResponse();
        return;
    }

    $track_id = $_POST["track_id"];
    if(!validateUuid($track_id)) {
        failedResponse();
        return;
    }

    $result = mysqli_query(
        $db_conn,
        "SELECT track_id FROM recovery WHERE email=\"".$email."\" AND track_id=\"".$track_id."\" LIMIT 1"
    );
    if(mysqli_num_rows($result) == 1 && mysqli_fetch_row($result)[0] == $track_id) {
        mysqli_query($db_conn, "UPDATE accounts SET password=\"".$password."\" WHERE email=\"".$email."\"");
        mysqli_query($db_conn, "DELETE FROM recovery WHERE email=\"".$email."\"");
        echo "{\"result\": \"1\"}";

        return;
    }
}

failedResponse();

?>