package serport

import (
	"os"
	"runtime"
	"strings"

	"github.com/nthnn/QLBase/sms/proc"
	"go.bug.st/serial.v1"
)

func stringInSlice(a string, list []string) bool {
	for _, b := range list {
		if b == a {
			return true
		}
	}
	return false
}

func GetArduinoSerialDevices() []string {
	var ports []string
	if list, err := serial.GetPortsList(); err == nil {
		for _, port := range list {
			if !stringInSlice(port, ports) &&
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
