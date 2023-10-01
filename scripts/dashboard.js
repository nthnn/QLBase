const appCard = (name, appId)=> {
    return "<div class=\"col-lg-4\"><div class=\"card card-body border-primary hover-btn shadow\"><div class=\"row\"><div class=\"col-lg-2\"><svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" width=\"32\" height=\"32\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5\" /></svg></div><div class=\"col-lg-10\"><h3 class=\"m-0\">" + name + "</h3><p>" + appId + "</p></div></div></div></div>";
};

const renderApps = (apps)=> {
    let keys = Object.keys(apps);
    if(keys.length == 0) {
        $("#no-app").removeClass("d-none");
        $("#no-app").addClass("d-block");
    }
    else {
        $("#no-app").removeClass("d-block");
        $("#no-app").addClass("d-none");
    }

    let count = 0;
    let stringified = "<div class=\"row\">";
    let values = Object.values(apps);

    for(let i = 0; i < keys.length; i++) {
        if(count == 3) {
            stringified += "</div><br/><div class=\"row\">";
            count = 0;
        }

        stringified += appCard(keys[i], values[i]);
        count++;
    }

    $("#apps").html(stringified + "</div>");
};

const fetchApps = ()=>
    $.post(
        "side/apps.php?fetch",
        {},
        (data)=> {
            if(data.result == '1')
                renderApps(data.apps);
        }
    ).fail(()=> {});

$(document).ready(()=> {
    $("#logout").click(()=> {
        $.post(
            "side/account.php?logout",
            {},
            ()=> window.location.href = "?"
        );
    });

    $("#add-btn").click(()=> {
        let name = $("#app-name").val();
        if(name.length < 6 || !/^[a-z0-9_]+$/.test(name)) {
            $("#app-name-error").removeClass("d-none");
            $("#app-name-error").addClass("d-block");
            $("#app-name-error").html("Invalid app name. It must only contain lower case alphabet, digits, and/or an underscore and must be greater than 6 characters.");

            return;
        }

        $("#app-name-error").removeClass("d-block");
        $("#app-name-error").addClass("d-none");

        $.post(
            "side/apps.php?create",
            {name: name},
            (data)=> {
                if(data.result == '0') {
                    $("#app-name-error").removeClass("d-none");
                    $("#app-name-error").addClass("d-block");
                    $("#app-name-error").html("Something went wrong.");

                    return;
                }

                $("#add-new-modal").modal("hide");
                $("#app-name-error").removeClass("d-block");
                $("#app-name-error").addClass("d-none");
                $("#app-name").val("");

                $("#new-app-name").html(name);
                $("#success-modal").modal("show");

                fetchApps();
            }
        );
    });

    fetchApps();
});