<?php
function execute($apiKey, $appId, $backend, $args) {
    logNetworkTraffic($apiKey, $appId);
    echo shell_exec("../bin/".$backend." ".join(" ", $args));
}
?>