package main

import (
	"database/sql"
	"os"
)

func main() {
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