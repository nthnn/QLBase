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