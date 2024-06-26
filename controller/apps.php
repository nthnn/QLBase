<?php

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
            "SELECT name, app_id, description FROM app WHERE creator_id=" . $sess_id
        );

        $ownedApps = array();
        if (mysqli_num_rows($res) > 0)
            while ($row = mysqli_fetch_assoc($res))
                array_push($ownedApps, array($row["name"], $row["app_id"], $row["description"]));

        return $ownedApps;
    }

    public static function getInfoById($user_id, $id) {
        global $db_conn;

        $res = mysqli_query(
            $db_conn,
            "SELECT app_id, app_key, name, description FROM app WHERE app_id=\"" . $id . "\" AND creator_id=" . $user_id
        );

        if (mysqli_num_rows($res) != 1)
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
}

?>