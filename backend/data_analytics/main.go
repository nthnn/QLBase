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

	case "id_delete_by_timestamp":
		failOnUmatchedArgSize(4, args)
		callback = deleteIdByTimestamp(apiKey, args)

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

	case "track_create":
		failOnUmatchedArgSize(8, args)
		callback = createTrackCallback(apiKey, args)

	case "track_create_live_timestamp":
		failOnUmatchedArgSize(7, args)
		callback = createTrackLiveTimestampCallback(apiKey, args)

	case "track_delete_by_anon_id":
		failOnUmatchedArgSize(4, args)
		callback = deleteTrackByAnonId(apiKey, args)

	case "track_delete_by_user_id":
		failOnUmatchedArgSize(4, args)
		callback = deleteTrackByUserId(apiKey, args)

	case "track_delete_by_event":
		failOnUmatchedArgSize(4, args)
		callback = deleteTrackByEvent(apiKey, args)

	case "track_delete_by_timestamp":
		failOnUmatchedArgSize(4, args)
		callback = deleteTrackByTimestamp(apiKey, args)

	case "track_get_by_anon_id":
		failOnUmatchedArgSize(3, args)
		callback = getTrackByAnonId(apiKey, args)

	case "track_get_by_user_id":
		failOnUmatchedArgSize(3, args)
		callback = getTrackByUserId(apiKey, args)

	case "track_get_by_event":
		failOnUmatchedArgSize(3, args)
		callback = getTrackByEvent(apiKey, args)

	case "track_get_by_timestamp":
		failOnUmatchedArgSize(3, args)
		callback = getTrackByTimestamp(apiKey, args)

	case "track_fetch_all":
		failOnUmatchedArgSize(2, args)
		callback = fetchAllTrack(apiKey, args)

	default:
		proc.ShowFailedResponse("Invalid argument arity.")
	}

	DispatchWithCallback(callback)
}
