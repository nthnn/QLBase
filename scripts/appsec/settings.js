const showError = (id, message)=> {
    $("#" + id + "-error").removeClass("d-none")
    $("#" + id + "-error").addClass("d-block");
    $("#" + id + "-error").html(message);
}, hideError = (id)=> {
    $("#" + id + "-error").removeClass("d-block");
    $("#" + id + "-error").addClass("d-none");
};

let prevSharedAccessHash = null,
    sharedAccessContent = [];
const renderSharedList = ()=> {
    if(sharedAccessContent.length == 0) {
        $("#shared-access-tbody").html("<tr><td colspan=\"3\" align=\"center\">No shared access yet.</td></tr>");
        return;
    }

    let contents = "";
    for(let data of sharedAccessContent)
        contents += "<tr><td>" + data[0] + "</td><td>" + data[1] + "</td><td></td></tr>";

    $("#shared-access-tbody").html(contents);
},fetchSharedList = ()=> {
    $.post({
        url: "side/apps.php?shared_list",
        data: {
            api_key: App.appKey
        },
        success: (data)=> {
            let hash = CryptoJS.MD5(data.toString()).toString();
            if(hash == prevSharedAccessHash)
                return;
            prevSharedAccessHash = hash;

            if(data.length == 0) {
                prevSharedAccessHash = null;
                sharedAccessContent = [];

                renderSharedList();
                return;
            }

            sharedAccessContent = data;
            renderSharedList();
        }
    });
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

$("#share-btn").click(()=> {
    let email = $("#share-email").val(),
        username = $("#share-username").val(),
        password = CryptoJS.MD5($("#share-password").val()).toString();

    if(!username ||
        username === "" ||
        !/^[a-zA-Z0-9_]+$/.test(username)) {
        showError("share", "Invalid username string.");
        return;
    }

    if(!password ||
        password === "" ||
        !/^[a-f0-9]{32}$/.test(password)) {
        showError("share", "Invalid password string.");
        return;
    }

    if(!email ||
        email.length == 0 ||
        !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email)) {
        showError("share", "Invalid email address.");
        return;
    }

    $.post(
        "side/apps.php?share_app",
        {
            api_key: App.appKey,
            api_id: App.appId,
            uname: username,
            pword: password,
            email: email
        },
        (r)=> {
            hideError("share");
            if(r.result == "1") {
                $("#share-access-modal").modal("hide");
                $("#access-shared-modal").modal("show");

                fetchSharedList();
                return;
            }

            showError("share", r.message);
        }
    );
});

$("#show-delete-modal").click(()=> {
    $("#deletion-username").val("");
    $("#deletion-password").val("");

    hideError("deletion");
    $("#delete-modal").modal("show");
});

$("#show-share-modal").click(()=> {
    $("#share-username").val("");
    $("#share-password").val("");
    $("#share-email").val("");

    hideError("share");
    $("#share-access-modal").modal("show");
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

fetchSharedList();
setInterval(fetchSharedList, 2000);