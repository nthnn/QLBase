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

let editor = monaco.editor.create(document.querySelector('#content'), {
    automaticLayout: true,
    value: "{}",
    tabSize: 4,
    language: "javascript",
    semanticHighlighting: { enabled: true },
    dimension: { height: 120 },
    minimap: { enabled: false }
}), headers = monaco.editor.create(document.querySelector('#http-headers'), {
    automaticLayout: true,
    value: JSON.stringify($("#http-headers").data("keys"), null, "\t"),
    tabSize: 4,
    language: "javascript",
    semanticHighlighting: { enabled: true },
    dimension: { height: 120 },
    minimap: { enabled: false }
}), response = monaco.editor.create(document.querySelector('#response'), {
    automaticLayout: true,
    value: "{}",
    tabSize: 4,
    language: "javascript",
    readOnly: true,
    semanticHighlighting: { enabled: true },
    dimension: { height: 376 },
    minimap: { enabled: false }
});

const authenticationActions = {
    "auth_create_user": ["Auth: Create User", '{\n\t"username": "",\n\t"email": "",\n\t"password": "",\n\t"enabled": "1"\n}'],
    "auth_update_by_username": ["Auth: Update by Username", '{\n\t"username": "",\n\t"email": "",\n\t"password": "",\n\t"enabled": "1"\n}'],
    "auth_update_by_email": ["Auth: Update by Email", '{\n\t"username": "",\n\t"email": "",\n\t"password": "",\n\t"enabled": "1"\n}'],
    "auth_delete_by_username": ["Auth: Delete by Username", '{\n\t"username": ""\n}'],
    "auth_delete_by_email": ["Auth: Delete by Email", '{\n\t"email": ""\n}'],
    "auth_get_by_username": ["Auth: Get by Username", '{\n\t"username": ""\n}'],
    "auth_get_by_email": ["Auth: Get by Email", '{\n\t"email": ""\n}'],
    "auth_enable_user": ["Auth: Enable User", '{\n\t"username": ""\n}'],
    "auth_disable_user": ["Auth: Disable User", '{\n\t"username": ""\n}'],
    "auth_is_enabled": ["Auth: Is User Enabled", '{\n\t"username": ""\n}'],
    "auth_login_username": ["Auth: Log-in Username", '{\n\t"username": "",\n\t"password": ""\n}'],
    "auth_login_email": ["Auth: Log-in Email", '{\n\t"email": "",\n\t"password": ""\n}'],
    "auth_logout": ["Auth: Logout", '{\n\t"sess_id": ""\n}'],
    "auth_validate_session": ["Auth: Validate Session", '{\n\t"sess_id": ""\n}'],
    "auth_fetch_all": ["Auth: Fetch All Users", '{}']
};

const smsActions = {
    "sms_verification": ["SMS: Send Verification", '{\n\t"recipient": "",\n\t"support": ""\n}'],
    "sms_validate": ["SMS: Validate", '{\n\t"recipient": "",\n\t"code": ""\n}'],
    "sms_is_validated": ["SMS: Is Validated", '{\n\t"recipient": "",\n\t"code": ""\n}'],
    "sms_fetch_all": ["SMS: Fetch All OTP", '{}'],
    "sms_delete_otp": ["SMS: Delete Verification", '{\n\t"recipient": "",\n\t"code": ""\n}']
};

