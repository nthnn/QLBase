package main

import (
	"database/sql"
	"os"
)

func main() {
	if len(os.Args) < 2 {
		return
	}

	var callback func(*sql.DB)
	args := os.Args[1:]

	switch args[0] {
	case "validate_sess":
		break
	}

	DispatchWithCallback(callback)
}
