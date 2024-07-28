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
include_once("../controller/shell.php");
include_once("../controller/validator.php");

global $db_conn;

class ContentDeliveryPage {
    private static function hasExpired($time) {
        if($time == 0)
            return false;

        return $time < time();
    }

    public static function isValidTicket($ticket) {
        global $db_conn;

        $res = mysqli_query($db_conn, "SELECT expiration FROM cdp WHERE ticket=\"".$ticket."\"");
        if($res && mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_row($res);
            freeDBQuery($res);

            return !ContentDeliveryPage::hasExpired($row[0]);
        }

        freeDBQuery($res);
        return false;
    }

    public static function invalidateRequest() {
        header("Location: ../404.html");
        die();
    }

    public static function getFileInfo($ticket) {
        global $db_conn;
        global $db_apps_conn;

        $infos = array();
        $res = mysqli_query($db_conn, "SELECT api_key, name FROM cdp WHERE ticket=\"".$ticket."\"");

        if($res && mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_array($res);

            $apiKey = $row[0];
            $name = $row[1];

            freeDBQuery($res);
            $res = mysqli_query($db_apps_conn, "SELECT orig_name, mime_type FROM ".$apiKey."_storage WHERE name=\"".$name."\"");

            if($res && mysqli_num_rows($res) == 1) {
                $row = mysqli_fetch_array($res);
    
                array_push($infos, $apiKey, $name, $row[0], $row[1]);
                freeDBQuery($res);
                return $infos;
            }

            freeDBQuery($res);
        }

        freeDBQuery($res);
        return $infos;
    }

    public static function downloadFile($infos) {
        $apiKey = $infos[0];
        $name = $infos[1];
        $origName = $infos[2];
        $mimeType = $infos[3];

        header("Content-Type: ".$mimeType);
        header("Content-Transfer-Encoding: Binary");

        Shell::run("../bin/storage", "extract ".$apiKey.
            " ..".DIRECTORY_SEPARATOR.
            "drive".DIRECTORY_SEPARATOR.$name.".zip");

        $origFile = "..".DIRECTORY_SEPARATOR.
            "drive".DIRECTORY_SEPARATOR.
            "temp".DIRECTORY_SEPARATOR.
            $origName;

        if(file_exists($origFile)) {
            header("Content-Length: ".filesize($origFile));
            readfile($origFile);

            unlink($origFile);
        }
        else ContentDeliveryPage::invalidateRequest();
    }

    public static function expire($apiKey, $ticket) {
        global $db_conn;
        $res = mysqli_query(
            $db_conn,
            "DELETE FROM cdp WHERE api_key=\"".
                $apiKey."\" AND ticket=\"".$ticket."\""
        );

        if(!$res) {
            Response::failed();
            freeDBQuery($res);

            return;
        }

        freeDBQuery($res);
        Response::success();
    }

    public static function expireAll($apiKey) {
        global $db_conn;
        $res = mysqli_query(
            $db_conn,
            "DELETE FROM cdp WHERE api_key=\"".$apiKey."\""
        );

        if(!$res) {
            Response::failed();
            freeDBQuery($res);

            return;
        }

        freeDBQuery($res);
        Response::success();
    }
}

?>