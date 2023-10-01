$(document).ready(()=> {
    $("#logout").click(()=> {
        $.post(
            "side/account.php?logout",
            {},
            ()=> window.location.href = "?"
        );
    });
});