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

func updateByUsernameCallback(apiKey string, args []string) func(*sql.DB) {
	username := args[2]
	email := args[3]
	password := args[4]

	return func(d *sql.DB) {
		query, err := d.Query("UPDATE " + apiKey + "_accounts SET email=\"" +
			email + "\", password=\"" + password + "\" WHERE username=\"" +
			username + "\"")

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

	return func(d *sql.DB) {
		query, err := d.Query("UPDATE " + apiKey + "_accounts SET username=\"" +
			username + "\", password=\"" + password + "\" WHERE email=\"" +
			email + "\"")

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
		query, err := d.Query("SELECT username, email, timedate FROM " +
			apiKey + "_accounts")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		var data [][]string
		for query.Next() {
			var username, email, timestamp string
			if err := query.Scan(&username, &email, &timestamp); err != nil {
				proc.ShowFailedResponse("Internal error occured.")
				return
			}

			data = append(data, []string{username, email, timestamp})
		}
		defer query.Close()

		buff := ""
		for i := 0; i < len(data); i++ {
			buff += "[\"" + data[i][0] + "\", \"" +
				data[i][1] + "\", \"" +
				data[i][2] + "\"], "
		}

		buff = buff[0 : len(buff)-2]
		proc.ShowResult("[" + buff + "]")
	}
}

func getByUsernameCallback(apiKey string, args []string) func(*sql.DB) {
	username := args[2]

	return func(d *sql.DB) {
		query, err := d.Query("SELECT email, timedate FROM " + apiKey +
			"_accounts WHERE username=\"" + username + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		count := 0
		var email, timedate string

		for query.Next() {
			count += 1
			if err := query.Scan(&email, &timedate); err != nil {
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

		proc.ShowResult("[\"" + email + "\", \"" + timedate + "\"]")
	}
}

func getByEmailCallback(apiKey string, args []string) func(*sql.DB) {
	email := args[2]

	return func(d *sql.DB) {
		query, err := d.Query("SELECT username, timedate FROM " + apiKey +
			"_accounts WHERE email=\"" + email + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		count := 0
		var username, timedate string

		for query.Next() {
			count += 1
			if err := query.Scan(&username, &timedate); err != nil {
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

		proc.ShowResult("[\"" + username + "\", \"" + timedate + "\"]")
	}
}
