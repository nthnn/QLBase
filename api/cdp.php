<?php
    include_once("../controller/cdp.php");
    include_once("../controller/validator.php");

    if((!isset($_GET["ticket"]) && empty($_GET["ticket"])) ||
        !validateUuid($_GET["ticket"]))
        ContentDeliveryPage::invalidateRequest();

    $ticket = $_GET["ticket"];
    if(!ContentDeliveryPage::isValidTicket($ticket))
        ContentDeliveryPage::invalidateRequest();

    $fileInfos = ContentDeliveryPage::getFileInfo($ticket);
    if(count($fileInfos) == 0)
        ContentDeliveryPage::invalidateRequest();

    ContentDeliveryPage::downloadFile($fileInfos);
?>