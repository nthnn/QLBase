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
	"os"
	"os/exec"

	"github.com/nthnn/QLBase/forgetpass/proc"
	"gopkg.in/ini.v1"
)

func generateUUID() string {
	newUUID, err := exec.Command("uuidgen").Output()
	if err != nil {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}

	return string(newUUID[:len(newUUID)-1])
}

func getCurrentHomeURL() string {
	wd, _ := os.Getwd()
	ini, err := ini.Load(wd + "/../bin/config.ini")

	if err != nil {
		proc.ShowFailedResponse("Internal error occured.")
		os.Exit(0)
	}

	return ini.Section("env").Key("home").String()
}
