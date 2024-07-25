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

let prevIdHash = "",
    prevIdContent = "",
    idPayloads = [];

let deletableIdTracker = null,
    deletableIdTimestamp = null;

let prevTrackHash = "",
    prevTrackContent = "",
    trackPayloads = [];

let deletableTrackTracker = null,
    deletableTrackTimestamp = null;

let prevPageHash = "",
    prevPageContent = "",
    pagePayloads = [];

let deletablePageTracker = null,
    deletablePageTimestamp = null;

let prevAliasHash = "",
    prevAliasContent = "";

let deletableAliasUser = null;

let idDataTable = null,
    trackDataTable = null,
    pageDataTable = null,
    aliasDataTable = null;

function showPayload(type, payload) {
    let payloadData = "";
    if(type == 0)
        payloadData = idPayloads[payload];
    else if(type == 1)
        payloadData = trackPayloads[payload];
    else if(type == 2)
        payloadData = pagePayloads[payload];

    $("#payload-content").html(
        JSON.stringify(payloadData, undefined, 4)
    );
    $("#payload-modal").modal("show");
}

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

function downloadIdContent() {
    let content = "";
    for(let row of prevIdContent)
        content += row[0] + "," + row[1] + "," +
            row[2] + ",\"" + row[3] + "\"," +
            btoa(JSON.stringify(row[4])) + "\n";
    
    downloadContent("data_analytics_id.csv", content);
}

function downloadTrackContent() {
    let content = "";
    for(let row of prevTrackContent)
        content += row[0] + "," + row[1] + "," +
            row[2] + ",\"" + row[3] + "\",\"" +
            row[4] + "\"," + btoa(JSON.stringify(row[5])) + "\n";

    downloadContent("data_analytics_track.csv", content);
}

function downloadPageContent() {
    let content = "";
    for(let row of prevPageContent)
        content += row[0] + "," + row[1] + "," +
            row[2] + "," + row[3] + "," + row[4] + ",\""
            row[5] + "\"," + btoa(JSON.stringify(row[6])) + "\n";

    downloadContent("data_analytics_page.csv", content);
}

function showConfirmIdDelete(tracker, timestamp) {
    deletableIdTracker = tracker;
    deletableIdTimestamp = timestamp;

    $("#modal-delete-btn").click(()=> requestDeleteId());
    $("#confirm-delete-modal").modal("show");
}

function showConfirmTrackDelete(tracker, timestamp) {
    deletableTrackTracker = tracker;
    deletableTrackTimestamp = timestamp;

    $("#modal-delete-btn").click(()=> requestDeleteTrack());
    $("#confirm-delete-modal").modal("show");
}

function showConfirmPageDelete(tracker, timestamp) {
    deletablePageTracker = tracker;
    deletablePageTimestamp = timestamp;

    $("#modal-delete-btn").click(()=> requestDeletePage());
    $("#confirm-delete-modal").modal("show");
}

function showConfirmAliasDelete(userId) {
    deletableAliasUser = userId;

    $("#modal-delete-btn").click(()=> requestDeleteAlias());
    $("#confirm-delete-modal").modal("show");
}

const requestDeleteId = ()=> {
    $.post({
        url: "api/index.php?action=id_delete_by_timestamp&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            tracker: deletableIdTracker,
            timestamp: deletableIdTimestamp
        },
        success: (data)=> {
            $("#confirm-delete-modal").modal("hide");

            if(data.result == "0") {
                $("#failed-delete-modal-msg").html("Failed to delete identification track.");
                $("#failed-delete-modal").modal("show");
    
                return;
            }

            $("#success-delete-modal-msg").html("Successfully deleted identification track.");
            $("#success-delete-modal").modal("show");
        }
    });
};

const requestDeleteTrack = ()=> {
    $.post({
        url: "api/index.php?action=track_delete_by_timestamp&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            tracker: deletableTrackTracker,
            timestamp: deletableTrackTimestamp
        },
        success: (data)=> {
            $("#confirm-delete-modal").modal("hide");

            if(data.result == "0") {
                $("#failed-delete-modal-msg").html("Failed to delete tracker.");
                $("#failed-delete-modal").modal("show");
    
                return;
            }

            $("#success-delete-modal-msg").html("Successfully deleted tracker.");
            $("#success-delete-modal").modal("show");
        }
    });
};