const dataAnalyticsActions = {
    "id_create": ["Identify: Create New", "{\n\t\"tracker\": \"\",\n\t\"anon_id\": \"\",\n\t\"user_id\": \"\",\n\t\"timestamp\": \"\",\n\t\"payload\": \"\"\n}"],
    "id_create_live_timestamp": ["Identify: Create with Live Timestamp", "{\n\t\"tracker\": \"\",\n\t\"anon_id\": \"\",\n\t\"user_id\": \"\",\n\t\"payload\": \"\"\n}"],
    "id_delete_by_anon_id": ["Identify: Delete by Anonymous ID", "{\n\t\"tracker\": \"\",\n\t\"anon_id\": \"\"\n}"],
    "id_delete_by_user_id": ["Identify: Delete by User ID", "{\n\t\"tracker\": \"\",\n\t\"user_id\": \"\"\n}"],
    "id_delete_by_timestamp": ["Identify: Delete by Timestamp", "{\n\t\"tracker\": \"\",\n\t\"timestamp\": \"\"\n}"],
    "id_get_by_anon_id": ["Identify: Fetch by Anon ID", "{\n\t\"anon_id\": \"\"\n}"],
    "id_get_by_user_id": ["Identify: Fetch by User ID", "{\n\t\"user_id\": \"\"\n}"],
    "id_get_by_timestamp": ["Identify: Fetch by Timestamp", "{\n\t\"timestamp\": \"\"\n}"],
    "id_fetch_all": ["Identify: Fetch All", "{}"],

    "track_create": ["Track: Create New", "{\n\t\"tracker\": \"\",\n\t\"anon_id\": \"\",\n\t\"user_id\": \"\",\n\t\"event\": \"\",\n\t\"timestamp\": \"\",\n\t\"payload\": \"\"\n}"],
    "track_create_live_timestamp": ["Track: Create with Live Timestamp", "{\n\t\"tracker\": \"\",\n\t\"anon_id\": \"\",\n\t\"user_id\": \"\",\n\t\"event\": \"\",\n\t\"payload\": \"\"\n}"],
    "track_delete_by_anon_id": ["Track: Delete by Anonymous ID", "{\n\t\"tracker\": \"\",\n\t\"anon_id\": \"\"\n}"],
    "track_delete_by_user_id": ["Track: Delete by User ID", "{\n\t\"tracker\": \"\",\n\t\"user_id\": \"\"\n}"],
    "track_delete_by_event": ["Track: Delete by Event", "{\n\t\"tracker\": \"\",\n\t\"event\": \"\"\n}"],
    "track_delete_by_timestamp": ["Track: Delete by Timestamp", "{\n\t\"tracker\": \"\",\n\t\"timestamp\": \"\"\n}"],
    "track_get_by_anon_id": ["Track: Fetch by Anon ID", "{\n\t\"anon_id\": \"\"\n}"],
    "track_get_by_user_id": ["Track: Fetch by User ID", "{\n\t\"user_id\": \"\"\n}"],
    "track_get_by_event": ["Track: Fetch by Event", "{\n\t\"user_id\": \"\",\n\t\"event\": \"\"\n}"],
    "track_get_by_timestamp": ["Track: Fetch by Timestamp", "{\n\t\"timestamp\": \"\"\n}"],
    "track_fetch_all": ["Track: Fetch All", "{}"],

    "page_create": ["Page: Create New", "{\n\t\"tracker\": \"\",\n\t\"anon_id\": \"\",\n\t\"user_id\": \"\",\n\t\"name\": \"\",\n\t\"category\": \"\",\n\t\"timestamp\": \"\",\n\t\"payload\": \"\"\n}"],
    "page_create_live_timestamp": ["Page: Create with Live Timestamp", "{\n\t\"tracker\": \"\",\n\t\"anon_id\": \"\",\n\t\"user_id\": \"\",\n\t\"name\": \"\",\n\t\"category\": \"\",\n\t\"payload\": \"\"\n}"],
    "page_delete_by_anon_id": ["Page: Delete by Anonymous ID", "{\n\t\"tracker\": \"\",\n\t\"anon_id\": \"\"\n}"],
    "page_delete_by_user_id": ["Page: Delete by User ID", "{\n\t\"tracker\": \"\",\n\t\"user_id\": \"\"\n}"],
    "page_delete_by_name": ["Page: Delete by Name", "{\n\t\"tracker\": \"\",\n\t\"name\": \"\"\n}"],
    "page_delete_by_category": ["Page: Delete by Category", "{\n\t\"tracker\": \"\",\n\t\"category\": \"\"\n}"],
    "page_delete_by_timestamp": ["Page: Delete by Timestamp", "{\n\t\"tracker\": \"\",\n\t\"timestamp\": \"\"\n}"],
    "page_get_by_anon_id": ["Page: Fetch by Anon ID", "{\n\t\"anon_id\": \"\"\n}"],
    "page_get_by_user_id": ["Page: Fetch by User ID", "{\n\t\"user_id\": \"\"\n}"],
    "page_get_by_name": ["Page: Fetch by Name", "{\n\t\"name\": \"\"\n}"],
    "page_get_by_category": ["Page: Fetch by Category", "{\n\t\"category\": \"\"\n}"],
    "page_get_by_timestamp": ["Page: Fetch by Timestamp", "{\n\t\"timestamp\": \"\"\n}"],
    "page_fetch_all": ["Page: Fetch All", "{}"],

    "alias_anon_has": ["Alias: Has Anonymous Alias", "{\n\t\"anon_id\": \"\"\n}"],
    "alias_user_has": ["Alias: Has User Alias", "{\n\t\"user_id\": \"\"\n}"],
    "alias_for_anon": ["Alias: Set For Anonymous ID", "{\n\t\"anon_id\": \"\",\n\t\"user_id\": \"\"\n}"],
    "alias_for_user": ["Alias: Set For User ID", "{\n\t\"user_id\": \"\",\n\t\"anon_id\": \"\"\n}"],
    "alias_fetch_all": ["Alias: Fetch All", "{}"],
};

