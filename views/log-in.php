<div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container animate__animated animate__slideInDown" align="center">
        <div class="col-lg-8" align="left">
            <div class="card card-body border-primary shadow">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mobile-only">
                            <center>
                                <img src="assets/qlbase-logo.png" width="50%" />
                                <h1 class="mt-2">Log-in</h1>
                            </center>
                        </div>

                        <h1 class="desktop-only">Log-in</h1>
                        <hr/>

                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" class="form-control" placeholder="Username" />
                        <p class="text-danger d-none" id="username-error"></p>

                        <label for="password" class="form-label mt-2">Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Password" />
                        <p class="text-danger d-none" id="password-error"></p>
                        <br/>

                        <p class="text-danger d-none" id="login-error"></p>
                        <div class="btn-group w-100">
                            <button class="btn btn-primary w-75" id="log-in">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.0" stroke="currentColor" width="18" height="18" class="mb-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                                Log-in
                            </button>

                            <a class="btn btn-outline-primary" href="?">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                            </a>
                        </div>
                        <hr/>

                        <p align="center">You can <a href="?page=sign-up" class="text-decoration-none">sign-up</a> if you don't have an account yet. Or click here if you <a href="?page=forgot" class="text-decoration-none">forgot your password</a>.</p>
                    </div>

                    <div class="col-lg-6 d-flex justify-content-center align-items-center" align="center">
                        <img src="assets/qlbase-logo.png" class="desktop-only" width="80%" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="scripts/vendors/jquery.min.js"></script>
<script src="scripts/vendors/cryptojs.core.min.js"></script>
<script src="scripts/vendors/cryptojs.md5.min.js"></script>
<script src="scripts/util.js"></script>
<script src="scripts/login.js"></script>