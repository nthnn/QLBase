package main

import (
	"auth/proc"
	"database/sql"
)

func createUserCallback(apiKey string, args []string) func(*sql.DB) {
	username := args[2]
	email := args[3]
	password := args[4]

	return func(d *sql.DB) {
		query, err := d.Query("INSERT INTO " + apiKey +
			"_accounts (username, email, password) VALUES (\"" +
			username + "\", \"" + email + "\", \"" + password + "\")")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		defer query.Close()
		proc.ShowSuccessResponse()
	}
}

func deleteUserCallback(apiKey string, args []string) func(*sql.DB) {
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
