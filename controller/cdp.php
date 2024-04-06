<?php

include_once("../controller/db_config.php");
include_once("../controller/validator.php");

global $db_conn;

class ContentDeliveryPage {
    private static function hasExpired($time) {
        if($time == 0)
            return false;

        // 8 * 60 * 60 = 28800 (8 hours)
        return $time < (time() - 28800);
    }

    public static function isValidTicket($ticket) {
        global $db_conn;

        $res = mysqli_query($db_conn, "SELECT expiration FROM cdp WHERE ticket=\"".$ticket."\"");
        if($res && mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_row($res);
            mysqli_free_result($res);

            return !ContentDeliveryPage::hasExpired($row[0]);
        }

        mysqli_free_result($res);
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

            mysqli_free_result($res);
            $res = mysqli_query($db_apps_conn, "SELECT orig_name, mime_type FROM ".$apiKey."_storage WHERE name=\"".$name."\"");

            if($res && mysqli_num_rows($res) == 1) {
                $row = mysqli_fetch_array($res);
    
                array_push($infos, $apiKey, $name, $row[0], $row[1]);
                return $infos;
            }
        }

        return $infos;
    }

    public static function downloadFile($infos) {
        $apiKey = $infos[0];
        $name = $infos[1];
        $origName = $infos[2];
        $mimeType = $infos[3];

        header("Content-Type: ".$mimeType);
        header("Content-Transfer-Encoding: Binary");

        shell_exec("../bin/storage extract ../drive/".$name.".zip");

        $origFile = "../drive/temp/".$origName;
        if(file_exists($origFile)) {
            header("Content-Length: ".filesize($origFile));
            readfile($origFile);

            unlink($origFile);
        }
        else ContentDeliveryPage::invalidateRequest();
    }
}

?>