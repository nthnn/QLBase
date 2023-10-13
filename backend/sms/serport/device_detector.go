package serport

import (
	"os"
	"runtime"
	"slices"
	"sms/proc"
	"strings"

	"go.bug.st/serial.v1"
)

func GetArduinoSerialDevices() []string {
	var ports []string
	if list, err := serial.GetPortsList(); err == nil {
		for _, port := range list {
			if !slices.Contains(ports, port) &&
				(runtime.GOOS != "windows" &&
					strings.Contains(port, "/dev/tty")) {
				ports = append(ports, port)
			}
		}
	} else {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}

	return ports
}
