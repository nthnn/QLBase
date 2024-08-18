<?php

/*
 * This file is part of QLBase (https://github.com/nthnn/QLBase).
 * Copyright 2024 - Nathanne Isip
 * 
 * Permission is hereby granted, free of charge,
 * to any person obtaining a copy of this software
 * and associated documentation files (the “Software”),
 * to deal in the Software without restriction,
 * including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to
 * whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions
 * of the Software.
 * 
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF
 * ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT
 * SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR
 * ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

include_once("../controller/account.php");
include_once("../controller/apps.php");
include_once("../controller/db_config.php");
include_once("../controller/response.php");
include_once("../controller/session_ctrl.php");
include_once("../controller/tor_detection.php");
include_once("../controller/validator.php");

if(TorDetection::isExitNode()) {
    http_response_code(403);
    return;
}

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
else if(isset($_GET["shared_list"]) && empty($_GET["shared_list"]) &&
    isset($_POST["api_key"]) && !empty($_POST["api_key"])) {
    $apiKey = $_POST["api_key"];
    if(!Validate::apiKey($apiKey)) {
        Response::failed();
        return;
    }

    Response::jsonContent();
    echo Apps::listSharedAccessors(SessionControl::getId(), $apiKey);
    return;
}
else if(isset($_GET["share_app"]) && empty($_GET["share_app"]) &&
    isset($_POST["api_key"]) && !empty($_POST["api_key"]) &&
    isset($_POST["api_id"]) && !empty($_POST["api_id"]) &&
    isset($_POST["uname"]) && !empty($_POST["uname"]) &&
    isset($_POST["pword"]) && !empty($_POST["pword"]) &&
    isset($_POST["email"]) && !empty($_POST["email"])) {
    $apiKey = $_POST["api_key"];
    if(!Validate::apiKey($apiKey)) {
        Response::failed();
        return;
    }

    $apiId = $_POST["api_id"];
    if(!Validate::apiId($apiId)) {
        Response::failed();
        return;
    }

    $username = $_POST["uname"];
    if(!Validate::username($username)) {
        Response::failed();
        return;
    }

    $password = $_POST["pword"];
    if(!Validate::loginPassword($password)) {
        Response::failed();
        return;
    }

    $email = $_POST["email"];
    if(!Validate::email($email)) {
        Response::failed();
        return;
    }

    Apps::shareApp(SessionControl::getId(), $username, $password, $apiKey, $apiId, $email);
    return;
}
else if(isset($_GET["unshare_app"]) && empty($_GET["unshare_app"]) &&
    isset($_POST["api_key"]) && !empty($_POST["api_key"]) &&
    isset($_POST["email"]) && !empty($_POST["email"])) {
    $apiKey = $_POST["api_key"];
    if(!Validate::apiKey($apiKey)) {
        Response::failed();
        return;
    }

    $email = $_POST["email"];
    if(!Validate::email($email)) {
        Response::failed();
        return;
    }

    Apps::unshareApp(SessionControl::getId(), $apiKey, $email);
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
        Response::failedMessage("Invalid username and/or password string.");
        return;
    }

    Apps::deleteApp(SessionControl::getId(), $apiKey, $username, $password);
    return;
}

http_response_code(403);

?>