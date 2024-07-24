<?php

include_once("shell.php");

$config_file = parse_ini_file(
    Shell::getCurrentOS() == "linux" ?
        "bin".DIRECTORY_SEPARATOR."config.ini" :
        dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."bin".DIRECTORY_SEPARATOR."config.ini",
    true
);

class Config {
    public static function getDBServerAddress() {
        if(isset($config["database"]["server"]))
            return $config["database"]["server"];

        return "localhost";
    }

    public static function getDBServerUsername() {
        if(isset($config["database"]["username"]))
            return $config["database"]["username"];

        return "root";
    }

    public static function getDBServerPassword() {
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

    public static function isSMSServiceEnabled() {
        return isset($config["env"]["sms"]) &&
            $config["env"]["sms"] === "enabled";
    }
}

?>