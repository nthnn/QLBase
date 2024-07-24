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

        $hash = md5(Util::guidv4(null));
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