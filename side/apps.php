<?php

include_once("../controller/apps.php");
include_once("../controller/db_config.php");
include_once("../controller/session_ctrl.php");
include_once("../controller/validator.php");

if(!(isset($_COOKIE["sess_id"]) &&
    !empty($_COOKIE["sess_id"]) &&
    SessionControl::validate($_COOKIE["sess_id"]))) {
    http_response_code(403);
    return;
}

if(isset($_GET["fetch"]) && empty($_GET["fetch"])) {
    jsonContentResponse();
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

http_response_code(403);

?>