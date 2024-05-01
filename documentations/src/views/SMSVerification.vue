<template>
    <h3 class="border-bottom">✉️ SMS Verification</h3>
    <p>Easily integrate SMS verification into your application using QLBase's OTP service. Protect your user accounts with one-time passwords sent via SMS. QLBase provides SMS verification functionality using an Arduino UNO with a SIM900 Shield as the underlying SMS hardware. This setup allows you to seamlessly integrate SMS verification into your application for added security.</p>

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <img src="@/assets/qlbase-cat-4.png" width="100%" />
        </div>

        <div class="col-lg-6 col-md-6">
            <br class="desktop-only" />
            <ol>
                <li><b>OTP Generation:</b> Utilizing the Arduino UNO with the SIM900 Shield, QLBase facilitates the secure generation of unique six-digit OTPs, ensuring a robust mechanism for user verification.</li>
                <li><b>SMS Delivery:</b> The integration with Arduino's SIM900 allows QLBase to send SMS messages efficiently, providing users with the necessary OTP for verification purposes. Including support contact details adds an extra layer of assistance.</li>
            </ol>
        </div>
    </div>

    <ol start="3">
        <li><b>Verification Endpoint:</b> Users can interact with the verification endpoint, providing the OTP received via SMS to confirm their phone numbers. This API-driven verification process enhances the user experience by integrating with your application's workflows.</li>
    </ol>
    <br/>

    <h4 class="border-bottom">📡 Authentication API Calls</h4>
    <hr/>
    <div class="row">
        <div class="col-6">
            <RouterLink to="/authentication" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>

                Authentication
            </RouterLink>
        </div>

        <div class="col-6">
            <div align="right">
                <RouterLink to="/data-analytics" class="btn btn-primary">
                    Data Analytics

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </RouterLink>
            </div>
        </div>
    </div>
</template>