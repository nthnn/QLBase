<div class="modal fade" id="payload-modal" tabindex="-1" role="dialog" aria-labelledby="payload-modalLabel" aria-hidden="true">
    <div class="modal-dialog shadow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paload-modalLabel">Payload</h5>
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="overflow-auto bg-secondary p-2 border border-gray rounded" style="height: 200px">
                    <pre id="payload-content"></pre>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="downloadContent('payload.json', $('#payload-content').text())">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                    </svg>
                    Download
                </button>

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
                <h5 class="modal-title" id="confirm-delete-modalLabel">Delete Row</h5>
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove this row?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close
                </button>

                <button type="button" class="btn btn-outline-danger" id="modal-delete-btn" id="delete-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="success-delete-modal" tabindex="-1" role="dialog" aria-labelledby="success-delete-modalLabel" aria-hidden="true">
    <div class="modal-dialog shadow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="success-delete-modalLabel">Success</h5>
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="success-delete-modal-msg"></p>
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

<div class="modal fade" id="failed-delete-modal" tabindex="-1" role="dialog" aria-labelledby="failed-delete-modalLabel" aria-hidden="true">
    <div class="modal-dialog shadow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="failed-delete-modalLabel">Failed</h5>
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="failed-delete-modal-msg"></p>
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

<h1>Data Analytics</h1>
<hr/>

<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" data-bs-toggle="tab" href="#identify" aria-selected="true" role="tab"><i class="bi bi-search"></i> Identify</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#tracking" aria-selected="false" tabindex="-1" role="tab"><i class="bi bi-signpost"></i> Tracking</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#paging" aria-selected="false" tabindex="-1" role="tab"><i class="bi bi-file-earmark"></i> Paging</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#alias" aria-selected="false" tabindex="-1" role="tab"><i class="bi bi-people"></i> Alias</a>
    </li>
</ul>
<br/>

<div class="tab-content">
    <div class="tab-pane fade show active" id="identify" role="tabpanel">
        <table class="table table-hover w-100" id="analytics-id-table">
            <thead>
                <tr>
                    <td>Tracker</td>
                    <td>Anonymous ID</td>
                    <td>User ID</td>
                    <td>Timedate</td>
                    <td>Payload</td>
                    <td>Options</td>
                </tr>
            </thead>
            <tbody id="analytics-id-tbody">
            </tbody>
        </table>

        <div class="w-100" align="center">
            <button class="btn btn-outline-primary" onclick="downloadIdContent()">Download Data</button>
        </div>
    </div>

    <div class="tab-pane fade" id="tracking" role="tabpanel">
        <table class="table table-hover w-100" id="analytics-track-table">
            <thead>
                <tr>
                    <td>Tracker</td>
                    <td>Anonymous ID</td>
                    <td>User ID</td>
                    <td>Event</td>
                    <td>Timedate</td>
                    <td>Payload</td>
                    <td>Options</td>
                </tr>
            </thead>
            <tbody id="analytics-track-tbody">
            </tbody>
        </table>

        <div class="w-100" align="center">
            <button class="btn btn-outline-primary" onclick="downloadTrackContent()">Download Data</button>
        </div>
    </div>

    <div class="tab-pane fade" id="paging" role="tabpanel">
        <table class="table table-hover w-100" id="analytics-paging-table">
            <thead>
                <tr>
                    <td>Tracker</td>
                    <td>Anonymous ID</td>
                    <td>User ID</td>
                    <td>Name</td>
                    <td>Category</td>
                    <td>Timedate</td>
                    <td>Payload</td>
                    <td>Options</td>
                </tr>
            </thead>
            <tbody id="analytics-paging-tbody">
            </tbody>
        </table>

        <div class="w-100" align="center">
            <button class="btn btn-outline-primary" onclick="downloadPageContent()">Download Data</button>
        </div>
    </div>

    <div class="tab-pane fade" id="alias" role="tabpanel">
        <table class="table table-hover w-100" id="analytics-alias-table">
            <thead>
                <tr>
                    <td>Anonymous ID</td>
                    <td>User ID</td>
                    <td>Options</td>
                </tr>
            </thead>
            <tbody id="analytics-alias-tbody">
            </tbody>
        </table>
    </div>
</div>

<script src="scripts/vendors/jquery.min.js"></script>
<script src="scripts/vendors/jquery.dataTables.min.js"></script>
<script src="scripts/vendors/cryptojs.core.min.js"></script>
<script src="scripts/vendors/cryptojs.md5.min.js"></script>
<script src="scripts/util.js"></script>
<script src="scripts/rotating-button.js"></script>
<script src="scripts/appsec/analytics.js"></script>

<style>@import url("styles/jquery.dataTables.min.css");</style>