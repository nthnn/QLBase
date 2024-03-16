package main

import (
	"database/sql"
	"encoding/json"
	"fmt"
	"os"
)

func dumpLogs() {
	DispatchWithCallback(func(db *sql.DB) {
		query, err := db.Query("SELECT origin, action, datetime, user_agent FROM " + os.Args[2] + "_logs")
		defer query.Close()

		if err != nil {
			os.Exit(0)
		}

		var logs [][]string
		for query.Next() {
			origin := ""
			action := ""
			dateTime := ""
			userAgent := ""

			query.Scan(&origin, &action, &dateTime, &userAgent)
			logs = append(logs, []string {origin, action, dateTime, userAgent})
		}

		jsonData, _ := json.Marshal(logs)
		fmt.Println(string(jsonData))
	})
}

func main() {
	if len(os.Args) == 3 {
		dumpLogs()
		os.Exit(0)
	}

	if len(os.Args) != 6 {
		os.Exit(0)
	}

	args := os.Args[1:]
	apiKey := args[0]
	origin := args[1]
	action := args[2]
	dateTime := args[3]
	userAgent := args[4]

	DispatchWithCallback(func(db *sql.DB) {
		query, _ := db.Query("INSERT INTO " + apiKey +
			"_logs (origin, action, datetime, user_agent) VALUES(\"" +
			origin + "\", \"" + action + "\", \"" + dateTime + "\", \"" +
			userAgent + "\")")
		query.Close()
	})
}