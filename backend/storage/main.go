package main

import (
	"database/sql"
	"os"

	"github.com/nthnn/QLBase/storage/proc"
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
	case "upload":
		failOnUmatchedArgSize(4, args)
		fileUploadCallback(apiKey, args)
	}

	DispatchWithCallback(callback)
}
