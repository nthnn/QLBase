<?php
    include_once("../controller/cdp.php");

    if((!isset($_GET["ticket"]) && empty($_GET["ticket"])) ||
        validateUuid($_GET["ticket"]))
        invalidateCDPRequest();

    $ticket = $_GET["ticket"];
    if(!isValidCDPTicket($ticket))
        invalidateCDPRequest();

    $fileInfos = getCDPFileInfo($ticket);
    if(count($fileInfos) == 0)
        invalidateCDPRequest();

    downloadFile($fileInfos);
?>