package db

import (
	"database/sql"
	"fmt"
	"os"
	"strconv"

	_ "github.com/go-sql-driver/mysql"
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
		fmt.Println(err)
		return
	}
	defer db_conn.Close()

	callback(db_conn)
}
