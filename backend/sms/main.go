package main

import (
	"database/sql"
	"fmt"
	"os"

	"sms/db"
	"sms/proc"
	"sms/serport"
)

func failOnUmatchedArgSize(size int, args []string) {
	if len(args) != size {
		proc.ShowFailedResponse("Invalid parameter arity.")
		os.Exit(-1)
	}
}

func main() {
	portList := serport.GetArduinoSerialDevices()
	if len(portList) < 1 {
		proc.ShowFailedResponse("No available SMS hardware found.")
		os.Exit(0)
	}

	port := serport.OpenSMSFirmwareConnection(
		serport.ConnectToSMSFirmware(portList[0]),
	)
	defer port.Close()

	serport.WriteToFirmwareSerial(port, "2")

	if len(os.Args) < 3 {
		return
	}

	var callback func(*sql.DB) = func(d *sql.DB) {}
	args := os.Args[1:]
	apiKey := args[1]

	switch args[0] {
	case "verify":
		failOnUmatchedArgSize(4, args) // verify +63xxxxxxxxxxx email
		callback = func(d *sql.DB) {}
	}

	fmt.Println(apiKey)
	db.DispatchWithCallback(callback)
}
