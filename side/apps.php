<?php

include_once("../controller/apps.php");
include_once("../controller/db_config.php");
include_once("../controller/session_ctrl.php");
include_once("../controller/response.php");
include_once("../controller/validator.php");

if(!(isset($_COOKIE["sess_id"]) &&
    !empty($_COOKIE["sess_id"]) &&
    SessionControl::validate($_COOKIE["sess_id"]))) {
    http_response_code(403);
    return;
}

if(isset($_GET["fetch"]) && empty($_GET["fetch"])) {
    Response::jsonContent();
    echo "{\"result\": \"1\", \"apps\": {";

    $str = "";
    foreach(Apps::getList() as $app) {
        $str .= "\"".$app[0]."\": [\"".$app[1]."\", \"".$app[2]."\"],";
    }

    $str = substr($str, 0, strlen($str) - 1);
    echo $str."}}";
    return;
}
else if(isset($_GET["create"]) && empty($_GET["create"]) &&
    isset($_POST["name"]) && !empty($_POST["name"]) &&
    isset($_POST["description"]) && !empty($_POST["description"])) {

    $name = $_POST["name"];
    if(!Validate::appName($name)) {
        Response::failed();
        return;
    }

    $description = $_POST["description"];
    if(!Validate::base64($description)) {
        Response::failed();
        return;
    }

    if(Apps::create($name, $description))
        Response::success();
    else Response::failed();

    return;
}
else if(isset($_GET["usage"]) && empty($_GET["usage"]) &&
    isset($_POST["api_key"]) && !empty($_POST["api_key"])) {
    $apiKey = $_POST["api_key"];
    if(!Validate::apiKey($apiKey)) {
        Response::failed();
        return;
    }

    Response::jsonContent();
    echo Apps::getAppStorageUsage($apiKey);
    return;
}
else if(isset($_GET["delete_app"]) && empty($_GET["delete_app"]) &&
    isset($_POST["api_key"]) && !empty($_POST["api_key"]) &&
    isset($_POST["username"]) && !empty($_POST["username"]) &&
    isset($_POST["password"]) && !empty($_POST["password"])) {
    $apiKey = $_POST["api_key"];
    if(!Validate::apiKey($apiKey)) {
        Response::failed();
        return;
    }

    $username = $_POST["username"];
    $password = $_POST["password"];
    if(!Validate::username($username) ||
        !Validate::loginPassword($password)) {
        Response::failed();
        return;
    }

    if(!Account::login($username, $password, false)) {
        Response::failed();
        return;
    }

    Response::jsonContent();
    return;
}

http_response_code(403);

?>