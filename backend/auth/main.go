package main

import (
	"database/sql"
	"fmt"
	"os"
)

func main() {
	if len(os.Args) < 2 {
		return
	}

	var callback func(*sql.DB) = func(d *sql.DB) {}
	args := os.Args[1:]

	switch args[0] {
	case "add":
		if len(args) != 6 {
			return
		}

		fmt.Println("Hey")
	}

	DispatchWithCallback(callback)
}
