let prevUsersHash = "";
let dataTable = null;

let deletableUser = null;
function deleteUser(username) {
    deletableUser = username;

    $("#deletable-username").html(deletableUser);
    $("#confirm-delete-modal").modal("show");
}

let editableUser = null, editableEmail = null;
function editUser(username, email, enabled) {
    editableUser = username;
    editableEmail = email;

    $("#username-edit").val(editableUser);
    $("#email-edit").val(editableEmail);
    $("#edit-user-modal").modal("show");

    $("#edit-error").removeClass("d-block");
    $("#edit-error").addClass("d-none");

    if(enabled) $("#enabled-edit").attr("checked", "true");
}

function requestUserDeletion() {
    $.post(
        "api?action=delete_by_username&api_key=" +
        App.appKey + "&app_id=" + App.appId + "&username=" +
        deletableUser,
        {},
        (data)=> {
            if(data.result == '0') {
                $("#failed-message").html("Somthing went wrong.");
                $("#failed-modal").modal("show");

                return;
            }

            $("#confirm-delete-modal").modal("hide");
            $("#success-message").html(
                "User &quot;" + deletableUser +
                "&quot; was successfully removed."
            );
            $("#success-modal").modal("show");

            deletableUser = null;
        }
    );
}

function requestSaveEdit() {
    const username = $("#username-edit").val();
    const email = $("#email-edit").val();
    const password = $("#password-edit").val();
    const confirmation = $("#confirm-password-edit").val();
    let hasError = false;

    for(let id of ["email-edit", "password-edit", "confirm-password-edit", "add"]) {
        $("#" + id + "-error").removeClass("d-block")
        $("#" + id + "-error").addClass("d-none");
    }

    if(!username ||
        username === "" ||
        !/^[a-zA-Z0-9_]+$/.test(username)) {
        showError("username-edit", "Invalid username.");
        hasError = true;
    }

    if(!email ||
        email.length == 0 ||
        !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email)) {
        showError("email-edit", "Invalid email address.");
        hasError = true;
    }

    if(!password ||
        password.length < 6 ||
        !isStrongPassword(password)) {
        showError("password-edit", "Input password is not strong.");
        hasError = true;
    }

    if(confirmation != password) {
        showError("confirm-password-edit", "Password confirmation did not match.");
        hasError = true;
    }

    if(hasError)
        return;

    $.post(
        "api?api_key=" + App.appKey +
        "&app_id=" + App.appId +
        "&action=update_by_username&username=" + username +
        "&email=" + email + "&password=" +
        CryptoJS.MD5(password).toString() +
        "&enabled=" + ($("#enabled-edit").is(":checked") ? 1 : 0),
        {},
        (data)=> {
            if(data.result == '0') {
                showError("edit", data.message);
                return;
            }

            $("#edit-user-modal").modal("hide");
            $("#username-edit").val("");
            $("#email-edit").val("");
            $("#password-edit").val("");
            $("#confirm-password-edit").val("");
            $("#enabled-edit").attr("checked", "false");

            $("#success-message").html(
                "User &quot;" + username +
                "&quot; was successfully edited."
            );
            $("#success-modal").modal("show");
        }
    );
}

const showError = (id, message)=> {
    $("#" + id + "-error").removeClass("d-none");
    $("#" + id + "-error").addClass("d-block");
    $("#" + id + "-error").html(message);
};

const fetchUsers = ()=> {
    $.post(
        "api/?api_key=" + App.appKey +
        "&app_id=" + App.appId +
        "&action=fetch_all_users",
        {},
        (data)=> {
            if(data.result == '0')
                return;

            if(data.value.length == 0) {
                $("#user-table").html("<tr><td colspan=\"5\" align=\"center\">No users yet.</td></tr>");
                return;
            }

            if(prevUsersHash == CryptoJS.MD5(JSON.stringify(data)).toString())
                return;
            prevUsersHash = CryptoJS.MD5(JSON.stringify(data)).toString();

            let accRows = "";
            const enabilityIcon = {
                "1": "<svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" width=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M4.5 12.75l6 6 9-13.5\" /></svg>",
                "0": "<svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" width=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M6 18L18 6M6 6l12 12\" /></svg>"
            };

            for(let acc of data.value) {
                accRows += "<tr><td>" + acc[0] + "</td><td>" +
                    acc[1] + "</td><td>" + enabilityIcon[acc[2]] + "</td><td>" + acc[3] +
                    "</td><td><button class=\"btn btn-sm btn-outline-primary mx-2\" onclick=\"editUser('" +
                    acc[0] + "', '" + acc[1] + "', " + acc[2] + ")\"><svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" widht=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10\" /></svg></button><button class=\"btn btn-sm btn-outline-danger\" onclick=\"deleteUser('" +
                    acc[0] +"')\"><svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" width=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0\" /></svg>" +
                    "</button></td></tr>";
            }

            $("#user-table").html(accRows);
            new DataTable("#auth-table");
        }
    )
};

$(document).ready(()=> {
    $("#add-btn").click(()=> {
        const username = $("#username").val();
        const email = $("#email").val();
        const password = $("#password").val();
        const confirmation = $("#confirm-password").val();
        let hasError = false;

        for(let id of ["username", "email", "password", "confirm-password", "add"]) {
            $("#" + id + "-error").removeClass("d-block")
            $("#" + id + "-error").addClass("d-none");
        }

        if(!username ||
            username === "" ||
            !/^[a-zA-Z0-9_]+$/.test(username)) {
            showError("username", "Invalid username.");
            hasError = true;
        }

        if(!email ||
            email.length == 0 ||
            !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email)) {
            showError("email", "Invalid email address.");
            hasError = true;
        }

        if(!password ||
            password.length < 6 ||
            !isStrongPassword(password)) {
            showError("password", "Input password is not strong.");
            hasError = true;
        }

        if(confirmation != password) {
            showError("confirm-password", "Password confirmation did not match.");
            hasError = true;
        }

        if(hasError)
            return;

        $.post(
            "api?api_key=" + App.appKey +
            "&app_id=" + App.appId +
            "&action=new_user&username=" + username +
            "&email=" + email + "&password=" +
            CryptoJS.MD5(password).toString() +
            "&enabled=" + ($("#enabled").is(":checked") ? 1 : 0),
            {},
            (data)=> {
                if(data.result == '0') {
                    showError("add", data.message);
                    return;
                }

                $("#add-user-modal").modal("hide");
                $("#username").val("");
                $("#email").val("");
                $("#password").val("");
                $("#confirm-password").val("");

                $("#success-message").html(
                    "User &quot;" + username +
                    "&quot; was successfully added."
                );
                $("#success-modal").modal("show");
            }
        );
    });
    setInterval(fetchUsers, 2000);
});

fetchUsers();