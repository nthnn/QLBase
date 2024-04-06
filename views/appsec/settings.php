<?php
include_once("controller/apps.php");
include_once("controller/session_ctrl.php");

$appInfo = getAppInfoById(getIdOfSession(), $_GET["id"]);
?>
<h1>Settings</h1>
<hr/>

<div class="form-group">
    <div class="row">
        <div class="col-3">
            <label class="form-label" for="app-name">App Name</label>
        </div>

        <div class="col-9">
            <input type="text" class="form-control" id="app-name" placeholder="App Name" value="<?php echo $appInfo["app_name"]; ?>" />
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-3">
            <label class="form-label" for="app-desc">App Description</label>
        </div>

        <div class="col-9">
            <input type="text" class="form-control" id="app-desc" placeholder="App Description" value="<?php echo htmlentities(base64_decode($appInfo["app_desc"])); ?>" />
        </div>
    </div>

    <div align="right" class="mt-2">
        <button class="btn btn-outline-primary px-4">Save</button>
    </div>
</div>