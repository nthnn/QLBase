package main

import (
	"database/sql"
	"encoding/base64"
	"encoding/json"
	"os"
	"strings"

	"github.com/gabriel-vasile/mimetype"
	"github.com/google/uuid"
	"github.com/nthnn/QLBase/storage/proc"
	"github.com/nthnn/QLBase/storage/util"
)

func fileUploadCallback(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		temp := args[2]
		dest := "../drive/" + base64.StdEncoding.EncodeToString([]byte(uuid.New().String()+"-"+args[3]))

		query, err := d.Query("SELECT id FROM " + apiKey + "_storage WHERE orig_name=\"" + temp[14:] + "\"")
		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			os.Remove(temp)

			return
		}

		count := 0
		for query.Next() {
			id := 0
			query.Scan(&id)

			count++
		}

		if count != 0 {
			proc.ShowFailedResponse("File already exists.")
			os.Remove(temp)

			return
		}

		if err := util.MoveTempFile(temp, dest); err != nil {
			proc.ShowFailedResponse("Unable to store uploaded file.")
			os.Remove(temp)

			return
		}

		mime, err := mimetype.DetectFile(temp)
		os.Remove(temp)

		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		checksum, err := util.CalculateChecksum(dest + ".zip")
		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		dbFileName := dest[9:]
		query, err = d.Query("INSERT INTO " + apiKey +
			"_storage (name, orig_name, mime_type, checksum) VALUES(\"" + dbFileName +
			"\", \"" + temp[14:] + "\", \"" + mime.String() +
			"\", \"" + checksum + "\")")
		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		query.Close()
		proc.ShowResult("\"" + dbFileName + "\"")
	}
}

func deleteFileCallback(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		fileName := args[2]

		query, err := d.Query("SELECT id FROM " + apiKey + "_storage WHERE name=\"" + fileName + "\"")
		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}
		defer query.Close()

		count := 0
		for query.Next() {
			id := 0
			query.Scan(&id)

			count++
		}

		if count != 1 {
			proc.ShowFailedResponse("File does not exists.")
			return
		}

		if err := os.Remove("../drive/" + fileName + ".zip"); err != nil {
			proc.ShowFailedResponse("Unable to delete file from server storage.")
			return
		}

		query, err = d.Query("DELETE FROM " + apiKey + "_storage WHERE name=\"" + fileName + "\"")
		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		query.Close()
		proc.ShowSuccessResponse()
	}
}

func getFileCallback(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		fileName := args[2]

		query, err := d.Query("SELECT orig_name, mime_type, checksum FROM " + apiKey + "_storage WHERE name=\"" + fileName + "\" LIMIT 1")
		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}
		defer query.Close()

		count := 0
		info := []string{}
		for query.Next() {
			orig_name := ""
			mime_type := ""
			checksum := ""

			query.Scan(&orig_name, &mime_type, &checksum)
			info = []string{orig_name, mime_type, checksum}

			count++
		}

		if count != 1 {
			proc.ShowFailedResponse("File does not exists.")
			return
		}

		buf := new(strings.Builder)
		json.NewEncoder(buf).Encode(info)

		proc.ShowResult(buf.String())
	}
}

func fetchAllCallback(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		query, err := d.Query("SELECT name, orig_name, mime_type, checksum FROM " + apiKey + "_storage")
		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}
		defer query.Close()

		rows := [][]string{}
		for query.Next() {
			name := ""
			origName := ""
			mimeType := ""
			checksum := ""

			query.Scan(&name, &origName, &mimeType, &checksum)
			rows = append(rows, []string{name, origName, mimeType, checksum})
		}

		buf := new(strings.Builder)
		if err := json.NewEncoder(buf).Encode(rows); err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		proc.ShowResult(buf.String())
	}
}
