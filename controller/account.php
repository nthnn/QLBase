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

class Account {
    private static function hasAccountForEmail($email) {
        global $db_conn;

        return mysqli_num_rows(
            mysqli_query(
                $db_conn,
                "SELECT * FROM accounts WHERE email=\"".$email."\""
            )
        ) != 0;
    }

    private static function hasAccountForUsername($username) {
        global $db_conn;

        return mysqli_num_rows(
            mysqli_query(
                $db_conn,
                "SELECT * FROM accounts WHERE username=\"".$username."\""
            )
        ) != 0;
    }

    public static function create($name, $username, $email, $password) {
        if(Account::hasAccountForEmail($email))
            return CreateAccountResponse::EMAIL_ALREADY_IN_USE;

        if(Account::hasAccountForUsername($username))
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

    public static function update($username, $name, $email, $password, $old) {
        if(!Account::hasAccountForUsername($username))
            return false;

        global $db_conn;
        $res = mysqli_query($db_conn, "UPDATE accounts SET name=\"".$name.
            "\", email=\"".$email."\", password=\"".md5($password)."\" WHERE username=\"".
            $username."\" AND password=\"".md5($old)."\" AND id=".getIdOfSession());

        return !(!$res);
    }

    public static function login($username, $password) {
        if(!Account::hasAccountForUsername($username))
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

    public static function getInfo($id) {
        global $db_conn;

        $res = mysqli_query(
            $db_conn,
            "SELECT name, email FROM accounts WHERE id=".$id
        );

        if(!$res || mysqli_num_rows($res) != 1)
            return null;

        $results = mysqli_fetch_array($res);
        $array = array($results[0], $results[1]);

        mysqli_free_result($res);
        return $array;
    }

    public static function getUsername($id) {
        global $db_conn;

        $res = mysqli_query(
            $db_conn,
            "SELECT username FROM accounts WHERE id=".$id
        );

        if(!$res || mysqli_num_rows($res) != 1)
            return null;

        $username = mysqli_fetch_array($res)[0];
        mysqli_free_result($res);

        return $username;
    }
}

?>