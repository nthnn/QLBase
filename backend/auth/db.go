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
	"strconv"

	_ "github.com/go-sql-driver/mysql"
	"github.com/nthnn/QLBase/auth/proc"
)

type DBConfig struct {
	DBUsername string
	DBPassword string
	DBName     string
	DBServer   string
	DBPort     uint16
}

func (config DBConfig) ToString() string {
	return config.DBUsername + ":" +
		config.DBPassword + "@tcp(" +
		config.DBServer + ":" +
		strconv.Itoa(int(config.DBPort)) +
		")/" + config.DBName
}

func ConfigDB(username string, password string, name string, server string, port uint16) DBConfig {
	return DBConfig{username, password, name, server, port}
}

func ConnectDB(config DBConfig) (*sql.DB, error) {
	db, err := sql.Open("mysql", config.ToString())

	if err != nil {
		return nil, err
	}

	err = db.Ping()
	if err != nil {
		return nil, err
	}

	return db, err
}

func DispatchWithCallback(callback func(*sql.DB)) {
	wd, _ := os.Getwd()
	db_config := LoadDBConfig(wd + "/../bin/config.ini")
	db_conn, err := ConnectDB(db_config)

	if err != nil {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}
	defer db_conn.Close()

	callback(db_conn)
}
