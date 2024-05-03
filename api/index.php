<?php

include_once("../controller/apps.php");
include_once("../controller/db_config.php");
include_once("../controller/validator.php");
include_once("../controller/response.php");
include_once("../controller/shell.php");
include_once("../controller/util.php");

Response::jsonContent();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_SERVER["HTTP_QLBASE_API_KEY"]) && !empty($_SERVER["HTTP_QLBASE_API_KEY"]) &&
    isset($_SERVER["HTTP_QLBASE_APP_ID"]) && !empty($_SERVER["HTTP_QLBASE_APP_ID"])) {
    $apiKey = $_SERVER["HTTP_QLBASE_API_KEY"];
    $appId = $_SERVER["HTTP_QLBASE_APP_ID"];

    if(!isset($_GET["action"]) ||
        empty($_GET["action"]) ||
        !Validate::apiKey($apiKey) ||
        !Apps::validateId($appId) ||
        !Apps::matchApiKeyId($apiKey, $appId)) {
        Response::failed();
        return;
    }

    $action = $_GET["action"];
    $backend = "";
    $args = array();

    switch($action) {
        case "handshake":
            Util::logTraffic($apiKey, $appId);
            echo "{\"result\": \"1\"}";
            return;
            
        case "new_user":
            $backend = "auth";
            array_push($args, "create", $apiKey);

            if(!isset($_POST["username"]) || empty($_POST["username"]) ||
                !isset($_POST["email"]) || empty($_POST["email"]) ||
                !isset($_POST["password"]) || empty($_POST["password"]) ||
                !isset($_POST["enabled"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $username = $_POST["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }

            $email = $_POST["email"];
            if(!Validate::email($email)) {
                Response::failedMessage("Invalid email string.");
                return;
            }

            $password = $_POST["password"];
            if(!Validate::loginPassword($password)) {
                Response::failedMessage("Invalid password hash.");
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
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $username = $_POST["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }
    
            $email = $_POST["email"];
            if(!Validate::email($email)) {
                Response::failedMessage("Invalid email string.");
                return;
            }
    
            $password = $_POST["password"];
            if(!Validate::loginPassword($password)) {
                Response::failedMessage("Invalid password hash.");
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
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $username = $_POST["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }
        
            $email = $_POST["email"];
            if(!Validate::email($email)) {
                Response::failedMessage("Invalid email string.");
                return;
            }
        
            $password = $_POST["password"];
            if(!Validate::loginPassword($password)) {
                Response::failedMessage("Invalid password hash.");
                return;
            }
        
            $enabled = $_POST["enabled"] == "1" ? "true" : "false";
            array_push($args, $email, $username, $password, $enabled);
            break;
    
        case "delete_by_username":
            $backend = "auth";
            array_push($args, "delete_by_username", $apiKey);

            if(!isset($_POST["username"]) || empty($_POST["username"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $username = $_POST["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }

            array_push($args, $username);
            break;

        case "delete_by_email":
            $backend = "auth";
            array_push($args, "delete_by_email", $apiKey);

            if(!isset($_POST["email"]) || empty($_POST["email"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $email = $_POST["email"];
            if(!Validate::email($email)) {
                Response::failedMessage("Invalid email string.");
                return;
            }
    
            array_push($args, $email);
            break;

        case "get_by_username":
            $backend = "auth";
            array_push($args, "get_by_username", $apiKey);
    
            if(!isset($_POST["username"]) || empty($_POST["username"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $username = $_POST["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }

            array_push($args, $username);
            break;

        case "get_by_email":
            $backend = "auth";
            array_push($args, "get_by_email", $apiKey);

            if(!isset($_POST["email"]) || empty($_POST["email"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $email = $_POST["email"];
            if(!Validate::email($email)) {
                Response::failedMessage("Invalid email string.");
                return;
            }
    
            array_push($args, $email);
            break;

        case "enable_user":
            $backend = "auth";
            array_push($args, "enable_user", $apiKey);

            if(!isset($_POST["username"]) || empty($_POST["username"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $username = $_POST["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }

            array_push($args, $username);
            break;

        case "disable_user":
            $backend = "auth";
            array_push($args, "disable_user", $apiKey);
    
            if(!isset($_POST["username"]) || empty($_POST["username"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $username = $_POST["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }
    
            array_push($args, $username);
            break;
    
        case "is_user_enabled":
            $backend = "auth";
            array_push($args, "is_user_enabled", $apiKey);
        
            if(!isset($_POST["username"]) || empty($_POST["username"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $username = $_POST["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }
        
            array_push($args, $username);
            break;

        case "login_username":
            $backend = "auth";
            array_push($args, "login_username", $apiKey);

            if(!isset($_POST["username"]) || empty($_POST["username"]) ||
                !isset($_POST["password"]) || empty($_POST["password"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $username = $_POST["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }
        
            $password = $_POST["password"];
            if(!Validate::loginPassword($password)) {
                Response::failedMessage("Invalid password hash.");
                return;
            }

            array_push($args, $username, $password);
            break;

        case "login_email":
            $backend = "auth";
            array_push($args, "login_email", $apiKey);

            if(!isset($_POST["email"]) || empty($_POST["email"]) ||
                !isset($_POST["password"]) || empty($_POST["password"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $email = $_POST["email"];
            if(!Validate::email($email)) {
                Response::failedMessage("Invalid email string.");
                return;
            }

            $password = $_POST["password"];
            if(!Validate::loginPassword($password)) {
                Response::failedMessage("Invalid password hash.");
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
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $recipient = $_POST["recipient"];
            if(!Validate::phoneNumber($recipient)) {
                Response::failedMessage("Invalid recipient string.");
                return;
            }

            $support = $_POST["support"];
            if(!Validate::email($support)) {
                Response::failedMessage("Invalid support email.");
                return;
            }

            array_push($args, $recipient, $support);
            break;

        case "sms_validate":
            $backend = "sms";
            array_push($args, "validate", $apiKey);
    
            if(!isset($_POST["recipient"]) || empty($_POST["recipient"]) ||
                !isset($_POST["code"]) || empty($_POST["code"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $recipient = $_POST["recipient"];
            if(!Validate::phoneNumber($recipient)) {
                Response::failedMessage("Invalid recipient string.");
                return;
            }
    
            $code = $_POST["code"];
            if(!Validate::verificationCode($code)) {
                Response::failedMessage("Invalid verification code.");
                return;
            }
    
            array_push($args, $recipient, $code);
            break;

        case "sms_is_validated":
            $backend = "sms";
            array_push($args, "is_validated", $apiKey);

            if(!isset($_POST["recipient"]) || empty($_POST["recipient"]) ||
                !isset($_POST["code"]) || empty($_POST["code"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $recipient = $_POST["recipient"];
            if(!Validate::phoneNumber($recipient)) {
                Response::failedMessage("Invalid recipient string.");
                return;
            }
        
            $code = $_POST["code"];
            if(!Validate::verificationCode($code)) {
                Response::failedMessage("Invalid verification code.");
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
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $recipient = $_POST["recipient"];
            if(!Validate::phoneNumber($recipient)) {
                Response::failedMessage("Invalid recipient string.");
                return;
            }
        
            $code = $_POST["code"];
            if(!Validate::verificationCode($code)) {
                Response::failedMessage("Invalid verification code.");
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
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }

            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }

            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }

            $timedate = $_POST["timestamp"];
            if(!Validate::dateTime($timedate)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }

            $payload = $_POST["payload"];
            if(!Validate::json($payload)) {
                Response::failedMessage("Invalid payload JSON string.");
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
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
    
            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
    
            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }

            $payload = $_POST["payload"];
            if(!Validate::json($payload)) {
                Response::failedMessage("Invalid payload JSON string.");
                return;
            }
    
            array_push($args, $tracker, $anon_id, $user_id, base64_encode($payload));
            break;

        case "id_delete_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "id_delete_by_anon_id", $apiKey);

            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["anon_id"]) || empty($_POST["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }

            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }

            array_push($args, $tracker, $anon_id);
            break;

        case "id_delete_by_user_id":
            $backend = "data_analytics";
            array_push($args, "id_delete_by_user_id", $apiKey);

            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["user_id"]) || empty($_POST["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }

            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
    
            array_push($args, $tracker, $user_id);
            break;

        case "id_get_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "id_get_by_anon_id", $apiKey);

            if(!isset($_POST["anon_id"]) || empty($_POST["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
    
            array_push($args, $anon_id);
            break;

        case "id_delete_by_timestamp":
            $backend = "data_analytics";
            array_push($args, "id_delete_by_timestamp", $apiKey);
    
            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["timestamp"]) || empty($_POST["timestamp"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
   
            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
    
            $timestamp = $_POST["timestamp"];
            if(!Validate::timestamp($timestamp)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }
        
            array_push($args, $tracker, "\"".$timestamp."\"");
            break;
    
        case "id_get_by_user_id":
            $backend = "data_analytics";
            array_push($args, "id_get_by_user_id", $apiKey);

            if(!isset($_POST["user_id"]) || empty($_POST["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }

            array_push($args, $user_id);
            break;

        case "id_get_by_timestamp":
            $backend = "data_analytics";
            array_push($args, "id_get_by_timestamp", $apiKey);

            if(!isset($_POST["timestamp"]) || empty($_POST["timestamp"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $timestamp = $_POST["timestamp"];
            if(!Validate::dateTime($timestamp)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }
            
            array_push($args, "\"".$timestamp."\"");
            break;

        case "id_fetch_all":
            $backend = "data_analytics";
            array_push($args, "id_fetch_all", $apiKey);
            break;

        case "track_create":
            $backend = "data_analytics";
            array_push($args, "track_create", $apiKey);

            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["anon_id"]) || empty($_POST["anon_id"]) ||
                !isset($_POST["user_id"]) || empty($_POST["user_id"]) ||
                !isset($_POST["event"]) || empty($_POST["event"]) ||
                !isset($_POST["timestamp"]) || empty($_POST["timestamp"]) ||
                !isset($_POST["payload"]) || empty($_POST["payload"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
    
            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
    
            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
    
            $event = $_POST["event"];
            if(!Validate::username($event)) {
                Response::failedMessage("Invalid event name.");
                return;
            }
    
            $timedate = $_POST["timestamp"];
            if(!Validate::dateTime($timedate)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }
    
            $payload = $_POST["payload"];
            if(!Validate::json($payload)) {
                Response::failedMessage("Invalid payload JSON string.");
                return;
            }
    
            array_push($args, $tracker, $anon_id, $user_id, $event, "\"".$timedate."\"", base64_encode($payload));
            break;
    
        case "track_create_live_timestamp":
            $backend = "data_analytics";
            array_push($args, "track_create_live_timestamp", $apiKey);
    
            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["anon_id"]) || empty($_POST["anon_id"]) ||
                !isset($_POST["user_id"]) || empty($_POST["user_id"]) ||
                !isset($_POST["event"]) || empty($_POST["event"]) ||
                !isset($_POST["payload"]) || empty($_POST["payload"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
        
            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
        
            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
    
            $event = $_POST["event"];
            if(!Validate::username($event)) {
                Response::failedMessage("Invalid event name.");
                return;
            }
    
            $payload = $_POST["payload"];
            if(!Validate::json($payload)) {
                Response::failedMessage("Invalid payload JSON string.");
                return;
            }
        
            array_push($args, $tracker, $anon_id, $user_id, $event, base64_encode($payload));
            break;
    
        case "track_delete_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "track_delete_by_anon_id", $apiKey);
    
            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["anon_id"]) || empty($_POST["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
    
            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
    
            array_push($args, $tracker, $anon_id);
            break;
    
        case "track_delete_by_user_id":
            $backend = "data_analytics";
            array_push($args, "track_delete_by_user_id", $apiKey);
    
            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["user_id"]) || empty($_POST["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
    
            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
        
            array_push($args, $tracker, $user_id);
            break;
    
        case "track_delete_by_event":
            $backend = "data_analytics";
            array_push($args, "track_delete_by_event", $apiKey);
    
            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["event"]) || empty($_POST["event"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
    
            $event = $_POST["event"];
            if(!Validate::username($event)) {
                Response::failedMessage("Invalid event name.");
                return;
            }
        
            array_push($args, $tracker, $event);
            break;
    
        case "track_delete_by_timestamp":
            $backend = "data_analytics";
            array_push($args, "track_delete_by_timestamp", $apiKey);
        
            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["timestamp"]) || empty($_POST["timestamp"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
       
            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
        
            $timestamp = $_POST["timestamp"];
            if(!Validate::timestamp($timestamp)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }
            
            array_push($args, $tracker, "\"".$timestamp."\"");
            break;
        
        case "track_get_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "track_get_by_anon_id", $apiKey);
    
            if(!isset($_POST["anon_id"]) || empty($_POST["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
        
            array_push($args, $anon_id);
            break;
    
        case "track_get_by_user_id":
            $backend = "data_analytics";
            array_push($args, "track_get_by_user_id", $apiKey);
    
            if(!isset($_POST["user_id"]) || empty($_POST["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
    
            array_push($args, $user_id);
            break;
    
        case "track_get_by_event":
            $backend = "data_analytics";
            array_push($args, "track_get_by_event", $apiKey);
    
            if(!isset($_POST["event"]) || empty($_POST["event"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $event = $_POST["event"];
            if(!Validate::username($event)) {
                Response::failedMessage("Invalid event name.");
                return;
            }
    
            array_push($args, $event);
            break;
    
        case "track_get_by_timestamp":
            $backend = "data_analytics";
            array_push($args, "track_get_by_timestamp", $apiKey);
    
            if(!isset($_POST["timestamp"]) || empty($_POST["timestamp"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $timestamp = $_POST["timestamp"];
            if(!Validate::dateTime($timestamp)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }
                
            array_push($args, "\"".$timestamp."\"");
            break;
    
        case "track_fetch_all":
            $backend = "data_analytics";
            array_push($args, "track_fetch_all", $apiKey);
            break;

        case "page_create":
            $backend = "data_analytics";
            array_push($args, "page_create", $apiKey);
    
            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["anon_id"]) || empty($_POST["anon_id"]) ||
                !isset($_POST["user_id"]) || empty($_POST["user_id"]) ||
                !isset($_POST["name"]) || empty($_POST["name"]) ||
                !isset($_POST["category"]) || empty($_POST["category"]) ||
                !isset($_POST["timestamp"]) || empty($_POST["timestamp"]) ||
                !isset($_POST["payload"]) || empty($_POST["payload"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
        
            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
        
            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
        
            $name = $_POST["name"];
            if(!Validate::username($name)) {
                Response::failedMessage("Invalid page name.");
                return;
            }
    
            $category = $_POST["category"];
            if(!Validate::username($category)) {
                Response::failedMessage("Invalid page category.");
                return;
            }
    
            $timedate = $_POST["timestamp"];
            if(!Validate::dateTime($timedate)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }
        
            $payload = $_POST["payload"];
            if(!Validate::json($payload)) {
                Response::failedMessage("Invalid payload JSON string.");
                return;
            }
        
            array_push(
                $args,
                $tracker,
                $anon_id,
                $user_id,
                $name,
                $category,
                "\"".$timedate."\"",
                base64_encode($payload)
            );
            break;
        
        case "page_create_live_timestamp":
            $backend = "data_analytics";
            array_push($args, "page_create_live_timestamp", $apiKey);

            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["anon_id"]) || empty($_POST["anon_id"]) ||
                !isset($_POST["user_id"]) || empty($_POST["user_id"]) ||
                !isset($_POST["name"]) || empty($_POST["name"]) ||
                !isset($_POST["category"]) || empty($_POST["category"]) ||
                !isset($_POST["payload"]) || empty($_POST["payload"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
            
            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
            
            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
        
            $name = $_POST["name"];
            if(!Validate::username($name)) {
                Response::failedMessage("Invalid page name.");
                return;
            }
        
            $category = $_POST["category"];
            if(!Validate::username($category)) {
                Response::failedMessage("Invalid page category.");
                return;
            }
    
            $payload = $_POST["payload"];
            if(!Validate::json($payload)) {
                Response::failedMessage("Invalid payload JSON string.");
                return;
            }
            
            array_push($args, $tracker, $anon_id, $user_id, $name, $category, base64_encode($payload));
            break;
        
        case "page_delete_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "page_delete_by_anon_id", $apiKey);
        
            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["anon_id"]) || empty($_POST["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
        
            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
        
            array_push($args, $tracker, $anon_id);
            break;
        
        case "page_delete_by_user_id":
            $backend = "data_analytics";
            array_push($args, "page_delete_by_user_id", $apiKey);

            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["user_id"]) || empty($_POST["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }

            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
            
            array_push($args, $tracker, $user_id);
            break;
        
        case "page_delete_by_name":
            $backend = "data_analytics";
            array_push($args, "page_delete_by_name", $apiKey);
        
            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["name"]) || empty($_POST["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
        
            $name = $_POST["name"];
            if(!Validate::username($name)) {
                Response::failedMessage("Invalid page name.");
                return;
            }
            
            array_push($args, $tracker, $name);
            break;
    
        case "page_delete_by_category":
            $backend = "data_analytics";
            array_push($args, "page_delete_by_category", $apiKey);
        
            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["category"]) || empty($_POST["category"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
        
            $category = $_POST["category"];
            if(!Validate::username($category)) {
                Response::failedMessage("Invalid page category.");
                return;
            }
            
            array_push($args, $tracker, $category);
            break;
    
        case "page_delete_by_timestamp":
            $backend = "data_analytics";
            array_push($args, "page_delete_by_timestamp", $apiKey);

            if(!isset($_POST["tracker"]) || empty($_POST["tracker"]) ||
                !isset($_POST["timestamp"]) || empty($_POST["timestamp"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
           
            $tracker = $_POST["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
            
            $timestamp = $_POST["timestamp"];
            if(!Validate::timestamp($timestamp)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }
                
            array_push($args, $tracker, "\"".$timestamp."\"");
            break;
            
        case "page_get_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "page_get_by_anon_id", $apiKey);

            if(!isset($_POST["anon_id"]) || empty($_POST["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
            
            array_push($args, $anon_id);
            break;
        
        case "page_get_by_user_id":
            $backend = "data_analytics";
            array_push($args, "page_get_by_user_id", $apiKey);
        
            if(!isset($_POST["user_id"]) || empty($_POST["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
            
            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
        
            array_push($args, $user_id);
            break;
        
        case "page_get_by_name":
            $backend = "data_analytics";
            array_push($args, "page_get_by_name", $apiKey);
        
            if(!isset($_POST["name"]) || empty($_POST["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
            
            $name = $_POST["name"];
            if(!Validate::username($name)) {
                Response::failedMessage("Invalid page name.");
                return;
            }
        
            array_push($args, $name);
            break;
        
        case "page_get_by_category":
            $backend = "data_analytics";
            array_push($args, "page_get_by_category", $apiKey);
        
            if(!isset($_POST["category"]) || empty($_POST["category"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
            
            $category = $_POST["category"];
            if(!Validate::username($category)) {
                Response::failedMessage("Invalid page category.");
                return;
            }
        
            array_push($args, $category);
            break;
    
        case "page_get_by_timestamp":
            $backend = "data_analytics";
            array_push($args, "page_get_by_timestamp", $apiKey);
        
            if(!isset($_POST["timestamp"]) || empty($_POST["timestamp"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $timestamp = $_POST["timestamp"];
            if(!Validate::dateTime($timestamp)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }
                    
            array_push($args, "\"".$timestamp."\"");
            break;
        
        case "page_fetch_all":
            $backend = "data_analytics";
            array_push($args, "page_fetch_all", $apiKey);
            break;

        case "alias_anon_has":
            $backend = "data_analytics";
            array_push($args, "alias_anon_has", $apiKey);

            if(!isset($_POST["anon_id"]) || empty($_POST["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }

            array_push($args, $anon_id);
            break;

        case "alias_user_has":
            $backend = "data_analytics";
            array_push($args, "alias_user_has", $apiKey);

            if(!isset($_POST["user_id"]) || empty($_POST["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }

            array_push($args, $user_id);
            break;

        case "alias_for_anon":
            $backend = "data_analytics";
            array_push($args, "alias_for_anon", $apiKey);

            if(!isset($_POST["user_id"]) || empty($_POST["user_id"]) ||
                !isset($_POST["anon_id"]) || empty($_POST["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }

            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }

            array_push($args, $anon_id, $user_id);
            break;
    
        case "alias_for_user":
            $backend = "data_analytics";
            array_push($args, "alias_for_user", $apiKey);

            if(!isset($_POST["user_id"]) || empty($_POST["user_id"]) ||
                !isset($_POST["anon_id"]) || empty($_POST["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $user_id = $_POST["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }

            $anon_id = $_POST["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }

            array_push($args, $user_id, $anon_id);
            break;

        case "alias_fetch_all":
            $backend = "data_analytics";
            array_push($args, "alias_fetch_all", $apiKey);
            break;

        case "db_create":
            $backend = "database";
            array_push($args, "create", $apiKey);

            if(!isset($_POST["name"]) || empty($_POST["name"]) ||
                !isset($_POST["mode"]) || empty($_POST["mode"]) ||
                !isset($_POST["content"]) || empty($_POST["content"])) {
                    Response::failedMessage("Insufficient parameter arity.");
                    return;
            }

            $name = $_POST["name"];
            if(!Validate::name($name)) {
                Response::failedMessage("Invalid database name.");
                return;
            }

            $mode = $_POST["mode"];
            if(!Validate::dbMode($mode)) {
                Response::failedMessage("Invalid database mode.");
                return;
            }

            $content = $_POST["content"];
            if(!Validate::dbContent($content)) {
                Response::failedMessage("Invalid database content.");
                return;
            }

            array_push($args, $name, $mode, $content);
            break;

        case "db_get_by_name":
            $backend = "database";
            array_push($args, "get_by_name", $apiKey);

            if(!isset($_POST["name"]) || empty($_POST["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $name = $_POST["name"];
            if(!Validate::name($name)) {
                Response::failedMessage("Invalid database name.");
                return;
            }

            array_push($args, $name);
            break;

        case "db_set_mode":
            $backend = "database";
            array_push($args, "set_db_mode", $apiKey);

            if(!isset($_POST["name"]) || empty($_POST["name"]) ||
                !isset($_POST["mode"]) || empty($_POST["mode"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $name = $_POST["name"];
            if(!Validate::name($name)) {
                Response::failedMessage("Invalid database name.");
                return;
            }

            $mode = $_POST["mode"];
            if(!Validate::dbMode($mode)) {
                Response::failedMessage("Invalid database mode.");
                return;
            }

            array_push($args, $name, $mode);
            break;

        case "db_get_mode":
            $backend = "database";
            array_push($args, "get_db_mode", $apiKey);
    
            if(!isset($_POST["name"]) || empty($_POST["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $name = $_POST["name"];
            if(!Validate::name($name)) {
                Response::failedMessage("Invalid database name.");
                return;
            }

            array_push($args, $name);
            break;

        case "db_read":
            $backend = "database";
            array_push($args, "read_db", $apiKey);
        
            if(!isset($_POST["name"]) || empty($_POST["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $name = $_POST["name"];
            if(!Validate::name($name)) {
                Response::failedMessage("Invalid database name.");
                return;
            }
    
            array_push($args, $name);
            break;

        case "db_write":
            $backend = "database";
            array_push($args, "set_db_mode", $apiKey);
    
            if(!isset($_POST["name"]) || empty($_POST["name"]) ||
                !isset($_POST["content"]) || empty($_POST["content"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $name = $_POST["name"];
            if(!Validate::name($name)) {
                Response::failedMessage("Invalid database name.");
                return;
            }
    
            $content = $_POST["content"];
            if(!Validate::dbContent($content)) {
                Response::failedMessage("Invalid database mode.");
                return;
            }

            array_push($args, $name, $content);
            break;

        case "db_delete":
            $backend = "database";
            array_push($args, "delete_db", $apiKey);
        
            if(!isset($_POST["name"]) || empty($_POST["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $name = $_POST["name"];
            if(!Validate::name($name)) {
                Response::failedMessage("Invalid database name.");
                return;
            }
    
            array_push($args, $name);
            break;

        case "db_fetch_all":
            $backend = "database";
            array_push($args, "fetch_all", $apiKey);
            break;

        case "file_upload":
            $backend = "storage";
            array_push($args, "upload", $apiKey);

            if(!isset($_FILES["subject"]) || $_FILES["subject"]["error"] !== UPLOAD_ERR_OK) {
                Response::failedMessage("File upload error.");
                return;
            }

            $out = "../drive/temp/".basename($_FILES["subject"]["name"]);
            if(!move_uploaded_file($_FILES["subject"]["tmp_name"], $out)) {
                Response::failedMessage("Unable to move uploaded file.");
                return;
            }

            array_push($args, "\"".$out."\"", "\"".basename($_FILES["subject"]["name"])."\"");
            break;

        case "file_delete":
            $backend = "storage";
            array_push($args, "delete", $apiKey);

            if(!isset($_POST["name"]) || empty($_POST["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $name = $_POST["name"];
            if(!Validate::base64($name)) {
                Response::failedMessage("Invalid file name.");
                return;
            }

            array_push($args, $name);
            break;

        case "file_get":
            $backend = "storage";
            array_push($args, "get", $apiKey);
    
            if(!isset($_POST["name"]) || empty($_POST["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $name = $_POST["name"];
            if(!Validate::base64($name)) {
                Response::failedMessage("Invalid file name.");
                return;
            }
    
            array_push($args, $name);
            break;
    
        case "file_download":
            $backend = "storage";
            array_push($args, "download", $apiKey);
        
            if(!isset($_POST["name"]) || empty($_POST["name"]) ||
                !isset($_POST["should_expire"]) || Validate::isEmpty($_POST["should_expire"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $name = $_POST["name"];
            if(!Validate::base64($name)) {
                Response::failedMessage("Invalid file name.");
                return;
            }

            $shouldExpire = $_POST["should_expire"];
            if($shouldExpire != "0" && $shouldExpire != "1") {
                Response::failedMessage("Invalid should_expire parameter value.");
                return;
            }

            array_push($args, $name, $shouldExpire);
            break;

        case "file_fetch_all":
            $backend = "storage";
            array_push($args, "fetch_all", $apiKey);
            break;
    
        default:
            Response::failed();
            return;
    }

    Shell::execute($apiKey, $appId, $backend, $args);
    return;
}

Response::failed();

?>