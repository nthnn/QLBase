package main

import (
	"database/sql"
	"fmt"
	"math/rand"
	"os"
	"regexp"
	"strconv"
	"strings"
	"time"

	"sms/proc"
	"sms/serport"
)

func isValidPhoneNumber(phone_number string) bool {
	regex := regexp.MustCompile(`^\+\d{2,3}.+$`)
	return regex.MatchString(phone_number)
}

func generateRandom6DigitString() string {
	rand.Seed(time.Now().UnixNano())
	return fmt.Sprintf("%06d", rand.Intn(1000000))
}

func sendSMSVerification(apiKey string, args []string) func(*sql.DB) {
	phoneNumber := args[2]
	if !isValidPhoneNumber(phoneNumber) {
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
			proc.ShowFailedResponse("Internal error occured.")
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

func fetchAllOTP(apiKey string, args []string) func(*sql.DB) {
	return func(d *sql.DB) {
		query, err := d.Query(
			"SELECT recipient, code, support_email, timedate, validated FROM " +
				apiKey + "_sms_auth")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}
		defer query.Close()

		var result [][]string
		for query.Next() {
			var recipient, code, support_email, timedate, validated string
			query.Scan(&recipient, &code, &support_email, &timedate, &validated)

			result = append(result, []string{recipient, code, support_email, timedate, validated})
		}

		if len(result) == 1 {
			proc.ShowResult("[]")
			return
		}

		var output string = "["
		for i := 0; i < len(result); i++ {
			res := result[i]

			output += "[\"" + res[0] + "\", \"" +
				res[1] + "\", \"" + res[2] + "\", \"" +
				res[3] + "\", \"" + res[4] + "\"], "
		}

		output = strings.TrimRight(output, ", ") + "]"
		proc.ShowResult(output)
	}
}

func deleteVerification(apiKey string, args []string) func(d *sql.DB) {
	recipient := args[2]
	code := args[3]

	return func(d *sql.DB) {
		query, err := d.Query("SELECT * FROM " + apiKey +
			"_sms_auth WHERE recipient=\"" + recipient +
			"\" AND code=\"" + code + "\"")

		if err != nil {
			query.Close()
			proc.ShowFailedResponse("Internal error occured.")

			return
		}

		count := 0
		for query.Next() {
			count += 1
		}

		if count != 1 {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		query, err = d.Query("DELETE FROM " + apiKey +
			"_sms_auth WHERE recipient=\"" + recipient +
			"\" AND code=\"" + code + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		proc.ShowSuccessResponse()
	}
}
