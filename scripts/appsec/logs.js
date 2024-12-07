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

let prevLogsHash = "",
    prevLogsContents = "",
    prevHideState = true;
let dataTable = null;

function downloadContent(fileName, content) {
    let file = new File(
        ["\ufeff" + content],
        fileName,
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

function downloadLogs() {
    let content = "";
    for(let row of prevLogsContents)
        content += "\"" + atob(row[0]) + "\"," +
            atob(row[1]) + "\"," +
            row[2] + ",\"" +
            atob(row[3]) + "\"\n";

    downloadContent("logs.csv", content);
}

const fetchLogs = ()=> {
    $.post({
        url: "api/logs.php",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == "0")
                return;

            let hideSelfReqs = $("#hide-selfreqs").is(":checked"),
                tempHash = sha512(JSON.stringify(data));
            if(prevHideState == hideSelfReqs &&
                prevLogsHash == tempHash)
                return;

            prevLogsContents = data;
            prevHideState = hideSelfReqs;
            prevLogsHash = tempHash;

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