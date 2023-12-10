package main

import (
	"os"
	"os/exec"

	"github.com/nthnn/QLBase/forgetpass/proc"
	"gopkg.in/ini.v1"
)

func generateUUID() string {
	newUUID, err := exec.Command("uuidgen").Output()
	if err != nil {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}

	return string(newUUID[:len(newUUID)-1])
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
