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
                <pre class="bg-secondary p-2 border border-gray rounded" id="payload-content"></pre>
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
    </div>
    <div class="tab-pane fade" id="tracking" role="tabpanel">
        <table class="table table-hover w-100" id="analytics-tracking-table">
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
            <tbody id="analytics-tracking-tbody">
            </tbody>
        </table>
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