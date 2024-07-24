<?php

include_once("config.php");

$db_server = Config::getDBServerAddress();
$db_username = Config::getDBServerUsername();
$db_password = Config::getDBServerPassword();

$db_conn = mysqli_connect(
    $db_server,
    $db_username,
    $db_password,
    Config::getInternalDatabaseName()
);

$db_apps_conn = mysqli_connect(
    $db_server,
    $db_username,
    $db_password,
    Config::getAppDatabaseName()
);

?>