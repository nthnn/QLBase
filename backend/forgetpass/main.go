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

	"github.com/nthnn/QLBase/forgetpass/db"
	"github.com/nthnn/QLBase/forgetpass/proc"
)

func failOnUmatchedArgSize(size int, args []string) {
	if len(args) != size {
		proc.ShowFailedResponse("Invalid parameter arity.")
		os.Exit(-1)
	}
}

func main() {
	if len(os.Args) != 2 {
		proc.ShowFailedResponse("Invalid argument arity.")
		os.Exit(0)
	}

	recipient := os.Args[1]
	email := ""

	if validateEmail(recipient) {
		email = recipient

		db.DispatchWithCallback(func(d *sql.DB) {
			query, err := d.Query(
				"SELECT * FROM accounts WHERE email=\"" +
					email + "\"")

			if err != nil {
				proc.ShowFailedResponse("Internal error occured.")
				os.Exit(0)
			}

			count := 0
			for query.Next() {
				count += 1
			}

			if count != 1 {
				proc.ShowFailedResponse("Email not found.")
				os.Exit(0)
			}
		})
	} else if validateUsername(recipient) {
		db.DispatchWithCallback(func(d *sql.DB) {
			query, err := d.Query(
				"SELECT email FROM accounts WHERE username=\"" +
					recipient + "\"")

			if err != nil {
				proc.ShowFailedResponse("Internal error occured.")
				os.Exit(0)
			}

			count := 0
			for query.Next() {
				query.Scan(&email)
				count += 1
			}

			if count != 1 {
				proc.ShowFailedResponse("Username not found.")
				os.Exit(0)
			}
		})
	} else {
		proc.ShowFailedResponse("Invalid username or email.")
		os.Exit(0)
	}

	sendConfirmation(email)
}
