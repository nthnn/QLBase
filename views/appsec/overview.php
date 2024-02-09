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
                <td>
                    <button class="btn btn-light btn-sm mx-2" id="btn-copy-key">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                        </svg>
                    </button>
                    <?php echo substr($appInfo["app_key"], 0, 15)."..."; ?>
                </td>
            </tr>
            <tr>
                <th>App ID</th>
                <td>
                    <button class="btn btn-light btn-sm mx-2" id="btn-copy-id">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                        </svg>
                    </button>
                    <?php echo substr($appInfo["app_id"], 0, 15)."..."; ?>
                </td>
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

<script src="scripts/vendors/jquery.min.js"></script>
<script src="scripts/appsec/overview.js"></script>
