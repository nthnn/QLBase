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
	"fmt"
	"os"
	"strings"

	"github.com/nthnn/QLBase/traffic/proc"
)

func failOnUmatchedArgSize(size int, args []string) {
	if len(args) != size {
		proc.ShowFailedResponse("Invalid parameter arity.")
		os.Exit(-1)
	}
}

func main() {
	if len(os.Args) != 3 {
		proc.ShowFailedResponse("Invalid argument arity.")
		os.Exit(0)
	}

	apiKey := os.Args[1]
	appId := os.Args[2]

	DispatchWithCallback(func(db *sql.DB) {
		query, err := db.Query("SELECT count FROM traffic WHERE api_key=\"" + apiKey +
			"\" AND app_id=\"" + appId + "\" ORDER BY STR_TO_DATE(\"date_time\", \"%d%m%Y\") ASC LIMIT 30")

		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		last30DayTraffic := make([]int, 30)
		for query.Next() {
			count := 0
			query.Scan(&count)

			last30DayTraffic = append(last30DayTraffic, count)
		}

		fmt.Println(
			"{\"result\": \"1\", \"traffic\": [" +
				strings.Trim(strings.Join(strings.Fields(fmt.Sprint(last30DayTraffic[len(last30DayTraffic)-30:])), ", "), "[]") +
				"]}")
	})
}
