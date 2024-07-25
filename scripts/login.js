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

const showError = (id, message)=> {
    $(id).removeClass("d-none");
    $(id).addClass("d-block");
    $(id).html(message);
};

$(document).ready(()=> {
    const loginButton = RotatingButton("#log-in");
    $("#log-in").click(()=> {
        const username = $("#username").val();
        const password = $("#password").val();

        let hasError = false;
        loginButton.show();

        for(let id of ["username", "password", "login"]) {
            $("#" + id + "-error").removeClass("d-block")
            $("#" + id + "-error").addClass("d-none");
        }

        if(!username ||
            username === "" ||
            !/^[a-zA-Z0-9_]+$/.test(username)) {
            showError("#username-error", "Invalid username.");
            hasError = true;
        }

        if(!password ||
            password === "" ||
            !isStrongPassword(password)) {
            showError("#password-error", "Input password is not strong. ");
            hasError = true;
        }

        if(hasError) {
            loginButton.hide();
            return;
        }

        $.post(
            "side/account.php?login",
            {
                username: username,
                password: CryptoJS.MD5(password).toString()
            },
            (r)=> {
                loginButton.hide();
                if(r.result == 1) {
                    window.location.href = "?";
                    return;
                }

                showError("#login-error", "Incorrect username or password.");
            }
        );
    });
});