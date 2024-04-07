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

if(isset($_GET["save"]) && empty($_GET["save"])) {
    if(isset($_POST["name"]) && !empty($_POST["name"]) &&
        isset($_POST["description"]) && !empty($_POST["description"]) &&
        isset($_POST["api_key"]) && !empty($_POST["api_key"]) &&
        Validate::appName($_POST["name"]) &&
        Validate::apiKey($_POST["api_key"])) {
        $name = $_POST["name"];
        $description = base64_encode($_POST["description"]);
        $apiKey = $_POST["api_key"];

        if(Apps::update($apiKey, $name, $description)) {
            Response::success();
            return;
        }
    }

    Response::failed();
    return;
}

http_response_code(403);

?>