<?php
    include_once("controller/session_validator.php");

    $view = "home";
    $title = "QLBase | Home";

    if(!isset($_COOKIE["sess_id"]) || !validateSession($_COOKIE["sess_id"])) {
        $view = "home";
        $title = "QLBase | Home";
    }
?>
<!DOCTYPE html>
<head>
    <title><?php echo $title; ?></title>

    <link href="./styles/bootstrap.min.css" rel="stylesheet" />
    <link href="./favicon.ico" rel="shortcut icon" />
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