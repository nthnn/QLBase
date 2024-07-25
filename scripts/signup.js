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
    const signUpButton = RotatingButton("#sign-up");
    $("#sign-up").click(()=> {
        const username = $("#username").val();
        const name = $("#name").val();
        const email = $("#email").val();
        const password = $("#password").val();

        const defaultErrorMessage = "Something went wrong, please try again later.";
        let hasError = false;
        signUpButton.show();

        for(let id of ["username", "name", "email", "password", "signup"]) {
            $("#" + id + "-error").removeClass("d-block")
            $("#" + id + "-error").addClass("d-none");
        }

        if(!username ||
            username.length < 6 ||
            !/^[a-zA-Z0-9_]+$/.test(username)) {
            showError("#username-error", "Invalid username.");
            hasError = true;
        }

        if(!name ||
            name.length < 5 ||
            !/^[A-Za-z\s]+$/.test(name)) {
            showError("#name-error", "Invalid name of user.");
            hasError = true;
        }

        if(!email ||
            email.length == 0 ||
            !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email)) {
            showError("#email-error", "Invalid email address.");
            hasError = true;
        }

        if(!password ||
            password < 6 ||
            !isStrongPassword(password)) {
            showError("#password-error", "Input password is not strong. ");
            hasError = true;
        }

        if(hasError) {
            signUpButton.hide();
            return;
        }

        const hashedPassword = CryptoJS.MD5(password).toString();
        $.post(
            "side/account.php?signup",
            {
                username: username,
                name: name,
                email: email,
                password: hashedPassword
            },
            (e)=> {
                signUpButton.hide();

                if(e.result == 0)
                    showError("#signup-error", e.message);
                else if(e.result == 1) {
                    $.post(
                        "side/account.php?login",
                        {
                            username: username,
                            password: hashedPassword
                        },
                        (r)=> {
                            if(r.result == 1) {
                                window.location.href = "?";
                                return;
                            }
    
                            showError("#signup-error", defaultErrorMessage);
                        }
                    );
                }
                else showError("#signup-error", defaultErrorMessage);
            }
        );
    });
});