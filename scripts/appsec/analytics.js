let prevIdHash = "",
    idPayloads = [];
let deletableIdTracker = null,
    deletableTimestamp = null;

function showPayload(payload) {
    $("#payload-content").html(
        JSON.stringify(idPayloads[payload], undefined, 4)
    );
    $("#payload-modal").modal("show");
}

function downloadPayload() {
    let file = new File(
        ["\ufeff" + $("#payload-content").text()],
        "payload.json",
        {type: "text/plain:charset=UTF-8"}
    );
    let url = window.URL.createObjectURL(file);

    let a = document.createElement("a");
    a.style = "display: none";
    a.href = url;
    a.download = file.name;
    a.click();

    window.URL.revokeObjectURL(url);
}

function showConfirmDelete(tracker, timestamp) {
    deletableIdTracker = tracker;
    deletableTimestamp = timestamp;

    $("#confirm-delete-id-modal").modal("show");
}

const requestDeleteId = ()=> {
    $.post({
        url: "api/index.php?action=id_delete_by_timestamp",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            tracker: deletableIdTracker,
            timestamp: deletableTimestamp
        },
        success: (data)=> {
            $("#confirm-delete-id-modal").modal("hide");

            if(data.result == '0') {
                $("#failed-delete-modal-msg").html("Failed to delete identification track.");
                $("#failed-delete-modal").modal("show");
    
                return;
            }

            $("#success-delete-modal-msg").html("Successfully deleted identification track.");
            $("#success-delete-modal").modal("show");
        }
    });
};

const renderToIdTable = (tracker, anonId, userId, timedate, payload)=> {
    return "<tr><td>" + tracker + "</td><td>" + anonId + "</td><td>" +
        userId + "</td><td>" + timedate + "</td><td><button class=\"btn btn-primary\"" +
        " onclick=\"showPayload(" + payload + ")\">Show</button></td>" +
        "<td><button class=\"btn btn-outline-danger\" onclick=\"showConfirmDelete('" + tracker +
        "', '" + timedate + "')\"><svg xmlns=\"http://www.w3.org/2000/svg\"" +
        "fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\"" +
        " width=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" " +
        "d=\"M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16" +
        " 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456" +
        " 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0" +
        " 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09" +
        " 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0\" /></svg></button></td></tr>";
};

const fetchAllId = ()=> {
    $.post({
        url: "api/index.php?action=id_fetch_all",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == '0')
                return;

            if(prevIdHash == CryptoJS.MD5(JSON.stringify(data)).toString())
                return;
            prevIdHash = CryptoJS.MD5(JSON.stringify(data)).toString();

            let tbody = "", i = 0;
            for(let row of data.value) {
                tbody += renderToIdTable(row[0], row[1], row[2], row[3], i);
                idPayloads.push(row[4]);

                i++;
            }

            $("#analytics-id-tbody").html(tbody);
        }
    });
};

$(document).ready(()=> {
    new DataTable("#analytics-id-table");
    new DataTable("#analytics-tracking-table");
    new DataTable("#analytics-paging-table");
    new DataTable("#analytics-alias-table");

    setInterval(fetchAllId, 2000);
});

fetchAllId();
