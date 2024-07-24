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
	"strings"

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
			"_database (name, mode, content) VALUES(\"" + name +
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

		if strings.Contains(mode, "r") {
			proc.ShowResult("[\"" + mode + "\", \"" + content + "\"]")
		} else {
			proc.ShowResult("[\"" + mode + "\"]")
		}

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

func getDbModeCallback(apiKey string, args []string) func(*sql.DB) {
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

		query, err = d.Query("SELECT mode FROM " + apiKey + "_database WHERE name=\"" + name + "\"")
		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			query.Close()

			return
		}

		mode := ""
		for query.Next() {
			query.Scan(&mode)
		}

		proc.ShowResult("\"" + mode + "\"")
		query.Close()
	}
}

func readDbCallback(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		name := args[2]
		query, err := d.Query("SELECT mode, content FROM " + apiKey + "_database WHERE name=\"" + name + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			query.Close()

			return
		}

		count := 0
		mode := ""
		content := ""

		for query.Next() {
			query.Scan(&mode, &content)
			count++
		}

		if count != 1 {
			proc.ShowFailedResponse("Cannot resolve database name.")
			query.Close()

			return
		}

		if !strings.Contains(mode, "r") {
			proc.ShowFailedResponse("Read operation denied.")
			query.Close()

			return
		}

		proc.ShowResult("\"" + content + "\"")
		query.Close()
	}
}

func writeDbCallback(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		name := args[2]
		content := args[3]
		query, err := d.Query("SELECT mode FROM " + apiKey + "_database WHERE name=\"" + name + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			query.Close()

			return
		}

		count := 0
		mode := ""

		for query.Next() {
			query.Scan(&mode)
			count++
		}

		if count != 1 {
			proc.ShowFailedResponse("Cannot resolve database name.")
			query.Close()

			return
		}

		if !strings.Contains(mode, "w") {
			proc.ShowFailedResponse("Write operation denied.")
			query.Close()

			return
		}

		query, err = d.Query("UPDATE " + apiKey +
			"_database SET content=\"" + content +
			"\" WHERE name=\"" + name + "\"")
		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			query.Close()

			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func deleteDbCallback(apiKey string, args []string) func(*sql.DB) {
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

		query, err = d.Query("DELETE FROM " + apiKey + "_database WHERE name=\"" + name + "\"")
		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			query.Close()

			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func fetchAllCallback(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		query, err := d.Query("SELECT name, mode FROM " + apiKey + "_database")
		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			query.Close()

			return
		}

		result := "["
		for query.Next() {
			name := ""
			mode := ""

			query.Scan(&name, &mode)
			result += "[\"" + name + "\", \"" + mode + "\"], "
		}

		query.Close()
		proc.ShowResult(strings.TrimSuffix(result, ", ") + "]")
	}
}
