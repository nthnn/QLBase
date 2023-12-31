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