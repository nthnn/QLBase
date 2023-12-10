const showMessage = (id, message)=> {
    $(id).removeClass("d-none");
    $(id).addClass("d-block");
    $(id).html(message);
};

$("#recover-btn").click(()=> {
    let email = $("#email").val(),
        password = $("#new-password").val(),
        confirm = $("#confirm-password").val();

    $("#error-msg").addClass("d-none");
    $("#success-msg").addClass("d-none");

    if(!email ||
        email.length == 0 ||
        !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email)) {
        showMessage("#error-msg", "Invalid email address.");
        return;
    }

    if(!password ||
        password < 6 ||
        !isStrongPassword(password)) {
        showMessage("#error-msg", "Weak new password.");
        return;
    }

    if(password != confirm) {
        showMessage("#error-msg", "New password and confirmation did not match.");
        return;
    }

    showMessage("#success-msg", "Password changed! You can now log-in.");
});