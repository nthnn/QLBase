import * as monaco from "https://cdn.jsdelivr.net/npm/monaco-editor@0.45.0/+esm";

let editor = monaco.editor.create(document.querySelector('#content'), {
    automaticLayout: true,
    value: "{}",
    tabSize: 4,
    language: "javascript",
    semanticHighlighting: { enabled: true },
    dimension: { height: 200 },
    minimap: { enabled: false }
}), headers = monaco.editor.create(document.querySelector('#http-headers'), {
    automaticLayout: true,
    value: JSON.stringify($("#http-headers").data("keys"), null, "\t"),
    tabSize: 4,
    language: "javascript",
    semanticHighlighting: { enabled: true },
    dimension: { height: 200 },
    minimap: { enabled: false }
}), response = monaco.editor.create(document.querySelector('#response'), {
    automaticLayout: true,
    value: "{}",
    tabSize: 4,
    language: "javascript",
    readOnly: true,
    semanticHighlighting: { enabled: true },
    dimension: { height: 536 },
    minimap: { enabled: false }
});

const authenticationActions = {
    "new_user": ["New User", '{\n\t"username": "",\n\t"email": "",\n\t"password": "",\n\t"enabled": "1"\n}'],
    "update_by_username": ["Update by Username", '{\n\t"username": "",\n\t"email": "",\n\t"password": "",\n\t"enabled": "1"\n}'],
    "update_by_email": ["Update by Email", '{\n\t"username": "",\n\t"email": "",\n\t"password": "",\n\t"enabled": "1"\n}'],
    "delete_by_username": ["Delete by Username", '{\n\t"username": ""\n}'],
    "delete_by_email": ["Delete by Email", '{\n\t"email": ""\n}'],
    "get_by_username": ["Get by Username", '{\n\t"username": ""\n}'],
    "get_by_email": ["Get by Email", '{\n\t"email": ""\n}'],
    "enabled_user": ["Enabled User", '{\n\t"username": ""\n}'],
    "disable_user": ["Disable User", '{\n\t"username": ""\n}'],
    "is_user_enabled": ["Is User Enabled", '{\n\t"username": ""\n}'],
    "login_username": ["Log-in Username", '{\n\t"username": "",\n\t"password": ""\n}'],
    "login_email": ["Log-in Email", '{\n\t"username": "",\n\t"password": ""\n}'],
    "fetch_all_users": ["Fetch All Users", '{}']
};

const smsActions = {
    "sms_verification": ["SMS Verification", '{\n\t"recipient": "",\n\t"support": ""\n}'],
    "sms_validate": ["SMS Validate", '{\n\t"recipient": "",\n\t"code": ""\n}'],
    "sms_is_validate": ["SMS Is Validate", '{\n\t"recipient": "",\n\t"code": ""\n}'],
    "fetch_all_otp": ["Fetch All OTP", '{}'],
    "delete_verification": ["Delete Verification", '{\n\t"recipient": "",\n\t"code": ""\n}']
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
    "page_delete_by_name": ["Page: Delete by Event", "{\n\t\"tracker\": \"\",\n\t\"name\": \"\"\n}"],
    "page_delete_by_category": ["Page: Delete by Event", "{\n\t\"tracker\": \"\",\n\t\"category\": \"\"\n}"],
    "page_delete_by_timestamp": ["Page: Delete by Timestamp", "{\n\t\"tracker\": \"\",\n\t\"timestamp\": \"\"\n}"],
    "page_get_by_anon_id": ["Page: Fetch by Anon ID", "{\n\t\"anon_id\": \"\"\n}"],
    "page_get_by_user_id": ["Page: Fetch by User ID", "{\n\t\"user_id\": \"\"\n}"],
    "page_get_by_name": ["Page: Fetch by Event", "{\n\t\"user_id\": \"\",\n\t\"name\": \"\"\n}"],
    "page_get_by_category": ["Page: Fetch by Event", "{\n\t\"user_id\": \"\",\n\t\"category\": \"\"\n}"],
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
    "file_fetch_all": ["Storage: File Fetch All", "{}"]
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
            url: "api/index.php?action=" + $("#action").find(":selected").val(),
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