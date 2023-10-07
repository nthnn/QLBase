package main

import (
	"database/sql"
	"forgetpass/db"
	"forgetpass/proc"
	"net/smtp"
	"os"
	"strings"

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
		url+"/recover.php?id="+tracker,
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