const requestDeletePage = ()=> {
    $.post({
        url: "api/index.php?action=page_delete_by_timestamp&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            tracker: deletablePageTracker,
            timestamp: deletablePageTimestamp
        },
        success: (data)=> {
            $("#confirm-delete-modal").modal("hide");

            if(data.result == "0") {
                $("#failed-delete-modal-msg").html("Failed to delete page tracker.");
                $("#failed-delete-modal").modal("show");
    
                return;
            }

            $("#success-delete-modal-msg").html("Successfully deleted page tracker.");
            $("#success-delete-modal").modal("show");
        }
    });
};

const requestDeleteAlias = ()=> {
    $.post({
        url: "api/index.php?action=alias_for_user&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            anon_id: "null",
            user_id: deletableAliasUser
        },
        success: (data)=> {
            $("#confirm-delete-modal").modal("hide");

            if(data.result == "0") {
                $("#failed-delete-modal-msg").html("Failed to delete aliased records.");
                $("#failed-delete-modal").modal("show");
    
                return;
            }

            $("#success-delete-modal-msg").html("Successfully deleted aliased records.");
            $("#success-delete-modal").modal("show");
        }
    });
};

const renderToIdTable = (tracker, anonId, userId, timedate, payload)=> {
    return "<tr><td>" + tracker + "</td><td>" + anonId + "</td><td>" +
        userId + "</td><td>" + timedate + "</td><td><button class=\"btn btn-primary\"" +
        " onclick=\"showPayload(0, " + payload + ")\">Show</button></td>" +
        "<td><button class=\"btn btn-outline-danger\" onclick=\"showConfirmIdDelete('" + tracker +
        "', '" + timedate + "')\"><svg xmlns=\"http://www.w3.org/2000/svg\"" +
        "fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\"" +
        " width=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" " +
        "d=\"M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16" +
        " 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456" +
        " 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0" +
        " 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09" +
        " 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0\" /></svg></button></td></tr>";
};

const renderToTrackTable = (tracker, anonId, userId, timedate, event, payload)=> {
    return "<tr><td>" + tracker + "</td><td>" + anonId + "</td><td>" +
        userId + "</td><td>" + event + "</td><td>" + timedate + 
        "</td><td><button class=\"btn btn-primary\" onclick=\"showPayload(1, " + payload + ")\">Show</button></td>" +
        "<td><button class=\"btn btn-outline-danger\" onclick=\"showConfirmTrackDelete('" + tracker +
        "', '" + timedate + "')\"><svg xmlns=\"http://www.w3.org/2000/svg\"" +
        "fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\"" +
        " width=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" " +
        "d=\"M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16" +
        " 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456" +
        " 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0" +
        " 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09" +
        " 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0\" /></svg></button></td></tr>";
};

const renderToPageTable = (tracker, anonId, userId, name, category, timedate, payload)=> {
    return "<tr><td>" + tracker + "</td><td>" + anonId + "</td><td>" +
        userId + "</td><td>" + name + "</td><td>" + category + "</td><td>" + timedate + 
        "</td><td><button class=\"btn btn-primary\" onclick=\"showPayload(1, " + payload + ")\">Show</button></td>" +
        "<td><button class=\"btn btn-outline-danger\" onclick=\"showConfirmPageDelete('" + tracker +
        "', '" + timedate + "')\"><svg xmlns=\"http://www.w3.org/2000/svg\"" +
        "fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\"" +
        " width=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" " +
        "d=\"M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16" +
        " 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456" +
        " 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0" +
        " 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09" +
        " 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0\" /></svg></button></td></tr>";
};

const renderToAliasTable = (anonId, userId)=> {
    return "<tr><td>" + anonId + "</td><td>" + userId + "</td><td>" +
    "<button class=\"btn btn-outline-danger\" onclick=\"showConfirmAliasDelete('" + anonId +
    "')\"><svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" " +
    "stroke-width=\"1.5\" stroke=\"currentColor\" width=\"16\" height=\"16\"><path stroke-linecap=\"round\" " +
    "stroke-linejoin=\"round\" d=\"M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 " +
    "1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456" +
    " 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0" +
    " 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09" +
    " 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0\" /></svg></button></td>";
};

