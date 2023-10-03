<?php

include_once("controller/account.php");

$userId = getIdOfSession();
$appInfo = getAppInfoById($userId, $appId);
$userName = getAccountUsername($userId);

?>
<h1 class="border-bottom">Overview</h1>
<br/>

<div class="row" align="center">
    <div class="col-sm-6">
        <h3 class="text-primary mb-0"><?php echo $appInfo["app_name"]; ?></h3>
        <small class="text-muted">App Name</small>
        <br/><br/>
    </div>

    <div class="col-sm-6">
        <h2 class="text-primary mb-0"><?php echo $userName; ?></h2>
        <small class="text-muted">Creator</small>
    </div>
</div>
<br/>

<div class="row" align="center">
    <div class="col-sm-6">
        <h3 class="text-primary mb-0"><?php echo $appInfo["app_key"]; ?></h3>
        <small class="text-muted">App Key</small>
        <br/><br/>
    </div>

    <div class="col-sm-6">
        <h3 class="text-primary mb-0"><?php echo $appInfo["app_id"]; ?></h3>
        <small class="text-muted">App ID</small>
    </div>
</div>
<br/>