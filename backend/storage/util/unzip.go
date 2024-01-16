package util

import (
	"archive/zip"
	"io"
	"os"
	"path/filepath"
)

func ExtractZip(zipFilePath, destinationFolder string) error {
	r, err := zip.OpenReader(zipFilePath)
	if err != nil {
		return err
	}
	defer r.Close()

	err = os.MkdirAll(destinationFolder, os.ModePerm)
	if err != nil {
		return err
	}

	for _, file := range r.File {
		rc, err := file.Open()
		if err != nil {
			return err
		}
		defer rc.Close()

		extractedFilePath := filepath.Join(destinationFolder, file.Name)
		if file.FileInfo().IsDir() {
			os.MkdirAll(extractedFilePath, os.ModePerm)
		} else {
			w, err := os.Create(extractedFilePath)
			if err != nil {
				return err
			}
			defer w.Close()

			_, err = io.Copy(w, rc)
			if err != nil {
				return err
			}
		}
	}

	return nil
}
