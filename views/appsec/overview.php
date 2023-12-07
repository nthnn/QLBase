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
                <th>Owner</th>
                <td><?php echo $userName; ?></td>
            </tr>
            <tr>
                <th>App Name</th>
                <td class="p-2"><?php echo $appInfo["app_name"]; ?></td>
            </tr>
            <tr>
                <th>App Key</th>
                <td><button class="btn btn-light mx-2" id="btn-copy-key"><i class="bi bi-clipboard"></i></button> <?php echo $appInfo["app_key"]; ?></td>
            </tr>
            <tr>
                <th>App ID</th>
                <td><button class="btn btn-light mx-2" id="btn-copy-id"><i class="bi bi-clipboard"></i></button> <?php echo $appInfo["app_id"]; ?></td>
            </tr>
        </table>
    </div>

    <div class="col-sm-7">
        <h3>Network Traffic</h3>
        <canvas id="traffic" style="width:100%;max-width:700px"></canvas>
    </div>
</div>
<br/>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toast-copied" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto" id="toast-title"></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">Copied to clipboard!</div>
    </div>
</div>

<script src="scripts/appsec/overview.js"></script>
