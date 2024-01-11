package main

import (
	"database/sql"
	"encoding/base64"
	"os"

	"github.com/gabriel-vasile/mimetype"
	"github.com/nthnn/QLBase/storage/proc"
	"github.com/nthnn/QLBase/storage/util"
)

func fileUploadCallback(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		temp := args[0]
		dest := base64.StdEncoding.EncodeToString([]byte(args[1]))

		query, err := d.Query("SELECT id FROM " + apiKey + "_storage WHERE temp_name=\"" + temp + "\"")
		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		count := 0
		for query.Next() {
			query.Scan(&count)
		}

		if count != 0 {
			proc.ShowFailedResponse("File already exists.")
			return
		}

		if err := util.MoveTempFile(temp, dest); err != nil {
			proc.ShowFailedResponse("Unable to store uploaded file.")
			os.Remove(temp)

			return
		}

		mime, err := mimetype.DetectFile(dest)
		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		checksum, err := util.CalculateChecksum(dest)
		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		query, err = d.Query("INSERT INTO " + apiKey +
			"_storage (name, temp_name, mime_type, checksum) VALUES(\"" + dest +
			"\", \"" + temp + "\", \"" + mime.String() +
			"\", \"" + checksum + "\")")
		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}

		query.Close()
		proc.ShowResult(dest)
	}
}
