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

include_once("../controller/db_config.php");
include_once("../controller/response.php");
include_once("../controller/validator.php");

global $db_conn;

Response::jsonContent();
if(!(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST")) {
    Response::failed();
    return;
}

if(isset($_POST["ue"]) && !empty($_POST["ue"])) {
    $ue = $_POST["ue"];

    if(!Validate::username($ue) &&
        !Validate::email($ue)) {
        Response::failed();
        return;
    }

    echo Shell::run("../bin/forgetpass", $ue);
    return;
}
else if(isset($_POST["email"]) && !empty($_POST["email"]) &&
    isset($_POST["newpass"]) && !empty($_POST["newpass"]) &&
    isset($_POST["track_id"]) && !empty($_POST["track_id"])) {

    $email = $_POST["email"];
    if(!Validate::email($email)) {
        Response::failed();
        return;
    }

    $password = $_POST["newpass"];
    if(!Validate::loginPassword($password)) {
        Response::failed();
        return;
    }

    $track_id = $_POST["track_id"];
    if(!Validate::uuid($track_id)) {
        Response::failed();
        return;
    }

    $result = mysqli_query(
        $db_conn,
        "SELECT track_id FROM recovery WHERE email=\"".$email."\" LIMIT 1"
    );
    if(mysqli_num_rows($result) == 1 && mysqli_fetch_row($result)[0] == $track_id) {
        freeDBQuery(
            mysqli_query(
                $db_conn,
                "UPDATE accounts SET password=\"".md5($password).
                "\" WHERE email=\"".$email."\""
            )
        );

        freeDBQuery(
            mysqli_query(
                $db_conn,
                "DELETE FROM recovery WHERE email=\"".$email."\""
            )
        );

        echo "{\"result\": \"1\"}";
        freeDBQuery($result);

        return;
    }

    freeDBQuery($result);
}

Response::failed();

?>