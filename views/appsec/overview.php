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
    <div class="col-sm-5">
        <h3>Summary</h3>
        <table class="table table-hover">
            <tr>
                <th>App Name</th>
                <td><?php echo $appInfo["app_name"]; ?></td>
            </tr>
            <tr>
                <th>App Key</th>
                <td><?php echo $appInfo["app_key"]; ?></td>
            </tr>
            <tr>
                <th>App ID</th>
                <td><?php echo $appInfo["app_id"]; ?></td>
            </tr>
            <tr>
                <th>Owner</th>
                <td><?php echo $userName; ?></td>
            </tr>
        </table>
    </div>

    <div class="col-sm-7">
        <h3>Network Traffic</h3>
        <canvas id="traffic" style="width:100%;max-width:700px"></canvas>
    </div>
</div>
<br/>

<script src="scripts/appsec/overview.js"></script>
