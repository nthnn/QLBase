<?php

include_once("../controller/apps.php");
include_once("../controller/validator.php");

header('Content-Type: application/json; charset=utf-8');

function failedResponse() {
    echo "{\"result\": \"0\"}";
}

if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_SERVER["HTTP_QLBASE_API_KEY"]) && !empty($_SERVER["HTTP_QLBASE_API_KEY"]) &&
    isset($_SERVER["HTTP_QLBASE_APP_ID"]) && !empty($_SERVER["HTTP_QLBASE_APP_ID"])) {
    $key = $_SERVER["HTTP_QLBASE_API_KEY"];
    if(!Validate::apiKey($key)) {
        failedResponse();
        return;
    }

    $id = $_SERVER["HTTP_QLBASE_APP_ID"];
    if(!Apps::validateId($id)) {
        failedResponse();
        return;
    }

    echo shell_exec("\"../bin/logger\" dump ".$key);
    return;
}

failedResponse();

?>