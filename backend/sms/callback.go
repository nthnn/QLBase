package main

import (
	"database/sql"
	"fmt"
	"math/rand"
	"os"
	"strconv"
	"time"

	"sms/proc"
	"sms/serport"

	"github.com/dongri/phonenumber"
)

func generateRandom6DigitString() string {
	rand.Seed(time.Now().UnixNano())
	return fmt.Sprintf("%06d", rand.Intn(1000000))
}

func sendSMSVerification(apiKey string, args []string) func(*sql.DB) {
	phoneNumber := args[2]
	if phonenumber.GetISO3166ByNumber(phoneNumber, true).CountryName == "" {
		proc.ShowFailedResponse("Invalid phone number.")
		os.Exit(0)
	}

	emailSupport := args[3]
	code := generateRandom6DigitString()

	portList := serport.GetArduinoSerialDevices()
	if len(portList) < 1 {
		proc.ShowFailedResponse("No available SMS hardware found.")
		os.Exit(0)
	}

	port := serport.OpenSMSFirmwareConnection(
		serport.ConnectToSMSFirmware(portList[0]),
	)

	serport.WriteToFirmwareSerial(
		port,
		phoneNumber+","+
			emailSupport+","+
			code)
	port.Close()

	return func(d *sql.DB) {
		query, err := d.Query("INSERT INTO " + apiKey +
			"_sms_auth (recipient, support_email, code, validated) VALUES (\"" +
			phoneNumber + "\", \"" + emailSupport + "\", \"" + code + "\", 0)")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured...")
			return
		}

		proc.ShowResult("\"" + code + "\"")
		query.Close()
	}
}

func validateVerificationCode(apiKey string, args []string) func(*sql.DB) {
	phoneNumber := args[2]
	code := args[3]

	return func(d *sql.DB) {
		query, err := d.Query("SELECT * FROM " + apiKey +
			"_sms_auth WHERE recipient=\"" + phoneNumber +
			"\" AND code=\"" + code + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		count := 0
		for query.Next() {
			count += 1
		}

		if count != 1 {
			proc.ShowFailedResponse("Recipient and code did not match.")
			return
		}

		query, err = d.Query("UPDATE " + apiKey +
			"_sms_auth SET validated=true WHERE recipient=\"" + phoneNumber +
			"\" AND code=\"" + code + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
		query.Close()
	}
}

func isCodeValidated(apiKey string, args []string) func(*sql.DB) {
	phoneNumber := args[2]
	code := args[3]

	return func(d *sql.DB) {
		query, err := d.Query("SELECT validated FROM " + apiKey +
			"_sms_auth WHERE recipient=\"" + phoneNumber +
			"\" AND code=\"" + code + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		var validated bool = false
		count := 0
		for query.Next() {
			query.Scan(&validated)
			count += 1
		}

		if count != 1 {
			proc.ShowFailedResponse("Recipient and code did not match.")
			return
		}

		enabled := 1
		if validated {
			enabled = 1
		} else {
			enabled = 0
		}

		proc.ShowResult("\"" + strconv.Itoa(enabled) + "\"")
		query.Close()
	}
}
