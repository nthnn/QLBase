/*
 * This file is part of QLBase (https://github.com/nthnn/QLBase).
 * Copyright 2024 - Nathanne Isip
 * 
 * Permission is hereby granted, free of charge,
 * to any person obtaining a copy of this software
 * and associated documentation files (the “Software”),
 * to deal in the Software without restriction,
 * including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to
 * whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions
 * of the Software.
 * 
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF
 * ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT
 * SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR
 * ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

package main

import (
	"database/sql"
	"os"
	"strconv"
	"strings"

	"github.com/nthnn/QLBase/sms/proc"
	"github.com/nthnn/QLBase/sms/serport"
)

func sendSMSVerification(apiKey string, args []string) func(*sql.DB) {
	phoneNumber := args[2]
	emailSupport := args[3]

	if !validatePhoneNumber(phoneNumber) {
		proc.ShowFailedResponse("Invalid phone number.")
		os.Exit(0)
	}

	if !validateEmail(emailSupport) {
		proc.ShowFailedResponse("Invalid email address string.")
		os.Exit(0)
	}

	code := generateRandom6DigitString()
	port := serport.OpenSMSFirmwareConnection(
		serport.ConnectToSMSFirmware(
			serport.GetSerialDeviceName()))
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

	if !validatePhoneNumber(phoneNumber) {
		proc.ShowFailedResponse("Invalid phone number.")
		os.Exit(0)
	}

	if !validateOTP(code) {
		proc.ShowFailedResponse("Invalid OTP string.")
		os.Exit(0)
	}

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

	if !validatePhoneNumber(phoneNumber) {
		proc.ShowFailedResponse("Invalid phone number.")
		os.Exit(0)
	}

	if !validateOTP(code) {
		proc.ShowFailedResponse("Invalid OTP string.")
		os.Exit(0)
	}

	return func(d *sql.DB) {
		query, err := d.Query("SELECT validated FROM " + apiKey +
			"_sms_auth WHERE recipient=\"" + phoneNumber +
			"\" AND code=\"" + code + "\"")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			return
		}

		enabled := 0
		count := 0
		for query.Next() {
			query.Scan(&enabled)
			count += 1
		}

		if count != 1 {
			proc.ShowFailedResponse("Recipient and code did not match.")
			return
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

		if len(result) == 0 {
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

	if !validatePhoneNumber(recipient) {
		proc.ShowFailedResponse("Invalid recipient phone number.")
		os.Exit(0)
	}

	if !validateOTP(code) {
		proc.ShowFailedResponse("Invalid OTP string.")
		os.Exit(0)
	}

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
