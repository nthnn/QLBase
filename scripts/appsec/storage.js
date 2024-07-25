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

const deleteBtn = RotatingButton("#delete-btn");

let prevFilesHash = "";
let dataTable = null;

let deletableFile = null;
function deleteFile(name, origName) {
    deletableFile = name;

    $("#deletable-file").html(origName);
    $("#confirm-delete-modal").modal("show");
}

function requestFileDeletion() {
    deleteBtn.show();

    $.ajax({
        url: "api/index.php?action=file_delete&dashboard",
        type: "POST",
        dataType: "json",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        data: {
            name: deletableFile
        },
        success: (data)=> {
            deleteBtn.hide();

            if(data.result == "0") {
                $("#failed-message").html("Somthing went wrong.");
                $("#failed-modal").modal("show");

                return;
            }

            $("#confirm-delete-modal").modal("hide");
            $("#success-message").html(
                "File &quot;" + deletableFile.substring(1, 15) +
                "...&quot; was successfully deleted."
            );
            $("#success-modal").modal("show");

            deletableFile = null;
        }
    });
}

function uploadFile() {
    let formData = new FormData();
    formData.append(
        "subject",
        document.querySelector("#subject").files[0]
    );

    const uploadBtn = RotatingButton("#upload-btn");
    uploadBtn.show();

    $.ajax({
        url: "api/index.php?action=file_upload&sandbox",
        type: "POST",
        headers: JSON.parse("{\"QLBase-API-Key\": \"" + App.appKey +
            "\", \"QLBase-App-ID\": \"" + App.appId + "\"}"),
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: (data)=> {
            if(data.result == "0") {
                $("#subject-label").html("Choose File");
                $("#upload-file-modal").modal("hide");
                $("#failed-modal").modal("show");

                uploadBtn.hide();
                return;
            }

            setTimeout(()=> {
                $("#subject-label").html("Choose File");
                $("#upload-file-modal").modal("hide");
                $("#success-modal").modal("show");

                uploadBtn.hide();
            }, 800);
        }
    });
}

const showError = (id, message)=> {
    $("#" + id + "-error").removeClass("d-none");
    $("#" + id + "-error").addClass("d-block");
    $("#" + id + "-error").html(message);
};

const fetchFiles = ()=> {
    $.post({
        url: "api/index.php?action=file_fetch_all&dashboard",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == "0")
                return;

            if(prevFilesHash == CryptoJS.MD5(JSON.stringify(data)).toString())
                return;
            prevFilesHash = CryptoJS.MD5(JSON.stringify(data)).toString();

            if(data.value.length == 0 && (prevFilesHash != "" ||
                prevFilesHash != "")) {
                dataTable.clear().destroy();
                dataTable = initDataTable("#storage-table", "No stored files found.");

                return;
            }

            let fileRows = "";
            for(let files of data.value) {
                fileRows += "<tr><td>" + files[0].substring(1, 15) + "</td><td>" +
                    files[1] + "</td><td>" + files[2] + "</td><td>" + files[3] + "</td><td><button class=\"btn btn-sm btn-outline-danger mx-2\"" +
                    " onclick=\"deleteFile('" + files[0] + "', '" + files[1] +
                    "')\"><svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" widht=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0\" /></svg></button></td></tr>";
            }

            dataTable.clear().destroy();
            $("#storage-table-body").html(fileRows);
            dataTable = initDataTable("#storage-table", "No stored files found.");
        }
    });
};

$(document).ready(()=> {
    dataTable = initDataTable("#storage-table", "No stored files found.");

    $("#subject").change(()=> {
        $("#subject-label").html("Choose File (" + $("#subject").val().split("\\").pop() + ")");
    });

    fetchFiles();
    setInterval(fetchFiles, 2000);

    $("#upload-btn").click(uploadFile);
});