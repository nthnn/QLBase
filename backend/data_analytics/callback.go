package main

import (
	"data_analytics/proc"
	"database/sql"
)

func createIdCallback(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	anonymous_id := args[3]
	user_id := args[4]
	timestamp := args[5]
	payload := args[6]

	return func(d *sql.DB) {
		query, err := d.Query("INSERT INTO " + apiKey +
			"_data_analytics_id (tracker, anonymous_id, user_id, timedate, payload) VALUES(\"" +
			tracker + "\", \"" + anonymous_id + "\", \"" + user_id + "\", \"" + timestamp +
			"\", \"" + payload + "\")")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func createIdWithoutTimestampCallback(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	anonymous_id := args[3]
	user_id := args[4]
	payload := args[5]

	return func(d *sql.DB) {
		query, err := d.Query("INSERT INTO " + apiKey +
			"_data_analytics_id (tracker, anonymous_id, user_id, payload) VALUES(\"" +
			tracker + "\", \"" + anonymous_id + "\", \"" + user_id + "\", \"" + payload + "\")")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}