const databaseActions = {
    "db_create": ["Database: Create", "{\n\t\"name\": \"\",\n\t\"mode\": \"\",\n\t\"content\": \"\"\n}"],
    "db_get_by_name": ["Database: Get By Name", "{\n\t\"name\": \"\"\n}"],
    "db_set_mode": ["Database: Set Mode", "{\n\t\"name\": \"\",\n\t\"mode\": \"\"\n}"],
    "db_get_mode": ["Database: Get Mode", "{\n\t\"name\": \"\"\n}"],
    "db_read": ["Database: Read Content", "{\n\t\"name\": \"\"\n}"],
    "db_write": ["Database: Write Content", "{\n\t\"name\": \"\",\n\t\"content\": \"\"\n}"],
    "db_delete": ["Database: Delete", "{\n\t\"name\": \"\"\n}"],
    "db_fetch_all": ["Database: Fetch All", "{}"]
};

const storageActions = {
    "file_upload": ["Storage: File Upload", "{}"],
    "file_delete": ["Storage: File Delete", "{\n\t\"name\": \"\"\n}"],
    "file_get": ["Storage: File Fetch", "{\n\t\"name\": \"\"\n}"],
    "file_download": ["Storage: File Download", "{\n\t\"name\": \"\",\n\t\"should_expire\": \"\"\n}"],
    "file_fetch_all": ["Storage: File Fetch All", "{}"],

    "cdp_expire_all": ["Content Delivery Page: Expire All", "{}"],
    "cdp_expire_ticket": ["Content Delivery Page: Revoke Ticket", "{\n\t\"ticket\": \"\"\n}"]
};

const addGroupToActions = (name)=> {
    $("#action").append("<option disabled value=\"\">─</option>");
    $("#action").append("<option disabled value=\"\">" + name + "</option>");
};

const addAction = (action, name, args)=>
    $("#action").append(
        "<option value=\"" + action +
        "\" data-args=\"" + btoa(args) +
        "\">" + name + "</option>"
    );

function validateJson(str) {
    if(typeof str !== "string")
        return false;

    try {
        JSON.parse(str);
        return true;
    }
    catch(e) {
        return false;
    }
}

const isUploadAction = ()=>
    $("#action").val() == "file_upload";

$(document).ready(()=> {
    $("#action").append("<option disabled selected value=\"\">Actions</option>");
    addAction("handshake", "Handshake", "{}");

    addGroupToActions("Authentication");
    for(let act in authenticationActions)
        addAction( act, authenticationActions[act][0], authenticationActions[act][1]);

    addGroupToActions("SMS");
    for(let act in smsActions)
        addAction(act, smsActions[act][0], smsActions[act][1]);

    addGroupToActions("Data Analytics");
    for(let act in dataAnalyticsActions)
        addAction(act, dataAnalyticsActions[act][0], dataAnalyticsActions[act][1]);

    addGroupToActions("Database");
    for(let act in databaseActions)
        addAction(act, databaseActions[act][0], databaseActions[act][1]);
    
    addGroupToActions("Storage");
    for(let act in storageActions)
        addAction(act, storageActions[act][0], storageActions[act][1]);

    const sendBtn = RotatingButton("#send");
    $("#send").click(()=> {
        const dataContents = editor.getValue(),
            httpHeaders = headers.getValue();

        $("#contents").removeClass("border-danger");
        $("#http-headers").removeClass("border-danger");

        sendBtn.show();
        $("#response").val("");

        if(!validateJson(dataContents)) {
            $("#contents").addClass("border-danger");
            sendBtn.hide();
            return;
        }

        if(!validateJson(httpHeaders)) {
            $("#http-headers").addClass("border-danger");
            sendBtn.hide();
            return;
        }

        let formData = new FormData();
        if(isUploadAction())
            formData.append(
                "subject",
                document.querySelector("#subject").files[0]
            );

        let reqData = JSON.parse(dataContents);
        for(let key in reqData)
            if(reqData.hasOwnProperty(key))
                formData.append(key, reqData[key]);

        $.ajax({
            url: "api/index.php?action=" + $("#action").find(":selected").val() + "&sandbox",
            type: "POST",
            headers: JSON.parse(httpHeaders),
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: (data)=> {
                response.setValue(JSON.stringify(data, null, 4))
                setTimeout(()=> sendBtn.hide(), 800);
            }
        });
    });

    $("#action").on("change", ()=> {
        editor.setValue(atob($("#action").find(":selected").data("args")))

        if(isUploadAction()) {
            $("#subject").removeAttr("disabled");
            $("#subject-label").removeClass("disabled");
        }
        else {
            $("#subject").attr("disabled", "true");
            $("#subject-label").addClass("disabled");
            $("#subject-label").html("Choose File");

            $("#subject").val(null);
        }
    });

    $("#subject").change(()=> {
        $("#subject-label").html("Choose File (" + $("#subject").val().split("\\").pop() + ")");
    });
});