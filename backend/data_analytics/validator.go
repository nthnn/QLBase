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

import(
	"encoding/json"
	"regexp"
	"time"
)

func validateTracker(tracker string) bool {
	if tracker == "null" {
		return true
	}
	
	if len(tracker) >= 6 {
		valid, _ := regexp.MatchString("^[A-Za-z]+$", tracker)
		return valid
	}

	return false
}

func validateUsername(username string) bool {
	if len(username) <= 6 {
		return false
	}

	valid, _ := regexp.MatchString("^[a-zA-Z0-9_]+$", username)
	return valid
}

func validateTimestamp(datetime string) bool {
	layout := "2006-01-02 15:04:05"
	parsedTime, err := time.Parse(layout, datetime)

	if err != nil {
		return false
	}

	inputFormatted := parsedTime.Format(layout)
	return inputFormatted == datetime
}

func validatePayload(jsonString string) bool {
	var js interface{}
	return json.Unmarshal([]byte(jsonString), &js) == nil
}