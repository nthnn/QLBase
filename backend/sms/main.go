package main

import (
	"sms/serport"
)

func main() {
	portList := serport.GetArduinoSerialDevices()
	port := serport.OpenSMSFirmwareConnection(
		serport.ConnectToSMSFirmware(portList[0]),
	)

	defer port.Close()
	serport.WriteToFirmwareSerial(port, "2")
}
