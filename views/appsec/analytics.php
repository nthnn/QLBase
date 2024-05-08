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

<div class="row">
    <div class="col-6"><h1>Data Analytics</h1></div>
    <div class="col-6" align="right">
        <a class="btn btn-primary" target="_blank" href="docs/<?php echo $docsLink; ?>">API Documentations</a>
    </div>
</div>
<hr/>

<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" data-bs-toggle="tab" href="#identify" aria-selected="true" role="tab">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
            <span class="desktop-only">Identify</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#tracking" aria-selected="false" tabindex="-1" role="tab">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
            </svg>
            <span class="desktop-only">Tracking</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#paging" aria-selected="false" tabindex="-1" role="tab">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
            </svg>
            <span class="desktop-only">Paging</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#alias" aria-selected="false" tabindex="-1" role="tab">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
            <span class="desktop-only">Alias</span>
        </a>
    </li>
</ul>
<br/>

<div class="tab-content">
    <div class="tab-pane fade show active" id="identify" role="tabpanel">
        <h3 class="mobile-only">Identification Analytics<hr/></h3>
        <table class="table table-hover w-100" id="analytics-id-table" cellspacing="0">
            <thead>
                <tr>
                    <th>Tracker</th>
                    <th>Anonymous ID</th>
                    <th>User ID</th>
                    <th>Timedate</th>
                    <th>Payload</th>
                    <th>Options</th>
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
        <h3 class="mobile-only">Tracking Analytics<hr/></h3>
        <table class="table table-hover w-100" id="analytics-track-table" cellspacing="0">
            <thead>
                <tr>
                    <th>Tracker</th>
                    <th>Anonymous ID</th>
                    <th>User ID</th>
                    <th>Event</th>
                    <th>Timedate</th>
                    <th>Payload</th>
                    <th>Options</th>
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
        <h3 class="mobile-only">Page Analytics<hr/></h3>
        <table class="table table-hover w-100" id="analytics-paging-table" cellspacing="0">
            <thead>
                <tr>
                    <th>Tracker</th>
                    <th>Anonymous ID</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Timedate</th>
                    <th>Payload</th>
                    <th>Options</th>
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
        <h3 class="mobile-only">Tracker Aliases<hr/></h3>
        <table class="table table-hover w-100" id="analytics-alias-table" cellspacing="0">
            <thead>
                <tr>
                    <th>Anonymous ID</th>
                    <th>User ID</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody id="analytics-alias-tbody">
            </tbody>
        </table>
    </div>
</div>

<script src="scripts/vendors/jquery.min.js"></script>
<script src="scripts/vendors/jquery.dataTables.min.js"></script>
<script src="scripts/vendors/dataTables.responsive.min.js"></script>
<script src="scripts/vendors/cryptojs.core.min.js"></script>
<script src="scripts/vendors/cryptojs.md5.min.js"></script>
<script src="scripts/util.js"></script>
<script src="scripts/rotating-button.js"></script>
<script src="scripts/datatable-init.js"></script>
<script src="scripts/appsec/analytics.js"></script>

<style>@import url("styles/jquery.dataTables.min.css");</style>