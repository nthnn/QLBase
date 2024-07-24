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