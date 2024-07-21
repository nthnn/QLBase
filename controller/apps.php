<?php

include_once("account.php");
include_once("db_config.php");
include_once("session_ctrl.php");
include_once("util.php");

global $db_conn;
$sess_id = SessionControl::getId();

class Apps {
    public static function validateId($id) {
        if (
            strlen($id) != 19 ||
            !preg_match("/^[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}$/", $id)
        )
            return false;

        global $db_conn;
        $res = mysqli_query($db_conn, "SELECT * FROM app WHERE app_id=\"" . $id . "\"");
        $count = mysqli_num_rows($res);

        mysqli_free_result($res);
        return $count == 1;
    }

    public static function create($name, $description) {
        global $db_conn;
        global $sess_id;

        $app_id = Util::generateAppID();
        while(true) {
            $check = mysqli_query($db_conn, "SELECT * FROM app WHERE app_id=\"".$app_id."\"");

            if(mysqli_num_rows($check) == 1)
                $app_id = Util::generateAppID();
            else break;
        }

        $id_hash = sha1(md5($name));
        $app_key = "qba_" . substr_replace($id_hash, '', 10) . "_" . substr(md5($id_hash), 24);
        $res = mysqli_query(
            $db_conn,
            "INSERT INTO app (creator_id, app_id, app_key, name, description) VALUES(".
            $sess_id.", \"".$app_id."\", \"".$app_key."\", \"".$name."\", \"".$description."\")"
        );

        global $db_apps_conn;
        mysqli_query($db_apps_conn, "CREATE TABLE ".$app_key."_accounts (id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(255), email VARCHAR(255), password VARCHAR(255), enabled TINYINT, timedate TIMESTAMP)");
        mysqli_query($db_apps_conn, "CREATE TABLE ".$app_key."_sms_auth (id INT PRIMARY KEY AUTO_INCREMENT, timedate TIMESTAMP, recipient VARCHAR(255), support_email VARCHAR(255), code VARCHAR(6), validated TINYINT)");
        mysqli_query($db_apps_conn, "CREATE TABLE ".$app_key."_data_analytics_id (id INT PRIMARY KEY AUTO_INCREMENT, tracker VARCHAR(255), anonymous_id VARCHAR(255), user_id VARCHAR(255), timedate TIMESTAMP, payload BLOB)");
        mysqli_query($db_apps_conn, "CREATE TABLE ".$app_key."_data_analytics_track (id INT PRIMARY KEY AUTO_INCREMENT, tracker VARCHAR(255), anonymous_id VARCHAR(255), user_id VARCHAR(255), event VARCHAR(255), timedate TIMESTAMP, payload BLOB)");
        mysqli_query($db_apps_conn, "CREATE TABLE ".$app_key."_data_analytics_page (id INT PRIMARY KEY AUTO_INCREMENT, tracker VARCHAR(255), anonymous_id VARCHAR(255), user_id VARCHAR(255), name VARCHAR(255), category VARCHAR(255), timedate TIMESTAMP, payload BLOB)");
        mysqli_query($db_apps_conn, "CREATE TABLE ".$app_key."_database (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), mode VARCHAR(2), content MEDIUMBLOB)");
        mysqli_query($db_apps_conn, "CREATE TABLE ".$app_key."_logs (id INT PRIMARY KEY AUTO_INCREMENT, origin VARCHAR(255), action VARCHAR(255), datetime VARCHAR(255), user_agent VARCHAR(255), sender VARCHAR(15))");
        mysqli_query($db_apps_conn, "CREATE TABLE ".$app_key."_storage (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), orig_name VARCHAR(255), mime_type VARCHAR(50), checksum VARCHAR(50))");

        return !(!$res);
    }

    public static function delete($name) {
        global $db_conn;
        global $sess_id;

        $res = mysqli_query(
            $db_conn,
            "DELETE FROM app WHERE name=\"" . $name . "\""
        );
        return !(!$res);
    }

    public static function update($apiKey, $name, $description) {
        global $db_conn;
        global $sess_id;

        $res = mysqli_query(
            $db_conn,
            "UPDATE app SET name=\"".$name."\", description=\"".
                $description."\" WHERE app_key=\"".$apiKey.
                "\" AND creator_id=\"".$sess_id."\""
        );
        return !(!$res);
    }

    public static function getList() {
        global $db_conn;
        global $sess_id;

        $res = mysqli_query(
            $db_conn,
            "SELECT DISTINCT a.name, a.app_id, a.description ".
            "FROM app a ".
            "LEFT JOIN shared_access sa ON a.app_id = sa.app_id AND a.app_key = sa.app_key ".
            "WHERE a.creator_id=".$sess_id." OR sa.friend=".$sess_id
        );

        $ownedApps = array();
        if(mysqli_num_rows($res) > 0)
            while ($row = mysqli_fetch_assoc($res))
                array_push($ownedApps, array($row["name"], $row["app_id"], $row["description"]));

        return $ownedApps;
    }

    public static function owned($appId) {
        global $db_conn;
        global $sess_id;

        return mysqli_num_rows(
            mysqli_query(
                $db_conn,
                "SELECT 1 ".
                "FROM app a ".
                "LEFT JOIN shared_access sa ON a.app_id = sa.app_id AND a.app_key = sa.app_key ".
                "WHERE (a.creator_id = ".$sess_id." OR sa.friend = ".$sess_id.") ".
                "AND a.app_id = \"".$appId."\" ".
                "LIMIT 1"
            )
        ) > 0;
    }

    public static function owner($appId) {
        global $db_conn;
        global $sess_id;

        $res = mysqli_query(
            $db_conn,
            "SELECT * FROM app WHERE app_id = \"".$appId."\" AND creator_id=".$sess_id
        );

        return mysqli_num_rows($res) == 1;
    }

