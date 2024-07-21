const showError = (id, message)=> {
    $("#" + id + "-error").removeClass("d-none")
    $("#" + id + "-error").addClass("d-block");
    $("#" + id + "-error").html(message);
}, hideError = (id)=> {
    $("#" + id + "-error").removeClass("d-block");
    $("#" + id + "-error").addClass("d-none");
};

const deleteBtn = RotatingButton("#delete-btn");
$("#delete-btn").click(()=> {
    const username = $("#deletion-username").val();
    const password = $("#deletion-password").val();
    let hasError = false;

    deleteBtn.show();
    hideError("deletion");

    if(!username ||
        username === "" ||
        !/^[a-zA-Z0-9_]+$/.test(username)) {
        showError("deletion", "Invalid username string.");
        hasError = true;
    }

    if(!password ||
        password === "" ||
        !isStrongPassword(password)) {
        showError("deletion", "Invalid password string.");
        hasError = true;
    }

    if(hasError) {
        deleteBtn.hide();
        return;
    }

    $.post({
        url: "side/apps.php?delete_app",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            username: username,
            password: CryptoJS.MD5(password).toString(),
            api_key: App.appKey
        },
        success: (data)=> {
            if(data.result == '0') {
                showError("deletion", data.message);
                $("#remove-modal").modal("hide");

                deleteBtn.hide();
                return;
            }

            window.location.href = ".";
        }
    });
});

$("#remove-btn").click(()=> {
    $.post(
        "side/apps.php?unshare_app",
        {
            api_key: App.appKey,
            email: App.email
        },
        (r)=> {
            hideError("remove");
            if(r.result == '1') {
                window.location.reload();
                return;
            }

            showError("remove", r.message);
        }
    );
});

$("#show-delete-modal").click(()=> {
    $("#deletion-username").val("");
    $("#deletion-password").val("");

    hideError("deletion");
    $("#delete-modal").modal("show");
});

$("#show-remove-modal").click(()=> {
    $("#remove-modal").modal("show");
});

$("#settings-save").click(()=> {
    let name = $("#app-name").val(),
        description = $("#app-desc").val();

    $("#settings-success").removeClass("d-block");
    $("#settings-success").addClass("d-none");

    $("#settings-error").removeClass("d-block");
    $("#settings-error").addClass("d-none");
    $("#settings-error").html("");

    if(name == "" || description == "") {
        $("#settings-error").removeClass("d-none");
        $("#settings-error").html("Name and/or description cannot be empty.");
        $("#settings-error").addClass("d-block");

        return;
    }

    if(name.length < 6 || !/^[a-zA-Z0-9_]+$/.test(name)) {
        $("#settings-error").removeClass("d-none");
        $("#settings-error").html("Invalid app name. It must only contain lower case alphabet, digits, and/or an underscore and must be greater than 6 characters.");
        $("#settings-error").addClass("d-block");

        return;
    }

    if(description.length < 6) {
        $("#settings-error").removeClass("d-none");
        $("#settings-error").html("Invalid app description. Must be greater than 6.");
        $("#settings-error").addClass("d-block");

        return;
    }

    $.post({
        url: "side/settings.php?save",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            name: name,
            description: description,
            api_key: App.appKey
        },
        success: (data)=> {
            if(data.result == '0') {
                $("#settings-error").removeClass("d-none");
                $("#settings-error").html("Something went wrong.");
                $("#settings-error").addClass("d-block");

                return;
            }

            $("#settings-success").removeClass("d-none");
            $("#settings-success").addClass("d-block");
        }
    });
});