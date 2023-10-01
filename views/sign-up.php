<div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container animate__animated animate__slideInDown" align="center">
        <div class="col-lg-8" align="left">
            <div class="card card-body border-primary shadow">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mobile-only">
                            <center>
                                <img src="assets/qlbase-logo.png" width="50%" />
                                <h1 class="mt-2">Sign-up</h1>
                            </center>
                        </div>

                        <h1 class="desktop-only">Sign-up</h1>
                        <hr/>

                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" class="form-control" placeholder="Username" />
                        <p class="text-danger d-none" id="username-error"></p>

                        <label for="name" class="form-label mt-2">Name</label>
                        <input type="text" id="name" class="form-control" placeholder="Name" />
                        <p class="text-danger d-none" id="name-error"></p>

                        <label for="email" class="form-label mt-2">Email</label>
                        <input type="email" id="email" class="form-control" placeholder="Email" />
                        <p class="text-danger d-none" id="email-error"></p>

                        <label for="password" class="form-label mt-2">Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Password" />
                        <p class="text-danger d-none" id="password-error"></p>
                        <br/>

                        <p class="text-danger d-none" id="signup-error"></p>
                        <div class="btn-group w-100">
                            <button class="btn btn-primary w-75" id="sign-up">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.0" stroke="currentColor" width="18" height="18" class="mb-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Sign-up
                            </button>

                            <a class="btn btn-outline-primary" href="?">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                            </a>
                        </div>
                        <hr/>

                        <p align="center">Or <a href="?page=log-in" class="text-decoration-none">log-in</a> if you already have an account.</p>
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
<script src="scripts/signup.js"></script>