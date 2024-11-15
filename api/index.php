<?php

/*
 * This file is part of QLBase (https://github.com/nthnn/QLBase).
 * Copyright 2024 - Nathanne Isip
 * 
 * Permission is hereby granted, free of charge,
 * to any person obtaining a copy of this software
 * and associated documentation files (the “Software”),
 * to deal in the Software without restriction,
 * including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to
 * whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions
 * of the Software.
 * 
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF
 * ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT
 * SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR
 * ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

include_once("../controller/apps.php");
include_once("../controller/cdp.php");
include_once("../controller/db_config.php");
include_once("../controller/validator.php");
include_once("../controller/response.php");
include_once("../controller/shell.php");
include_once("../controller/tor_detection.php");
include_once("../controller/util.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST");

if(TorDetection::isExitNode()) {
    http_response_code(403);
    return;
}

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

    $postData = $_POST;
    if(count($postData) == 0)
        $postData = json_decode(
            file_get_contents("php://input"),
            true
        );

    $action = $_GET["action"];
    $backend = "";
    $args = array();

    switch($action) {
        case "handshake":
            Util::logTraffic($apiKey, $appId);
            echo "{\"result\": \"1\"}";
            return;
            
        case "auth_create_user":
            $backend = "auth";
            array_push($args, "create", $apiKey);

            if(!isset($postData["username"]) || empty($postData["username"]) ||
                !isset($postData["email"]) || empty($postData["email"]) ||
                !isset($postData["password"]) || empty($postData["password"]) ||
                !isset($postData["enabled"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $username = $postData["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }

            $email = $postData["email"];
            if(!Validate::email($email)) {
                Response::failedMessage("Invalid email string.");
                return;
            }

            $password = $postData["password"];
            if(!Validate::loginPassword($password)) {
                Response::failedMessage("Invalid password hash.");
                return;
            }

            $enabled = $postData["enabled"] == "1" ? "true" : "false";
            array_push($args, $username, $email, $password, $enabled);
            break;

        case "auth_update_by_username":
            $backend = "auth";
            array_push($args, "update_by_username", $apiKey);
    
            if(!isset($postData["username"]) || empty($postData["username"]) ||
                !isset($postData["email"]) || empty($postData["email"]) ||
                !isset($postData["password"]) || empty($postData["password"]) ||
                !isset($postData["enabled"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $username = $postData["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }
    
            $email = $postData["email"];
            if(!Validate::email($email)) {
                Response::failedMessage("Invalid email string.");
                return;
            }
    
            $password = $postData["password"];
            if(!Validate::loginPassword($password)) {
                Response::failedMessage("Invalid password hash.");
                return;
            }
    
            $enabled = $postData["enabled"] == "1" ? "true" : "false";
            array_push($args, $username, $email, $password, $enabled);
            break;

        case "auth_update_by_email":
            $backend = "auth";
            array_push($args, "update_by_email", $apiKey);
        
            if(!isset($postData["username"]) || empty($postData["username"]) ||
                !isset($postData["email"]) || empty($postData["email"]) ||
                !isset($postData["password"]) || empty($postData["password"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $username = $postData["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }
        
            $email = $postData["email"];
            if(!Validate::email($email)) {
                Response::failedMessage("Invalid email string.");
                return;
            }
        
            $password = $postData["password"];
            if(!Validate::loginPassword($password)) {
                Response::failedMessage("Invalid password hash.");
                return;
            }
        
            $enabled = $postData["enabled"] == "1" ? "true" : "false";
            array_push($args, $email, $username, $password, $enabled);
            break;
    
        case "auth_delete_by_username":
            $backend = "auth";
            array_push($args, "delete_by_username", $apiKey);

            if(!isset($postData["username"]) || empty($postData["username"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $username = $postData["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }

            array_push($args, $username);
            break;

        case "auth_delete_by_email":
            $backend = "auth";
            array_push($args, "delete_by_email", $apiKey);

            if(!isset($postData["email"]) || empty($postData["email"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $email = $postData["email"];
            if(!Validate::email($email)) {
                Response::failedMessage("Invalid email string.");
                return;
            }
    
            array_push($args, $email);
            break;

        case "auth_get_by_username":
            $backend = "auth";
            array_push($args, "get_by_username", $apiKey);
    
            if(!isset($postData["username"]) || empty($postData["username"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $username = $postData["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }

            array_push($args, $username);
            break;

        case "auth_get_by_email":
            $backend = "auth";
            array_push($args, "get_by_email", $apiKey);

            if(!isset($postData["email"]) || empty($postData["email"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $email = $postData["email"];
            if(!Validate::email($email)) {
                Response::failedMessage("Invalid email string.");
                return;
            }
    
            array_push($args, $email);
            break;

        case "auth_enable_user":
            $backend = "auth";
            array_push($args, "enable_user", $apiKey);

            if(!isset($postData["username"]) || empty($postData["username"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $username = $postData["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }

            array_push($args, $username);
            break;

        case "auth_disable_user":
            $backend = "auth";
            array_push($args, "disable_user", $apiKey);
    
            if(!isset($postData["username"]) || empty($postData["username"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $username = $postData["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }
    
            array_push($args, $username);
            break;
    
        case "auth_is_enabled":
            $backend = "auth";
            array_push($args, "is_user_enabled", $apiKey);
        
            if(!isset($postData["username"]) || empty($postData["username"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $username = $postData["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }
        
            array_push($args, $username);
            break;

        case "auth_login_username":
            $backend = "auth";
            array_push($args, "login_username", $apiKey);

            if(!isset($postData["username"]) || empty($postData["username"]) ||
                !isset($postData["password"]) || empty($postData["password"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $username = $postData["username"];
            if(!Validate::username($username)) {
                Response::failedMessage("Invalid username string.");
                return;
            }
        
            $password = $postData["password"];
            if(!Validate::loginPassword($password)) {
                Response::failedMessage("Invalid password hash.");
                return;
            }

            array_push(
                $args,
                $username,
                $password,
                base64_encode($_SERVER['HTTP_USER_AGENT']),
                $_SERVER['REMOTE_ADDR']
            );
            break;

        case "auth_login_email":
            $backend = "auth";
            array_push($args, "login_email", $apiKey);

            if(!isset($postData["email"]) || empty($postData["email"]) ||
                !isset($postData["password"]) || empty($postData["password"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $email = $postData["email"];
            if(!Validate::email($email)) {
                Response::failedMessage("Invalid email string.");
                return;
            }

            $password = $postData["password"];
            if(!Validate::loginPassword($password)) {
                Response::failedMessage("Invalid password hash.");
                return;
            }

            array_push(
                $args,
                $email,
                $password,
                base64_encode($_SERVER['HTTP_USER_AGENT']),
                $_SERVER['REMOTE_ADDR']
            );
            break;

        case "auth_logout":
            $backend = "auth";
            array_push($args, "logout", $apiKey);

            if(!isset($postData["sess_id"]) || empty($postData["sess_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $sessionId = $postData["sess_id"];
            if(!Validate::authSessionId($sessionId)) {
                Response::failedMessage("Invalid session ID string.");
                return;
            }

            array_push(
                $args,
                $sessionId
            );
            break;

        case "auth_validate_session":
            $backend = "auth";
            array_push($args, "validate_session", $apiKey);

            if(!isset($postData["sess_id"]) || empty($postData["sess_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $sessionId = $postData["sess_id"];
            if(!Validate::authSessionId($sessionId)) {
                Response::failedMessage("Invalid session ID string.");
                return;
            }

            array_push(
                $args,
                $sessionId,
                base64_encode($_SERVER['HTTP_USER_AGENT']),
                $_SERVER['REMOTE_ADDR']
            );
            break;
    
        case "auth_fetch_all":
            $backend = "auth";
            array_push($args, "fetch_all", $apiKey);
            break;

        case "sms_verification":
            $backend = "sms";
            array_push($args, "verify", $apiKey);

            if(!isset($postData["recipient"]) || empty($postData["recipient"]) ||
                !isset($postData["support"]) || empty($postData["support"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $recipient = $postData["recipient"];
            if(!Validate::phoneNumber($recipient)) {
                Response::failedMessage("Invalid recipient string.");
                return;
            }

            $support = $postData["support"];
            if(!Validate::email($support)) {
                Response::failedMessage("Invalid support email.");
                return;
            }

            array_push($args, $recipient, $support);
            break;

        case "sms_validate":
            $backend = "sms";
            array_push($args, "validate", $apiKey);
    
            if(!isset($postData["recipient"]) || empty($postData["recipient"]) ||
                !isset($postData["code"]) || empty($postData["code"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $recipient = $postData["recipient"];
            if(!Validate::phoneNumber($recipient)) {
                Response::failedMessage("Invalid recipient string.");
                return;
            }
    
            $code = $postData["code"];
            if(!Validate::verificationCode($code)) {
                Response::failedMessage("Invalid verification code.");
                return;
            }
    
            array_push($args, $recipient, $code);
            break;

        case "sms_is_validated":
            $backend = "sms";
            array_push($args, "is_validated", $apiKey);

            if(!isset($postData["recipient"]) || empty($postData["recipient"]) ||
                !isset($postData["code"]) || empty($postData["code"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $recipient = $postData["recipient"];
            if(!Validate::phoneNumber($recipient)) {
                Response::failedMessage("Invalid recipient string.");
                return;
            }
        
            $code = $postData["code"];
            if(!Validate::verificationCode($code)) {
                Response::failedMessage("Invalid verification code.");
                return;
            }

            array_push($args, $recipient, $code);
            break;

        case "sms_fetch_all":
            $backend = "sms";
            array_push($args, "sms_fetch_all", $apiKey);
            break;

        case "sms_delete_otp":
            $backend = "sms";
            array_push($args, "sms_delete_otp", $apiKey);

            if(!isset($postData["recipient"]) || empty($postData["recipient"]) ||
                !isset($postData["code"]) || empty($postData["code"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $recipient = $postData["recipient"];
            if(!Validate::phoneNumber($recipient)) {
                Response::failedMessage("Invalid recipient string.");
                return;
            }
        
            $code = $postData["code"];
            if(!Validate::verificationCode($code)) {
                Response::failedMessage("Invalid verification code.");
                return;
            }
        
            array_push($args, $recipient, $code);
            break;

        case "id_create":
            $backend = "data_analytics";
            array_push($args, "id_create", $apiKey);

            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["anon_id"]) || empty($postData["anon_id"]) ||
                !isset($postData["user_id"]) || empty($postData["user_id"]) ||
                !isset($postData["timestamp"]) || empty($postData["timestamp"]) ||
                !isset($postData["payload"]) || empty($postData["payload"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }

            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }

            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }

            $timedate = $postData["timestamp"];
            if(!Validate::dateTime($timedate)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }

            $payload = $postData["payload"];
            if(!Validate::json($payload)) {
                Response::failedMessage("Invalid payload JSON string.");
                return;
            }

            array_push($args, $tracker, $anon_id, $user_id, "\"".$timedate."\"", base64_encode($payload));
            break;

        case "id_create_live_timestamp":
            $backend = "data_analytics";
            array_push($args, "id_create_live_timestamp", $apiKey);

            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["anon_id"]) || empty($postData["anon_id"]) ||
                !isset($postData["user_id"]) || empty($postData["user_id"]) ||
                !isset($postData["payload"]) || empty($postData["payload"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
    
            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
    
            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }

            $payload = $postData["payload"];
            if(!Validate::json($payload)) {
                Response::failedMessage("Invalid payload JSON string.");
                return;
            }
    
            array_push($args, $tracker, $anon_id, $user_id, base64_encode($payload));
            break;

        case "id_delete_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "id_delete_by_anon_id", $apiKey);

            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["anon_id"]) || empty($postData["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }

            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }

            array_push($args, $tracker, $anon_id);
            break;

        case "id_delete_by_user_id":
            $backend = "data_analytics";
            array_push($args, "id_delete_by_user_id", $apiKey);

            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["user_id"]) || empty($postData["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }

            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
    
            array_push($args, $tracker, $user_id);
            break;

        case "id_get_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "id_get_by_anon_id", $apiKey);

            if(!isset($postData["anon_id"]) || empty($postData["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
    
            array_push($args, $anon_id);
            break;

        case "id_delete_by_timestamp":
            $backend = "data_analytics";
            array_push($args, "id_delete_by_timestamp", $apiKey);
    
            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["timestamp"]) || empty($postData["timestamp"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
   
            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
    
            $timestamp = $postData["timestamp"];
            if(!Validate::timestamp($timestamp)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }
        
            array_push($args, $tracker, "\"".$timestamp."\"");
            break;
    
        case "id_get_by_user_id":
            $backend = "data_analytics";
            array_push($args, "id_get_by_user_id", $apiKey);

            if(!isset($postData["user_id"]) || empty($postData["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }

            array_push($args, $user_id);
            break;

        case "id_get_by_timestamp":
            $backend = "data_analytics";
            array_push($args, "id_get_by_timestamp", $apiKey);

            if(!isset($postData["timestamp"]) || empty($postData["timestamp"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $timestamp = $postData["timestamp"];
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

            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["anon_id"]) || empty($postData["anon_id"]) ||
                !isset($postData["user_id"]) || empty($postData["user_id"]) ||
                !isset($postData["event"]) || empty($postData["event"]) ||
                !isset($postData["timestamp"]) || empty($postData["timestamp"]) ||
                !isset($postData["payload"]) || empty($postData["payload"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
    
            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
    
            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
    
            $event = $postData["event"];
            if(!Validate::username($event)) {
                Response::failedMessage("Invalid event name.");
                return;
            }
    
            $timedate = $postData["timestamp"];
            if(!Validate::dateTime($timedate)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }
    
            $payload = $postData["payload"];
            if(!Validate::json($payload)) {
                Response::failedMessage("Invalid payload JSON string.");
                return;
            }
    
            array_push($args, $tracker, $anon_id, $user_id, $event, "\"".$timedate."\"", base64_encode($payload));
            break;
    
        case "track_create_live_timestamp":
            $backend = "data_analytics";
            array_push($args, "track_create_live_timestamp", $apiKey);

            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["anon_id"]) || empty($postData["anon_id"]) ||
                !isset($postData["user_id"]) || empty($postData["user_id"]) ||
                !isset($postData["event"]) || empty($postData["event"]) ||
                !isset($postData["payload"]) || empty($postData["payload"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
        
            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
        
            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
    
            $event = $postData["event"];
            if(!Validate::username($event)) {
                Response::failedMessage("Invalid event name.");
                return;
            }
    
            $payload = $postData["payload"];
            if(!Validate::json($payload)) {
                Response::failedMessage("Invalid payload JSON string.");
                return;
            }
        
            array_push($args, $tracker, $anon_id, $user_id, $event, base64_encode($payload));
            break;
    
        case "track_delete_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "track_delete_by_anon_id", $apiKey);
    
            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["anon_id"]) || empty($postData["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
    
            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
    
            array_push($args, $tracker, $anon_id);
            break;
    
        case "track_delete_by_user_id":
            $backend = "data_analytics";
            array_push($args, "track_delete_by_user_id", $apiKey);
    
            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["user_id"]) || empty($postData["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
    
            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
        
            array_push($args, $tracker, $user_id);
            break;
    
        case "track_delete_by_event":
            $backend = "data_analytics";
            array_push($args, "track_delete_by_event", $apiKey);
    
            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["event"]) || empty($postData["event"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
    
            $event = $postData["event"];
            if(!Validate::username($event)) {
                Response::failedMessage("Invalid event name.");
                return;
            }
        
            array_push($args, $tracker, $event);
            break;
    
        case "track_delete_by_timestamp":
            $backend = "data_analytics";
            array_push($args, "track_delete_by_timestamp", $apiKey);
        
            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["timestamp"]) || empty($postData["timestamp"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
       
            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
        
            $timestamp = $postData["timestamp"];
            if(!Validate::timestamp($timestamp)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }
            
            array_push($args, $tracker, "\"".$timestamp."\"");
            break;
        
        case "track_get_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "track_get_by_anon_id", $apiKey);
    
            if(!isset($postData["anon_id"]) || empty($postData["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
        
            array_push($args, $anon_id);
            break;
    
        case "track_get_by_user_id":
            $backend = "data_analytics";
            array_push($args, "track_get_by_user_id", $apiKey);
    
            if(!isset($postData["user_id"]) || empty($postData["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
    
            array_push($args, $user_id);
            break;
    
        case "track_get_by_event":
            $backend = "data_analytics";
            array_push($args, "track_get_by_event", $apiKey);
    
            if(!isset($postData["event"]) || empty($postData["event"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $event = $postData["event"];
            if(!Validate::username($event)) {
                Response::failedMessage("Invalid event name.");
                return;
            }
    
            array_push($args, $event);
            break;
    
        case "track_get_by_timestamp":
            $backend = "data_analytics";
            array_push($args, "track_get_by_timestamp", $apiKey);
    
            if(!isset($postData["timestamp"]) || empty($postData["timestamp"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $timestamp = $postData["timestamp"];
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
    
            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["anon_id"]) || empty($postData["anon_id"]) ||
                !isset($postData["user_id"]) || empty($postData["user_id"]) ||
                !isset($postData["name"]) || empty($postData["name"]) ||
                !isset($postData["category"]) || empty($postData["category"]) ||
                !isset($postData["timestamp"]) || empty($postData["timestamp"]) ||
                !isset($postData["payload"]) || empty($postData["payload"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
        
            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
        
            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
        
            $name = $postData["name"];
            if(!Validate::username($name)) {
                Response::failedMessage("Invalid page name.");
                return;
            }
    
            $category = $postData["category"];
            if(!Validate::username($category)) {
                Response::failedMessage("Invalid page category.");
                return;
            }
    
            $timedate = $postData["timestamp"];
            if(!Validate::dateTime($timedate)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }
        
            $payload = $postData["payload"];
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

            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["anon_id"]) || empty($postData["anon_id"]) ||
                !isset($postData["user_id"]) || empty($postData["user_id"]) ||
                !isset($postData["name"]) || empty($postData["name"]) ||
                !isset($postData["category"]) || empty($postData["category"]) ||
                !isset($postData["payload"]) || empty($postData["payload"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
            
            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
            
            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
        
            $name = $postData["name"];
            if(!Validate::username($name)) {
                Response::failedMessage("Invalid page name.");
                return;
            }
        
            $category = $postData["category"];
            if(!Validate::username($category)) {
                Response::failedMessage("Invalid page category.");
                return;
            }
    
            $payload = $postData["payload"];
            if(!Validate::json($payload)) {
                Response::failedMessage("Invalid payload JSON string.");
                return;
            }
            
            array_push($args, $tracker, $anon_id, $user_id, $name, $category, base64_encode($payload));
            break;
        
        case "page_delete_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "page_delete_by_anon_id", $apiKey);
        
            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["anon_id"]) || empty($postData["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
        
            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
        
            array_push($args, $tracker, $anon_id);
            break;
        
        case "page_delete_by_user_id":
            $backend = "data_analytics";
            array_push($args, "page_delete_by_user_id", $apiKey);

            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["user_id"]) || empty($postData["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }

            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
            
            array_push($args, $tracker, $user_id);
            break;
        
        case "page_delete_by_name":
            $backend = "data_analytics";
            array_push($args, "page_delete_by_name", $apiKey);
        
            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["name"]) || empty($postData["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
        
            $name = $postData["name"];
            if(!Validate::username($name)) {
                Response::failedMessage("Invalid page name.");
                return;
            }
            
            array_push($args, $tracker, $name);
            break;
    
        case "page_delete_by_category":
            $backend = "data_analytics";
            array_push($args, "page_delete_by_category", $apiKey);
        
            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["category"]) || empty($postData["category"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
        
            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
        
            $category = $postData["category"];
            if(!Validate::username($category)) {
                Response::failedMessage("Invalid page category.");
                return;
            }
            
            array_push($args, $tracker, $category);
            break;
    
        case "page_delete_by_timestamp":
            $backend = "data_analytics";
            array_push($args, "page_delete_by_timestamp", $apiKey);

            if(!isset($postData["tracker"]) || empty($postData["tracker"]) ||
                !isset($postData["timestamp"]) || empty($postData["timestamp"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
           
            $tracker = $postData["tracker"];
            if(!Validate::tracker($tracker)) {
                Response::failedMessage("Invalid tracking ID.");
                return;
            }
            
            $timestamp = $postData["timestamp"];
            if(!Validate::timestamp($timestamp)) {
                Response::failedMessage("Invalid timestamp format.");
                return;
            }
                
            array_push($args, $tracker, "\"".$timestamp."\"");
            break;
            
        case "page_get_by_anon_id":
            $backend = "data_analytics";
            array_push($args, "page_get_by_anon_id", $apiKey);

            if(!isset($postData["anon_id"]) || empty($postData["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }
            
            array_push($args, $anon_id);
            break;
        
        case "page_get_by_user_id":
            $backend = "data_analytics";
            array_push($args, "page_get_by_user_id", $apiKey);
        
            if(!isset($postData["user_id"]) || empty($postData["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
            
            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }
        
            array_push($args, $user_id);
            break;
        
        case "page_get_by_name":
            $backend = "data_analytics";
            array_push($args, "page_get_by_name", $apiKey);
        
            if(!isset($postData["name"]) || empty($postData["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
            
            $name = $postData["name"];
            if(!Validate::username($name)) {
                Response::failedMessage("Invalid page name.");
                return;
            }
        
            array_push($args, $name);
            break;
        
        case "page_get_by_category":
            $backend = "data_analytics";
            array_push($args, "page_get_by_category", $apiKey);
        
            if(!isset($postData["category"]) || empty($postData["category"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
            
            $category = $postData["category"];
            if(!Validate::username($category)) {
                Response::failedMessage("Invalid page category.");
                return;
            }
        
            array_push($args, $category);
            break;
    
        case "page_get_by_timestamp":
            $backend = "data_analytics";
            array_push($args, "page_get_by_timestamp", $apiKey);
        
            if(!isset($postData["timestamp"]) || empty($postData["timestamp"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $timestamp = $postData["timestamp"];
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

            if(!isset($postData["anon_id"]) || empty($postData["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }

            array_push($args, $anon_id);
            break;

        case "alias_user_has":
            $backend = "data_analytics";
            array_push($args, "alias_user_has", $apiKey);

            if(!isset($postData["user_id"]) || empty($postData["user_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }

            array_push($args, $user_id);
            break;

        case "alias_for_anon":
            $backend = "data_analytics";
            array_push($args, "alias_for_anon", $apiKey);

            if(!isset($postData["user_id"]) || empty($postData["user_id"]) ||
                !isset($postData["anon_id"]) || empty($postData["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $anon_id = $postData["anon_id"];
            if(!Validate::tracker($anon_id)) {
                Response::failedMessage("Invalid anonymous ID.");
                return;
            }

            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }

            array_push($args, $anon_id, $user_id);
            break;
    
        case "alias_for_user":
            $backend = "data_analytics";
            array_push($args, "alias_for_user", $apiKey);

            if(!isset($postData["user_id"]) || empty($postData["user_id"]) ||
                !isset($postData["anon_id"]) || empty($postData["anon_id"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $user_id = $postData["user_id"];
            if(!Validate::username($user_id)) {
                Response::failedMessage("Invalid user ID.");
                return;
            }

            $anon_id = $postData["anon_id"];
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

            if(!isset($postData["name"]) || empty($postData["name"]) ||
                !isset($postData["mode"]) || empty($postData["mode"]) ||
                !isset($postData["content"]) || empty($postData["content"])) {
                    Response::failedMessage("Insufficient parameter arity.");
                    return;
            }

            $name = $postData["name"];
            if(!Validate::name($name)) {
                Response::failedMessage("Invalid database name.");
                return;
            }

            $mode = $postData["mode"];
            if(!Validate::dbMode($mode)) {
                Response::failedMessage("Invalid database mode.");
                return;
            }

            $content = $postData["content"];
            if(!Validate::dbContent($content)) {
                Response::failedMessage("Invalid database content.");
                return;
            }

            array_push($args, $name, $mode, $content);
            break;

        case "db_get_by_name":
            $backend = "database";
            array_push($args, "get_by_name", $apiKey);

            if(!isset($postData["name"]) || empty($postData["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $name = $postData["name"];
            if(!Validate::name($name)) {
                Response::failedMessage("Invalid database name.");
                return;
            }

            array_push($args, $name);
            break;

        case "db_set_mode":
            $backend = "database";
            array_push($args, "set_db_mode", $apiKey);

            if(!isset($postData["name"]) || empty($postData["name"]) ||
                !isset($postData["mode"]) || empty($postData["mode"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $name = $postData["name"];
            if(!Validate::name($name)) {
                Response::failedMessage("Invalid database name.");
                return;
            }

            $mode = $postData["mode"];
            if(!Validate::dbMode($mode)) {
                Response::failedMessage("Invalid database mode.");
                return;
            }

            array_push($args, $name, $mode);
            break;

        case "db_get_mode":
            $backend = "database";
            array_push($args, "get_db_mode", $apiKey);
    
            if(!isset($postData["name"]) || empty($postData["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $name = $postData["name"];
            if(!Validate::name($name)) {
                Response::failedMessage("Invalid database name.");
                return;
            }

            array_push($args, $name);
            break;

        case "db_read":
            $backend = "database";
            array_push($args, "read_db", $apiKey);
        
            if(!isset($postData["name"]) || empty($postData["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $name = $postData["name"];
            if(!Validate::name($name)) {
                Response::failedMessage("Invalid database name.");
                return;
            }
    
            array_push($args, $name);
            break;

        case "db_write":
            $backend = "database";
            array_push($args, "write_db", $apiKey);

            if(!isset($postData["name"]) || empty($postData["name"]) ||
                !isset($postData["content"]) || empty($postData["content"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $name = $postData["name"];
            if(!Validate::name($name)) {
                Response::failedMessage("Invalid database name.");
                return;
            }
    
            $content = $postData["content"];
            if(!Validate::dbContent($content)) {
                Response::failedMessage("Invalid database mode.");
                return;
            }

            array_push($args, $name, $content);
            break;

        case "db_delete":
            $backend = "database";
            array_push($args, "delete_db", $apiKey);
        
            if(!isset($postData["name"]) || empty($postData["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $name = $postData["name"];
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

            if(!isset($postData["name"]) || empty($postData["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $name = $postData["name"];
            if(!Validate::base64($name)) {
                Response::failedMessage("Invalid file name.");
                return;
            }

            array_push($args, $name);
            break;

        case "file_get":
            $backend = "storage";
            array_push($args, "get", $apiKey);
    
            if(!isset($postData["name"]) || empty($postData["name"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }
    
            $name = $postData["name"];
            if(!Validate::base64($name)) {
                Response::failedMessage("Invalid file name.");
                return;
            }
    
            array_push($args, $name);
            break;
    
        case "file_download":
            $backend = "storage";
            array_push($args, "download", $apiKey);
        
            if(!isset($postData["name"]) || empty($postData["name"]) ||
                !isset($postData["should_expire"]) || Validate::isEmpty($postData["should_expire"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $name = $postData["name"];
            if(!Validate::base64($name)) {
                Response::failedMessage("Invalid file name.");
                return;
            }

            $shouldExpire = $postData["should_expire"];
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

        case "cdp_expire_all":
            Util::logTraffic($apiKey, $appId);
            Shell::log($apiKey, Shell::detectSender());
            ContentDeliveryPage::expireAll($apiKey);
            return;
            

        case "cdp_expire_ticket":
            if(!isset($postData["ticket"]) || empty($postData["ticket"])) {
                Response::failedMessage("Insufficient parameter arity.");
                return;
            }

            $ticket = $postData["ticket"];
            if(!Validate::uuid($ticket)) {
                Response::failedMessage("Invalid ticket UUIDv4 string.");
                return;
            }

            Util::logTraffic($apiKey, $appId);
            Shell::log($apiKey, Shell::detectSender());
            ContentDeliveryPage::expire($apiKey, $ticket);
            return;

        default:
            Response::failed();
            return;
    }

    Shell::execute($apiKey, $appId, $backend, $args);
    return;
}

Response::failed();

?>