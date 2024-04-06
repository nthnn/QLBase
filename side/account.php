<?php

include_once("../controller/account.php");
include_once("../controller/db_config.php");
include_once("../controller/session_ctrl.php");
include_once("../controller/response.php");
include_once("../controller/validator.php");

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