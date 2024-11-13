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

class Validate {
    public static function isEmpty($str) {
        return $str === "" && strlen($str) == 0;
    }

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
        json_decode(base64_decode($json));
        return json_last_error() === 0;
    }

    public static function timestamp($timestamp) {
        return preg_match("/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/", $timestamp);
    }

    public static function apiKey($key) {
        return preg_match("/^qba_[0-9a-fA-F]{10}_[0-9a-fA-F]{8}$/", $key);
    }

    public static function apiId($id) {
        return preg_match("/^[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}$/", $id);
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

    public static function authSessionId($uuid) {
        $pattern = "/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i";
        return preg_match($pattern, $uuid) === 1;
    }
}

?>