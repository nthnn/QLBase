<?php

include_once("../controller/apps.php");
include_once("../controller/shell.php");
include_once("../controller/response.php");
include_once("../controller/validator.php");

Response::jsonContent();
if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_SERVER["HTTP_QLBASE_API_KEY"]) && !empty($_SERVER["HTTP_QLBASE_API_KEY"]) &&
    isset($_SERVER["HTTP_QLBASE_APP_ID"]) && !empty($_SERVER["HTTP_QLBASE_APP_ID"])) {
    $key = $_SERVER["HTTP_QLBASE_API_KEY"];
    if(!Validate::apiKey($key)) {
        Response::failed();
        return;
    }

    $id = $_SERVER["HTTP_QLBASE_APP_ID"];
    if(!Apps::validateId($id)) {
        Response::failed();
        return;
    }

    echo Shell::run("../bin/logger", "dump ".$key);
    return;
}

Response::failed();

?>