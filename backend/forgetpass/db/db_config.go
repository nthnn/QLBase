package db

import (
	"forgetpass/proc"
	"os"

	"gopkg.in/ini.v1"
)

func LoadDBConfig(configFile string) DBConfig {
	ini, err := ini.Load(configFile)
	if err != nil {
		proc.ShowFailedResponse("Internal error occured. " + err.Error())
		os.Exit(0)
	}

	database := ini.Section("database")
	return ConfigDB(
		database.Key("username").String(),
		database.Key("password").String(),
		database.Key("system").String(),
		database.Key("server").String(),
		uint16(database.Key("port").MustInt(3306)))
}
