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

func deleteIdByAnonId(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	anonId := args[3]

	return func(d *sql.DB) {
		query, err := d.Query("DELETE FROM " + apiKey +
			"_data_analytics_id WHERE tracker=\"" +
			tracker + "\" AND anonymous_id=\"" +
			anonId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func deleteIdByUserId(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	anonId := args[3]

	return func(d *sql.DB) {
		query, err := d.Query("DELETE FROM " + apiKey +
			"_data_analytics_id WHERE tracker=\"" +
			tracker + "\" AND user_id=\"" +
			anonId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func getIdByAnonId(apiKey string, args []string) func(*sql.DB) {
	anonId := args[2]

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, user_id, timedate, payload FROM " +
			apiKey + "_data_analytics_id WHERE anonymous_id=\"" +
			anonId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var results [][]string
		for query.Next() {
			var tracker, user_id, timedate, payload string
			query.Scan(&tracker, &user_id, &timedate, &payload)

			results = append(results, []string{tracker, user_id, timedate, payload})
		}

		if len(results) == 0 {
			proc.ShowResult("[]")
			return
		}

		result := "["
		for i := 0; i < len(results); i++ {
			result += "[\"" + results[i][0] +
				"\", \"" + results[i][1] +
				"\", \"" + results[i][2] +
				"\", \"" + results[i][3] +
				"\"], "
		}
		result = result[0 : len(result)-2]

		proc.ShowResult(result)
	}
}

func getIdByUserId(apiKey string, args []string) func(*sql.DB) {
	userId := args[2]

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, anonymous_id, timedate, payload FROM " +
			apiKey + "_data_analytics_id WHERE user_id=\"" +
			userId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var results [][]string
		for query.Next() {
			var tracker, anon_id, timedate, payload string
			query.Scan(&tracker, &anon_id, &timedate, &payload)

			results = append(results, []string{tracker, anon_id, timedate, payload})
		}

		if len(results) == 0 {
			proc.ShowResult("[]")
			return
		}

		result := "["
		for i := 0; i < len(results); i++ {
			result += "[\"" + results[i][0] +
				"\", \"" + results[i][1] +
				"\", \"" + results[i][2] +
				"\", \"" + results[i][3] +
				"\"], "
		}
		result = result[0 : len(result)-2]

		proc.ShowResult(result)
	}
}

func getIdByTimestamp(apiKey string, args []string) func(*sql.DB) {
	timestamp := args[2]

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, anonymous_id, user_id, payload FROM " +
			apiKey + "_data_analytics_id WHERE timedate=\"%" +
			timestamp + "%\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var results [][]string
		for query.Next() {
			var tracker, anon_id, user_id, payload string
			query.Scan(&tracker, &anon_id, &user_id, &payload)

			results = append(results, []string{tracker, anon_id, user_id, payload})
		}

		if len(results) == 0 {
			proc.ShowResult("[]")
			return
		}

		result := "["
		for i := 0; i < len(results); i++ {
			result += "[\"" + results[i][0] +
				"\", \"" + results[i][1] +
				"\", \"" + results[i][2] +
				"\", \"" + results[i][3] +
				"\"], "
		}
		result = result[0 : len(result)-2]

		proc.ShowResult(result)
	}
}

func fetchAllId(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, anonymous_id, user_id, timestamp, payload FROM " +
			apiKey + "_data_analytics_id")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var results [][]string
		for query.Next() {
			var tracker, anon_id, user_id, timestamp, payload string
			query.Scan(&tracker, &anon_id, &user_id, &timestamp, &payload)

			results = append(results, []string{tracker, anon_id, user_id, timestamp, payload})
		}

		if len(results) == 0 {
			proc.ShowResult("[]")
			return
		}

		result := "["
		for i := 0; i < len(results); i++ {
			result += "[\"" + results[i][0] +
				"\", \"" + results[i][1] +
				"\", \"" + results[i][2] +
				"\", \"" + results[i][3] +
				"\", \"" + results[i][4] +
				"\"], "
		}
		result = result[0 : len(result)-2]

		proc.ShowResult(result)
	}
}
