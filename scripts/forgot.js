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
    const forgotBtn = RotatingButton("#forgot-btn");

    $("#forgot-btn").click(()=> {
        let ue = $("#ue").val();

        hideMessage("#ue-error");
        hideMessage("#ue-success");
        forgotBtn.show();

        if(!ue ||
            ue === "" ||
            (!/^[a-zA-Z0-9_]+$/.test(ue) &&
            !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(ue))) {
            showMessage("#ue-error", "Invalid username or email.");
            forgotBtn.hide();
            return;
        }

        $.post(
            "side/forgetpass.php",
            { ue: ue },
            (data)=> {
                forgotBtn.hide();

                if(data.result == "1")
                    showMessage("#ue-success", "Recovery email was sent.");
                else showMessage("#ue-error", data.message);
            }
        )
    });
});