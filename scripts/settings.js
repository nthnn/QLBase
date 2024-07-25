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

const showError = (input, message)=> {
    $("#" + input + "-error")
        .removeClass("d-none")
        $("#" + input + "-error").addClass("d-block");
    $("#" + input + "-error")
        .html(message);
};

const hideErrors = ()=> {
    for(let input of ["name", "email", "old-password", "new-password"]) {
        $("#" + input + "-error").removeClass("d-block")
        $("#" + input + "-error").addClass("d-none");
    }
};

$(document).ready(()=> {
    $("#logout").click(()=> {
        $.post(
            "side/account.php?logout",
            {},
            ()=> window.location.href = "?"
        );
    });

    $("#save-settings").click(()=> {
        let username = $("#username").val(),
            name = $("#name").val(),
            email = $("#email").val(),
            oldPassword = $("#old-password").val(),
            newPassword = $("#new-password").val(),
            hasError = false;

        hideErrors();
        if(!name ||
            name.length < 5 ||
            !/^[A-Za-z\s]+$/.test(name)) {
            showError("name", "Invalid name of user.");
            hasError = true;
        }
        
        if(!email ||
            email.length == 0 ||
            !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email)) {
            showError("email", "Invalid email address.");
            hasError = true;
        }
        
        if(!oldPassword ||
            oldPassword < 6 ||
            !isStrongPassword(oldPassword)) {
            showError("old-password", "Invalid old password.");
            hasError = true;
        }

        if(!newPassword ||
            newPassword < 6 ||
            !isStrongPassword(newPassword)) {
            showError("new-password", "Weak new password. Must at least contain both lower and upper case letter, digits, and symbol.");
            hasError = true;
        }

        if(hasError)
            return;

        $.post(
            "side/account.php?login",
            {
                username: username,
                password: CryptoJS.MD5(oldPassword).toString()
            },
            (r)=> {
                if(r.result == "1") {
                    $.post(
                        "side/account.php?update",
                        {
                            username: username,
                            name: name,
                            email: email,
                            password: CryptoJS.MD5(newPassword).toString(),
                            old: CryptoJS.MD5(oldPassword).toString()
                        },
                        (rs)=> {
                            if(rs.result == "1")
                                window.location.reload();
                            else showError("save", rs.message);
                        }
                    );

                    return;
                }

                showError("save", "Incorrect old password.");
            }
        );
    });
});