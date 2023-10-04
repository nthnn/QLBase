<?php

include_once("../controller/apps.php");
include_once("../controller/validator.php");

header('Content-Type: application/json; charset=utf-8');

function validateApiKey($key) {
    return preg_match("/^qba_[0-9a-fA-F]{10}_[0-9a-fA-F]{8}$/", $key);
}

function failedResponse() {
    echo "{\"result\": \"0\"}";
}

function execute($backend, $args) {
    echo shell_exec("../bin/".$backend." ".join(" ", $args));
}

if(isset($_GET["api_key"]) && !empty($_GET["api_key"]) &&
    isset($_GET["app_id"]) && !empty($_GET["app_id"])) {
    $apiKey = $_GET["api_key"];
    $appId = $_GET["app_id"];

    if(!isset($_GET["action"]) ||
        empty($_GET["action"]) ||
        !validateApiKey($apiKey) ||
        !validateAppId($appId) ||
        !matchApiKeyAppId($apiKey, $appId)) {
        failedResponse();
        return;
    }

    $action = $_GET["action"];
    $backend = "";
    $args = array();

    switch($action) {
        case "new_user":
            $backend = "auth";
            array_push($args, "create", $apiKey);

            if(!isset($_GET["username"]) || empty($_GET["username"]) ||
                !isset($_GET["email"]) || empty($_GET["email"]) ||
                !isset($_GET["password"]) || empty($_GET["password"]) ||
                !validateUsername($_GET["username"]) ||
                !validateEmail($_GET["email"]) ||
                !validateLoginPassword($_GET["password"]))
                failedResponse();

            array_push($args, $_GET["username"], $_GET["email"], $_GET["password"]);
            break;

        default:
            failedResponse();
            return;
    }

    execute($backend, $args);
    return;
}

failedResponse();

?>