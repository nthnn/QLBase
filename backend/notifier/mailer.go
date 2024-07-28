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

import(
	"net/smtp"
	"os"
	"strings"

	"gopkg.in/ini.v1"
)

var address string = ""
var from string = ""

func getEmailAuth() smtp.Auth {
	wd, _ := os.Getwd()
	ini, err := ini.Load(wd + "/../bin/config.ini")

	if err != nil {
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

func generateFromEmailTemplate(status, originUser, appName string) string {
	wd, _ := os.Getwd()
	path := ""

	if status == "add" {
		path = "/../bin/template-added-access.html"
	} else if status == "remove" {
		path = "/../bin/template-removed-access.html"
	} else {
		os.Exit(0)
	}

	data, err := os.ReadFile(wd + path)
	if err != nil {
		os.Exit(0)
	}

	content := strings.Replace(
		string(data),
		"{{origin-user}}",
		originUser,
		-1,
	)
	content = strings.Replace(
		content,
		"{{app-name}}",
		appName,
		-1,
	)

	return content
}

func sendNotification(status, originUser, appName, recipientEmail string) {
	subject := "Subject: QLBase Shared Access\n"
	mime := "MIME-version: 1.0;\nContent-Type: text/html; charset=\"UTF-8\";\n\n"
	body := generateFromEmailTemplate(status, originUser, appName)

	to := []string{recipientEmail}
	message := []byte(subject + mime + body)

	auth := getEmailAuth()
	smtp.SendMail(
		address,
		auth,
		from,
		to,
		message,
	)
}