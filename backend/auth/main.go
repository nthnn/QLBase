package main

import (
	"database/sql"
	"os"

	"github.com/nthnn/QLBase/auth/proc"
)

func failOnUmatchedArgSize(size int, args []string) {
	if len(args) != size {
		proc.ShowFailedResponse("Invalid parameter arity.")
		os.Exit(-1)
	}
}

func main() {
	if len(os.Args) < 3 {
		proc.ShowFailedResponse("Invalid argument arity.")
		os.Exit(0)
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

	case "enable_user":
		failOnUmatchedArgSize(3, args)
		callback = enableUser(apiKey, args)

	case "disable_user":
		failOnUmatchedArgSize(3, args)
		callback = disableUser(apiKey, args)

	case "is_user_enabled":
		failOnUmatchedArgSize(3, args)
		callback = isUserEnabled(apiKey, args)

	case "login_username":
		failOnUmatchedArgSize(4, args)
		callback = loginUserWithUsername(apiKey, args)

	case "login_email":
		failOnUmatchedArgSize(4, args)
		callback = loginUserWithEmail(apiKey, args)

	case "fetch_all":
		callback = fetchAllUserCallback(apiKey)

	default:
		proc.ShowFailedResponse("Invalid argument arity.")
	}

	DispatchWithCallback(callback)
}
