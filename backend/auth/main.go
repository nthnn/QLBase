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

	"github.com/nthnn/QLBase/auth/proc"
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
		failOnUnmatchedArgSize(6, args)
		callback = createUserCallback(apiKey, args)

	case "delete_by_username":
		failOnUnmatchedArgSize(3, args)
		callback = deleteByUsernameCallback(apiKey, args)

	case "delete_by_email":
		failOnUnmatchedArgSize(3, args)
		callback = deleteByEmailCallback(apiKey, args)

	case "update_by_username":
		failOnUnmatchedArgSize(6, args)
		callback = updateByUsernameCallback(apiKey, args)

	case "update_by_email":
		failOnUnmatchedArgSize(6, args)
		callback = updateByEmailCallback(apiKey, args)

	case "get_by_username":
		failOnUnmatchedArgSize(3, args)
		callback = getByUsernameCallback(apiKey, args)

	case "get_by_email":
		failOnUnmatchedArgSize(3, args)
		callback = getByEmailCallback(apiKey, args)

	case "enable_user":
		failOnUnmatchedArgSize(3, args)
		callback = enableUser(apiKey, args)

	case "disable_user":
		failOnUnmatchedArgSize(3, args)
		callback = disableUser(apiKey, args)

	case "is_user_enabled":
		failOnUnmatchedArgSize(3, args)
		callback = isUserEnabled(apiKey, args)

	case "login_username":
		failOnUnmatchedArgSize(6, args)
		callback = loginUserWithUsername(apiKey, args)

	case "login_email":
		failOnUnmatchedArgSize(6, args)
		callback = loginUserWithEmail(apiKey, args)

	case "logout":
		failOnUnmatchedArgSize(3, args)
		callback = logout(apiKey, args)

	case "validate_session":
		failOnUnmatchedArgSize(5, args)
		callback = validateSession(apiKey, args)

	case "fetch_all":
		callback = fetchAllUserCallback(apiKey)

	default:
		proc.ShowFailedResponse("Invalid argument arity.")
	}

	DispatchWithCallback(callback)
}
