<?php

class Response {
    public static function jsonContent() {
        header("Content-Type: application/json; charset=utf-8");
    }

    public static function failed() {
        Response::jsonContent();
        echo "{\"result\": \"0\"}";
    }
    
    public static function failedMessage($message) {
        Response::jsonContent();
        echo "{\"result\": \"0\", \"message\": \"".$message."\"}";
    }

    public static function success() {
        Response::jsonContent();
        echo "{\"result\": \"1\"}";
    }
}

?>