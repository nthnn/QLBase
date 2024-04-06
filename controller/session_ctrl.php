<?php

include_once("db_config.php");
include_once("util.php");

global $db_conn;

class SessionControl {
    public static function validate($hash) {
        global $db_conn;

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

    public static function create($user_id) {
        global $db_conn;

        $hash = md5(Util::guidv4());
        $result = mysqli_query($db_conn, "INSERT INTO sessions(user_id, hash, user_agent, remote_addr) ".
            "VALUES(".$user_id.", \"".$hash.
            "\", \"".$_SERVER["HTTP_USER_AGENT"].
            "\", \"".$_SERVER["REMOTE_ADDR"]."\")");

        if(!$result)
            return null;

        setcookie("sess_id", $hash, time() + (86400 * 30), "/");
        return $hash;
    }

    public static function delete() {
        global $db_conn;

        mysqli_query($db_conn, "DELETE FROM sessions WHERE hash=\"".$_COOKIE["sess_id"]."\"");
        setcookie("sess_id", "", time() - 3600, "/");
    }

    public static function getId() {
        if(!isset($_COOKIE["sess_id"]) || empty($_COOKIE["sess_id"]))
            return -1;

        global $db_conn;
        $res = mysqli_query(
            $db_conn,
            "SELECT user_id FROM sessions WHERE hash=\"".$_COOKIE["sess_id"]."\""
        );

        if(!$res || mysqli_num_rows($res) != 1)
            return -1;

        $id = mysqli_fetch_array($res)[0];
        mysqli_free_result($res);

        return $id;
    }
}

?>