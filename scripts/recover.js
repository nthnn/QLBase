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
        "api/forgetpass.php",
        {
            email: email,
            newpass: CryptoJS.MD5(password).toString(),
            track_id: trackId
        },
        (r)=> {
            recoverButton.hide();
            if(r.result == 1) {
                showMessage("#success-msg", "Password changed! You can now log-in.");
                return;
            }

            showMessage("#error-msg", "Something went wrong.");
        }
    );
});