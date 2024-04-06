<?php

include_once("../controller/account.php");
include_once("../controller/db_config.php");
include_once("../controller/session_ctrl.php");
include_once("../controller/validator.php");

function jsonContentResponse() {
    header("Content-Type: application/json; charset=utf-8");
}

function failedResponse() {
    jsonContentResponse();
    echo "{\"result\": \"0\"}";
}

function successResponse() {
    jsonContentResponse();
    echo "{\"result\": \"1\"}";
}

function respondWithErrorMessage($message) {
    jsonContentResponse();
    echo "{\"result\": \"0\", \"message\": \"".$message."\"}";
}

if(isset($_GET["login"]) && empty($_GET["login"]) &&
    isset($_POST["username"]) && !empty($_POST["username"]) &&
    isset($_POST["password"]) && !empty($_POST["password"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    if(!validateUsername($username) ||
        !validateLoginPassword($password)) {
        failedResponse();
        return;
    }

    if(Account::login($username, $password)) {
        successResponse();
        return;
    }

    failedResponse();
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

    if(!validateName($name)) {
        respondWithErrorMessage("Invalid name of user.");
        return;
    }

    if(!validateUsername($username)) {
        respondWithErrorMessage("Invalid username");
        return;
    }

    if(!validateEmail($email)) {
        respondWithErrorMessage("Invalid email");
        return;
    }

    if(!validateLoginPassword($password)) {
        respondWithErrorMessage("Invalid password");
        return;
    }

    $result = Account::create($name, $username, $email, $password);
    switch($result) {
        case CreateAccountResponse::DB_ERROR:
            respondWithErrorMessage("Internal database error occured.");
            return;

        case CreateAccountResponse::USERNAME_ALREADY_IN_USE:
            respondWithErrorMessage("Username already in use.");
            return;

        case CreateAccountResponse::EMAIL_ALREADY_IN_USE:
            respondWithErrorMessage("Email already in use.");
            return;

        case CreateAccountResponse::SUCCESS:
            successResponse();
            return;

        default:
            respondWithErrorMessage("Internal system error occured.");
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

    if(!validateName($name)) {
        respondWithErrorMessage("Invalid name of user.");
        return;
    }

    if(!validateUsername($username)) {
        respondWithErrorMessage("Invalid username");
        return;
    }

    if(!validateEmail($email)) {
        respondWithErrorMessage("Invalid email");
        return;
    }

    if(!validateLoginPassword($password)) {
        respondWithErrorMessage("Invalid password");
        return;
    }

    if(!validateLoginPassword($old)) {
        respondWithErrorMessage("Invalid old password");
        return;
    }

    if(Account::update($username, $name, $email, $password, $old))
        successResponse();
    else failedResponse();

    return;
}

http_response_code(403);

?>