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
<script src="scripts/util.js"></script>
<script src="scripts/rotating-button.js"></script>
<script src="scripts/appsec/analytics.js"></script>

<style>@import url("styles/jquery.dataTables.min.css");</style>