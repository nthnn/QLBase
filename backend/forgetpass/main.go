package main

import (
	"database/sql"
	"os"

	"forgetpass/db"
	"forgetpass/proc"
)

func failOnUmatchedArgSize(size int, args []string) {
	if len(args) != size {
		proc.ShowFailedResponse("Invalid parameter arity.")
		os.Exit(-1)
	}
}

func main() {
	if len(os.Args) != 2 {
		proc.ShowFailedResponse("Invalid argument arity.")
		os.Exit(0)
	}

	recipient := os.Args[1]
	email := ""

	if validateEmail(recipient) {
		email = recipient

		db.DispatchWithCallback(func(d *sql.DB) {
			query, err := d.Query(
				"SELECT * FROM accounts WHERE email=\"" +
					email + "\"")

			if err != nil {
				proc.ShowFailedResponse("Internal error occured.")
				os.Exit(0)
			}

			count := 0
			for query.Next() {
				count += 1
			}

			if count != 1 {
				proc.ShowFailedResponse("Email not found.")
				os.Exit(0)
			}
		})
	} else if validateUsername(recipient) {
		db.DispatchWithCallback(func(d *sql.DB) {
			query, err := d.Query(
				"SELECT email FROM accounts WHERE username=\"" +
					recipient + "\"")

			if err != nil {
				proc.ShowFailedResponse("Internal error occured.")
				os.Exit(0)
			}

			count := 0
			for query.Next() {
				query.Scan(&email)
				count += 1
			}

			if count != 1 {
				proc.ShowFailedResponse("Username not found.")
				os.Exit(0)
			}
		})
	} else {
		proc.ShowFailedResponse("Invalid username or email.")
		os.Exit(0)
	}

	sendConfirmation(email)
}
