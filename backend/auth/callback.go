package main

import (
	"auth/proc"
	"database/sql"
	"strconv"
)

func createUserCallback(apiKey string, args []string) func(*sql.DB) {
	username := args[2]
	email := args[3]
	password := args[4]
	enabled := 0

	if args[5] == "true" {
		enabled = 1
	} else if args[5] == "false" {
		enabled = 0
	} else {
		enabled = 1
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT * FROM " + apiKey +
			"_accounts WHERE username=\"" +
			username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		count := 0
		for query.Next() {
			count += 1
		}

		if count != 0 {
			proc.ShowFailedResponse("Username already in-use.")
			return
		}

		query, err = d.Query("SELECT * FROM " + apiKey +
			"_accounts WHERE email=\"" + email + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		count = 0
		for query.Next() {
			count += 1
		}

		if count != 0 {
			proc.ShowFailedResponse("Email already in-use.")
			return
		}

		query, err = d.Query("INSERT INTO " + apiKey +
			"_accounts (username, email, password, enabled) VALUES (\"" +
			username + "\", \"" + email + "\", \"" + password + "\", " +
			strconv.Itoa(enabled) + ")")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		defer query.Close()
		proc.ShowSuccessResponse()
	}
}

func updateByUsernameCallback(apiKey string, args []string) func(*sql.DB) {
	username := args[2]
	email := args[3]
	password := args[4]
	enabled := 0

	if args[5] == "true" {
		enabled = 1
	} else if args[5] == "false" {
		enabled = 0
	} else {
		enabled = 1
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT * FROM " + apiKey +
			"_accounts WHERE username=\"" + username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		count := 0
		for query.Next() {
			count += 1
		}

		if count != 1 {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		query, err = d.Query("UPDATE " + apiKey + "_accounts SET email=\"" +
			email + "\", password=\"" + password + "\", enabled=" +
			strconv.Itoa(enabled) + " WHERE username=\"" + username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		defer query.Close()
		proc.ShowSuccessResponse()
	}
}

func updateByEmailCallback(apiKey string, args []string) func(*sql.DB) {
	email := args[2]
	username := args[3]
	password := args[4]
	enabled := 0

	if args[5] == "true" {
		enabled = 1
	} else if args[5] == "false" {
		enabled = 0
	} else {
		enabled = 1
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT * FROM " + apiKey +
			"_accounts WHERE username=\"" + username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		count := 0
		for query.Next() {
			count += 1
		}

		if count != 1 {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		query, err = d.Query("UPDATE " + apiKey + "_accounts SET username=\"" +
			username + "\", password=\"" + password + "\", enabled=" +
			strconv.Itoa(enabled) + " WHERE email=\"" + email + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		defer query.Close()
		proc.ShowSuccessResponse()
	}
}

func deleteByUsernameCallback(apiKey string, args []string) func(*sql.DB) {
	username := args[2]

	return func(d *sql.DB) {
		check, err := d.Query("SELECT * FROM " + apiKey +
			"_accounts WHERE username=\"" + username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		count := 0
		for check.Next() {
			count += 1
		}

		if count != 1 {
			proc.ShowFailedResponse("No user found with the specified username.")
			return
		}
		check.Close()

		query, err := d.Query(
			"DELETE FROM " + apiKey +
				"_accounts WHERE username=\"" + username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func deleteByEmailCallback(apiKey string, args []string) func(*sql.DB) {
	email := args[2]

	return func(d *sql.DB) {
		check, err := d.Query("SELECT * FROM " + apiKey +
			"_accounts WHERE email=\"" + email + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		count := 0
		for check.Next() {
			count += 1
		}

		if count != 1 {
			proc.ShowFailedResponse("No user found with the specified email.")
			return
		}
		check.Close()

		query, err := d.Query(
			"DELETE FROM " + apiKey +
				"_accounts WHERE email=\"" + email + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func fetchAllUserCallback(apiKey string) func(*sql.DB) {
	return func(d *sql.DB) {
		query, err := d.Query("SELECT username, email, enabled, timedate FROM " +
			apiKey + "_accounts")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		var data [][]string
		for query.Next() {
			var username, email, enabled, timestamp string
			if err := query.Scan(&username, &email, &enabled, &timestamp); err != nil {
				proc.ShowFailedResponse("Internal error occured.")
				return
			}

			data = append(data, []string{username, email, enabled, timestamp})
		}
		defer query.Close()

		buff := ""
		for i := 0; i < len(data); i++ {
			buff += "[\"" + data[i][0] + "\", \"" +
				data[i][1] + "\", \"" +
				data[i][2] + "\", \"" +
				data[i][3] + "\"], "
		}

		if buff != "" {
			buff = buff[0 : len(buff)-2]
		}
		proc.ShowResult("[" + buff + "]")
	}
}

func getByUsernameCallback(apiKey string, args []string) func(*sql.DB) {
	username := args[2]

	return func(d *sql.DB) {
		query, err := d.Query("SELECT email, enabled, timedate FROM " + apiKey +
			"_accounts WHERE username=\"" + username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		count := 0
		var email, enabled, timedate string

		for query.Next() {
			count += 1
			if err := query.Scan(&email, &enabled, &timedate); err != nil {
				proc.ShowFailedResponse("Internal error occured.")
				return
			}
		}

		if count == 0 {
			proc.ShowFailedResponse("No user with specified username.")
			return
		}

		if count != 1 {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowResult("[\"" + email + "\", \"" +
			enabled + "\", \"" +
			timedate + "\"]")
	}
}

func getByEmailCallback(apiKey string, args []string) func(*sql.DB) {
	email := args[2]

	return func(d *sql.DB) {
		query, err := d.Query("SELECT username, enabled, timedate FROM " + apiKey +
			"_accounts WHERE email=\"" + email + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		count := 0
		var username, enabled, timedate string

		for query.Next() {
			count += 1
			if err := query.Scan(&username, &enabled, &timedate); err != nil {
				proc.ShowFailedResponse("Internal error occured.")
				return
			}
		}

		if count == 0 {
			proc.ShowFailedResponse("No user with specified email.")
			return
		}

		if count != 1 {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowResult("[\"" + username + "\", \"" +
			enabled + "\", \"" +
			timedate + "\"]")
	}
}

func enableUser(apiKey string, args []string) func(*sql.DB) {
	username := args[2]

	return func(d *sql.DB) {
		query, err := d.Query("SELECT * FROM " + apiKey +
			"_accounts WHERE username=\"" + username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		count := 0
		for query.Next() {
			count += 1
		}

		if count != 1 {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		query, err = d.Query("UPDATE " + apiKey +
			"_accounts SET enabled=1 WHERE username=\"" +
			username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func disableUser(apiKey string, args []string) func(*sql.DB) {
	username := args[2]

	return func(d *sql.DB) {
		query, err := d.Query("SELECT * FROM " + apiKey +
			"_accounts WHERE username=\"" + username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		count := 0
		for query.Next() {
			count += 1
		}

		if count != 1 {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		query, err = d.Query("UPDATE " + apiKey +
			"_accounts SET enabled=0 WHERE username=\"" +
			username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func isUserEnabled(apiKey string, args []string) func(*sql.DB) {
	username := args[2]

	return func(d *sql.DB) {
		query, err := d.Query("SELECT * FROM " + apiKey +
			"_accounts WHERE username=\"" + username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		count := 0
		for query.Next() {
			count += 1
		}

		if count != 1 {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		query, err = d.Query("SELECT enabled FROM " + apiKey +
			"_accounts WHERE username=\"" +
			username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		enabled := false
		query.Next()
		query.Scan(&enabled)

		if enabled {
			proc.ShowResult("\"1\"")
		} else {
			proc.ShowResult("\"0\"")
		}

		query.Close()
	}
}
