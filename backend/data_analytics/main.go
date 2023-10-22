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

	case "id_create_live_timestamp":
		failOnUmatchedArgSize(6, args)
		callback = createIdLiveTimestampCallback(apiKey, args)

	case "id_delete_by_anon_id":
		failOnUmatchedArgSize(4, args)
		callback = deleteIdByAnonId(apiKey, args)

	case "id_delete_by_user_id":
		failOnUmatchedArgSize(4, args)
		callback = deleteIdByUserId(apiKey, args)

	case "id_get_by_anon_id":
		failOnUmatchedArgSize(3, args)
		callback = getIdByAnonId(apiKey, args)

	case "id_get_by_user_id":
		failOnUmatchedArgSize(3, args)
		callback = getIdByUserId(apiKey, args)

	case "id_get_by_timestamp":
		failOnUmatchedArgSize(3, args)
		callback = getIdByTimestamp(apiKey, args)

	case "id_fetch_all":
		failOnUmatchedArgSize(2, args)
		callback = fetchAllId(apiKey, args)

	default:
		proc.ShowFailedResponse("Invalid argument arity.")
	}

	DispatchWithCallback(callback)
}
