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
    $("#" + id + "-error").removeClass("d-none")
    $("#" + id + "-error").addClass("d-block");
    $("#" + id + "-error").html(message);
}, hideError = (id)=> {
    $("#" + id + "-error").removeClass("d-block");
    $("#" + id + "-error").addClass("d-none");
};

let prevSharedAccessHash = null,
    sharedAccessContent = [],
    tobeRemovedAccessor = null;
let shareBtn = RotatingButton("#share-btn"),
    removeBtn = RotatingButton("#remove-access-btn");

const removeSharedAccess = (email)=> {
    tobeRemovedAccessor = email;
    $("#remove-access-modal").modal("show");
}, removeAccess = ()=> {
    removeBtn.show();

    $.post({
        url: "side/apps.php?unshare_app",
        data: {
            api_key: App.appKey,
            email: tobeRemovedAccessor
        },
        success: (data)=> {
            removeBtn.hide();
            $("#remove-access-modal").modal("hide");

            if(data.result == "0") {
                $("#remove-access-failed-modal").modal("show");
                return;
            }

            $("#remove-access-success-modal").modal("show");
        }
    });
}, renderSharedList = ()=> {
    if(sharedAccessContent.length == 0) {
        $("#shared-access-tbody").html("<tr><td colspan=\"3\" align=\"center\">No shared access yet.</td></tr>");
        return;
    }

    let contents = "";
    for(let data of sharedAccessContent)
        contents += "<tr><td>" + data[0] + "</td><td>" + data[1] + "</td><td><button class=\"btn btn-sm btn-outline-danger\" onclick=\"removeSharedAccess('" + data[1] + "')\"><svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" width=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0\" /></svg></button></td></tr>";

    $("#shared-access-tbody").html(contents);
},fetchSharedList = ()=> {
    $.post({
        url: "side/apps.php?shared_list",
        data: {
            api_key: App.appKey
        },
        success: (data)=> {
            let hash = sha512(data.toString());
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
            password: sha512(password),
            api_key: App.appKey
        },
        success: (data)=> {
            if(data.result == "0") {
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
            if(r.result == "1") {
                window.location.reload();
                return;
            }

            showError("remove", r.message);
        }
    );
});

$("#share-btn").click(()=> {
    shareBtn.show();

    let email = $("#share-email").val(),
        username = $("#share-username").val(),
        password = sha512($("#share-password").val());

    if(!username ||
        username === "" ||
        !/^[a-zA-Z0-9_]+$/.test(username)) {
        showError("share", "Invalid username string.");
        shareBtn.hide();

        return;
    }

    if(!password ||
        password === "" ||
        !/^[a-f0-9]{32}$/.test(password)) {
        showError("share", "Invalid password string.");
        shareBtn.hide();

        return;
    }

    if(!email ||
        email.length == 0 ||
        !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email)) {
        showError("share", "Invalid email address.");
        shareBtn.hide();

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
            shareBtn.hide();
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
            if(data.result == "0") {
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