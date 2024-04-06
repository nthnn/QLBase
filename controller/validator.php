<?php

class Validate {
    public static function username($username) {
        return strlen($username) > 6 &&
            preg_match("/^[a-zA-Z0-9_]+$/", $username);
    }

    public static function name($name) {
        $nameLength = strlen($name);
        if(!preg_match("/^[A-Za-z\s\"-]+$/", $name) ||
            ($nameLength < 2 || $nameLength > 100))
            return false;

        return true;
    }

    public static function loginPassword($password) {
        return strlen($password) === 32 &&
            preg_match("/^[a-f0-9]+$/", $password);
    }

    public static function email($email) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            return false;

        list($username, $domain) = explode("@", $email);
        if(empty($domain) || strpos($domain, ".") === false)
            return false;

        return checkdnsrr($domain, "MX");
    }

    public static function appName($name) {
        return strlen($name) > 6 &&
            preg_match("/^[a-zA-Z0-9_]+$/", $name);
    }

    public static function phoneNumber($input) {
        return preg_match(
            "/^\+?\d+$/",
            str_replace(" ", "", $input)
        );
    }

    public static function verificationCode($code) {
        return preg_match("/^\d{6}$/", $code);
    }

    public static function tracker($tracker) {
        return $tracker == "null" || (strlen($tracker) >= 6 &&
            preg_match("/^[A-Za-z]+$/", $tracker));
    }

    public static function dateTime($datetime) {
        $timestamp = strtotime($datetime);

        if($timestamp !== false) {
            $input_formatted = date('Y-m-d H:i:s', $timestamp);

            if ($input_formatted === $datetime)
                return true;
        }

        return false;
    }

    public static function json($json) {
        json_decode($json);
        return json_last_error() === 0;
    }

    public static function timestamp($timestamp) {
        return preg_match("/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/", $timestamp);
    }

    public static function apiKey($key) {
        return preg_match("/^qba_[0-9a-fA-F]{10}_[0-9a-fA-F]{8}$/", $key);
    }

    public static function uuid($uuid) {
        return preg_match(
            "/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[1-5][0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/",
            $uuid
        ) === 1;
    }

    public static function dbMode($mode) {
        return preg_match("/^[wr]+$/", $mode);
    }

    public static function base64($content) {
        $decoded = base64_decode($content);
        if($decoded === false)
            return false;

        return true;
    }

    public static function dbContent($content) {
        $decoded = base64_decode($content);
        if($decoded === false)
            return false;

        return !(json_decode($decoded) === null &&
            json_last_error() !== JSON_ERROR_NONE);
    }
}

?>