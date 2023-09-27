<?php
    include_once("controller/session_validator.php");

    $view = "home";
    $title = "QLBase | Home";
    $sess_id = $_COOKIE["sess_id"];

    if(isset($_COOKIE["sess_id"]) && validateSession($sess_id)) {
        if(!isset($_GET['page'])) {
            $view = "dashboard";
            $title = "QLBase | Dashboard";
        }
        else { }
    }
    else {
        $view = "home";
        $title = "QLBase | Home";
    }
?>
<!DOCTYPE html>
<head>
    <title><?php echo $title; ?></title>

    <link href="./styles/global.css" rel="stylesheet" />
    <link href="./styles/bootstrap.min.css" rel="stylesheet" />
    <link href="./favicon.ico" rel="shortcut icon" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet"/>
</head>
<body>
    <?php
        switch($view) {
            case "home":
                require("views/home.php");
                break;
        }
    ?>
</body>
</html>