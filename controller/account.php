<?php

include_once("db_config.php");
include_once("session_ctrl.php");

global $db_conn;

enum CreateAccountResponse {
    case SUCCESS;
    case DB_ERROR;
    case EMAIL_ALREADY_IN_USE;
    case USERNAME_ALREADY_IN_USE;
}

function hasAccountForEmail($email) {
    global $db_conn;

    return mysqli_num_rows(
        mysqli_query(
            $db_conn,
            "SELECT * FROM accounts WHERE email=\"".$email."\""
        )
    ) == 0;
}

function hasAccountForUsername($username) {
    global $db_conn;

    return mysqli_num_rows(
        mysqli_query(
            $db_conn,
            "SELECT * FROM accounts WHERE username=\"".$username."\""
        )
    ) == 0;
}

function createAccount($name, $username, $email, $password) {
    if(hasAccountForEmail($email))
        return CreateAccountResponse::EMAIL_ALREADY_IN_USE;

    if(hasAccountForUsername($username))
        return CreateAccountResponse::USERNAME_ALREADY_IN_USE;

    global $db_conn;
    $result = mysqli_query(
        $db_conn,
        "INSERT INTO accounts (name, username, email, password) ".
        "VALUES (\"".$name."\", \"".$username."\", \"".$email.
        "\", \"".md5($password)."\")"
    );

    return $result ?
        CreateAccountResponse::SUCCESS :
        CreateAccountResponse::DB_ERROR;
}

function loginAccount($username, $password) {
    if(!hasAccountForUsername($username))
        return false;

    global $db_conn;
    $result = mysqli_query(
        $db_conn,
        "SELECT id FROM accounts WHERE ".
        "username=\"".$username."\" AND password=\"".md5($password)."\""
    );

    if(!$result || mysqli_num_rows($result) == 0)
        return false;

    createSession(mysqli_fetch_array($result)[0]);
    return true;
}

?>