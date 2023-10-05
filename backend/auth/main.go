package main

import (
	"auth/proc"
	"database/sql"
	"os"
)

func failOnUmatchedArgSize(size int, args []string) {
	if len(args) != size {
		proc.ShowFailedResponse("Invalid parameter arity.")
		os.Exit(-1)
	}
}

func main() {
	if len(os.Args) < 3 {
		return
	}

	var callback func(*sql.DB) = func(d *sql.DB) {}
	args := os.Args[1:]
	apiKey := args[1]

	switch args[0] {
	case "create":
		failOnUmatchedArgSize(6, args)
		callback = createUserCallback(apiKey, args)

	case "delete_by_username":
		failOnUmatchedArgSize(3, args)
		callback = deleteByUsernameCallback(apiKey, args)

	case "delete_by_email":
		failOnUmatchedArgSize(3, args)
		callback = deleteByEmailCallback(apiKey, args)

	case "update_by_username":
		failOnUmatchedArgSize(6, args)
		callback = updateByUsernameCallback(apiKey, args)

	case "update_by_email":
		failOnUmatchedArgSize(6, args)
		callback = updateByEmailCallback(apiKey, args)

	case "get_by_username":
		failOnUmatchedArgSize(3, args)
		callback = getByUsernameCallback(apiKey, args)

	case "get_by_email":
		failOnUmatchedArgSize(3, args)
		callback = getByEmailCallback(apiKey, args)

	case "fetch_all":
		callback = fetchAllUserCallback(apiKey)
	}

	DispatchWithCallback(callback)
}
