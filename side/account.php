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
include_once("../controller/db_config.php");
include_once("../controller/response.php");
include_once("../controller/session_ctrl.php");
include_once("../controller/tor_detection.php");
include_once("../controller/validator.php");

if(TorDetection::isExitNode()) {
    http_response_code(403);
    return;
}

if(isset($_GET["login"]) && empty($_GET["login"]) &&
    isset($_POST["username"]) && !empty($_POST["username"]) &&
    isset($_POST["password"]) && !empty($_POST["password"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    if(!Validate::username($username) ||
        !Validate::loginPassword($password)) {
        Response::failed();
        return;
    }

    if(Account::login($username, $password)) {
        Response::success();
        return;
    }

    Response::failed();
    return;
}
else if(isset($_GET["signup"]) && empty($_GET["signup"]) &&
    isset($_POST["username"]) && !empty($_POST["username"]) &&
    isset($_POST["name"]) && !empty($_POST["name"]) &&
    isset($_POST["email"]) && !empty($_POST["email"]) &&
    isset($_POST["password"]) && !empty($_POST["password"])) {

    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if(!Validate::name($name)) {
        Response::failedMessage("Invalid name of user.");
        return;
    }

    if(!Validate::username($username)) {
        Response::failedMessage("Invalid username");
        return;
    }

    if(!Validate::email($email)) {
        Response::failedMessage("Invalid email");
        return;
    }

    if(!Validate::loginPassword($password)) {
        Response::failedMessage("Invalid password");
        return;
    }

    $result = Account::create($name, $username, $email, $password);
    switch($result) {
        case CreateAccountResponse::DB_ERROR:
            Response::failedMessage("Internal database error occured.");
            return;

        case CreateAccountResponse::USERNAME_ALREADY_IN_USE:
            Response::failedMessage("Username already in use.");
            return;

        case CreateAccountResponse::EMAIL_ALREADY_IN_USE:
            Response::failedMessage("Email already in use.");
            return;

        case CreateAccountResponse::SUCCESS:
            Response::success();
            return;

        default:
            Response::failedMessage("Internal system error occured.");
            return;
    }
}
else if(isset($_GET["logout"]) && empty($_GET["logout"])) {
    if(!(isset($_COOKIE["sess_id"]) && !empty($_COOKIE["sess_id"]) &&
        SessionControl::validate($_COOKIE["sess_id"])))
        http_response_code(403);
    else SessionControl::delete();

    return;
}
else if(isset($_GET["update"]) && empty($_GET["update"]) &&
    isset($_POST["username"]) && !empty($_POST["username"]) &&
    isset($_POST["name"]) && !empty($_POST["name"]) &&
    isset($_POST["email"]) && !empty($_POST["email"]) &&
    isset($_POST["password"]) && !empty($_POST["password"]) &&
    isset($_POST["old"]) && !empty($_POST["old"])) {

    if(!(isset($_COOKIE["sess_id"]) && !empty($_COOKIE["sess_id"]) &&
        SessionControl::validate($_COOKIE["sess_id"]))) {
        http_response_code(403);
        return;
    }

    $username = $_POST["username"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $old = $_POST["old"];

    if(!Validate::name($name)) {
        Response::failedMessage("Invalid name of user.");
        return;
    }

    if(!Validate::username($username)) {
        Response::failedMessage("Invalid username");
        return;
    }

    if(!Validate::email($email)) {
        Response::failedMessage("Invalid email");
        return;
    }

    if(!Validate::loginPassword($password)) {
        Response::failedMessage("Invalid password");
        return;
    }

    if(!Validate::loginPassword($old)) {
        Response::failedMessage("Invalid old password");
        return;
    }

    if(Account::update($username, $name, $email, $password, $old))
        Response::success();
    else Response::failed();

    return;
}

http_response_code(403);

?>