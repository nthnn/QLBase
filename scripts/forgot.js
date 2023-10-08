const showMessage = (id, message)=> {
    $(id).removeClass("d-none");
    $(id).addClass("d-block");
    $(id).html(message);
};

const hideMessage = (id)=> {
    $(id).removeClass("d-block");
    $(id).addClass("d-none");
};

$(document).ready(()=> {
    $("#forgot-btn").click(()=> {
        let ue = $("#ue").val();

        hideMessage("#ue-error");
        hideMessage("#ue-success");

        if(!ue ||
            ue === "" ||
            (!/^[a-zA-Z0-9_]+$/.test(ue) &&
            !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(ue))) {
            showMessage("#ue-error", "Invalid username or email.");
            return;
        }

        $.post(
            "api/forgetpass.php",
            { ue: ue },
            (data)=> {
                if(data.result == '1')
                    showMessage("#ue-success", "Recovery email was sent.");
                else showMessage("#ue-error", data.message);
            }
        )
    });
});