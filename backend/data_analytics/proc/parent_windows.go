//go:build windows
// +build windows

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
	 "unsafe"
 
	 "golang.org/x/sys/windows"
 )
 
 func IsParentProcessPHP() bool {
	 currentPid := windows.GetCurrentProcessId()
	 possiblePHP := []string{"php.exe", "php-cgi.exe"}
 
	 hSnapshot, err := windows.CreateToolhelp32Snapshot(windows.TH32CS_SNAPPROCESS, 0)
	 if err != nil {
		 return false
	 }
	 defer windows.CloseHandle(hSnapshot)
 
	 var processEntry windows.ProcessEntry32
	 processEntry.Size = uint32(unsafe.Sizeof(processEntry))
 
	 findProcessByID := func(pid uint32) (ppid uint32, name string, found bool) {
		 if err := windows.Process32First(hSnapshot, &processEntry); err != nil {
			 return
		 }
 
		 for {
			 if processEntry.ProcessID == pid {
				 return processEntry.ParentProcessID, windows.UTF16ToString(processEntry.ExeFile[:]), true
			 }
 
			 if err := windows.Process32Next(hSnapshot, &processEntry); err != nil {
				 break
			 }
		 }
 
		 return 0, "", false
	 }
 
	 seenPIDs := make(map[uint32]bool)
	 for currentPid != 0 {
		 if _, seen := seenPIDs[currentPid]; seen {
			 break
		 }
 
		 seenPIDs[currentPid] = true
		 ppid, parentProcessName, found := findProcessByID(currentPid)
 
		 if !found {
			 break
		 }
 
		 for _, phpName := range possiblePHP {
			 if parentProcessName == phpName {
				 return true
			 }
		 }
 
		 currentPid = ppid
	 }
 
	 return false
 }
 