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

    const sendBtn = RotatingButton("#send");
    $("#send").click(()=> {
        const dataContents = $("#contents").val(),
            httpHeaders = $("#http-headers").val();

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

        $.ajax({
            url: "api/index.php?action=" + $("#action").find(":selected").val(),
            type: "POST",
            data: JSON.parse(dataContents),
            headers: JSON.parse(httpHeaders),
            dataType: "json",
            success: (data)=> {
                $("#response").val(JSON.stringify(data, null, 4))
                setTimeout(()=> sendBtn.hide(), 800);
            }
        });
    });

    $("#action").on("change", ()=>
        $("#contents").val(atob($("#action").find(":selected").data("args")))
    );
});