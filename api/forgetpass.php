<?php

include_once("../controller/validator.php");

header('Content-Type: application/json; charset=utf-8');

function execute($backend, $args) {
    
}

function failedResponse() {
    echo "{\"result\": \"0\"}";
}

if(isset($_POST["ue"]) && !empty($_POST["ue"])) {
    $ue = $_POST["ue"];

    if(!validateUsername($ue) &&
        !validateEmail($ue)) {
        failedResponse();
        return;
    }

    echo shell_exec("../bin/forgetpass ".$ue);
    return;
}

failedResponse();

?>