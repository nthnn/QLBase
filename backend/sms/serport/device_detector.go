package serport

import (
	"os"
	"sms/proc"

	"go.bug.st/serial.v1"
)

func GetArduinoSerialDevices() []string {
	var ports []string
	if list, err := serial.GetPortsList(); err == nil {
		for _, port := range list {
			ports = append(ports, port)
		}
	} else {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}

	return ports
}
