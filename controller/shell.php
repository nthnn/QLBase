<?php
function logShelling($apiKey) {
    $action = "N/A";
    if(isset($_GET["action"]) && !empty($_GET["action"]))
        $action = $_GET["action"];

    shell_exec("\"../bin/logger\" \"".$apiKey."\" \"".$_SERVER["REMOTE_ADDR"].
        "\" \"".$action."\" \"".date("Y-m-d H:i:s")."\" \"".
        $_SERVER["HTTP_USER_AGENT"]."\"");
}

function execute($apiKey, $appId, $backend, $args) {
    logNetworkTraffic($apiKey, $appId);
    logShelling($apiKey);

    echo shell_exec("\"../bin/".$backend."\" ".join(" ", $args));
}
?>