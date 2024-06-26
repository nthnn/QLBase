<?php

include_once("../controller/db_config.php");
include_once("../controller/response.php");
include_once("../controller/validator.php");

global $db_conn;

Response::jsonContent();
if(!(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST")) {
    Response::failed();
    return;
}

if(isset($_POST["ue"]) && !empty($_POST["ue"])) {
    $ue = $_POST["ue"];

    if(!Validate::username($ue) &&
        !Validate::email($ue)) {
        Response::failed();
        return;
    }

    echo Shell::run("../bin/forgetpass", $ue);
    return;
}
else if(isset($_POST["email"]) && !empty($_POST["email"]) &&
    isset($_POST["newpass"]) && !empty($_POST["newpass"]) &&
    isset($_POST["track_id"]) && !empty($_POST["track_id"])) {

    $email = $_POST["email"];
    if(!Validate::email($email)) {
        Response::failed();
        return;
    }

    $password = $_POST["newpass"];
    if(!Validate::loginPassword($password)) {
        Response::failed();
        return;
    }

    $track_id = $_POST["track_id"];
    if(!Validate::uuid($track_id)) {
        Response::failed();
        return;
    }

    $result = mysqli_query(
        $db_conn,
        "SELECT track_id FROM recovery WHERE email=\"".$email."\" LIMIT 1"
    );
    if(mysqli_num_rows($result) == 1 && mysqli_fetch_row($result)[0] == $track_id) {
        mysqli_query($db_conn, "UPDATE accounts SET password=\"".md5($password)."\" WHERE email=\"".$email."\"");
        mysqli_query($db_conn, "DELETE FROM recovery WHERE email=\"".$email."\"");
        echo "{\"result\": \"1\"}";

        return;
    }
}

Response::failed();

?>