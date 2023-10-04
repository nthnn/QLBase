package main

import (
	"auth/proc"
	"database/sql"
	"os"
)

func main() {
	if len(os.Args) < 2 {
		return
	}

	var callback func(*sql.DB) = func(d *sql.DB) {}
	args := os.Args[1:]

	switch args[0] {
	case "create":
		if len(args) != 5 {
			return
		}

		callback = func(d *sql.DB) {
			apiKey := args[1]
			username := args[2]
			email := args[3]
			password := args[4]

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

	DispatchWithCallback(callback)
}
