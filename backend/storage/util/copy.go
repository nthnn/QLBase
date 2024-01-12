package util

import (
	"archive/zip"
	"io"
	"os"
)

func MoveTempFile(source string, destination string) error {
	src, err := os.Open(source)
	if err != nil {
		return err
	}
	defer src.Close()

	dest, err := os.Create(destination + ".zip")
	if err != nil {
		return err
	}
	defer dest.Close()

	zipOut := zip.NewWriter(dest)
	zipFile, err := zipOut.Create(source[14:])
	if err != nil {
		return err
	}

	if _, err := io.Copy(zipFile, src); err != nil {
		return err
	}

	zipOut.Close()
	return err
}
