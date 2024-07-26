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
	"os"

	"github.com/nthnn/QLBase/data_analytics/proc"
)

func createIdCallback(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	anonId := args[3]
	userId := args[4]
	timestamp := args[5]
	payload := args[6]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	if !validateTimestamp(timestamp) {
		proc.ShowFailedResponse("Invalid timestamp string.")
		os.Exit(0)
	}

	if !validatePayload(payload) {
		proc.ShowFailedResponse("Invalid payload string content.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("INSERT INTO " + apiKey +
			"_data_analytics_id (tracker, anonymous_id, user_id, timedate, payload) VALUES(\"" +
			tracker + "\", \"" + anonId + "\", \"" + userId + "\", \"" + timestamp +
			"\", \"" + payload + "\")")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func createIdLiveTimestampCallback(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	anonId := args[3]
	userId := args[4]
	payload := args[5]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	if !validatePayload(payload) {
		proc.ShowFailedResponse("Invalid payload string content.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("INSERT INTO " + apiKey +
			"_data_analytics_id (tracker, anonymous_id, user_id, payload) VALUES(\"" +
			tracker + "\", \"" + anonId + "\", \"" + userId + "\", \"" + payload + "\")")

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

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

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

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

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

func deleteIdByTimestamp(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	timestamp := args[3]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTimestamp(timestamp) {
		proc.ShowFailedResponse("Invalid timestamp string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("DELETE FROM " + apiKey +
			"_data_analytics_id WHERE tracker=\"" +
			tracker + "\" AND timedate=STR_TO_DATE(\"" +
			timestamp + "\", \"%Y-%m-%d %H:%i:%s\")")

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
	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, user_id, timedate, CONVERT(payload USING utf8) FROM " +
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
				"\", " + decodeBase64(results[i][3]) +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
	}
}

func getIdByUserId(apiKey string, args []string) func(*sql.DB) {
	userId := args[2]
	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, anonymous_id, timedate, CONVERT(payload USING utf8) FROM " +
			apiKey + "_data_analytics_id WHERE user_id=\"" +
			userId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		var results [][]string
		for query.Next() {
			var tracker, anon_id, timedate, payload string
			query.Scan(&tracker, &anon_id, &timedate, &payload)

			results = append(results, []string{tracker, anon_id, timedate, payload})
		}

		if len(results) == 0 {
			proc.ShowResult("[]")
			query.Close()
			return
		}

		result := "["
		for i := 0; i < len(results); i++ {
			result += "[\"" + results[i][0] +
				"\", \"" + results[i][1] +
				"\", \"" + results[i][2] +
				"\", " + decodeBase64(results[i][3]) +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
		query.Close()
	}
}

func getIdByTimestamp(apiKey string, args []string) func(*sql.DB) {
	timestamp := args[2]
	if !validateTimestamp(timestamp) {
		proc.ShowFailedResponse("Invalid timestamp string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, anonymous_id, user_id, CONVERT(payload USING utf8) FROM " +
			apiKey + "_data_analytics_id WHERE timedate=\"" +
			timestamp + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		var results [][]string
		for query.Next() {
			var tracker, anon_id, user_id, payload string
			query.Scan(&tracker, &anon_id, &user_id, &payload)

			results = append(results, []string{tracker, anon_id, user_id, payload})
		}

		if len(results) == 0 {
			proc.ShowResult("[]")
			query.Close()
			return
		}

		result := "["
		for i := 0; i < len(results); i++ {
			result += "[\"" + results[i][0] +
				"\", \"" + results[i][1] +
				"\", \"" + results[i][2] +
				"\", " + decodeBase64(results[i][3]) +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
		query.Close()
	}
}

func fetchAllId(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, anonymous_id, user_id, timedate, CONVERT(payload USING utf8) FROM " +
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
			payload := decodeBase64(results[i][4])
			if payload == "" {
				payload = "{}"
			}

			result += "[\"" + results[i][0] +
				"\", \"" + results[i][1] +
				"\", \"" + results[i][2] +
				"\", \"" + results[i][3] +
				"\", " + payload +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
	}
}

func createTrackCallback(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	anonId := args[3]
	userId := args[4]
	event := args[5]
	timestamp := args[6]
	payload := args[7]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	if !validateTimestamp(timestamp) {
		proc.ShowFailedResponse("Invalid timestamp string.")
		os.Exit(0)
	}

	if !validatePayload(payload) {
		proc.ShowFailedResponse("Invalid payload string content.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("INSERT INTO " + apiKey +
			"_data_analytics_track (tracker, anonymous_id, user_id, event, timedate, payload) VALUES(\"" +
			tracker + "\", \"" + anonId + "\", \"" + userId + "\", \"" + event +
			"\", \"" + timestamp + "\", \"" + payload + "\")")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func createTrackLiveTimestampCallback(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	anonId := args[3]
	userId := args[4]
	event := args[5]
	payload := args[6]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	if !validatePayload(payload) {
		proc.ShowFailedResponse("Invalid payload string content.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("INSERT INTO " + apiKey +
			"_data_analytics_track (tracker, anonymous_id, user_id, event, payload) VALUES(\"" +
			tracker + "\", \"" + anonId + "\", \"" +
			userId + "\", \"" + event + "\", \"" +
			payload + "\")")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func deleteTrackByAnonId(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	anonId := args[3]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("DELETE FROM " + apiKey +
			"_data_analytics_track WHERE tracker=\"" +
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

func deleteTrackByUserId(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	userId := args[3]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("DELETE FROM " + apiKey +
			"_data_analytics_track WHERE tracker=\"" +
			tracker + "\" AND user_id=\"" +
			userId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func deleteTrackByEvent(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	event := args[3]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateUsername(event) {
		proc.ShowFailedResponse("Invalid event name string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("DELETE FROM " + apiKey +
			"_data_analytics_track WHERE tracker=\"" +
			tracker + "\" AND event=\"" +
			event + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func deleteTrackByTimestamp(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	timestamp := args[3]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTimestamp(timestamp) {
		proc.ShowFailedResponse("Invalid timestamp string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("DELETE FROM " + apiKey +
			"_data_analytics_track WHERE tracker=\"" +
			tracker + "\" AND timedate=STR_TO_DATE(\"" +
			timestamp + "\", \"%Y-%m-%d %H:%i:%s\")")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func getTrackByAnonId(apiKey string, args []string) func(*sql.DB) {
	anonId := args[2]
	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, user_id, event, timedate, CONVERT(payload USING utf8) FROM " +
			apiKey + "_data_analytics_track WHERE anonymous_id=\"" +
			anonId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var results [][]string
		for query.Next() {
			var tracker, user_id, event, timedate, payload string
			query.Scan(&tracker, &user_id, &event, &timedate, &payload)

			results = append(results, []string{tracker, user_id, event, timedate, payload})
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
				"\", " + decodeBase64(results[i][4]) +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
	}
}

func getTrackByUserId(apiKey string, args []string) func(*sql.DB) {
	userId := args[2]
	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, anonymous_id, event, timedate, CONVERT(payload USING utf8) FROM " +
			apiKey + "_data_analytics_track WHERE user_id=\"" +
			userId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var results [][]string
		for query.Next() {
			var tracker, anon_id, event, timedate, payload string
			query.Scan(&tracker, &anon_id, &event, &timedate, &payload)

			results = append(results, []string{tracker, anon_id, event, timedate, payload})
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
				"\", " + decodeBase64(results[i][4]) +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
	}
}

func getTrackByEvent(apiKey string, args []string) func(*sql.DB) {
	event := args[2]
	if !validateUsername(event) {
		proc.ShowFailedResponse("Invalid event name string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, user_id, anonymous_id, timedate, CONVERT(payload USING utf8) FROM " +
			apiKey + "_data_analytics_track WHERE event=\"" +
			event + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var results [][]string
		for query.Next() {
			var tracker, user_id, anon_id, timedate, payload string
			query.Scan(&tracker, &user_id, &anon_id, &timedate, &payload)

			results = append(results, []string{tracker, user_id, anon_id, timedate, payload})
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
				"\", " + decodeBase64(results[i][4]) +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
	}
}

func getTrackByTimestamp(apiKey string, args []string) func(*sql.DB) {
	timestamp := args[2]
	if !validateTimestamp(timestamp) {
		proc.ShowFailedResponse("Invalid timestamp string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, anonymous_id, user_id, event, CONVERT(payload USING utf8) FROM " +
			apiKey + "_data_analytics_track WHERE timedate=\"" +
			timestamp + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		var results [][]string
		for query.Next() {
			var tracker, anon_id, user_id, event, payload string
			query.Scan(&tracker, &anon_id, &user_id, &event, &payload)

			results = append(results, []string{tracker, anon_id, user_id, event, payload})
		}

		if len(results) == 0 {
			proc.ShowResult("[]")
			query.Close()
			return
		}

		result := "["
		for i := 0; i < len(results); i++ {
			result += "[\"" + results[i][0] +
				"\", \"" + results[i][1] +
				"\", \"" + results[i][2] +
				"\", \"" + results[i][3] +
				"\", " + decodeBase64(results[i][4]) +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
		query.Close()
	}
}

func fetchAllTrack(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, anonymous_id, user_id, event, timedate, CONVERT(payload USING utf8) FROM " +
			apiKey + "_data_analytics_track")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var results [][]string
		for query.Next() {
			var tracker, anon_id, user_id, event, timestamp, payload string
			query.Scan(&tracker, &anon_id, &user_id, &event, &timestamp, &payload)

			results = append(results, []string{tracker, anon_id, user_id, event, timestamp, payload})
		}

		if len(results) == 0 {
			proc.ShowResult("[]")
			return
		}

		result := "["
		for i := 0; i < len(results); i++ {
			payload := decodeBase64(results[i][5])
			if payload == "" {
				payload = "{}"
			}

			result += "[\"" + results[i][0] +
				"\", \"" + results[i][1] +
				"\", \"" + results[i][2] +
				"\", \"" + results[i][3] +
				"\", \"" + results[i][4] +
				"\", " + payload +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
	}
}

func createPageCallback(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	anonId := args[3]
	userId := args[4]
	name := args[5]
	category := args[6]
	timestamp := args[7]
	payload := args[8]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	if !validateUsername(name) {
		proc.ShowFailedResponse("Invalid page name string.")
		os.Exit(0)
	}

	if !validateUsername(category) {
		proc.ShowFailedResponse("Invalid page category string.")
		os.Exit(0)
	}

	if !validateTimestamp(timestamp) {
		proc.ShowFailedResponse("Invalid timestamp string.")
		os.Exit(0)
	}

	if !validatePayload(payload) {
		proc.ShowFailedResponse("Invalid payload string content.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("INSERT INTO " + apiKey +
			"_data_analytics_page (tracker, anonymous_id, user_id, name, category, timedate, payload) VALUES(\"" +
			tracker + "\", \"" + anonId + "\", \"" + userId + "\", \"" + name +
			"\", \"" + category + "\", \"" + timestamp + "\", \"" + payload + "\")")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func createPageLiveTimestampCallback(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	anonId := args[3]
	userId := args[4]
	name := args[5]
	category := args[6]
	payload := args[7]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	if !validateUsername(name) {
		proc.ShowFailedResponse("Invalid page name string.")
		os.Exit(0)
	}

	if !validateUsername(category) {
		proc.ShowFailedResponse("Invalid page category string.")
		os.Exit(0)
	}

	if !validatePayload(payload) {
		proc.ShowFailedResponse("Invalid payload string content.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("INSERT INTO " + apiKey +
			"_data_analytics_page (tracker, anonymous_id, user_id, name, category, payload) VALUES(\"" +
			tracker + "\", \"" + anonId + "\", \"" +
			userId + "\", \"" + name + "\", \"" + category + "\", \"" +
			payload + "\")")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func deletePageByAnonId(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	anonId := args[3]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("DELETE FROM " + apiKey +
			"_data_analytics_page WHERE tracker=\"" +
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

func deletePageByUserId(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	userId := args[3]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("DELETE FROM " + apiKey +
			"_data_analytics_page WHERE tracker=\"" +
			tracker + "\" AND user_id=\"" +
			userId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func deletePageByName(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	name := args[3]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateUsername(name) {
		proc.ShowFailedResponse("Invalid page name string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("DELETE FROM " + apiKey +
			"_data_analytics_page WHERE tracker=\"" +
			tracker + "\" AND name=\"" +
			name + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func deletePageByCategory(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	category := args[3]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateUsername(category) {
		proc.ShowFailedResponse("Invalid page category string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("DELETE FROM " + apiKey +
			"_data_analytics_page WHERE tracker=\"" +
			tracker + "\" AND category=\"" +
			category + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func deletePageByTimestamp(apiKey string, args []string) func(*sql.DB) {
	tracker := args[2]
	timestamp := args[3]

	if !validateTracker(tracker) {
		proc.ShowFailedResponse("Invalid tracker ID string.")
		os.Exit(0)
	}

	if !validateTimestamp(timestamp) {
		proc.ShowFailedResponse("Invalid timestamp string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("DELETE FROM " + apiKey +
			"_data_analytics_page WHERE tracker=\"" +
			tracker + "\" AND timedate=STR_TO_DATE(\"" +
			timestamp + "\", \"%Y-%m-%d %H:%i:%s\")")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func getPageByAnonId(apiKey string, args []string) func(*sql.DB) {
	anonId := args[2]
	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, user_id, name, category, timedate, CONVERT(payload USING utf8) FROM " +
			apiKey + "_data_analytics_page WHERE anonymous_id=\"" +
			anonId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var results [][]string
		for query.Next() {
			var tracker, user_id, name, category, timedate, payload string
			query.Scan(&tracker, &user_id, &name, &category, &timedate, &payload)

			results = append(results, []string{tracker, user_id, name, category, timedate, payload})
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
				"\", " + decodeBase64(results[i][6]) +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
	}
}

func getPageByUserId(apiKey string, args []string) func(*sql.DB) {
	userId := args[2]
	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, anonymous_id, name, category, timedate, CONVERT(payload USING utf8) FROM " +
			apiKey + "_data_analytics_page WHERE user_id=\"" +
			userId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var results [][]string
		for query.Next() {
			var tracker, anon_id, name, category, timedate, payload string
			query.Scan(&tracker, &anon_id, &name, &category, &timedate, &payload)

			results = append(results, []string{tracker, anon_id, name, category, timedate, payload})
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
				"\", " + decodeBase64(results[i][5]) +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
	}
}

func getPageByName(apiKey string, args []string) func(*sql.DB) {
	name := args[2]
	if !validateUsername(name) {
		proc.ShowFailedResponse("Invalid page name string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, user_id anonymous_id, category, timedate, CONVERT(payload USING utf8) FROM " +
			apiKey + "_data_analytics_page WHERE name=\"" +
			name + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var results [][]string
		for query.Next() {
			var tracker, user_id, anon_id, category, timedate, payload string
			query.Scan(&tracker, &user_id, &anon_id, &category, &timedate, &payload)

			results = append(results, []string{tracker, user_id, anon_id, category, timedate, payload})
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
				"\", " + decodeBase64(results[i][5]) +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
	}
}

func getPageByCategory(apiKey string, args []string) func(*sql.DB) {
	category := args[2]
	if !validateUsername(category) {
		proc.ShowFailedResponse("Invalid page category string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, user_id anonymous_id, name, timedate, CONVERT(payload USING utf8) FROM " +
			apiKey + "_data_analytics_page WHERE category=\"" +
			category + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var results [][]string
		for query.Next() {
			var tracker, user_id, anon_id, name, timedate, payload string
			query.Scan(&tracker, &user_id, &anon_id, &name, &timedate, &payload)

			results = append(results, []string{tracker, user_id, anon_id, name, timedate, payload})
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
				"\", " + decodeBase64(results[i][5]) +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
	}
}

func getPageByTimestamp(apiKey string, args []string) func(*sql.DB) {
	timestamp := args[2]
	if !validateTimestamp(timestamp) {
		proc.ShowFailedResponse("Invalid timestamp string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, anonymous_id, user_id, name, category, CONVERT(payload USING utf8) FROM " +
			apiKey + "_data_analytics_page WHERE timedate=\"" +
			timestamp + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		var results [][]string
		for query.Next() {
			var tracker, anon_id, user_id, name, category, payload string
			query.Scan(&tracker, &anon_id, &user_id, &name, &category, &payload)

			results = append(results, []string{tracker, anon_id, user_id, name, category, payload})
		}

		if len(results) == 0 {
			proc.ShowResult("[]")
			query.Close()
			return
		}

		result := "["
		for i := 0; i < len(results); i++ {
			result += "[\"" + results[i][0] +
				"\", \"" + results[i][1] +
				"\", \"" + results[i][2] +
				"\", \"" + results[i][3] +
				"\", \"" + results[i][4] +
				"\", " + decodeBase64(results[i][5]) +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
		query.Close()
	}
}

func fetchAllPage(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		query, err := d.Query("SELECT tracker, anonymous_id, user_id, name, category, timedate, CONVERT(payload USING utf8) FROM " +
			apiKey + "_data_analytics_page")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var results [][]string
		for query.Next() {
			var tracker, anon_id, user_id, name, category, timestamp, payload string
			query.Scan(&tracker, &anon_id, &user_id, &name, &category, &timestamp, &payload)

			results = append(results, []string{tracker, anon_id, user_id, name, category, timestamp, payload})
		}

		if len(results) == 0 {
			proc.ShowResult("[]")
			return
		}

		result := "["
		for i := 0; i < len(results); i++ {
			payload := decodeBase64(results[i][6])
			if payload == "" {
				payload = "{}"
			}

			result += "[\"" + results[i][0] +
				"\", \"" + results[i][1] +
				"\", \"" + results[i][2] +
				"\", \"" + results[i][3] +
				"\", \"" + results[i][4] +
				"\", \"" + results[i][5] +
				"\", " + payload +
				"], "
		}
		result = result[0:len(result)-2] + "]"

		proc.ShowResult(result)
	}
}

func aliasAnonHas(apiKey string, args []string) func(*sql.DB) {
	anonId := args[2]
	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		id := ""
		err := d.QueryRow("SELECT user_id FROM " + apiKey +
			"_data_analytics_id WHERE user_id <> \"null\" AND anonymous_id=\"" +
			anonId + "\"").Scan(&id)

		if err == sql.ErrNoRows {
			proc.ShowResult("\"null\"")
			return
		} else if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		err = d.QueryRow("SELECT user_id FROM " + apiKey +
			"_data_analytics_page WHERE user_id <> \"null\" AND anonymous_id=\"" +
			anonId + "\"").Scan(&id)

		if err == sql.ErrNoRows {
			proc.ShowResult("\"null\"")
			return
		} else if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		err = d.QueryRow("SELECT user_id FROM " + apiKey +
			"_data_analytics_track WHERE user_id <> \"null\" AND anonymous_id=\"" +
			anonId + "\"").Scan(&id)

		if err == sql.ErrNoRows {
			proc.ShowResult("\"null\"")
			return
		} else if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowResult("\"null\"")
	}
}

func aliasUserHas(apiKey string, args []string) func(*sql.DB) {
	userId := args[2]
	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		id := ""
		err := d.QueryRow("SELECT anonymous_id FROM " + apiKey +
			"_data_analytics_id WHERE anonymous_id <> \"null\" AND user_id=\"" +
			userId + "\"").Scan(&id)

		if err == sql.ErrNoRows {
			proc.ShowResult("\"null\"")
			return
		} else if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		err = d.QueryRow("SELECT anonymous_id FROM " + apiKey +
			"_data_analytics_page WHERE anonymous_id <> \"null\" AND user_id=\"" +
			userId + "\"").Scan(&id)

		if err == sql.ErrNoRows {
			proc.ShowResult("\"null\"")
			return
		} else if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		err = d.QueryRow("SELECT anonymous_id FROM " + apiKey +
			"_data_analytics_track WHERE anonymous_id <> \"null\" AND user_id=\"" +
			userId + "\"").Scan(&id)

		if err == sql.ErrNoRows {
			proc.ShowResult("\"null\"")
			return
		} else if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowResult("\"null\"")
	}
}

func aliasForAnon(apiKey string, args []string) func(*sql.DB) {
	anonId := args[2]
	userId := args[3]

	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		_, err := d.Query("UPDATE " + apiKey +
			"_data_analytics_id SET user_id=\"" + userId +
			"\" WHERE anonymous_id=\"" + anonId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		_, err = d.Query("UPDATE " + apiKey +
			"_data_analytics_page SET user_id=\"" + userId +
			"\" WHERE anonymous_id=\"" + anonId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		_, err = d.Query("UPDATE " + apiKey +
			"_data_analytics_track SET user_id=\"" + userId +
			"\" WHERE anonymous_id=\"" + anonId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		proc.ShowSuccessResponse()
		return
	}
}

func aliasForUser(apiKey string, args []string) func(*sql.DB) {
	userId := args[2]
	anonId := args[3]

	if !validateTracker(anonId) {
		proc.ShowFailedResponse("Invalid anonymous ID string.")
		os.Exit(0)
	}

	if !validateTracker(userId) {
		proc.ShowFailedResponse("Invalid user ID string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		_, err := d.Query("UPDATE " + apiKey +
			"_data_analytics_id SET anonymous_id=\"" + anonId +
			"\" WHERE user_id=\"" + userId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		_, err = d.Query("UPDATE " + apiKey +
			"_data_analytics_page SET anonymous_id=\"" + anonId +
			"\" WHERE user_id=\"" + userId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		_, err = d.Query("UPDATE " + apiKey +
			"_data_analytics_track SET anonymous_id=\"" + anonId +
			"\" WHERE user_id=\"" + userId + "\"")

		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		proc.ShowSuccessResponse()
		return
	}
}

func aliasFetchAll(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		var aliases [][]string

		query, err := d.Query("SELECT user_id, anonymous_id FROM " + apiKey +
			"_data_analytics_id WHERE anonymous_id <> \"null\" AND user_id <> \"null\"")

		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		for query.Next() {
			var userId, anonId string
			query.Scan(&userId, &anonId)

			aliases = append(aliases, []string{userId, anonId})
		}

		query, err = d.Query("SELECT user_id, anonymous_id FROM " + apiKey +
			"_data_analytics_page WHERE anonymous_id <> \"null\" AND user_id <> \"null\"")

		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		for query.Next() {
			var userId, anonId string
			query.Scan(&userId, &anonId)

			aliases = append(aliases, []string{userId, anonId})
		}

		query, err = d.Query("SELECT user_id, anonymous_id FROM " + apiKey +
			"_data_analytics_track WHERE anonymous_id <> \"null\" AND user_id <> \"null\"")

		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		for query.Next() {
			var userId, anonId string
			query.Scan(&userId, &anonId)

			aliases = append(aliases, []string{userId, anonId})
		}

		response := ""
		for i := 0; i < len(aliases); i++ {
			response += "[\"" + aliases[i][0] + "\", \"" + aliases[i][1] + "\"],"
		}

		if len(aliases) > 0 {
			response = response[:len(response)-1]
		}

		response = "[" + response + "]"
		proc.ShowResult(response)
	}
}
