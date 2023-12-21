package main

import (
	"database/sql"
	"fmt"
	"os"
	"strings"

	"github.com/nthnn/QLBase/traffic/proc"
)

func failOnUmatchedArgSize(size int, args []string) {
	if len(args) != size {
		proc.ShowFailedResponse("Invalid parameter arity.")
		os.Exit(-1)
	}
}

func main() {
	if len(os.Args) != 3 {
		proc.ShowFailedResponse("Invalid argument arity.")
		os.Exit(0)
	}

	apiKey := os.Args[1]
	appId := os.Args[2]

	DispatchWithCallback(func(db *sql.DB) {
		query, err := db.Query("SELECT count FROM traffic WHERE api_key=\"" + apiKey +
			"\" AND app_id=\"" + appId + "\" ORDER BY STR_TO_DATE(\"date_time\", \"%d%m%Y\") ASC LIMIT 30")

		if err != nil {
			proc.ShowFailedResponse("Something went wrong. " + err.Error())
			return
		}

		last30DayTraffic := make([]int, 30)
		for query.Next() {
			count := 0
			query.Scan(&count)

			last30DayTraffic = append(last30DayTraffic, count)
		}

		fmt.Println(
			"{\"result\": \"1\", \"traffic\": [" +
				strings.Trim(strings.Join(strings.Fields(fmt.Sprint(last30DayTraffic[len(last30DayTraffic)-30:])), ", "), "[]") +
				"]}")
	})
}
