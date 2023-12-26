package main

import (
	"database/sql"

	"github.com/nthnn/QLBase/database/proc"
)

func createDbCallback(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		name := args[2]
		mode := args[3]
		contents := args[4]

		query, err := d.Query("SELECT id FROM " + apiKey + "_database WHERE name=\"" + name + "\"")
		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		count := 0
		for query.Next() {
			id := 0
			query.Scan(&id)

			count++
		}

		if count != 0 {
			proc.ShowFailedResponse("Database name already in use.")
			return
		}

		_, err = d.Query("INSERT INTO " + apiKey +
			"_database (name, mode, contents) VALUES(\"" + name +
			"\", \"" + mode + "\", \"" + contents + "\")")
		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		query.Close()
		proc.ShowSuccessResponse()
	}
}

func getByNameCallback(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		name := args[2]
		query, err := d.Query("SELECT id FROM " + apiKey + "_database WHERE name=\"" + name + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			query.Close()

			return
		}

		count := 0
		for query.Next() {
			id := 0
			query.Scan(&id)

			count++
		}

		if count != 1 {
			proc.ShowFailedResponse("Cannot resolve database name.")
			query.Close()

			return
		}

		query, err = d.Query("SELECT mode, content FROM " + apiKey + "_database WHERE name=\"" + name + "\"")
		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			query.Close()

			return
		}

		mode := ""
		content := ""

		for query.Next() {
			query.Scan(&mode, &content)
		}

		proc.ShowResult("[\"" + mode + "\", \"" + content + "\"]")
		query.Close()
	}
}

func setDbModeCallback(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		name := args[2]
		mode := args[3]
		query, err := d.Query("SELECT id FROM " + apiKey + "_database WHERE name=\"" + name + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			query.Close()

			return
		}

		count := 0
		for query.Next() {
			id := 0
			query.Scan(&id)

			count++
		}

		if count != 1 {
			proc.ShowFailedResponse("Cannot resolve database name.")
			query.Close()

			return
		}

		query, err = d.Query("UPDATE " + apiKey +
			"_database SET mode=\"" + mode +
			"\" WHERE name=\"" + name + "\"")
		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			query.Close()

			return
		}

		proc.ShowSuccessResponse()
	}
}
