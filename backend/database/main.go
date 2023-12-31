package main

import (
	"database/sql"
	"os"

	"github.com/nthnn/QLBase/database/proc"
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
		failOnUmatchedArgSize(5, args)
		callback = createDbCallback(apiKey, args)

	case "get_by_name":
		failOnUmatchedArgSize(3, args)
		callback = getByNameCallback(apiKey, args)

	case "set_db_mode":
		failOnUmatchedArgSize(4, args)
		callback = setDbModeCallback(apiKey, args)

	case "get_db_mode":
		failOnUmatchedArgSize(3, args)
		callback = getDbModeCallback(apiKey, args)

	case "delete_db":
		failOnUmatchedArgSize(3, args)
		callback = deleteDbCallback(apiKey, args)

	case "fetch_all":
		failOnUmatchedArgSize(2, args)
		callback = fetchAllCallback(apiKey, args)
	}

	DispatchWithCallback(callback)
}
