<?php
    include_once("controller/validator.php");

    if(!isset($_GET["id"]) || empty($_GET["id"])) {
        header("Location: ?");
        return;
    }

    $id = $_GET["id"];
    if(!Validate::uuid($id)) {
        header("Location: ?");
        return;
    }

    include_once("controller/db_config.php");

    global $db_conn;
    $res = mysqli_query($db_conn, "SELECT * FROM recovery WHERE track_id=\"".$id."\"");
    $count = mysqli_num_rows($res);

    if($count != 1) {
        header("Location: ?");
        return;
    }
?>
<div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container" align="center">
        <div class="col-lg-4" align="left">
            <div class="card card-body border-primary shadow">
                <center>
                    <img src="assets/qlbase-logo.png" width="50%" class="mobile-only" />
                    <img src="assets/qlbase-logo.png" width="40%" class="desktop-only" />
                    <h1 class="mt-2">Account Recovery</h1>
                </center>
                <hr/>

                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" class="form-control" placeholder="Email" />

                <label for="new-password" class="form-label">New Password</label>
                <input type="password" id="new-password" class="form-control" placeholder="New Password" />

                <label for="confirm-password" class="form-label mt-2">Confirm Password</label>
                <input type="password" id="confirm-password" class="form-control" placeholder="Confirm Password" />

                <p class="text-danger d-none" id="ue-error"></p>
                <p class="text-primary d-none" id="ue-success"></p>

                <p class="text-danger d-none" id="error-msg"></p>
                <p class="text-info d-none" id="success-msg"></p>
                <button class="btn btn-primary mt-2" id="recover-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    Save Password
                </button>
                <hr/>

                <p align="center">Or click here to <a href="?page=sign-up" class="text-decoration-none">sign-up</a> or <a href="?page=log-in" class="text-decoration-none">log-in</a>.</p>
            </div>
        </div>
    </div>
</div>

<script src="scripts/vendors/jquery.min.js"></script>
<script src="scripts/vendors/cryptojs.core.min.js"></script>
<script src="scripts/vendors/cryptojs.md5.min.js"></script>
<script src="scripts/util.js"></script>
<script src="scripts/rotating-button.js"></script>
<script src="scripts/recover.js"></script>