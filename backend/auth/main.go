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
	apiKey := args[1]

	switch args[0] {
	case "create":
		if len(args) != 5 {
			proc.ShowFailedResponse("Invalid parameter arity.")
			return
		}

		callback = createUserCallback(apiKey, args)

	case "delete":
		if len(args) != 3 {
			proc.ShowFailedResponse("Invalid parameter arity.")
			return
		}

		callback = deleteUserCallback(apiKey, args)
	}

	DispatchWithCallback(callback)
}
