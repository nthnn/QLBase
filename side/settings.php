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