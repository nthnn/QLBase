<?php

$db_server = "localhost";
$db_username = "root";
$db_password = "";

$db_conn = mysqli_connect($db_server, $db_username, $db_password, "qlbase");
$db_apps_conn = mysqli_connect($db_server, $db_username, $db_password, "qlbase_apps");

?>