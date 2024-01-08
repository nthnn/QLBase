package main

import (
	"database/sql"
)

func fileUploadCallback(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
	}
}
