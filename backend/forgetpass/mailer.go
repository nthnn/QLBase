package main

import (
	"database/sql"
	"net/smtp"
	"os"
	"strings"

	"github.com/nthnn/QLBase/forgetpass/db"
	"github.com/nthnn/QLBase/forgetpass/proc"
	"gopkg.in/ini.v1"
)

var address string = ""
var from string = ""

func generateFromEmailTemplate(url string, tracker string) string {
	wd, _ := os.Getwd()
	data, err := os.ReadFile(wd + "/../bin/forget-pass-template.html")

	if err != nil {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}

	return strings.Replace(
		string(data),
		"{{recovery-link}}",
		url+"/?page=recover&id="+tracker,
		-1)
}

func getEmailAuth() smtp.Auth {
	wd, _ := os.Getwd()
	ini, err := ini.Load(wd + "/../bin/config.ini")

	if err != nil {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}
	smtpConfig := ini.Section("smtp")

	from = smtpConfig.Key("from").String()
	password := smtpConfig.Key("password").String()

	host := smtpConfig.Key("host").String()
	port := smtpConfig.Key("port").String()

	address = host + ":" + port
	return smtp.PlainAuth("", from, password, host)
}

func sendConfirmation(email string) {
	subject := "Subject: QLBase Password Recovery\n"
	mime := "MIME-version: 1.0;\nContent-Type: text/html; charset=\"UTF-8\";\n\n"
	tracker := generateUUID()
	body := generateFromEmailTemplate(getCurrentHomeURL(), tracker)

	to := []string{email}
	message := []byte(subject + mime + body)

	auth := getEmailAuth()
	err := smtp.SendMail(address, auth, from, to, message)

	if err != nil {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}

	db.DispatchWithCallback(func(d *sql.DB) {
		for {
			query, err := d.Query("SELECT * FROM recovery WHERE track_id=\"" +
				tracker + "\"")

			if err != nil {
				proc.ShowFailedResponse("Internal error occured.")
				os.Exit(0)
			}

			count := 0
			for query.Next() {
				count += 1
			}

			if count == 1 {
				tracker = generateUUID()
			} else {
				break
			}

			query.Close()
		}

		query, err := d.Query("INSERT INTO recovery (track_id, email) VALUES (\"" +
			tracker + "\", \"" + email + "\")")

		if err != nil {
			proc.ShowFailedResponse("Internal error occured.")
			os.Exit(0)
		}

		proc.ShowSuccessResponse()
		query.Close()
	})
}
