<?php
include_once("controller/apps.php");
include_once("controller/session_ctrl.php");

$appInfo = Apps::getInfoById(SessionControl::getId(), $_GET["id"]);

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

    <p class="alert alert-info mt-2 d-none" id="settings-success">Changes saved successfully!</p>
    <p class="alert alert-danger mt-2 d-none" id="settings-error"></p>

    <div align="right" class="mt-2">
        <button class="btn btn-outline-primary px-4" id="settings-save">Save</button>
    </div>
    <hr/>

    <div class="card border-danger mt-2">
        <div class="card-title bg-danger text-white py-1 px-2">Danger Zone</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <b>Delete this app</b>
                    <p>This app will no longer be recoverable once deleted, please be sure.</p>
                </div>

                <div class="col-md-6">
                    <button id="delete-app" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="delete-modal">Delete App</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="scripts/vendors/jquery.min.js"></script>
<script src="scripts/appsec/settings.js"></script>