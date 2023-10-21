package main

import (
	"data_analytics/proc"
	"os"

	"gopkg.in/ini.v1"
)

func LoadDBConfig(configFile string) DBConfig {
	ini, err := ini.Load(configFile)
	if err != nil {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}

	database := ini.Section("database")
	return ConfigDB(
		database.Key("username").String(),
		database.Key("password").String(),
		database.Key("name").String(),
		database.Key("server").String(),
		uint16(database.Key("port").MustInt(3306)))
}
