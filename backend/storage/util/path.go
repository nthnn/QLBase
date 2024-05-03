package util

import (
	"runtime"
	"strings"
)

func SafePathSanitation(path string) string {
	if runtime.GOOS == "windows" {
		return strings.ReplaceAll(path, "/", "\\")
	}

	return path
}
