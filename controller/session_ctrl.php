<?php

include_once("db_config.php");
include_once("util.php");

global $db_conn;

function validateSession($hash) {
    global $db_conn;

    if(!$db_conn)
        return false;

    $res1 = mysqli_query($db_conn, "SELECT user_id FROM sessions WHERE hash=\"".$hash."\"".
        " AND user_agent=\"".$_SERVER["HTTP_USER_AGENT"]."\" AND remote_addr=\"".
        $_SERVER["REMOTE_ADDR"]."\"");
    if(!$res1 || mysqli_num_rows($res1) != 1)
        return false;

    $id = mysqli_fetch_array($res1)[0];
    return mysqli_num_rows(
        mysqli_query(
            $db_conn,
            "SELECT * FROM accounts WHERE id=".$id
        )
    ) == 1;
}

function createSession($user_id) {
    global $db_conn;

    $hash = md5(guidv4());
    $result = mysqli_query($db_conn, "INSERT INTO sessions(user_id, hash, user_agent, remote_addr) ".
        "VALUES(".$user_id.", \"".$hash.
        "\", \"".$_SERVER["HTTP_USER_AGENT"].
        "\", \"".$_SERVER["REMOTE_ADDR"]."\")");

    if(!$result)
        return null;

    setcookie("sess_id", $hash, time() + (86400 * 30), "/");
    return $hash;
}

function deleteSession() {
    global $db_conn;

    mysqli_query($db_conn, "DELETE FROM sessions WHERE hash=\"".$_COOKIE["sess_id"]."\"");
    setcookie("sess_id", "", time() - 3600, "/");
}

?>