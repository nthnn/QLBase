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

	"github.com/nthnn/QLBase/database/proc"
)

func failOnUnmatchedArgSize(size int, args []string) {
	if len(args) != size {
		proc.ShowFailedResponse("Invalid parameter arity.")
		os.Exit(-1)
	}
}

func main() {
	if !proc.IsParentProcessPHP() {
		os.Exit(0)
	}

	if len(os.Args) < 3 {
		proc.ShowFailedResponse("Invalid argument arity.")
		os.Exit(0)
	}

	var callback func(*sql.DB) = func(d *sql.DB) {}
	args := os.Args[1:]
	apiKey := args[1]

	if !validateApiKey(apiKey) {
		proc.ShowFailedResponse("Invalid API key string.")
		os.Exit(0)
	}

	switch args[0] {
	case "create":
		failOnUnmatchedArgSize(5, args)
		callback = createDbCallback(apiKey, args)

	case "get_by_name":
		failOnUnmatchedArgSize(3, args)
		callback = getByNameCallback(apiKey, args)

	case "set_db_mode":
		failOnUnmatchedArgSize(4, args)
		callback = setDbModeCallback(apiKey, args)

	case "get_db_mode":
		failOnUnmatchedArgSize(3, args)
		callback = getDbModeCallback(apiKey, args)

	case "write_db":
		failOnUnmatchedArgSize(4, args)
		callback = writeDbCallback(apiKey, args)

	case "read_db":
		failOnUnmatchedArgSize(3, args)
		callback = readDbCallback(apiKey, args)

	case "delete_db":
		failOnUnmatchedArgSize(3, args)
		callback = deleteDbCallback(apiKey, args)

	case "fetch_all":
		failOnUnmatchedArgSize(2, args)
		callback = fetchAllCallback(apiKey, args)
	}

	DispatchWithCallback(callback)
}
