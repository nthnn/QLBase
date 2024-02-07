<?php
    include_once("controller/session_ctrl.php");

    $view = "home";
    $title = "QLBase | Home";
    $sess_id = isset($_COOKIE["sess_id"]) ? $_COOKIE["sess_id"] : "";

    function getPage($viewName, $pageTitle) {
        global $view;
        global $title;

        $view = $viewName;
        $title = "QLBase | ".$pageTitle;
    }

    function defaultPage() {
        getPage("home", "Home");
    }

    function sessionCleanUp() {
        if(isset($_COOKIE["sess_id"]) && !empty($_COOKIE["sess_id"]))
            deleteSession();
    }

    if(isset($_COOKIE["sess_id"]) && !empty($_COOKIE["sess_id"]) && validateSession($sess_id)) {
        if(isset($_GET["page"]) && !empty($_GET["page"]))
            switch($_GET["page"]) {
                case "settings":
                    getPage("settings", "Settings");
                    break;

                case "app":
                    getPage("app", "App");
                    break;

                default:
                    getPage("dashboard", "Dashboard");
                    break;
            }
        else getPage("dashboard", "Dashboard");
    }
    else if(isset($_GET["page"]) && !empty($_GET["page"])) {
        $page = $_GET["page"];
        sessionCleanUp();

        if($page == "sign-up")
            getPage("sign-up", "Sign-up");
        else if($page == "log-in")
            getPage("log-in", "Log-in");
        else if($page == "recover")
            getPage("recover", "Recover");
        else if($page == "forgot")
            getPage("forgot", "Forgot Your Password");
        else defaultPage();
    }
    else {
        sessionCleanUp();
        defaultPage();
    }
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="QLBase" />
    <meta name="keywords" content="nthnn" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?php echo $title; ?></title>

    <link href="./styles/global.css" rel="stylesheet" />
    <link href="./styles/timeline.css" rel="stylesheet" />
    <link href="./styles/bootstrap.min.css" rel="stylesheet" />

    <link href="./favicon.ico" rel="shortcut icon" />
</head>
<body>
    <?php require_once("views/".$view.".php"); ?>
</body>
</html>