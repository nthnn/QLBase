package main

import (
	"net/mail"
	"regexp"
)

func validateUsername(username string) bool {
	match, _ := regexp.MatchString("^[a-zA-Z0-9_]+$", username)
	return len(username) >= 6 && match
}

func validateEmail(email string) bool {
	_, err := mail.ParseAddress(email)
	return err == nil
}
