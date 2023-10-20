const authenticationActions = {
    "new_user": ["New User", ""],
    "update_by_username": ["Update by Username", ""],
    "update_by_email": ["Update by Email", ""],
    "delete_by_username": ["Delete by Username", ""],
    "delete_by_email": ["Delete by Email", ""],
    "get_by_username": ["Get by Username", ""],
    "get_by_email": ["Get by Email", ""],
    "enabled_user": ["Enabled User", ""],
    "disable_user": ["Disable User", ""],
    "is_user_enabled": ["Is User Enabled", ""],
    "login_username": ["Log-in Username", ""],
    "login_email": ["Log-in Email", ""],
    "fetch_all_users": ["Fetch All Users", ""]
};

const smsActions = {
    "sms_verification": ["SMS Verification", ""],
    "sms_validate": ["SMS Validate", ""],
    "sms_is_validate": ["SMS Is Validate", ""],
    "fetch_all_otp": ["Fetch All OTP", ""],
    "delete_verification": ["Delete Verification", ""]
};

const addGroupToActions = (name)=> {
    $("#action").append("<option disabled value=\"\">─</option>");
    $("#action").append("<option disabled value=\"\">" + name + "</option>");
};
const addAction = (action, name)=>
    $("#action").append("<option value=\"" + action + "\">" + name + "</option>");

$(document).ready(()=> {
    $("#action").append("<option disabled selected value=\"\">Actions</option>");
    addAction("handshake", "Handshake");

    addGroupToActions("Authentication");
    for(let act in authenticationActions)
        addAction(act, authenticationActions[act][0]);

    addGroupToActions("SMS");
    for(let act in smsActions)
        addAction(act, smsActions[act][0]);

    $("#send").click(()=> {
        $.ajax({
            url: "api/index.php?action=" + $("#action").find(":selected").val(),
            type: "POST",
            data: JSON.parse($("#contents").val()),
            headers: JSON.parse($("#http-headers").val()),
            dataType: "json",
            success: (data)=>
                $("#response").val(JSON.stringify(data, null, 4))
        });
    });
});