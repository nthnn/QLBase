<?php
include_once("controller/apps.php");
include_once("controller/session_ctrl.php");

$appInfo = Apps::getInfoById($_GET["id"]);
$appId = $appInfo["app_id"];

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
            <?php if(Apps::owner($appId)) { ?>
            <div class="row">
                <div class="col-md-6">
                    <b>Delete this app</b>
                    <p>This app will no longer be recoverable once deleted, please be sure.</p>
                </div>

                <div class="col-md-6">
                    <button type="button" id="show-delete-modal" class="btn btn-outline-danger w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                        Delete App
                    </button>
                </div>
            </div>
            <?php
                }
                else {
            ?>
            <div class="row">
                <div class="col-md-6">
                    <b>Delete this app</b>
                    <p>Your shared access to this app will be removed. To regain access, you must contact the owner.</p>
                </div>

                <div class="col-md-6">
                    <button type="button" id="show-remove-modal" class="btn btn-outline-danger w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                        Delete App
                    </button>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>

<div class="modal fade" id="remove-modal" tabindex="-1" role="dialog" aria-labelledby="remove-modalLabel" aria-hidden="true">
    <div class="modal-dialog shadow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="remove-modalLabel">Remove Modal</h5>
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove your shared access to this app?</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modalLabel" aria-hidden="true">
    <div class="modal-dialog shadow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-modalLabel">Delete Modal</h5>
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Enter your log-in credentials to ensure deletion of &quot;<b><?php echo $appName; ?></b>&quot;</p>
                <hr/>

                <label for="deletion-username" class="form-label">Username</label>
                <input type="text" id="deletion-username" class="form-control" placeholder="Username" />

                <label for="deletion-password" class="form-label mt-2">Password</label>
                <input type="password" id="deletion-password" class="form-control" placeholder="Password" />

                <p class="text-danger d-none mt-2 mb-0 pb-0" id="deletion-error"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close
                </button>

                <button type="button" class="btn btn-outline-danger" id="delete-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script src="scripts/vendors/jquery.min.js"></script>
<script src="scripts/vendors/cryptojs.core.min.js"></script>
<script src="scripts/vendors/cryptojs.md5.min.js"></script>
<script src="scripts/util.js"></script>
<script src="scripts/rotating-button.js"></script>
<script src="scripts/appsec/settings.js"></script>