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

const trackId = new URLSearchParams(window.location.search).get("id");
if(!/^[0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12}$/i
    .test(trackId))
    window.location.href = "?";

const showMessage = (id, message)=> {
    $(id).removeClass("d-none");
    $(id).addClass("d-block");
    $(id).html(message);
};

const recoverButton = RotatingButton("#recover-btn");
$("#recover-btn").click(()=> {
    let email = $("#email").val(),
        password = $("#new-password").val(),
        confirm = $("#confirm-password").val();

    $("#error-msg").addClass("d-none");
    $("#success-msg").addClass("d-none");
    recoverButton.show();

    if(!email ||
        email.length == 0 ||
        !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email)) {
        showMessage("#error-msg", "Invalid email address.");
        recoverButton.hide();
        return;
    }

    if(!password ||
        password < 6 ||
        !isStrongPassword(password)) {
        showMessage("#error-msg", "Weak new password.");
        recoverButton.hide();
        return;
    }

    if(password != confirm) {
        showMessage("#error-msg", "New password and confirmation did not match.");
        recoverButton.hide();
        return;
    }

    $.post(
        "side/forgetpass.php",
        {
            email: email,
            newpass: CryptoJS.MD5(password).toString(),
            track_id: trackId
        },
        (r)=> {
            recoverButton.hide();
            if(r.result == 1) {
                $("#email").val(""),
                $("#new-password").val(""),
                $("#confirm-password").val("");

                showMessage("#success-msg", "Password changed! You can now log-in.");
                return;
            }

            showMessage("#error-msg", "Something went wrong.");
        }
    );
});