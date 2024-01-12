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
		temp := args[2]
		dest := "../drive/" + base64.StdEncoding.EncodeToString([]byte(args[3]))

		query, err := d.Query("SELECT id FROM " + apiKey + "_storage WHERE temp_name=\"" + temp[14:] + "\"")
		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			os.Remove(temp)

			return
		}

		count := 0
		for query.Next() {
			query.Scan(&count)
		}

		if count != 0 {
			proc.ShowFailedResponse("File already exists.")
			os.Remove(temp)

			return
		}

		if err := util.MoveTempFile(temp, dest); err != nil {
			proc.ShowFailedResponse("Unable to store uploaded file. " + err.Error())
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
			"_storage (name, temp_name, mime_type, checksum) VALUES(\"" + dbFileName +
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
