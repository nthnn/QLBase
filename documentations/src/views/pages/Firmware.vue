<template>
    <h1 class="border-bottom">💽 Firmware</h1>
    <p>The SMS OTP feature in QLBase is of utmost importance, providing a secure user authentication method through one-time passwords sent via SMS. In the following sections, you'll discover an in-depth look at the firmware, complete with setup instructions to make integration a smooth process.</p>
    <br/>

    <h3 class="border-bottom">⚡ Components</h3>
    <p>The hardware components for the SMS OTP firmware of the QLBase requires only two boards: Arduino UNO development board and SIM900 GSM/GPRS UNO Shield.</p>

    <hr/>
    <div class="row">
        <div class="col-6">
            <RouterLink to="/deployment" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>

                Deployment
            </RouterLink>
        </div>

        <div class="col-6">
            <div align="right">
                <RouterLink to="/contrib" class="btn btn-primary">
                    Contributing and Contributors

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </RouterLink>
            </div>
        </div>
    </div>
</template>