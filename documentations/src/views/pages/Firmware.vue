<template>
    <h1 class="border-bottom">💿 Firmware</h1>
    <p>The SMS OTP feature in QLBase is of utmost importance, providing a secure user authentication method through one-time passwords sent via SMS. In the following sections, you'll discover an in-depth look at the firmware, complete with setup instructions to make integration a smooth process.</p>
    <br/>

    <h3 class="border-bottom">⚡ Components</h3>
    <p>The SMS OTP (Short Message Service One-Time Password) firmware, an integral part of the QLBase system, relies on a concise and efficient hardware setup. This essential framework necessitates the utilization of just two key components, namely the Arduino UNO development board and the SIM900 GSM/GPRS UNO Shield.</p>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card card-body">
                <img src="@/assets/board-arduino-uno.png" width="100%" />
                <b class="card-title" align="center">Arduino UNO</b>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-body">
                <img src="@/assets/board-sim900-shield.png" width="100%" />
                <b class="card-title" align="center">SIM900 GSM/GPRS Shield</b>
            </div>
        </div>
    </div>

    <p>The Arduino Uno board is a popular and versatile microcontroller platform that serves as a foundation for countless DIY electronics projects. Developed by Arduino, an open-source hardware and software community, the Uno is designed for both beginners and experienced electronics enthusiasts, making it an ideal choice for those looking to learn, experiment, and prototype with microcontrollers.</p>
    <p>While, the SIM900 GSM/GPRS Uno Shield is a specialized add-on module designed to work in conjunction with Arduino Uno and compatible microcontroller boards. This shield enables wireless communication over the Global System for Mobile Communications (GSM) and General Packet Radio Service (GPRS) networks, making it a valuable tool for projects that require remote data transmission, SMS messaging, and internet connectivity.</p>
    <br/>

    <h3 class="border-bottom">🔧 Hardware Setup</h3>
    <p>Before you can upload the firmware, you need to set up your development environment and configure the Arduino UNO with the SIM900 shield. Ensure that you have an Arduino UNO and a SIM900 shield. Connect the SIM900 shield to the Arduino UNO, and make sure the following pin connections below are in accordance:</p>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Arduino UNO</th>
                <th>SIM900 Shield</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>5V</td>
                <td>VCC</td>
            </tr>
            <tr>
                <td>GND</td>
                <td>GND</td>
            </tr>
            <tr>
                <td>D7</td>
                <td>RX</td>
            </tr>
            <tr>
                <td>D8</td>
                <td>TX</td>
            </tr>
        </tbody>
    </table>

    <p>For more informations about using the SIM900 GSM/GPRS shield, please refer to this <a href="https://lastminuteengineers.com/sim900-gsm-shield-arduino-tutorial/" target="_blank" class="text-decoration-none">article</a>.</p>
    <br/>

    <h3 class="border-bottom">📡Uploading the Firmware</h3>
    <p>In this crucial steps, we will guide you through the process of uploading the SMS OTP firmware to your Arduino UNO with the SIM900 shield. This action is pivotal for enabling secure user authentication through SMS OTP for QLBase.</p>
    <ol>
        <li>Begin by installing <a href="https://code.visualstudio.com/" target="_blank" class="text-decoration-none">Visual Studio Code</a>, a versatile and powerful integrated development environment (IDE).</li>
        <li>Install the <a href="https://platformio.org/" target="_blank" class="text-decoration-none">PlatformIO</a> extension for Visual Studio Code.</li>
        <li>Open the <a href="https://github.com/nthnn/QLBase/tree/main/sms-otp-firmware" target="_blank" class="text-decoration-none">sms-otp-firmware</a> folder inside the QLBase in Visual Studio Code using the PlatformIO extension.</li>
        <li>Configure your SIM900 power source and wait for it to blink every 3 seconds.</li>
        <li>Use PlatformIO to build and upload the firmware to your Arduino UNO with the SIM900 shield by clicking the upload button at the lower left bottom bar of the Visual Studio Code.</li>
    </ol>
    <p>After following these steps, you can now connect the Arduino UNO to your computer where the QLBase is running to use the SMS-OTP API service.</p>

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