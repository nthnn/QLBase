let prevUsersHash = "";
let dataTable = null;

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
    $("#add-btn").click(()=> {});

    fetchUsers();
    setInterval(fetchUsers, 2000);
});