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

class TorDetection {
    static function updateExitNodeList() {
        $exitNodesData = @file_get_contents("https://check.torproject.org/exit-addresses");
        if($exitNodesData === false)
            return false;

        $cachedFile = realpath(__DIR__."/../bin")."/tor-exit-nodes";
        $result = file_put_contents($cachedFile, $exitNodesData);
        if($result === false)
            return false;

        return true;
    }

    static function isExitNode() {
        $ip = $_SERVER["REMOTE_ADDR"];
        $cachedFile = realpath(__DIR__."/../bin")."/tor-exit-nodes";

        if(!file_exists($cachedFile)) {
            if(TorDetection::updateExitNodeList())
                return TorDetection::isExitNode();

            return false;
        }
        else if(time() - filemtime($cachedFile) > 1200) {
            unlink($cachedFile);
            TorDetection::updateExitNodeList();
        }

        $fileHandle = fopen($cachedFile, "r");
        if(!$fileHandle)
            return false;

        while(($line = fgets($fileHandle)) !== false) {
            if(strpos($line, "ExitAddress") === 0) {
                $parts = explode(" ", $line);

                if(isset($parts[1]) && trim($parts[1]) === $ip) {
                    fclose($fileHandle);
                    return true;
                }
            }
        }

        fclose($fileHandle);
        return false;
    }
}

?>