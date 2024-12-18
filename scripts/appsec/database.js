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

import * as monaco from "https://cdn.jsdelivr.net/npm/monaco-editor@0.45.0/+esm";

let prevDBHash = "",
    deletableDbName = null,
    dataTable = null;

let createDbEditor = monaco.editor.create(document.querySelector('#db-content'), {
    automaticLayout: true,
    value: "{}",
    tabSize: 4,
    language: "javascript",
    semanticHighlighting: { enabled: true },
    dimension: { height: 120 },
    minimap: { enabled: false }
});

window.downloadDb = (name)=> {
    $.post({
        url: "api/index.php?action=db_read&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            name: name
        },
        success: (data)=> {
            if(data.result == "0")
                return;

            saveAs(
                new Blob([JSON.stringify(data.value)],
                {type: 'application/json'}),
                name + ".json"
            );
        }
    });
}

window.deleteDb = (name)=> {
    deletableDbName = name;

    $("#deletable-name").html(deletableDbName);
    $("#confirm-delete-modal").modal("show");
}

window.requestDatabaseDeletion = ()=> {
    $.post({
        url: "api/index.php?action=db_delete&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            name: deletableDbName
        },
        success: (data)=> {
            if(data.result == "0")
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
        url: "api/index.php?action=db_fetch_all&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == "0")
                return;

            let tempHash = sha512(JSON.stringify(data));
            if(prevDBHash == tempHash)
                return;
            prevDBHash = tempHash;

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

const showError = (id, message)=> {
    $("#" + id + "-error").removeClass("d-none");
    $("#" + id + "-error").addClass("d-block");
    $("#" + id + "-error").html(message);
};

const createBtn = RotatingButton("#create-btn");
$("#create-btn").click(()=> {
    let dbName = $("#db-name").val(),
        dbMode = $("input[name=\"db-mode\"]:checked").val(),
        dbContent = createDbEditor.getValue();

    createBtn.show();
    $("#db-name-error")
        .removeClass("d-block")
        .addClass("d-none");
    $("#db-content-error")
        .removeClass("d-block")
        .addClass("d-none");
    $("#db-create-error")
        .removeClass("d-block")
        .addClass("d-none");

    if(!/^[A-Za-z\s\"-]+$/.test(dbName)) {
        createBtn.hide();
        showError("db-name", "Invalid database name.");
        return;
    }

    try { JSON.parse(dbContent); }
    catch(error) {
        createBtn.hide();
        showError("db-content", "Invalid JSON string content.");
        return;
    }

    $.post({
        url: "api/index.php?action=db_create&dashboard",
        type: "POST",
        dataType: "json",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            name: dbName,
            mode: dbMode,
            content: btoa(dbContent)
        },
        success: (data)=> {
            createBtn.hide();
            if(data.result == "0") {
                $("#db-create-error")
                    .removeClass("d-none")
                    .addClass("d-block");
                return;
            }

            createDbEditor.setValue("{}");
            $("input[name=\"db-mode\"]:checked").val("false");
            $("#db-name").val("");
            $("#create-db-modal").modal("hide");
            $("#success-modal").modal("show");
        }
    });
});

$(document).ready(()=> {
    dataTable = initDataTable("#db-table", "No database found.");

    fetchDb();
    setInterval(fetchDb, 2000);
});
