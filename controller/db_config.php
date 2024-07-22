<?php

$config_file = parse_ini_file("bin/config.ini", true);

class DBConfig {
    public static function getServerAddress() {
        if(isset($config["database"]["server"]))
            return $config["database"]["server"];

        return "localhost";
    }

    public static function getServerUsername() {
        if(isset($config["database"]["username"]))
            return $config["database"]["username"];

        return "root";
    }

    public static function getServerPassword() {
        if(isset($config["database"]["password"]))
            return $config["database"]["password"];

        return "";
    }

    public static function getInternalDatabaseName() {
        if(isset($config["database"]["system"]))
            return $config["database"]["system"];

        return "qlbase";
    }

    public static function getAppDatabaseName() {
        if(isset($config["database"]["name"]))
            return $config["database"]["name"];

        return "qlbase_apps";
    }
}

$db_server = DBConfig::getServerAddress();
$db_username = DBConfig::getServerUsername();
$db_password = DBConfig::getServerPassword();

$db_conn = mysqli_connect(
    $db_server,
    $db_username,
    $db_password,
    DBConfig::getInternalDatabaseName()
);

$db_apps_conn = mysqli_connect(
    $db_server,
    $db_username,
    $db_password,
    DBConfig::getAppDatabaseName()
);

?>