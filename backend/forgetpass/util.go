package main

import (
	"forgetpass/proc"
	"os"
	"os/exec"

	"gopkg.in/ini.v1"
)

func generateUUID() string {
	newUUID, err := exec.Command("uuidgen").Output()
	if err != nil {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}

	return string(newUUID)
}

func getCurrentHomeURL() string {
	wd, _ := os.Getwd()
	ini, err := ini.Load(wd + "/../bin/config.ini")

	if err != nil {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}

	return ini.Section("env").Key("home").String()
}
