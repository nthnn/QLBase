package main

import (
	"database/sql"
	"os"
)

func main() {
	if len(os.Args) != 5 {
		os.Exit(0)
	}

	args := os.Args[1:]
	apiKey := args[1]
	origin := args[2]
	action := args[3]
	dateTime := args[4]
	userAgent := args[5]

	DispatchWithCallback(func(db *sql.DB) {
		query, _ := db.Query("INSERT INTO qba_" + apiKey +
			"_logs (origin, action, datetime, user_agent) VALUES(\"" +
			origin + "\", \"" + action + "\", \"" + dateTime + "\", \"" +
			userAgent + "\")")
		query.Close()
	})
}