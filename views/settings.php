<?php

include_once("controller/account.php");
include_once("controller/session_ctrl.php");

$user_id = SessionControl::getId();

$username = Account::getUsername($user_id);
$user_info = Account::getInfo($user_id);

$name = $user_info[0];
$email = $user_info[1];

?>
<nav class="navbar navbar-expand-lg bg-primary fixed-top shadow" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">QLBase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-main" aria-controls="navbar-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-main">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="?">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" id="logout" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                        </svg>
                        Logout (<?php echo $username; ?>)
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<br/><br/><br/><br/>

<div class="container">
    <div class="row">
        <div class="col-lg-3"></div>

        <div class="col-lg-6">
            <div class="card card-body border-primary">
                <h1>Settings</h1>
                <hr/>

                <div class="row">
                    <div class="col-3">
                        <label for="name" class="form-label">Name</label>
                    </div>

                    <div class="col-9">
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>" />
                    </div>
                </div>
                <p class="text-danger d-none" id="name-error"></p>

                <div class="row mt-2">
                    <div class="col-3">
                        <label for="username" class="form-label">Username</label>
                    </div>

                    <div class="col-9">
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo $username; ?>" disabled />
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-3">
                        <label for="email" class="form-label">Email</label>
                    </div>
                    
                    <div class="col-9">
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" />
                    </div>
                </div>
                <p class="text-danger d-none" id="email-error"></p>

                <div class="row mt-2">
                    <div class="col-3">
                        <label for="old-password" class="form-label">Old Password</label>
                    </div>

                    <div class="col-9">
                        <input type="password" id="old-password" name="old-password" class="form-control" />
                    </div>
                </div>
                <p class="text-danger d-none" id="old-password-error"></p>

                <div class="row mt-2">
                    <div class="col-3">
                        <label for="new-password" class="form-label">New Password</label>
                    </div>

                    <div class="col-9">
                        <input type="password" id="new-password" name="new-password" class="form-control" />
                    </div>
                </div>
                <p class="text-danger d-none" id="new-password-error"></p>

                <hr/>
                <p class="text-danger d-none" id="save-error"></p>
                <button type="button" class="btn btn-primary" id="save-settings">Save</button>
            </div>
        </div>

        <div class="col-lg-3"></div>
    </div>
</div>

<script src="scripts/vendors/jquery.min.js"></script>
<script src="scripts/vendors/bootstrap.bundle.min.js"></script>
<script src="scripts/vendors/cryptojs.core.min.js"></script>
<script src="scripts/vendors/cryptojs.md5.min.js"></script>
<script src="scripts/util.js"></script>
<script src="scripts/settings.js"></script>

<?php include_once("components/footer.html"); ?>