<?php

include_once("../controller/apps.php");
include_once("../controller/validator.php");

function validateApiKey($key) {
    return preg_match("/^qba_[0-9a-fA-F]{10}_[0-9a-fA-F]{8}$/", $key);
}

function failedResponse() {
    echo "{\"result\": \"0\"}";
}

function failedResponseMessage($message) {
    echo "{\"result\": \"0\", \"message\": \"".$message."\"}";
}

function execute($backend, $args) {
    echo shell_exec("../bin/".$backend." ".join(" ", $args));
}

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if(isset($_SERVER["HTTP_QLBASE_API_KEY"]) && !empty($_SERVER["HTTP_QLBASE_API_KEY"]) &&
    isset($_SERVER["HTTP_QLBASE_APP_ID"]) && !empty($_SERVER["HTTP_QLBASE_APP_ID"])) {
    $apiKey = $_SERVER["HTTP_QLBASE_API_KEY"];
    $appId = $_SERVER["HTTP_QLBASE_APP_ID"];

    if(!isset($_GET["action"]) ||
        empty($_GET["action"]) ||
        !validateApiKey($apiKey) ||
        !validateAppId($appId) ||
        !matchApiKeyAppId($apiKey, $appId)) {
        failedResponse();
        return;
    }

    $action = $_GET["action"];
    $backend = "";
    $args = array();

    switch($action) {
        case "new_user":
            $backend = "auth";
            array_push($args, "create", $apiKey);

            if(!isset($_POST["username"]) || empty($_POST["username"]) ||
                !isset($_POST["email"]) || empty($_POST["email"]) ||
                !isset($_POST["password"]) || empty($_POST["password"]) ||
                !isset($_POST["enabled"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }

            $username = $_POST["username"];
            if(!validateUsername($username)) {
                failedResponseMessage("Invalid username string.");
                return;
            }

            $email = $_POST["email"];
            if(!validateEmail($email)) {
                failedResponseMessage("Invalid email string.");
                return;
            }

            $password = $_POST["password"];
            if(!validateLoginPassword($password)) {
                failedResponseMessage("Invalid password hash.");
                return;
            }

            $enabled = $_POST["enabled"] == "1" ? "true" : "false";
            array_push($args, $username, $email, $password, $enabled);
            break;

        case "update_by_username":
            $backend = "auth";
            array_push($args, "update_by_username", $apiKey);
    
            if(!isset($_POST["username"]) || empty($_POST["username"]) ||
                !isset($_POST["email"]) || empty($_POST["email"]) ||
                !isset($_POST["password"]) || empty($_POST["password"]) ||
                !isset($_POST["enabled"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }
    
            $username = $_POST["username"];
            if(!validateUsername($username)) {
                failedResponseMessage("Invalid username string.");
                return;
            }
    
            $email = $_POST["email"];
            if(!validateEmail($email)) {
                failedResponseMessage("Invalid email string.");
                return;
            }
    
            $password = $_POST["password"];
            if(!validateLoginPassword($password)) {
                failedResponseMessage("Invalid password hash.");
                return;
            }
    
            $enabled = $_POST["enabled"] == "1" ? "true" : "false";
            array_push($args, $username, $email, $password, $enabled);
            break;

        case "update_by_email":
            $backend = "auth";
            array_push($args, "update_by_email", $apiKey);
        
            if(!isset($_POST["username"]) || empty($_POST["username"]) ||
                !isset($_POST["email"]) || empty($_POST["email"]) ||
                !isset($_POST["password"]) || empty($_POST["password"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }
        
            $username = $_POST["username"];
            if(!validateUsername($username)) {
                failedResponseMessage("Invalid username string.");
                return;
            }
        
            $email = $_POST["email"];
            if(!validateEmail($email)) {
                failedResponseMessage("Invalid email string.");
                return;
            }
        
            $password = $_POST["password"];
            if(!validateLoginPassword($password)) {
                failedResponseMessage("Invalid password hash.");
                return;
            }
        
            $enabled = $_POST["enabled"] == "1" ? "true" : "false";
            array_push($args, $email, $username, $password, $enabled);
            break;
    
        case "delete_by_username":
            $backend = "auth";
            array_push($args, "delete_by_username", $apiKey);

            if(!isset($_POST["username"]) || empty($_POST["username"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }

            $username = $_POST["username"];
            if(!validateUsername($username)) {
                failedResponseMessage("Invalid username string.");
                return;
            }

            array_push($args, $username);
            break;

        case "delete_by_email":
            $backend = "auth";
            array_push($args, "delete_by_email", $apiKey);

            if(!isset($_POST["email"]) || empty($_POST["email"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }
    
            $email = $_POST["email"];
            if(!validateEmail($email)) {
                failedResponseMessage("Invalid email string.");
                return;
            }
    
            array_push($args, $email);
            break;

        case "get_by_username":
            $backend = "auth";
            array_push($args, "get_by_username", $apiKey);
    
            if(!isset($_POST["username"]) || empty($_POST["username"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }
    
            $username = $_POST["username"];
            if(!validateUsername($username)) {
                failedResponseMessage("Invalid username string.");
                return;
            }

            array_push($args, $username);
            break;

        case "get_by_email":
            $backend = "auth";
            array_push($args, "get_by_email", $apiKey);

            if(!isset($_POST["email"]) || empty($_POST["email"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }

            $email = $_POST["email"];
            if(!validateEmail($email)) {
                failedResponseMessage("Invalid email string.");
                return;
            }
    
            array_push($args, $email);
            break;

        case "enable_user":
            $backend = "auth";
            array_push($args, "enable_user", $apiKey);

            if(!isset($_POST["username"]) || empty($_POST["username"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }
    
            $username = $_POST["username"];
            if(!validateUsername($username)) {
                failedResponseMessage("Invalid username string.");
                return;
            }

            array_push($args, $username);
            break;

        case "disable_user":
            $backend = "auth";
            array_push($args, "disable_user", $apiKey);
    
            if(!isset($_POST["username"]) || empty($_POST["username"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }

            $username = $_POST["username"];
            if(!validateUsername($username)) {
                failedResponseMessage("Invalid username string.");
                return;
            }
    
            array_push($args, $username);
            break;
    
        case "is_user_enabled":
            $backend = "auth";
            array_push($args, "is_user_enabled", $apiKey);
        
            if(!isset($_POST["username"]) || empty($_POST["username"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }
    
            $username = $_POST["username"];
            if(!validateUsername($username)) {
                failedResponseMessage("Invalid username string.");
                return;
            }
        
            array_push($args, $username);
            break;

        case "login_username":
            $backend = "auth";
            array_push($args, "login_username", $apiKey);

            if(!isset($_POST["username"]) || empty($_POST["username"]) ||
                !isset($_POST["password"]) || empty($_POST["password"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }

            $username = $_POST["username"];
            if(!validateUsername($username)) {
                failedResponseMessage("Invalid username string.");
                return;
            }
        
            $password = $_POST["password"];
            if(!validateLoginPassword($password)) {
                failedResponseMessage("Invalid password hash.");
                return;
            }

            array_push($args, $username, $password);
            break;

        case "login_email":
            $backend = "auth";
            array_push($args, "login_email", $apiKey);

            if(!isset($_POST["email"]) || empty($_POST["email"]) ||
                !isset($_POST["password"]) || empty($_POST["password"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }

            $email = $_POST["email"];
            if(!validateEmail($email)) {
                failedResponseMessage("Invalid email string.");
                return;
            }

            $password = $_POST["password"];
            if(!validateLoginPassword($password)) {
                failedResponseMessage("Invalid password hash.");
                return;
            }

            array_push($args, $email, $password);
            break;

        case "fetch_all_users":
            $backend = "auth";
            array_push($args, "fetch_all", $apiKey);
            break;

        case "sms_verification":
            $backend = "sms";
            array_push($args, "verify", $apiKey);

            if(!isset($_POST["recipient"]) || empty($_POST["recipient"]) ||
                !isset($_POST["support"]) || empty($_POST["support"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }

            $recipient = $_POST["recipient"];
            if(!validatePhoneNumber($recipient)) {
                failedResponseMessage("Invalid recipient string.");
                return;
            }

            $support = $_POST["support"];
            if(!validateEmail($support)) {
                failedResponseMessage("Invalid support email.");
                return;
            }

            array_push($args, $recipient, $support);
            break;

        case "sms_validate":
            $backend = "sms";
            array_push($args, "validate", $apiKey);
    
            if(!isset($_POST["recipient"]) || empty($_POST["recipient"]) ||
                !isset($_POST["code"]) || empty($_POST["code"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }
    
            $recipient = $_POST["recipient"];
            if(!validatePhoneNumber($recipient)) {
                failedResponseMessage("Invalid recipient string.");
                return;
            }
    
            $code = $_POST["code"];
            if(!validateVerificationCode($code)) {
                failedResponseMessage("Invalid verification code.");
                return;
            }
    
            array_push($args, $recipient, $code);
            break;

        case "sms_is_validated":
            $backend = "sms";
            array_push($args, "is_validated", $apiKey);
        
            if(!isset($_POST["recipient"]) || empty($_POST["recipient"]) ||
                !isset($_POST["code"]) || empty($_POST["code"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }
        
            $recipient = $_POST["recipient"];
            if(!validatePhoneNumber($recipient)) {
                failedResponseMessage("Invalid recipient string.");
                return;
            }
        
            $code = $_POST["code"];
            if(!validateVerificationCode($code)) {
                failedResponseMessage("Invalid verification code.");
                return;
            }
        
            array_push($args, $recipient, $code);
            break;

        default:
            failedResponse();
            return;
    }

    execute($backend, $args);
    return;
}

failedResponse();

?>