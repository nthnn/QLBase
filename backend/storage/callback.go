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
	"encoding/base64"
	"encoding/json"
	"os"
	"strconv"
	"strings"
	"time"

	"github.com/gabriel-vasile/mimetype"
	"github.com/google/uuid"
	"github.com/nthnn/QLBase/storage/proc"
	"github.com/nthnn/QLBase/storage/util"
)

func fileUploadCallback(apiKey string, args []string) func(*sql.DB) {
	temp := args[2]
	if !validateFilename(temp) {
		proc.ShowFailedResponse("Invalid file name string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		dest := util.SafePathSanitation("../drive/") +
			base64.StdEncoding.EncodeToString([]byte(uuid.New().String()+"-"+args[3]))

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
	fileName := args[2]
	if !validateBase64Filename(fileName) {
		proc.ShowFailedResponse("Invalid file name string from base64.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
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

		if err := os.Remove(util.SafePathSanitation("../drive/") + fileName + ".zip"); err != nil {
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
	fileName := args[2]
	if !validateBase64Filename(fileName) {
		proc.ShowFailedResponse("Invalid file name string from base64.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT orig_name, mime_type, checksum FROM " +
			apiKey + "_storage WHERE name=\"" +
			fileName + "\" LIMIT 1")

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

func downloadCallback(apiKey string, args []string) func(*sql.DB) {
	fileName := args[2]
	shouldExpire := args[3]

	if !validateBase64Filename(fileName) {
		proc.ShowFailedResponse("Invalid file name string from base64.")
		os.Exit(0)
	}

	if shouldExpire != "0" && shouldExpire != "1" {
		proc.ShowFailedResponse("Expirable value must be 0 or 1.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT id FROM " + apiKey +
			"_storage WHERE name=\"" +
			fileName + "\"")

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

		var timestamp int64 = 0
		if shouldExpire == "1" {
			timestamp = time.Now().Add(24 * time.Hour).Unix()
		}

		ticket := uuid.New().String()
		serverDb, err := ServerDB()
		if err != nil {
			proc.ShowFailedResponse("Something went wrong.")
			return
		}
		defer serverDb.Close()

		query, err = serverDb.Query("INSERT INTO cdp (api_key, ticket, name, expiration) VALUES(\"" + apiKey +
			"\", \"" + ticket + "\", \"" + fileName + "\", " + strconv.Itoa(int(timestamp)) + ")")
		if err != nil {
			proc.ShowFailedResponse("Something went wrong. " + err.Error())
			return
		}

		query.Close()
		proc.ShowResult("\"" + ticket + "\"")
	}
}

func extractCallback(apiKey string, args []string) func(*sql.DB) {
	fileName := args[2]
	if !validateFilename(fileName) {
		proc.ShowFailedResponse("Invalid file name string from base64.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		util.ExtractZip(fileName, util.SafePathSanitation("../drive/temp"))
	}
}

func fetchAllCallback(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		query, err := d.Query("SELECT name, orig_name, mime_type, checksum FROM " +
			apiKey + "_storage")

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
