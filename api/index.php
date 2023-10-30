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

if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_SERVER["HTTP_QLBASE_API_KEY"]) && !empty($_SERVER["HTTP_QLBASE_API_KEY"]) &&
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
        case "handshake":
            echo "{\"result\": \"1\"}";
            return;
            
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

        case "fetch_all_otp":
            $backend = "sms";
            array_push($args, "fetch_all_otp", $apiKey);
            break;

        case "delete_verification":
            $backend = "sms";
            array_push($args, "delete_verification", $apiKey);

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

        case "id_create":
            $backend = "data_analytics";
            array_push($args, "id_create", $apiKey);

            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["anon_id"]) || empty($_POST["anon_id"]) ||
                !isset($_POST["user_id"]) || empty($_POST["user_id"]) ||
                !isset($_POST["timestamp"]) || empty($_POST["timestamp"]) ||
                !isset($_POST["payload"]) || empty($_POST["payload"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $_POST["tracker"];
            if(!validateTracker($tracker)) {
                failedResponseMessage("Invalid tracking ID.");
                return;
            }

            $anon_id = $_POST["anon_id"];
            if(!validateTracker($anon_id)) {
                failedResponseMessage("Invalid anonymous ID.");
                return;
            }

            $user_id = $_POST["user_id"];
            if(!validateUsername($user_id)) {
                failedResponseMessage("Invalid user ID.");
                return;
            }

            $timedate = $_POST["timestamp"];
            if(!validateDateTime($timedate)) {
                failedResponseMessage("Invalid timestamp format.");
                return;
            }

            $payload = $_POST["payload"];
            if(!validateJson($payload)) {
                failedResponseMessage("Invalid payload JSON string.");
                return;
            }

            array_push($args, $tracker, $anon_id, $user_id, "\"".$timedate."\"", base64_encode($payload));
            break;

        case "id_create_live_timestamp":
            $backend = "data_analytics";
            array_push($args, "id_create_live_timestamp", $apiKey);

            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["anon_id"]) || empty($_POST["anon_id"]) ||
                !isset($_POST["user_id"]) || empty($_POST["user_id"]) ||
                !isset($_POST["payload"]) || empty($_POST["payload"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $_POST["tracker"];
            if(!validateTracker($tracker)) {
                failedResponseMessage("Invalid tracking ID.");
                return;
            }
    
            $anon_id = $_POST["anon_id"];
            if(!validateTracker($anon_id)) {
                failedResponseMessage("Invalid anonymous ID.");
                return;
            }
    
            $user_id = $_POST["user_id"];
            if(!validateUsername($user_id)) {
                failedResponseMessage("Invalid user ID.");
                return;
            }

            $payload = $_POST["payload"];
            if(!validateJson($payload)) {
                failedResponseMessage("Invalid payload JSON string.");
                return;
            }
    
            array_push($args, $tracker, $anon_id, $user_id, base64_encode($payload));
            break;

        case "id_delete_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "id_delete_by_anon_id", $apiKey);

            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["anon_id"]) || empty($_POST["anon_id"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $_POST["tracker"];
            if(!validateTracker($tracker)) {
                failedResponseMessage("Invalid tracking ID.");
                return;
            }

            $anon_id = $_POST["anon_id"];
            if(!validateTracker($anon_id)) {
                failedResponseMessage("Invalid anonymous ID.");
                return;
            }

            array_push($args, $tracker, $anon_id);
            break;

        case "id_delete_by_user_id":
            $backend = "data_analytics";
            array_push($args, "id_delete_by_user_id", $apiKey);

            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["user_id"]) || empty($_POST["user_id"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $_POST["tracker"];
            if(!validateTracker($tracker)) {
                failedResponseMessage("Invalid tracking ID.");
                return;
            }

            $user_id = $_POST["user_id"];
            if(!validateUsername($user_id)) {
                failedResponseMessage("Invalid user ID.");
                return;
            }
    
            array_push($args, $tracker, $user_id);
            break;

        case "id_get_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "id_get_by_anon_id", $apiKey);

            if(!isset($_POST["anon_id"]) || empty($_POST["anon_id"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }
    
            $anon_id = $_POST["anon_id"];
            if(!validateTracker($anon_id)) {
                failedResponseMessage("Invalid anonymous ID.");
                return;
            }
    
            array_push($args, $anon_id);
            break;
    
        case "id_get_by_user_id":
            $backend = "data_analytics";
            array_push($args, "id_get_by_user_id", $apiKey);

            if(!isset($_POST["user_id"]) || empty($_POST["user_id"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }
    
            $user_id = $_POST["user_id"];
            if(!validateUsername($user_id)) {
                failedResponseMessage("Invalid user ID.");
                return;
            }

            array_push($args, $user_id);
            break;

        case "id_get_by_timestamp":
            $backend = "data_analytics";
            array_push($args, "id_get_by_timestamp", $apiKey);

            if(!isset($_POST["timestamp"]) || empty($_POST["timestamp"])) {
                failedResponseMessage("Insufficient parameter arity.");
                return;
            }

            $timestamp = $_POST["timestamp"];
            if(!validateDateTime($timestamp)) {
                failedResponseMessage("Invalid timestamp format.");
                return;
            }
            
            array_push($args, "\"".$timestamp."\"");
            break;

        case "id_fetch_all":
            $backend = "data_analytics";
            array_push($args, "id_fetch_all", $apiKey);
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