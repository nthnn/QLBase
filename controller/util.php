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

include_once("db_config.php");
include_once("response.php");

class Util {
    public static function guidv4($data) {
        $data = $data ?? random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function generateAppID() {
        $bytes = random_bytes(8);
        $hexStr = bin2hex($bytes);

        return substr($hexStr, 0, 4) . '-' .
            substr($hexStr, 4, 4) . '-' .
            substr($hexStr, 8, 4) . '-' .
            substr($hexStr, 12, 4);
    }

    public static function logTraffic($apiKey, $appId) {
        global $db_conn;
        $dt = date("dmy");
    
        $result = mysqli_query($db_conn, "SELECT * FROM traffic WHERE date_time=\"".$dt.
            "\" AND api_key=\"".$apiKey."\" AND app_id=\"".$appId."\"");
        
        if($result) {
            if(mysqli_num_rows($result) > 0)
                mysqli_query($db_conn, "UPDATE traffic SET count = count + 1 WHERE date_time=\"".
                    $dt."\" AND api_key=\"".$apiKey."\" AND app_id=\"".$appId."\"");
            else mysqli_query($db_conn, "INSERT INTO traffic (date_time, api_key, app_id) VALUES(\"".$dt.
                "\", \"".$apiKey."\", \"".$appId."\")");
    
            return;
        }
    
        Response::failed();
        exit(0);
    }
}

?>