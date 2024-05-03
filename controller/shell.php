<?php

include_once("../controller/util.php");

class Shell {
    public static function log($apiKey, $sender) {
        $action = "N/A";

        if(isset($_GET["action"]) && !empty($_GET["action"]))
            $action = $_GET["action"];

        $origin = base64_encode($_SERVER["REMOTE_ADDR"]);
        $action = base64_encode($action);
        $userAgent = base64_encode($_SERVER["HTTP_USER_AGENT"]);

        Shell::run("../bin/logger", "\"".$apiKey."\" \"".$origin.
            "\" \"".$action."\" \"".date("Y-m-d H:i:s")."\" \"".
            $userAgent."\" ".$sender);
    }

    public static function run($program, $arguments) {
        if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            $program = str_replace("/", "\\", $program);

        return shell_exec("\"".$program."\" ".$arguments);
    }

    public static function detectSender() {
        $sender = "app";

        if(isset($_GET["dashboard"]) && empty($_GET["dashboard"]))
            $sender = "dashboard";
        else if(isset($_GET["sandbox"]) && empty($_GET["sandbox"]))
            $sender = "sandbox";

        return $sender;
    }

    public static function execute($apiKey, $appId, $backend, $args) {
        Shell::log($apiKey, Shell::detectSender());
        Util::logTraffic($apiKey, $appId);

        echo Shell::run("../bin/".$backend, join(" ", $args));
    }
}

?>