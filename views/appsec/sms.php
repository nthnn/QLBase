<h1>SMS Verification</h1>
<hr/>

<table class="table table-hover w-100" id="sms-table" cellspacing="0">
    <thead>
        <th>Recipient</th>
        <th>Code</th>
        <th>Support Email</th>
        <th>Date Creation</th>
        <th>Validated</th>
        <th>Options</th>
    </thead>
    <tbody id="sms-table-body">
    </tbody>
</table>

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
                <p id="success-message"></p>
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
                <p>Are you sure you want to remove &quot;<span id="deletable-verification"></span>&quot; with OTP &quot;<span id="deletable-otp"></span>&quot; verification?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close
                </button>

                <button type="button" class="btn btn-outline-danger" onclick="requestVerificationDeletion()" id="delete-btn">
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
<script src="scripts/vendors/jquery.dataTables.min.js"></script>
<script src="scripts/vendors/dataTables.responsive.min.js"></script>
<script src="scripts/vendors/cryptojs.core.min.js"></script>
<script src="scripts/vendors/cryptojs.md5.min.js"></script>
<script src="scripts/datatable-init.js"></script>
<script src="scripts/appsec/sms.js"></script>

<style>@import url("styles/jquery.dataTables.min.css");</style>