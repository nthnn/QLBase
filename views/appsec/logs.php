<div class="row">
    <div class="col-6"><h1>Log Reports</h1></div>
    <div class="col-6" align="right">
        <button class="btn btn-outline-primary" onclick="downloadLogs()">Download Logs</button>
    </div>
</div>
<hr/>

<table id="logs-table" class="table table-hover w-100" cellspacing="0">
    <thead>
        <th>Client</th>
        <th>Action</th>
        <th>Date/Time</th>
        <th>User-Agent</th>
        <th>Origin</th>
    </thead>
    <tbody id="logs-table-body">
    </tbody>
</table>
<hr/>

<div class="w-100">
    <input type="checkbox" id="hide-selfreqs" onclick="fetchLogs()" checked />
    <label for="hide-selfreqs">Hide self-requests on logs</label>
</div>

<script src="scripts/vendors/jquery.min.js"></script>
<script src="scripts/vendors/jquery.dataTables.min.js"></script>
<script src="scripts/vendors/dataTables.responsive.min.js"></script>
<script src="scripts/vendors/sha512.min.js"></script>
<script src="scripts/datatable-init.js"></script>
<script src="scripts/appsec/logs.js"></script>

<style>@import url("styles/jquery.dataTables.min.css");</style>