package serport

import (
	"os"
	"sms/proc"
	"strings"

	"github.com/hedhyw/Go-Serial-Detector/pkg/v1/serialdet"
)

func GetArduinoSerialDevices() []string {
	var ports []string
	if list, err := serialdet.List(); err == nil {
		for _, p := range list {
			desc := p.Description()

			if strings.Contains(strings.ToLower(desc), "arduino") {
				ports = append(ports, p.Path())
			}
		}
	} else {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}

	return ports
}
