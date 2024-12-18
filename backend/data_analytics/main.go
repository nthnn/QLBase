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

func failOnUnmatchedArgSize(size int, args []string) {
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

	if !validateApiKey(apiKey) {
		proc.ShowFailedResponse("Invalid API key string.")
		os.Exit(0)
	}

	switch args[0] {
	case "id_create":
		failOnUnmatchedArgSize(7, args)
		callback = createIdCallback(apiKey, args)

	case "id_create_live_timestamp":
		failOnUnmatchedArgSize(6, args)
		callback = createIdLiveTimestampCallback(apiKey, args)

	case "id_delete_by_anon_id":
		failOnUnmatchedArgSize(4, args)
		callback = deleteIdByAnonId(apiKey, args)

	case "id_delete_by_user_id":
		failOnUnmatchedArgSize(4, args)
		callback = deleteIdByUserId(apiKey, args)

	case "id_delete_by_timestamp":
		failOnUnmatchedArgSize(4, args)
		callback = deleteIdByTimestamp(apiKey, args)

	case "id_get_by_anon_id":
		failOnUnmatchedArgSize(3, args)
		callback = getIdByAnonId(apiKey, args)

	case "id_get_by_user_id":
		failOnUnmatchedArgSize(3, args)
		callback = getIdByUserId(apiKey, args)

	case "id_get_by_timestamp":
		failOnUnmatchedArgSize(3, args)
		callback = getIdByTimestamp(apiKey, args)

	case "id_fetch_all":
		failOnUnmatchedArgSize(2, args)
		callback = fetchAllId(apiKey, args)

	case "track_create":
		failOnUnmatchedArgSize(8, args)
		callback = createTrackCallback(apiKey, args)

	case "track_create_live_timestamp":
		failOnUnmatchedArgSize(7, args)
		callback = createTrackLiveTimestampCallback(apiKey, args)

	case "track_delete_by_anon_id":
		failOnUnmatchedArgSize(4, args)
		callback = deleteTrackByAnonId(apiKey, args)

	case "track_delete_by_user_id":
		failOnUnmatchedArgSize(4, args)
		callback = deleteTrackByUserId(apiKey, args)

	case "track_delete_by_event":
		failOnUnmatchedArgSize(4, args)
		callback = deleteTrackByEvent(apiKey, args)

	case "track_delete_by_timestamp":
		failOnUnmatchedArgSize(4, args)
		callback = deleteTrackByTimestamp(apiKey, args)

	case "track_get_by_anon_id":
		failOnUnmatchedArgSize(3, args)
		callback = getTrackByAnonId(apiKey, args)

	case "track_get_by_user_id":
		failOnUnmatchedArgSize(3, args)
		callback = getTrackByUserId(apiKey, args)

	case "track_get_by_event":
		failOnUnmatchedArgSize(3, args)
		callback = getTrackByEvent(apiKey, args)

	case "track_get_by_timestamp":
		failOnUnmatchedArgSize(3, args)
		callback = getTrackByTimestamp(apiKey, args)

	case "track_fetch_all":
		failOnUnmatchedArgSize(2, args)
		callback = fetchAllTrack(apiKey, args)

	case "page_create":
		failOnUnmatchedArgSize(9, args)
		callback = createPageCallback(apiKey, args)

	case "page_create_live_timestamp":
		failOnUnmatchedArgSize(8, args)
		callback = createPageLiveTimestampCallback(apiKey, args)

	case "page_delete_by_anon_id":
		failOnUnmatchedArgSize(4, args)
		callback = deletePageByAnonId(apiKey, args)

	case "page_delete_by_user_id":
		failOnUnmatchedArgSize(4, args)
		callback = deletePageByUserId(apiKey, args)

	case "page_delete_by_name":
		failOnUnmatchedArgSize(4, args)
		callback = deletePageByName(apiKey, args)

	case "page_delete_by_category":
		failOnUnmatchedArgSize(4, args)
		callback = deletePageByCategory(apiKey, args)

	case "page_delete_by_timestamp":
		failOnUnmatchedArgSize(4, args)
		callback = deletePageByTimestamp(apiKey, args)

	case "page_get_by_anon_id":
		failOnUnmatchedArgSize(3, args)
		callback = getPageByAnonId(apiKey, args)

	case "page_get_by_user_id":
		failOnUnmatchedArgSize(3, args)
		callback = getPageByUserId(apiKey, args)

	case "page_get_by_name":
		failOnUnmatchedArgSize(3, args)
		callback = getPageByName(apiKey, args)

	case "page_get_by_category":
		failOnUnmatchedArgSize(3, args)
		callback = getPageByCategory(apiKey, args)

	case "page_get_by_timestamp":
		failOnUnmatchedArgSize(3, args)
		callback = getPageByTimestamp(apiKey, args)

	case "page_fetch_all":
		failOnUnmatchedArgSize(2, args)
		callback = fetchAllPage(apiKey, args)

	case "alias_anon_has":
		failOnUnmatchedArgSize(3, args)
		callback = aliasAnonHas(apiKey, args)

	case "alias_user_has":
		failOnUnmatchedArgSize(3, args)
		callback = aliasUserHas(apiKey, args)

	case "alias_for_anon":
		failOnUnmatchedArgSize(4, args)
		callback = aliasForAnon(apiKey, args)

	case "alias_for_user":
		failOnUnmatchedArgSize(4, args)
		callback = aliasForUser(apiKey, args)

	case "alias_fetch_all":
		failOnUnmatchedArgSize(2, args)
		callback = aliasFetchAll(apiKey, args)

	default:
		proc.ShowFailedResponse("Invalid argument arity.")
	}

	DispatchWithCallback(callback)
}
