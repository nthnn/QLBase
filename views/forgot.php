<div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container animate__animated animate__slideInDown" align="center">
        <div class="col-lg-4" align="left">
            <div class="card card-body border-primary shadow">
                <center>
                    <img src="assets/qlbase-logo.png" width="50%" class="mobile-only" />
                    <img src="assets/qlbase-logo.png" width="40%" class="desktop-only" />
                    <h1 class="mt-2">Forgot Password</h1>
                </center>
                <hr/>

                <label for="ue" class="form-label">Username or Email</label>
                <input type="text" id="ue" class="form-control" placeholder="Username or Email" />

                <p class="text-danger d-none" id="ue-error"></p>
                <p class="text-primary d-none" id="ue-success"></p>

                <p class="text-danger d-none" id="fp-error"></p>
                <div class="btn-group w-100 mt-2">
                    <button class="btn btn-primary w-75" id="forgot-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        Request Recovery
                    </button>

                    <a class="btn btn-outline-primary" href="?">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    </a>
                </div>
                <hr/>

                <p align="center">Or click here to <a href="?page=sign-up" class="text-decoration-none">sign-up</a> or <a href="?page=log-in" class="text-decoration-none">log-in</a>.</p>
            </div>
        </div>
    </div>
</div>

<script src="scripts/vendors/jquery.min.js"></script>
<script src="scripts/util.js"></script>
<script src="scripts/forgot.js"></script>