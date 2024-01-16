<?php
    include_once("../controller/db_config.php");
    include_once("../controller/validator.php");

    global $db_conn;

    function hasExpired($time) {
        if($time == 0)
            return false;

        // 8 * 60 * 60 = 28800 (8 hours)
        return $time < (time() - 28800);
    }

    function isValidCDPTicket($ticket) {
        global $db_conn;

        $res = mysqli_query($db_conn, "SELECT expiration FROM cdp WHERE ticket=\"".$ticket."\"");
        if($res && mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_row($result);
            mysqli_free_result($res);

            return !hasExpired($row[0]);
        }

        mysqli_free_result($res);
        return false;
    }

    function invalidateCDPRequest() {
        header("Location: ../404.html");
        die();
    }

    function getCDPFileInfo($ticket) {
        global $db_conn;
        $infos = array();

        $res = mysqli_query($db_conn, "SELECT api_key, name FROM cdp WHERE ticket=\"".$ticket."\"");
        if($res && mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_array($res);

            $apiKey = $row[0];
            $name = $row[0];

            mysqli_free_result($res);
            $res = mysqli_query($db_conn, "SELECT orig_name, mime_type FROM ".$apiKey."_storage WHERE name=\"".$name."\"");
            if($res && mysqli_num_rows($res) == 1) {
                $row = mysqli_fetch_array($res);

                array_push($infos, $apiKey, $row[0], $row[1]);
                return $infos;
            }
        }

        return $infos;
    }

    function downloadFile($infos) {
        $apiKey = $infos[0];
        $origName = $infos[1];
        $mimeType = $infos[2];

        header("Content-Type: ".$mimeType);
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"".basename($origName)."\"");

        shell_exec("../bin/storage extract ".$origName);

        $origFile = "../drive/temp/".$origName;
        if(file_exists($origFile)) {
            header("Content-Length: ".filesize($origFile));
            readfile($origFile);
        }
        else invalidateCDPRequest();
    }
?>