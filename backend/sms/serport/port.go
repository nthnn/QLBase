package serport

import (
	"io"
	"os"
	"sms/proc"
	"time"

	"github.com/jacobsa/go-serial/serial"
)

func OpenSMSFirmwareConnection(options serial.OpenOptions) io.ReadWriteCloser {
	port, err := serial.Open(options)
	if err != nil {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}

	time.Sleep(1 * time.Second)
	return port
}

func WriteToFirmwareSerial(portStream io.ReadWriteCloser, content string) int {
	n, err := portStream.Write([]byte(content))

	if err != nil {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}

	return n
}