    public static function getInfoById($id) {
        global $db_conn;

        $res = mysqli_query(
            $db_conn,
            "SELECT app_id, app_key, name, description FROM app WHERE app_id=\"" . $id . "\""
        );

        if(mysqli_num_rows($res) != 1)
            return null;

        $val = mysqli_fetch_array($res);
        return array(
            "app_id" => $val["app_id"],
            "app_key" => $val["app_key"],
            "app_name" => $val["name"],
            "app_desc" => $val["description"]
        );
    }

    public static function matchApiKeyId($key, $id) {
        global $db_conn;
        $res = mysqli_query($db_conn, "SELECT * FROM app WHERE app_key=\"".$key."\" AND app_id=\"".$id."\"");

        return mysqli_num_rows($res) == 1;
    }

    public static function getAppStorageUsage($apiKey) {
        global $db_apps_conn;
        $tables = array(
            $apiKey."_accounts",
            $apiKey."_database",
            $apiKey."_data_analytics_id",
            $apiKey."_data_analytics_page",
            $apiKey."_data_analytics_track",
            $apiKey."_logs",
            $apiKey."_sms_auth",
            $apiKey."_storage"
        );

        $data = array();
        foreach ($tables as $table) {
            $sql = "SELECT table_name,
                        (data_length + index_length) / 1024 AS 'size'
                    FROM information_schema.TABLES 
                    WHERE table_schema = 'qlbase_apps' 
                    AND table_name = '".$table."'";

            $result = mysqli_query($db_apps_conn, $sql);
            if(mysqli_num_rows($result) > 0)
                while($row = mysqli_fetch_assoc($result)) {
                    $res = mysqli_fetch_assoc(mysqli_query(
                        $db_apps_conn,
                        "SELECT COUNT(*) as count FROM ".$table
                    ));

                    $data[str_replace($apiKey."_", "", $row["table_name"])] =
                        array($res["count"], str_replace(".000", "", $row["size"]));
                }
        }

        return json_encode($data);
    }

    public static function listSharedAccessors($apiKey) {
        global $db_conn;

        $res = mysqli_query(
            $db_conn,
            "SELECT accounts.name, accounts.email ".
            "FROM accounts JOIN shared_access ".
            "ON accounts.id = shared_access.friend ".
            "WHERE shared_access.app_key = \"".$apiKey."\""
        );

        $data = array();
        while($row = mysqli_fetch_assoc($res))
            $data[$row["name"]] = $row["email"];

        return json_encode($data);
    }

    public static function shareApp($originId, $username, $password, $appKey, $appId, $email) {
        if(!Account::login($username, $password, false)) {
            Response::failedMessage("Invalid username and/or password.");
            return;
        }

        global $db_conn;
        $res = mysqli_query(
            $db_conn,
            "SELECT * FROM app WHERE creator_id=".$originId." AND app_id=\"".$appId."\""
        );

        if(mysqli_num_rows($res) != 1) {
            Response::failedMessage("Request origin is not the owner.");
            return;
        }
        mysqli_free_result($res);

        $res = mysqli_query(
            $db_conn,
            "SELECT id FROM accounts WHERE email=\"".$email."\""
        );

        if(mysqli_num_rows($res) != 1) {
            Response::failedMessage("Something went wrong.");
            return;
        }

        $recipientId = mysqli_fetch_array($res)[0];
        $res = mysqli_query(
            $db_conn,
            "SELECT * FROM shared_access WHERE friend=".$recipientId." AND app_id=\"".$appId."\""
        );

        if(!$res) {
            Response::failedMessage("Something went wrong.");
            return;
        }

        if(mysqli_num_rows($res) == 1) {
            Response::failedMessage("App already shared with specified user.");
            return;
        }

        $res = mysqli_query(
            $db_conn,
            "INSERT INTO shared_access (app_id, app_key, friend) ".
            "VALUES(\"".$appId."\", \"".$appKey."\", ".$recipientId.")"
        );

        if(!$res) {
            Response::failedMessage("Something went wrong.");
            return;
        }

        Response::success();
        return;
    }

    public static function unshareApp($originId, $apiKey, $email) {
        global $db_conn;

        $res = mysqli_query(
            $db_conn,
            "SELECT * FROM app WHERE creator_id=".$originId." AND app_key=\"".$apiKey."\""
        );

        $sharedRes = mysqli_query(
            $db_conn,
            "SELECT * FROM shared_access WHERE friend=".$originId." AND app_key=\"".$apiKey."\""
        );

        if(mysqli_num_rows($res) != 1 ||
            mysqli_num_rows($sharedRes) != 1) {
            Response::failedMessage("Request origin is not the owner.");
            return;
        }

        mysqli_free_result($res);
        mysqli_free_result($sharedRes);

        $res = mysqli_query(
            $db_conn,
            "SELECT id FROM accounts WHERE email=\"".$email."\""
        );

        if(!$res || mysqli_num_rows($res) != 1) {
            Response::failedMessage("User not found.");
            return;
        }

        $subjectId = mysqli_fetch_array($res)[0];
        mysqli_free_result($res);

        $res = mysqli_query(
            $db_conn,
            "DELETE FROM shared_access WHERE app_key=\"".$apiKey."\" AND friend=\"".$subjectId."\""
        );

        if(mysqli_affected_rows($db_conn) != 1) {
            Response::failedMessage("User not listed on shared accessors.");
            return;
        }

        if($res) {
            Response::success();
            return;
        }
        mysqli_free_result($res);

        Response::failed();
        return;
    }
}

?>