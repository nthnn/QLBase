let prevDBHash = "",
    deletableDbName = null,
    dataTable = null;

function downloadDb(name) {
    $.post({
        url: "api/index.php?action=db_read",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            name: name
        },
        success: (data)=> {
            if(data.result == '0')
                return;

            saveAs(new Blob([atob(data.value)], {type: 'application/json'}), name + ".json");
        }
    });
}

function deleteDb(name) {
    deletableDbName = name;

    $("#deletable-name").html(deletableDbName);
    $("#confirm-delete-modal").modal("show");
}

function requestDatabaseDeletion() {
    $.post({
        url: "api/index.php?action=db_delete",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            name: deletableDbName
        },
        success: (data)=> {
            if(data.result == '0')
                return;

            $("#success-message").html("Deleted database '" + deletableDbName + "' permanently.");
            $("#confirm-delete-modal").modal("hide");
            $("#success-modal").modal("show");
        }
    }).fail(()=> {
        $("#confirm-delete-modal").modal("hide");
        $("#error-message").html("Error trying to permanently delete database '" + deletableDbName + "'.");
        $("#error-modal").modal("show");
    });
}

function toModeString(mode) {
    let modes = [];

    if(mode.includes("r"))
        modes.push("Read");
    if(mode.includes("w"))
        modes.push("Write");

    return modes.join("/");
}

const fetchDb = ()=> {
    $.post({
        url: "api/index.php?action=db_fetch_all",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == '0')
                return;

            if(prevDBHash == CryptoJS.MD5(JSON.stringify(data)).toString())
                return;
            prevDBHash = CryptoJS.MD5(JSON.stringify(data)).toString();

            if(data.value.length == 0 && (prevDBHash != "" ||
                prevDBHash == "5e28988ff412b216da4a633fa9ff52f5")) {
                dataTable.clear().destroy();
                dataTable = initDataTable("#db-table", "No database found.");

                return;
            }

            let rows = "";
            for(let val of data.value)
                rows += "<tr><td>" + val[0] +
                    "</td><td>" + toModeString(val[1]) +
                    "</td><td><button class=\"btn btn-sm btn-outline-danger\" onclick=\"deleteDb('" +
                    val[0] + "')\"><svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" width=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0\" /></svg>" +
                    "</button>" + (val[1].includes("r") ? "<button class=\"btn btn-sm btn-outline-primary mx-2\" onclick=\"downloadDb('"+ val[0] +
                    "')\"><svg xmlns=\"http://www.w3.org/2000/svg\" style=\"margin-left: 4px; margin-top: 4px\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" width=\"16\" height=\"16\"><path d=\"M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z\"/><path d=\"M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z\"/></svg></button>" : "") + "</td>"

                dataTable.clear().destroy();
                $("#db-table-body").html(rows);
                dataTable = initDataTable("#db-table", "No database found.");
        }
    });
};

$(document).ready(()=> {
    dataTable = initDataTable("#db-table", "No database found.");

    fetchDb();
    setInterval(fetchDb, 2000);
});
