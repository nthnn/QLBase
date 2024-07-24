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

	"github.com/nthnn/QLBase/storage/proc"
)

func failOnUnmatchedArgSize(size int, args []string) {
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
		failOnUnmatchedArgSize(4, args)
		callback = fileUploadCallback(apiKey, args)

	case "delete":
		failOnUnmatchedArgSize(3, args)
		callback = deleteFileCallback(apiKey, args)

	case "get":
		failOnUnmatchedArgSize(3, args)
		callback = getFileCallback(apiKey, args)

	case "download":
		failOnUnmatchedArgSize(4, args)
		callback = downloadCallback(apiKey, args)

	case "extract":
		failOnUnmatchedArgSize(2, args)
		callback = extractCallback(apiKey, args)

	case "fetch_all":
		failOnUnmatchedArgSize(2, args)
		callback = fetchAllCallback(apiKey, args)
	}

	DispatchWithCallback(callback)
}
