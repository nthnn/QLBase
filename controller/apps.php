<?php

include_once("db_config.php");
include_once("session_ctrl.php");
include_once("util.php");

global $db_conn;
$sess_id = getIdOfSession();

function validateAppId($id) {
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

function addNewApp($name, $description) {
    global $db_conn;
    global $sess_id;

    $app_id = generateAppID();
    while(true) {
        $check = mysqli_query($db_conn, "SELECT * FROM app WHERE app_id=\"".$app_id."\"");

        if(mysqli_num_rows($check) == 1)
            $app_id = generateAppID();
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
    mysqli_query($db_apps_conn, "CREATE TABLE ".$app_key."_storage (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255), temp_name VARCHAR(255), mime_type VARCHAR(50), checksum VARCHAR(50)");

    return !(!$res);
}

function removeNewApp($name) {
    global $db_conn;
    global $sess_id;

    $res = mysqli_query(
        $db_conn,
        "DELETE FROM app WHERE name=\"" . $name . "\""
    );
    return !(!$res);
}

function getAppsOfCurrentUser() {
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

function getAppInfo($name) {
    global $db_conn;

    $res = mysqli_query(
        $db_conn,
        "SELECT id, app_key, app_id, creator_id FROM app WHERE name=\"" . $name . "\""
    );

    if (mysqli_num_rows($res) != 1)
        return null;

    $val = mysqli_fetch_array($res);
    return array(
        "id" => $val["id"],
        "app_key" => $val["app_key"],
        "app_id" => $val["app_id"],
        "creator_id" => $val["creator_id"]
    );
}

function getAppInfoById($user_id, $id) {
    global $db_conn;

    $res = mysqli_query(
        $db_conn,
        "SELECT app_id, app_key, name FROM app WHERE app_id=\"" . $id . "\" AND creator_id=" . $user_id
    );

    if (mysqli_num_rows($res) != 1)
        return null;

    $val = mysqli_fetch_array($res);
    return array(
        "app_id" => $val["app_id"],
        "app_key" => $val["app_key"],
        "app_name" => $val["name"]
    );
}

function matchApiKeyAppId($key, $id) {
    global $db_conn;
    $res = mysqli_query($db_conn, "SELECT * FROM app WHERE app_key=\"".$key."\" AND app_id=\"".$id."\"");

    return mysqli_num_rows($res) == 1;
}

?>