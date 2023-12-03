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

	case "page_create":
		failOnUmatchedArgSize(8, args)
		callback = createPageCallback(apiKey, args)

	case "page_create_live_timestamp":
		failOnUmatchedArgSize(8, args)
		callback = createPageLiveTimestampCallback(apiKey, args)

	case "page_delete_by_anon_id":
		failOnUmatchedArgSize(4, args)
		callback = deletePageByAnonId(apiKey, args)

	case "page_delete_by_user_id":
		failOnUmatchedArgSize(4, args)
		callback = deletePageByUserId(apiKey, args)

	case "page_delete_by_name":
		failOnUmatchedArgSize(4, args)
		callback = deletePageByName(apiKey, args)

	case "page_delete_by_category":
		failOnUmatchedArgSize(4, args)
		callback = deletePageByCategory(apiKey, args)

	case "page_delete_by_timestamp":
		failOnUmatchedArgSize(4, args)
		callback = deletePageByTimestamp(apiKey, args)

	case "page_get_by_anon_id":
		failOnUmatchedArgSize(3, args)
		callback = getPageByAnonId(apiKey, args)

	case "page_get_by_user_id":
		failOnUmatchedArgSize(3, args)
		callback = getPageByUserId(apiKey, args)

	case "page_get_by_name":
		failOnUmatchedArgSize(3, args)
		callback = getPageByName(apiKey, args)

	case "page_get_by_category":
		failOnUmatchedArgSize(3, args)
		callback = getPageByCategory(apiKey, args)

	case "page_get_by_timestamp":
		failOnUmatchedArgSize(3, args)
		callback = getPageByTimestamp(apiKey, args)

	case "page_fetch_all":
		failOnUmatchedArgSize(2, args)
		callback = fetchAllPage(apiKey, args)

	case "alias_anon_has":
		failOnUmatchedArgSize(3, args)
		callback = aliasAnonHas(apiKey, args)

	case "alias_user_has":
		failOnUmatchedArgSize(3, args)
		callback = aliasUserHas(apiKey, args)

	case "alias_for_anon":
		failOnUmatchedArgSize(4, args)
		callback = aliasForAnon(apiKey, args)

	case "alias_for_user":
		failOnUmatchedArgSize(4, args)
		callback = aliasForUser(apiKey, args)

	case "alias_fetch_all":
		failOnUmatchedArgSize(2, args)
		callback = aliasFetchAll(apiKey, args)

	default:
		proc.ShowFailedResponse("Invalid argument arity.")
	}

	DispatchWithCallback(callback)
}
