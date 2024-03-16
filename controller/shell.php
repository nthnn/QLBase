<?php
function logShelling($apiKey) {
    $action = "N/A";
    if(isset($_GET["action"]) && !empty($_GET["action"]))
        $action = $_GET["action"];

    $origin = base64_encode($_SERVER["REMOTE_ADDR"]);
    $action = base64_encode($action);
    $userAgent = base64_encode($_SERVER["HTTP_USER_AGENT"]);

    shell_exec("\"../bin/logger\" \"".$apiKey."\" \"".$origin.
        "\" \"".$action."\" \"".date("Y-m-d H:i:s")."\" \"".
        $userAgent."\"");
}

function execute($apiKey, $appId, $backend, $args) {
    logNetworkTraffic($apiKey, $appId);
    logShelling($apiKey);

    echo shell_exec("\"../bin/".$backend."\" ".join(" ", $args));
}
?>