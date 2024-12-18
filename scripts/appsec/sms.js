/*
 * This file is part of QLBase (https://github.com/nthnn/QLBase).
 * Copyright 2024 - Nathanne Isip
 * 
 * Permission is hereby granted, free of charge,
 * to any person obtaining a copy of this software
 * and associated documentation files (the “Software”),
 * to deal in the Software without restriction,
 * including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to
 * whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions
 * of the Software.
 * 
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF
 * ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT
 * SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR
 * ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

let prevSMSHash = "";
let deletableVerification = null,
    deletableOTP = null,
    dataTable = null;

function deleteVerification(recipient, code) {
    deletableVerification = recipient;
    deletableOTP = code;

    $("#deletable-verification").html(deletableVerification);
    $("#deletable-otp").html(deletableOTP);
    $("#confirm-delete-modal").modal("show");
}

function requestVerificationDeletion() {
    $.post({
        url: "api/index.php?action=sms_delete_otp&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            recipient: deletableVerification,
            code: deletableOTP
        },
        success: (data)=> {
            if(data.result == "0")
                return;

            $("#success-message").html("Removed OTP verification.");
            $("#confirm-delete-modal").modal("hide");
            $("#success-modal").modal("show");
        }
    }).fail(()=> {
        $("#confirm-delete-modal").modal("hide");
        $("#error-message").html("Error trying to remove the OTP verification.");
        $("#error-modal").modal("show");
    });
}

const fetchSMSLogs = ()=> {
    $.post({
        url: "api/index.php?action=sms_fetch_all&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == "0")
                return;

            let tempHash = sha512(JSON.stringify(data));
            if(prevSMSHash == tempHash)
                return;
            prevSMSHash = tempHash;

            if(data.value.length == 0 && (prevSMSHash != "" ||
                prevSMSHash == "5e28988ff412b216da4a633fa9ff52f5")) {
                dataTable.clear().destroy();
                dataTable = initDataTable("#sms-table", "No SMS OTP verficiations found.");

                return;
            }

            let otpRows = "";
            const enabilityIcon = {
                "1": "<svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" width=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M4.5 12.75l6 6 9-13.5\" /></svg>",
                "0": "<svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" width=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M6 18L18 6M6 6l12 12\" /></svg>"
            };

            data.value.forEach((e)=>
                otpRows += "<tr><td>" + e[0] +
                    "</td><td>" + e[1] +
                    "</td><td>" + e[2] +
                    "</td><td>" + e[3] +
                    "</td><td>" + enabilityIcon[e[4]] +
                    "</td><td><button class=\"btn btn-sm btn-outline-danger\" onclick=\"deleteVerification('" +
                    e[0] + "', '" + e[1] + "')\"><svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" width=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0\" /></svg>" +
                    "</button></td></tr>"
            );

            $("#sms-table-body").html(otpRows);
        }
    });
};

$(document).ready(()=> {
    dataTable = initDataTable("#sms-table", "No SMS OTP verficiations found.");

    fetchSMSLogs();
    setInterval(fetchSMSLogs, 2000);
});
