<?php

include_once("controller/account.php");

$userId = getIdOfSession();
$appInfo = getAppInfoById($userId, $appId);
$userName = getAccountUsername($userId);

?>

<div class="border-bottom">
    <div class="row">
        <div class="col-6">
            <h1>Overview</h1>
        </div>

        <div class="col-6" align="right">
            <form action="./sandbox.php" method="post" target="_blank">
                <input type="hidden" name="api_key" value="<?php echo $apiKey; ?>" />
                <input type="hidden" name="app_id" value="<?php echo $appId; ?>" />
                <button type="submit" href="./sandbox.html" class="btn btn-primary">Sandbox</button>
            </form>
        </div>
    </div>
</div>
<br/>

<div class="row">
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

<div class="row">
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