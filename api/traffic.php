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
include_once("../controller/response.php");
include_once("../controller/shell.php");
include_once("../controller/tor_detection.php");
include_once("../controller/validator.php");

if(TorDetection::isExitNode()) {
    http_response_code(403);
    return;
}

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

    echo Shell::run("../bin/traffic", $key." ".$id);
    return;
}

Response::failed();

?>