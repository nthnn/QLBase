<?php
    require_once("../controller/db_config.php");
    require_once("../controller/validator.php");

    global $db_conn;

    function hasExpired($time) {
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
?>