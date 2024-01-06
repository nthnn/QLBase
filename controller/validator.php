<?php

function validateUsername($username) {
    return strlen($username) > 6 &&
        preg_match("/^[a-zA-Z0-9_]+$/", $username);
}

function validateName($name) {
    $nameLength = strlen($name);
    if(!preg_match("/^[A-Za-z\s\"-]+$/", $name) ||
        ($nameLength < 2 || $nameLength > 100))
        return false;

    return true;
}

function validateLoginPassword($password) {
    return strlen($password) === 32 &&
        preg_match("/^[a-f0-9]+$/", $password);
}

function validateEmail($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        return false;

    list($username, $domain) = explode("@", $email);
    if(empty($domain) || strpos($domain, ".") === false)
        return false;

    return checkdnsrr($domain, "MX");
}

function validateAppName($name) {
    return strlen($name) > 6 &&
        preg_match("/^[a-zA-Z0-9_]+$/", $name);
}

function validatePhoneNumber($input) {
    return preg_match(
        "/^\+?\d+$/",
        str_replace(" ", "", $input)
    );
}

function validateVerificationCode($code) {
    return preg_match("/^\d{6}$/", $code);
}

function validateTracker($tracker) {
    return $tracker == "null" || (strlen($tracker) >= 6 &&
        preg_match("/^[A-Za-z]+$/", $tracker));
}

function validateDateTime($datetime) {
    $timestamp = strtotime($datetime);

    if($timestamp !== false) {
        $input_formatted = date('Y-m-d H:i:s', $timestamp);

        if ($input_formatted === $datetime)
            return true;
    }

    return false;
}

function validateJson($json) {
    json_decode($json);
    return json_last_error() === 0;
}

function validateTimestamp($timestamp) {
    return preg_match("/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/", $timestamp);
}

function validateApiKey($key) {
    return preg_match("/^qba_[0-9a-fA-F]{10}_[0-9a-fA-F]{8}$/", $key);
}

function validateUuid($uuid) {
    return preg_match(
        "/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[1-5][0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/",
        $uuid
    ) === 1;
}

function validateDatabaseMode($mode) {
    return preg_match("/^[wr]+$/", $mode);
}

function validateBase64($content) {
    $decoded = base64_decode($content);
    if($decoded === false)
        return false;

    return true;
}

function validateDatabaseContent($content) {
    $decoded = base64_decode($content);
    if($decoded === false)
        return false;

    return !(json_decode($decoded) === null &&
        json_last_error() !== JSON_ERROR_NONE);
}

?>