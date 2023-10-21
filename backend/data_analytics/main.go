package main

import (
	"data_analytics/proc"
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
		proc.ShowFailedResponse("Invalid argument arity.")
		os.Exit(0)
	}

	var callback func(*sql.DB) = func(d *sql.DB) {}
	args := os.Args[1:]
	apiKey := args[1]

	switch args[0] {
	case "id_create":
		failOnUmatchedArgSize(7, args)
		callback = createIdCallback(apiKey, args)

	case "id_create_without_timestamp":
		failOnUmatchedArgSize(6, args)
		callback = createIdWithoutTimestampCallback(apiKey, args)

	default:
		proc.ShowFailedResponse("Invalid argument arity.")
	}

	DispatchWithCallback(callback)
}