const fetchAllId = ()=> {
    $.post({
        url: "api/index.php?action=id_fetch_all&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == "0")
                return;

            if(prevIdHash == CryptoJS.MD5(JSON.stringify(data)).toString())
                return;

            prevIdContent = data.value;
            prevIdHash = CryptoJS.MD5(JSON.stringify(data)).toString();

            if(prevIdContent.length == 0 && (prevIdHash != "" ||
                prevIdHash == "5e28988ff412b216da4a633fa9ff52f5")) {
                idDataTable.clear().destroy();
                idDataTable = initDataTable(
                    "#analytics-id-table",
                    "No analytic identification tracks found."
                );

                return;
            }

            let tbody = "", i = 0;
            for(let row of data.value) {
                tbody += renderToIdTable(row[0], row[1], row[2], row[3], i);
                idPayloads.push(row[4]);

                i++;
            }

            idDataTable.clear().destroy();
            $("#analytics-id-tbody").html(tbody);
            idDataTable = initDataTable(
                "#analytics-id-table",
                "No analytic identification tracks found."
            );
    }
    });
};

const fetchAllTrack = ()=> {
    $.post({
        url: "api/index.php?action=track_fetch_all&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == "0")
                return;

            if(prevTrackHash == CryptoJS.MD5(JSON.stringify(data)).toString())
                return;

            prevTrackContent = data.value;
            prevTrackHash = CryptoJS.MD5(JSON.stringify(data)).toString();

            if(prevTrackContent.length == 0 && (prevTrackHash != "" ||
                prevTrackHash == "5e28988ff412b216da4a633fa9ff52f5")) {
                trackDataTable.clear().destroy();
                trackDataTable = initDataTable(
                    "#analytics-track-table",
                    "No analytic trackers found."
                );
                return;
            }

            let tbody = "", i = 0;
            for(let row of data.value) {
                tbody += renderToTrackTable(row[0], row[1], row[2], row[4], row[3], i);
                trackPayloads.push(row[5]);

                i++;
            }

            trackDataTable.clear().destroy();
            $("#analytics-track-tbody").html(tbody);
            trackDataTable = initDataTable(
                "#analytics-track-table",
                "No analytic trackers found."
            );
        }
    });
};

const fetchAllPage = ()=> {
    $.post({
        url: "api/index.php?action=page_fetch_all&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == "0")
                return;

            if(prevPageHash == CryptoJS.MD5(JSON.stringify(data)).toString())
                return;

            prevPageContent = data.value;
            prevPageHash = CryptoJS.MD5(JSON.stringify(data)).toString();

            if(prevPageContent.length == 0 && (prevPageHash != "" ||
                prevPageHash == "5e28988ff412b216da4a633fa9ff52f5")) {
                pageDataTable.clear().destroy();
                pageDataTable = initDataTable(
                    "#analytics-paging-table",
                    "No analytic page trackers found."
                );
                return;
            }

            let tbody = "", i = 0;
            for(let row of data.value) {
                tbody += renderToPageTable(row[0], row[1], row[2], row[3], row[4], row[5], i);
                trackPayloads.push(row[6]);

                i++;
            }

            pageDataTable.clear().destroy();
            $("#analytics-paging-tbody").html(tbody);
            pageDataTable = initDataTable(
                "#analytics-paging-table",
                "No analytic page trackers found."
            );
        }
    });
};

const fetchAllAlias = ()=> {
    $.post({
        url: "api/index.php?action=alias_fetch_all&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == "0")
                return;

            if(prevAliasHash == CryptoJS.MD5(JSON.stringify(data)).toString())
                return;

            prevAliasContent = data.value;
            prevAliasHash = CryptoJS.MD5(JSON.stringify(data)).toString();

            if(prevAliasContent.length == 0 && (prevAliasHash != "" ||
                prevAliasHash == "5e28988ff412b216da4a633fa9ff52f5")) {
                aliasDataTable.clear().destroy();
                aliasDataTable = initDataTable(
                    "#analytics-alias-table",
                    "No analytic aliased records found."
                );
                return;
            }

            let tbody = "";
            for(let row of data.value)
                tbody += renderToAliasTable(row[0], row[1]);

            aliasDataTable.clear().destroy();
            $("#analytics-alias-tbody").html(tbody);
            aliasDataTable = initDataTable(
                "#analytics-alias-table",
                "No analytic aliased records found."
            );
        }
    });
};

$(document).ready(()=> {
    idDataTable = initDataTable("#analytics-id-table", "No analytic identification tracks found.");
    trackDataTable = initDataTable("#analytics-track-table", "No analytic trackers found.");
    pageDataTable = initDataTable("#analytics-paging-table", "No analytic page trackers found.");
    aliasDataTable = initDataTable("#analytics-alias-table", "No analytic aliased records found.");

    const fetchAll = ()=> {
        fetchAllId();
        fetchAllTrack();
        fetchAllPage();
        fetchAllAlias();
    };

    fetchAll();
    setInterval(fetchAll, 2000);
});
