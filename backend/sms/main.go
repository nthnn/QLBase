package main

import (
	"database/sql"
	"os"

	"sms/db"
	"sms/proc"
)

func failOnUmatchedArgSize(size int, args []string) {
	if len(args) != size {
		proc.ShowFailedResponse("Invalid parameter arity.")
		os.Exit(-1)
	}
}

func main() {
	if len(os.Args) < 3 {
		proc.ShowFailedResponse("Invalid argument arity.")
		os.Exit(0)
	}

	var callback func(*sql.DB) = func(d *sql.DB) {}
	args := os.Args[1:]
	apiKey := args[1]

	switch args[0] {
	case "verify":
		failOnUmatchedArgSize(4, args)
		callback = sendSMSVerification(apiKey, args)

	case "validate":
		failOnUmatchedArgSize(4, args)
		callback = validateVerificationCode(apiKey, args)

	case "is_validated":
		failOnUmatchedArgSize(4, args)
		callback = isCodeValidated(apiKey, args)

	case "fetch_all_otp":
		failOnUmatchedArgSize(2, args)
		callback = fetchAllOTP(apiKey, args)

	case "delete_verification":
		failOnUmatchedArgSize(4, args)
		callback = deleteVerification(apiKey, args)

	default:
		proc.ShowFailedResponse("Invalid argument arity.")
	}

	db.DispatchWithCallback(callback)
}
