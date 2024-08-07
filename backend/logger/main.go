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
	"database/sql"
	"encoding/json"
	"fmt"
	"os"

	"github.com/nthnn/QLBase/logger/proc"
)

func dumpLogs() {
	DispatchWithCallback(func(db *sql.DB) {
		query, err := db.Query("SELECT origin, action, datetime, user_agent, sender FROM " + os.Args[2] + "_logs")

		if err != nil {
			os.Exit(0)
		}
		defer query.Close()

		var logs [][]string
		for query.Next() {
			origin := ""
			action := ""
			dateTime := ""
			userAgent := ""
			sender := ""

			query.Scan(&origin, &action, &dateTime, &userAgent, &sender)
			logs = append(logs, []string{origin, action, dateTime, userAgent, sender})
		}

		jsonData, _ := json.Marshal(logs)
		fmt.Println(string(jsonData))
	})
}

func main() {
	if !proc.IsParentProcessPHP() {
		os.Exit(0)
	}

	if len(os.Args) == 3 {
		dumpLogs()
		os.Exit(0)
	}

	if len(os.Args) != 7 {
		os.Exit(0)
	}

	args := os.Args[1:]
	apiKey := args[0]
	origin := args[1]
	action := args[2]
	dateTime := args[3]
	userAgent := args[4]
	sender := args[5]

	if !validateApiKey(apiKey) ||
		!validateTimestamp(dateTime) ||
		!validateSender(sender) {
		os.Exit(0)
	}

	DispatchWithCallback(func(db *sql.DB) {
		query, _ := db.Query("INSERT INTO " + apiKey +
			"_logs (origin, action, datetime, user_agent, sender) VALUES(\"" +
			origin + "\", \"" + action + "\", \"" + dateTime + "\", \"" +
			userAgent + "\", \"" + sender + "\")")
		query.Close()
	})
}
