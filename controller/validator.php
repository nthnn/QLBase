<?php

function validateUsername($username) {
    return preg_match('/^[a-zA-Z0-9_]+$/', $username);
}

function validateName($name) {
    $nameLength = strlen($name);
    if(!preg_match('/^[A-Za-z\s\'-]+$/', $name) ||
        ($nameLength < 2 || $nameLength > 100))
        return false;

    return true;
}

function validateLoginPassword($password) {
    return strlen($password) === 32 && preg_match('/^[a-f0-9]+$/', $password);
}

function validateEmail($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        return false;

    list($username, $domain) = explode('@', $email);
    if(empty($domain) || strpos($domain, '.') === false)
        return false;

    return checkdnsrr($domain, 'MX');
}

?>