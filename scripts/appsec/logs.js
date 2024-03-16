let prevLogsHash = "", prevHideState = true;
let dataTable = null;

const fetchLogs = ()=> {
    $.post({
        url: "api/logs.php",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == '0')
                return;

            let hideSelfReqs = $("#hide-selfreqs").is(":checked");
            if(prevHideState == hideSelfReqs &&
                prevLogsHash == CryptoJS.MD5(JSON.stringify(data)).toString())
                return;

            prevLogsHash = CryptoJS.MD5(JSON.stringify(data)).toString();
            prevHideState = hideSelfReqs;

            if(data.length == 0 && (prevLogsHash != "" ||
                prevLogsHash != "")) {
                dataTable.clear().destroy();
                dataTable = initDataTable("#logs-table", "No log records found.");

                return;
            }

            let logRows = "";
            data.reverse();
            for(let log of data) {
                let tag = log[4], badgeColor = "primary";
                if(hideSelfReqs && tag == "dashboard")
                    continue;

                if(tag == "dashboard")
                    badgeColor = "warning";
                else if(tag == "sandbox")
                    badgeColor = "success";

                tag = tag.charAt(0).toUpperCase() + tag.slice(1);
                logRows += "<tr><td>" + atob(log[0]) + "</td><td>" +
                    atob(log[1]) + "</td><td>" + log[2] + "</td><td>" +
                    atob(log[3]) + "</td><td><span class=\"badge bg-" + badgeColor +
                    "\">" + tag + "</span></td></tr>";
            }

            dataTable.clear().destroy();
            $("#logs-table-body").html(logRows);
            dataTable = initDataTable("#logs-table", "No log records found.");
        }
    });
};

$(document).ready(()=> {
    dataTable = initDataTable("#logs-table", "No log records found.");

    fetchLogs();
    setInterval(fetchLogs, 2000);
});