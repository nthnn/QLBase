package main

import (
	"database/sql"
	"fmt"
	"os"
	"sort"
	"strconv"

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
		i := 0
		for query.Next() {
			count := 0
			query.Scan(&count)

			last30DayTraffic[i] = count
			i++
		}

		stringified := ""
		sort.Sort(sort.Reverse(sort.IntSlice(last30DayTraffic)))

		for i := len(last30DayTraffic) - 1; i >= 0; i-- {
			stringified += strconv.Itoa(last30DayTraffic[i]) + ", "
		}

		fmt.Println("{\"result\": \"1\", \"traffic\": [" + stringified[:len(stringified)-2] + "]}")
	})
}
