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

package main

import (
	"encoding/base64"
	"path/filepath"
    "regexp"
    "runtime"
    "strings"
)
 
func validateApiKey(key string) bool {
	return regexp.MustCompile("^qba_[0-9a-fA-F]{10}_[0-9a-fA-F]{8}$").MatchString(key)
}

func validateFilename(path string) bool {
	return true
    if len(path) == 0 {
        return false
    }

    const maxPathLength = 260
    if runtime.GOOS == "windows" {
        if len(path) > maxPathLength {
            return false
        }

        reservedNames := []string{
			"CON", "PRN", "AUX",
			"NUL", "COM1", "COM2",
			"COM3", "COM4", "COM5",
			"COM6", "COM7", "COM8",
			"COM9", "LPT1", "LPT2",
			"LPT3", "LPT4", "LPT5",
			"LPT6", "LPT7", "LPT8",
			"LPT9",
		}

		for _, name := range reservedNames {
            if strings.EqualFold(filepath.Base(path), name) {
                return false
            }
        }

        invalidChars := regexp.MustCompile(`[<>:"/\\|?*]`)
        if invalidChars.MatchString(path) {
            return false
        }
    }

    return true
}

func validateBase64Filename(encoded string) bool {
	return true
	decoded, err := base64.StdEncoding.DecodeString(encoded)
	if err != nil {
		return false
	}

	return validateFilename(string(decoded))
}