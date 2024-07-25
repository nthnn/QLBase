<div class="row">
    <div class="col-6"><h1>Database Storage</h1></div>
    <div class="col-6" align="right">
        <a class="btn btn-primary" target="_blank" href="docs/<?php echo $docsLink; ?>">API Documentations</a>
    </div>
</div>
<hr/>

<table class="table table-hover w-100" id="db-table" cellspacing="0">
    <thead>
        <th>Name</th>
        <th>Mode</th>
        <th>Options</th>
    </thead>
    <tbody id="db-table-body">
    </tbody>
</table>

<br/>
<button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#create-db-modal">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
    </svg>
    New Database
</button>

<div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="success-modalLabel" aria-hidden="true">
    <div class="modal-dialog shadow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="success-modalLabel">Success</h5>
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="success-message">Database successfully created!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="failed-modal" tabindex="-1" role="dialog" aria-labelledby="failed-modalLabel" aria-hidden="true">
    <div class="modal-dialog shadow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="failed-modalLabel">Failed</h5>
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="failed-message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm-delete-modal" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-modalLabel" aria-hidden="true">
    <div class="modal-dialog shadow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirm-delete-modalLabel">Delete Verification</h5>
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to permanently delete database &quot;<span id="deletable-name"></span>&quot;?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close
                </button>

                <button type="button" class="btn btn-outline-danger" onclick="requestDatabaseDeletion()" id="delete-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="create-db-modal" tabindex="-1" role="dialog" aria-labelledby="create-db-modalLabel" aria-hidden="true">
    <div class="modal-dialog shadow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create-db-modalLabel">New Database</h5>
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="db-name" class="form-label">Database Name</label>
                <input type="text" class="form-control" id="db-name" name="db-name" placeholder="Database Name"></input>
                <p class="text-danger d-none" id="db-name-error"></p>

                <label class="form-label mt-2">I/O Permission Mode</label>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="db-mode" id="read-mode" value="r"></input>
                        <label class="form-check-label" for="read-mode">Read Mode</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="db-mode" id="write-mode" value="w"></input>
                        <label class="form-check-label" for="write-mode">Write Mode</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="db-mode" id="read-write-mode" value="wr" checked></input>
                        <label class="form-check-label" for="read-write-mode">Read/Write Mode</label>
                    </div>
                </div>

                <label for="db-content" class="form-label mt-2">Database Content</label>
                <div id="db-content" class="form-control p-0 m-0" style="height: 200px"></div>
                <p class="text-danger d-none" id="db-content-error"></p>

                <p class="text-danger d-none mt-2" id="db-create-error"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </button>

                <button type="button" class="btn btn-primary" id="create-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Create
                </button>
            </div>
        </div>
    </div>
</div>

<script src="scripts/vendors/jquery.min.js"></script>
<script src="scripts/vendors/jquery.dataTables.min.js"></script>
<script src="scripts/vendors/dataTables.responsive.min.js"></script>
<script src="scripts/vendors/cryptojs.core.min.js"></script>
<script src="scripts/vendors/cryptojs.md5.min.js"></script>
<script src="scripts/vendors/FileSaver.min.js"></script>
<script src="scripts/datatable-init.js"></script>
<script src="scripts/rotating-button.js"></script>
<script src="scripts/appsec/database.js" type="module"></script>

<style>@import url("styles/jquery.dataTables.min.css");</style>