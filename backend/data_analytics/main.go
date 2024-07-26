/*
 * This file is part of QLBase (https://github.com/nthnn/QLBase).
 * Copyright 2024 - Nathanne Isip
 * 
 * Permission is hereby granted, free of charge,
 * to any person obtaining a copy of this software
 * and associated documentation files (the “Software”),
 * to deal in the Software without restriction,
 * including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to
 * whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions
 * of the Software.
 * 
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF
 * ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT
 * SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR
 * ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

package main

import (
	"database/sql"
	"os"

	"github.com/nthnn/QLBase/data_analytics/proc"
)

func failOnUmatchedArgSize(size int, args []string) {
	if len(args) != size {
		proc.ShowFailedResponse("Invalid parameter arity.")
		os.Exit(-1)
	}
}

func main() {
	if !proc.IsParentProcessPHP() {
		os.Exit(0)
	}

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
