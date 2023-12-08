<?php

include_once("../controller/apps.php");
include_once("../controller/validator.php");

header('Content-Type: application/json; charset=utf-8');

function failedResponse() {
    echo "{\"result\": \"0\"}";
}

if(isset($_GET["key"]) && !empty($_GET["key"]) &&
    isset($_GET["id"]) && !empty($_GET["id"])) {

    $key = $_GET["key"];
    if(!validateApiKey($key)) {
        failedResponse();
        return;
    }

    $id = $_GET["id"];
    if(!validateAppId($id)) {
        failedResponse();
        return;
    }

    echo shell_exec("../bin/traffic ".$key." ".$id);
    return;
}

failedResponse();

?>