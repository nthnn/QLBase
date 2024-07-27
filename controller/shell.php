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

class Shell {
    public static function log($apiKey, $sender) {
        $action = "N/A";

        if(isset($_GET["action"]) && !empty($_GET["action"]))
            $action = $_GET["action"];

        $origin = base64_encode($_SERVER["REMOTE_ADDR"]);
        $action = base64_encode($action);
        $userAgent = base64_encode($_SERVER["HTTP_USER_AGENT"]);

        Shell::run("../bin/logger", "\"".$apiKey."\" \"".$origin.
            "\" \"".$action."\" \"".date("Y-m-d H:i:s")."\" \"".
            $userAgent."\" ".$sender);
    }

    public static function run($program, $arguments) {
        if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            $program = str_replace("/", "\\", $program);

        return shell_exec("\"".$program."\" ".$arguments);
    }

    public static function detectSender() {
        $sender = "app";

        if(isset($_GET["dashboard"]) && empty($_GET["dashboard"]))
            $sender = "dashboard";
        else if(isset($_GET["sandbox"]) && empty($_GET["sandbox"]))
            $sender = "sandbox";

        return $sender;
    }

    public static function execute($apiKey, $appId, $backend, $args) {
        global $db_conn;
        $res = mysqli_query(
            $db_conn,
            "SELECT * FROM app WHERE app_id=\"".$appId.
                "\" AND app_key=\"".$apiKey."\""
        );

        if(mysqli_num_rows($res) != 1) {
            Response::failedMessage("Invalid API key and/or ID.");
            freeDbQuery($res);

            return;
        }
        freeDbQuery($res);

        Shell::log($apiKey, Shell::detectSender());
        Util::logTraffic($apiKey, $appId);

        echo Shell::run("../bin/".$backend, join(" ", $args));
    }
}

?>