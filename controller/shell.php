<?php

class Shell {
    private static function log($apiKey, $sender) {
        $action = "N/A";

        if(isset($_GET["action"]) && !empty($_GET["action"]))
            $action = $_GET["action"];

        $origin = base64_encode($_SERVER["REMOTE_ADDR"]);
        $action = base64_encode($action);
        $userAgent = base64_encode($_SERVER["HTTP_USER_AGENT"]);

        shell_exec("\"../bin/logger\" \"".$apiKey."\" \"".$origin.
            "\" \"".$action."\" \"".date("Y-m-d H:i:s")."\" \"".
            $userAgent."\" ".$sender);
    }

    public static function execute($apiKey, $appId, $backend, $args) {
        $sender = "app";

        if(isset($_GET["dashboard"]) && empty($_GET["dashboard"]))
            $sender = "dashboard";
        else if(isset($_GET["sandbox"]) && empty($_GET["sandbox"]))
            $sender = "sandbox";

        Shell::log($apiKey, $sender);
        logNetworkTraffic($apiKey, $appId);

        echo shell_exec("\"../bin/".$backend."\" ".join(" ", $args));
    }
}

?>