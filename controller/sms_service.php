<?php

function isSMSServiceEnabled() {
    $config = parse_ini_file("bin/config.ini", true);
    return isset($config["env"]["sms"]) &&
        $config["env"]["sms"] === "enabled";
}

?>