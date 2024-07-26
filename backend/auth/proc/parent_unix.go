//go:build !windows
// +build !windows

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

package proc

import (
	"fmt"
	"io/ioutil"
	"os"
	"strconv"
	"strings"
)

func IsParentProcessPHP() bool {
	ppid := os.Getppid()
	httpd := "/opt/lampp/bin/httpd "

	parentCommContent, err := ioutil.ReadFile(
		fmt.Sprintf("/proc/%d/comm", ppid),
	)

	if err != nil {
		return false
	}

	parentProcessName := strings.TrimSpace(string(parentCommContent))
	if strings.HasPrefix(parentProcessName, httpd) {
		return true
	}

	parentCmdlineContent, err := ioutil.ReadFile(
		fmt.Sprintf("/proc/%d/cmdline", ppid),
	)
	if err == nil {
		parentCmdline := strings.Join(
			strings.Split(
				string(parentCmdlineContent),
				"\x00",
			),
			" ",
		)

		if strings.HasPrefix(parentCmdline, httpd) {
			return true
		}
	}

	ppidFileContent, err := ioutil.ReadFile(
		fmt.Sprintf("/proc/%d/status", ppid),
	)
	if err != nil {
		return false
	}

	var gppid int
	ppidLines := strings.Split(string(ppidFileContent), "\n")

	for _, line := range ppidLines {
		if strings.HasPrefix(line, "PPid:") {
			gppid, err = strconv.Atoi(strings.Fields(line)[1])

			if err != nil {
				return false
			}

			break
		}
	}

	parentCommContent, err = ioutil.ReadFile(
		fmt.Sprintf("/proc/%d/comm", gppid),
	)
	if err != nil {
		return false
	}

	if strings.HasPrefix(strings.TrimSpace(string(parentCommContent)), httpd) {
		return true
	}

	parentCmdlineContent, err = ioutil.ReadFile(
		fmt.Sprintf("/proc/%d/cmdline", gppid),
	)
	if err == nil {
		parentCmdline := strings.Join(
			strings.Split(
				string(parentCmdlineContent),
				"\x00",
			),
			" ",
		)

		if strings.HasPrefix(parentCmdline, httpd) {
			return true
		}
	}

	return false
}
