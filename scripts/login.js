const showError = (id, message)=> {
    $(id).removeClass("d-none");
    $(id).addClass("d-block");
    $(id).html(message);
};

$(document).ready(()=> {
    const loginButton = RotatingButton("#log-in");
    console.log(loginButton);
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