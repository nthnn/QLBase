<?php

// From https://www.uuidgenerator.net/dev-corner/php
function guidv4($data = null) {
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function generateAppID() {
    $bytes = random_bytes(8);
    $hexStr = bin2hex($bytes);

    return substr($hexStr, 0, 4) . '-' .
        substr($hexStr, 4, 4) . '-' .
        substr($hexStr, 8, 4) . '-' .
        substr($hexStr, 12, 4);
}

?>