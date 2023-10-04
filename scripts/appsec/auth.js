let prevUsersHash = "";
let dataTable = null;

const showError = (id, message)=> {
    $("#" + id + "-error").removeClass("d-none");
    $("#" + id + "-error").addClass("d-block");
    $("#" + id + "-error").html(message);
};

const fetchUsers = ()=> {
    $.post(
        "api/?api_key=" + App.appKey +
        "&app_id=" + App.appId +
        "&action=fetch_all",
        {},
        (data)=> {
            if(data.result == '0')
                return;

            if(prevUsersHash == CryptoJS.MD5(JSON.stringify(data)).toString())
                return;
            prevUsersHash = CryptoJS.MD5(JSON.stringify(data)).toString();

            let accRows = "";
            for(let acc of data.value) {
                accRows += "<tr><td>" + acc[0] + "</td><td>" +
                    acc[1] + "</td><td>" + acc[2] + "</td><td></td></tr>";
            }

            $("#user-table").html(accRows);
            dataTable = new DataTable("#auth-table");
        }
    ).fail(()=> {
        if(dataTable != null)
            dataTable.destroy({remove: true});

        $("#user-table").html("<tr><td colspan=\"4\" align=\"center\">No users yet.</td></tr>");
    });
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
            CryptoJS.MD5(password).toString(),
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

                $("#success-message").html("User &quot;" + username + "&quot; was successfully added.");
                $("#success-modal").modal("show");
            }
        );
    });
    setInterval(fetchUsers, 2000);
});

fetchUsers();